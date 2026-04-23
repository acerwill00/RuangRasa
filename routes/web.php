<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Appointment;
use App\Models\Article;
use App\Models\Psychologist;
use App\Models\User;

Route::get('/', function () {
    $articles = Article::latest()->take(3)->get();
    return view('pages.home', compact('articles'));
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/services', function () {
    return view('pages.services');
});

Route::get('/our-psychologist', function () {
    $models = Psychologist::all();
    $psychologists = [];
    foreach($models as $m) {
        $psychologists[$m->id] = [
            'name'        => $m->name,
            'image'       => asset('img/prof-pic.jpeg'),
            'specialties' => [$m->specialization],
            'price'       => number_format($m->price_per_session, 0, ',', '.'),
            'schedules'   => ['Today', 'Tomorrow'],
            'swimlanes'   => ['today', 'highly_recommended'],
            'bio'         => $m->bio,
        ];
    }
    return view('pages.directory', compact('psychologists'));
});

Route::get('/psychologist/{id}', function ($id) {
    if (is_numeric($id)) {
        $m = Psychologist::findOrFail($id);
    } else {
        $m = Psychologist::where('slug', $id)->firstOrFail();
    }

    $psychologist = [
        'id'          => $m->id,
        'name'        => $m->name,
        'title'       => 'Clinical Psychologist',
        'image'       => asset('img/prof-pic.jpeg'),
        'specialties' => [$m->specialization],
        'price'       => number_format($m->price_per_session, 0, ',', '.'),
        'bio'         => $m->bio ?? 'A dedicated professional.',
        'bio1'        => $m->bio ?? 'A dedicated professional who helps clients navigate life challenges with compassion and evidence-based methods.',
        'bio2'        => 'With a focus on creating a safe and non-judgmental space, sessions are tailored to your unique needs and goals.',
        'badges'      => 'Licensed & Verified Psychologist',
        'experience'  => '3+ Years',
        'languages'   => 'Indonesian, English',
    ];

    // Generate next 7 days starting from today
    $dates = [];
    for ($i = 0; $i < 7; $i++) {
        $dates[] = \Carbon\Carbon::today()->addDays($i)->format('Y-m-d');
    }

    // Fetch already-booked slots for this psychologist across the next 7 days
    $bookedRaw = \App\Models\Appointment::where('psychologist_id', $m->id)
        ->whereIn('schedule_date', $dates)
        ->whereNotIn('status', ['canceled'])
        ->get(['schedule_date', 'schedule_time']);

    $bookedSlots = [];
    foreach ($bookedRaw as $apt) {
        $dateKey = $apt->schedule_date;
        $timeKey = substr($apt->schedule_time, 0, 5);
        $bookedSlots[$dateKey][] = $timeKey;
    }

    $timeSlots = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];

    return view('pages.psychologist-profile', compact('psychologist', 'dates', 'bookedSlots', 'timeSlots'));
});

Route::get('/articles', function () {
    // Merge DB articles + config fallbacks (DB takes priority)
    $dbArticles = Article::latest()->get()->keyBy('slug')->toArray();
    $configArticles = config('articles', []);
    $articles = array_merge($configArticles, $dbArticles);
    return view('pages.articles', compact('articles'));
});

Route::get('/article/{slug}', function ($slug) {
    // Try DB first, then config fallback
    $article = Article::where('slug', $slug)->first();
    if ($article) {
        return view('pages.article-single', ['article' => $article->toArray()]);
    }
    $articles = config('articles', []);
    if (!array_key_exists($slug, $articles)) {
        abort(404);
    }
    return view('pages.article-single', ['article' => $articles[$slug]]);
});

Route::get('/faq', function () {
    return view('pages.faq');
});

