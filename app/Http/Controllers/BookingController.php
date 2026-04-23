<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psychologist;
use App\Models\Appointment;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ─── Available time slots (08:00–17:00, hourly) ───────────────────────────
    const TIME_SLOTS = [
        '08:00', '09:00', '10:00', '11:00',
        '12:00', '13:00', '14:00', '15:00',
        '16:00', '17:00',
    ];

    // ─── Step 2: Show service selection ───────────────────────────────────────
    public function service(Request $request, $psychologistId)
    {
        // Guard: redirect to directory if the ID is clearly not a valid psychologist
        $psychologist = Psychologist::find($psychologistId)
            ?? Psychologist::where('slug', $psychologistId)->first();

        if (!$psychologist) {
            return redirect('/our-psychologist')->with('error', 'Please select a psychologist first.');
        }

        // Store psychologist in session as soon as wizard starts
        session(['booking.psychologist_id' => $psychologist->id]);

        // Pre-fill date & time if the user picked them on the profile page
        if ($request->filled('date') && $request->filled('time')) {
            $date = $request->input('date');
            $time = $request->input('time');

            // Validate the values before trusting them
            $validDate = \Carbon\Carbon::parse($date)->isFuture() ||
                         \Carbon\Carbon::parse($date)->isToday();
            if ($validDate && in_array($time, self::TIME_SLOTS)) {
                session([
                    'booking.date' => $date,
                    'booking.time' => $time . ':00',
                ]);
            }
        } else {
            // No pre-selection — clear any stale date/time from a previous booking
            // so the progress bar doesn't falsely show Schedule as completed
            session()->forget(['booking.date', 'booking.time']);
        }

        return view('booking.service', compact('psychologist'));
    }

    // ─── Step 2: Store service selection ──────────────────────────────────────
    public function storeService(Request $request, $psychologistId)
    {
        $request->validate([
            'service_type' => 'required|in:psikolog_klinis,konseling',
        ]);

        $psychologist = Psychologist::findOrFail($psychologistId);

        // Price logic: Konseling is a flat rate; Psikolog Klinis uses the psychologist's own fee
        $price = $request->service_type === 'psikolog_klinis'
            ? $psychologist->price_per_session
            : 150000;

        session([
            'booking.service_type'  => $request->service_type,
            'booking.service_price' => $price,
        ]);

        // If date & time were already pre-selected from the profile page, skip schedule step
        if (session('booking.date') && session('booking.time')) {
            return redirect("/book/{$psychologistId}/payment");
        }

        return redirect("/book/{$psychologistId}/schedule");
    }

    // ─── Step 3: Show schedule picker ─────────────────────────────────────────
    public function schedule($psychologistId)
    {
        // Guard: service must be selected first
        if (!session('booking.service_type')) {
            return redirect("/book/{$psychologistId}");
        }

        $psychologist = Psychologist::findOrFail($psychologistId);

        // Generate next 7 days starting from today
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Carbon::today()->addDays($i)->format('Y-m-d');
        }

        // Fetch already-booked slots for this psychologist across the next 7 days
        $bookedRaw = Appointment::where('psychologist_id', $psychologistId)
            ->whereIn('schedule_date', $dates)
            ->whereNotIn('status', ['canceled'])
            ->get(['schedule_date', 'schedule_time']);

        // Build a keyed array: ['2026-04-17' => ['09:00', '11:00'], ...]
        $bookedSlots = [];
        foreach ($bookedRaw as $apt) {
            $dateKey = $apt->schedule_date;
            $timeKey = substr($apt->schedule_time, 0, 5); // trim seconds
            $bookedSlots[$dateKey][] = $timeKey;
        }

        $booking = [
            'psychologist'  => $psychologist,
            'service_type'  => session('booking.service_type'),
            'service_price' => session('booking.service_price'),
        ];

        $timeSlots = self::TIME_SLOTS;

        return view('booking.schedule', compact('psychologist', 'dates', 'bookedSlots', 'booking', 'timeSlots'));
    }

    // ─── Step 3: Store schedule ────────────────────────────────────────────────
    public function storeSchedule(Request $request, $psychologistId)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => ['required', 'regex:/^\d{2}:\d{2}$/'],
        ]);

        // Validate time is one of the allowed slots
        if (!in_array($request->time, self::TIME_SLOTS)) {
            return back()->withErrors(['time' => 'Please select a valid time slot.']);
        }

        // Check for conflicts
        $conflict = Appointment::where('psychologist_id', $psychologistId)
            ->where('schedule_date', $request->date)
            ->where('schedule_time', $request->time . ':00')
            ->whereNotIn('status', ['canceled'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['time' => 'This slot was just booked. Please choose another time.']);
        }

        session([
            'booking.date' => $request->date,
            'booking.time' => $request->time . ':00',
        ]);

        return redirect("/book/{$psychologistId}/payment");
    }

    // ─── Step 4: Show payment/confirm page ────────────────────────────────────
    public function payment($psychologistId)
    {
        // Guard: date/time must be selected first
        if (!session('booking.date')) {
            return redirect("/book/{$psychologistId}/schedule");
        }

        $psychologist = Psychologist::findOrFail($psychologistId);

        $booking = [
            'psychologist'  => $psychologist,
            'service_type'  => session('booking.service_type'),
            'service_price' => session('booking.service_price'),
            'date'          => session('booking.date'),
            'time'          => session('booking.time'),
        ];

        return view('booking.payment', compact('booking'));
    }

    // ─── Cancel appointment (from patient dashboard) ───────────────────────────
    public function cancel(Request $request, $appointmentId)
    {
        $appointment = Appointment::where('user_id', auth()->id())
            ->findOrFail($appointmentId);

        if ($appointment->status !== 'scheduled') {
            return back()->with('error', 'Only scheduled appointments can be canceled.');
        }

        // Enforce 12-hour notice window
        $sessionStart = Carbon::parse($appointment->schedule_date . ' ' . $appointment->schedule_time);
        if ($sessionStart->diffInHours(Carbon::now(), false) > -12) {
            // diffInHours(now, false) is negative if session is in the future
            // > -12 means less than 12h away
            return back()->with('error', 'Appointments can only be canceled at least 12 hours before the session.');
        }

        $appointment->update(['status' => 'canceled']);

        return back()->with('success', 'Your appointment has been canceled.');
    }

    // ─── Post-Booking Success Page ────────────────────────────────────────────
    public function success($orderId)
    {
        $appointment = Appointment::with(['psychologist', 'order'])
            ->where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('booking.success', compact('appointment'));
    }

    public function rate(Request $request, $appointmentId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::where('user_id', auth()->id())
            ->findOrFail($appointmentId);

        if ($appointment->status !== 'completed') {
            return back()->with('error', 'You can only rate completed appointments.');
        }

        if ($appointment->rating !== null) {
            return back()->with('error', 'You have already rated this appointment.');
        }

        $appointment->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