Route::get('/privacy', function () {
    return view('pages.privacy');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

// ─── Guest Authentication Routes ───────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () { return view('auth.register'); })->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/verify-email', [\App\Http\Controllers\VerificationController::class, 'show'])->name('verification.show');
    Route::post('/verify-email', [\App\Http\Controllers\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verify-email/resend', [\App\Http\Controllers\VerificationController::class, 'resend'])->name('verification.resend');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Patient Authenticated Routes ─────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Profile (admin can also view their own profile)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Checkout API — keep auth-only (middleware in controller handles logic)
    Route::post('/api/checkout', [PaymentController::class, 'createPaymentToken']);
    Route::post('/api/checkout/simulate-success', [PaymentController::class, 'simulateSuccess']);
});

// ─── Patient-Only Routes (admins are redirected away) ─────────────────────────
Route::middleware(['auth', 'ensure.patient'])->group(function () {

    // Patient Dashboard
    Route::get('/dashboard', function () {
        $appointments = Appointment::with(['psychologist', 'order'])
            ->where('user_id', auth()->id())
            ->orderBy('schedule_date', 'desc')
            ->get();
        return view('dashboard.patient', compact('appointments'));
    })->name('dashboard');

    // ── Booking Wizard ──────────────────────────────────────────────────────
    Route::get('/book/{psychologist}',           [BookingController::class, 'service'])->name('booking.service');
    Route::post('/book/{psychologist}',          [BookingController::class, 'storeService'])->name('booking.service.store');
    Route::get('/book/{psychologist}/schedule',  [BookingController::class, 'schedule'])->name('booking.schedule');
    Route::post('/book/{psychologist}/schedule', [BookingController::class, 'storeSchedule'])->name('booking.schedule.store');
    Route::get('/book/{psychologist}/payment',   [BookingController::class, 'payment'])->name('booking.payment');
    Route::get('/booking/success/{order_id}',    [BookingController::class, 'success'])->name('booking.success');

    // Cancel appointment
    Route::post('/appointments/{appointment}/cancel', [BookingController::class, 'cancel'])->name('appointment.cancel');
    // Rate appointment
    Route::post('/appointments/{appointment}/rate', [BookingController::class, 'rate'])->name('appointment.rate');

    // Appointment detail page (patient view)
    Route::get('/appointments/{appointment}', function (\App\Models\Appointment $appointment) {
        // Ensure the patient can only see their own appointment
        if ($appointment->user_id !== auth()->id()) abort(403);
        $apt = $appointment->load(['user', 'psychologist', 'order']);
        return view('dashboard.appointment-detail', compact('apt'));
    })->name('appointment.show');
    // Complaints (Patient)
    Route::get('/complaints/create', [\App\Http\Controllers\ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [\App\Http\Controllers\ComplaintController::class, 'store'])->name('complaints.store');
});

// ─── Admin Authenticated Routes ────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $now = now();

        $totalAppointments  = Appointment::count();
        $totalPatients      = User::where('is_admin', false)->count();
        $activeAppointments = Appointment::where('status', 'scheduled')
            ->where(function ($q) use ($now) {
                $q->where('schedule_date', '>', $now->toDateString())
                  ->orWhere(function ($q2) use ($now) {
                      $q2->where('schedule_date', $now->toDateString())
                         ->where('schedule_time', '>=', $now->format('H:i:s'));
                  });
            })
            ->count();

        // Default: active/upcoming scheduled appointments
        $activeList = Appointment::with(['user', 'psychologist'])
            ->where('status', 'scheduled')
            ->where(function ($q) use ($now) {
                $q->where('schedule_date', '>', $now->toDateString())
                  ->orWhere(function ($q2) use ($now) {
                      $q2->where('schedule_date', $now->toDateString())
                         ->where('schedule_time', '>=', $now->format('H:i:s'));
                  });
            })
            ->orderBy('schedule_date')
            ->orderBy('schedule_time')
            ->get();

        // Archive: past + canceled
        $pastList = Appointment::with(['user', 'psychologist'])
            ->where(function ($q) use ($now) {
                $q->where('status', '!=', 'scheduled')
                  ->orWhere('schedule_date', '<', $now->toDateString())
                  ->orWhere(function ($q2) use ($now) {
                      $q2->where('schedule_date', $now->toDateString())
                         ->where('schedule_time', '<', $now->format('H:i:s'));
                  });
            })
            ->orderBy('schedule_date', 'desc')
            ->get();

        return view('dashboard.admin', compact(
            'totalAppointments', 'totalPatients', 'activeAppointments',
            'activeList', 'pastList'
        ));
    })->name('admin.dashboard');


    Route::get('/admin/patients', [\App\Http\Controllers\Admin\PatientController::class, 'index']);
    Route::resource('/admin/psychologists', \App\Http\Controllers\Admin\PsychologistController::class);

    // Article management
    Route::get('/admin/articles',                    [\App\Http\Controllers\Admin\ArticleController::class, 'index']);
    Route::get('/admin/articles/create',             [\App\Http\Controllers\Admin\ArticleController::class, 'create']);
    Route::post('/admin/articles',                   [\App\Http\Controllers\Admin\ArticleController::class, 'store']);
    Route::get('/admin/articles/{article}/edit',     [\App\Http\Controllers\Admin\ArticleController::class, 'edit']);
    Route::put('/admin/articles/{article}',          [\App\Http\Controllers\Admin\ArticleController::class, 'update']);
    Route::delete('/admin/articles/{article}',       [\App\Http\Controllers\Admin\ArticleController::class, 'destroy']);

    // Admin appointment detail
    Route::get('/admin/appointments/{appointment}', function (\App\Models\Appointment $appointment) {
        $apt = $appointment->load(['user', 'psychologist', 'order']);
        return view('admin.appointments.show', compact('apt'));
    })->name('admin.appointment.show');

    // Admin Complaints
    Route::get('/admin/complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('admin.complaints.index');
    Route::patch('/admin/complaints/{complaint}/resolve', [\App\Http\Controllers\Admin\ComplaintController::class, 'resolve'])->name('admin.complaints.resolve');
});

// ─── Midtrans Webhook (no auth) ────────────────────────────────────────────────
Route::post('/api/midtrans/webhook', [PaymentController::class, 'webhook']);
