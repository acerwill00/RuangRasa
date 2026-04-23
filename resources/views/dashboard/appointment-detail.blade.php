@extends('layouts.app')

@section('title', 'Appointment Detail — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-3xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="/dashboard" class="text-text-main opacity-50 hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Appointment Detail</h1>
                <p class="text-xs opacity-50 mt-0.5">Booking confirmed on {{ $apt->created_at->format('d M Y') }}</p>
            </div>

            @php
                $aptBadge = match($apt->status) {
                    'scheduled' => 'bg-blue-100 text-blue-700',
                    'completed' => 'bg-green-100 text-green-700',
                    'canceled'  => 'bg-red-100 text-red-700',
                    default     => 'bg-slate-100 text-slate-600',
                };
                $orderBadge = match($apt->order->status ?? 'unknown') {
                    'success'            => 'bg-green-100 text-green-700',
                    'pending'            => 'bg-yellow-100 text-yellow-700',
                    'failed', 'canceled' => 'bg-red-100 text-red-700',
                    default              => 'bg-slate-100 text-slate-600',
                };
                $serviceLabel = match($apt->service_type ?? '') {
                    'psikolog_klinis' => 'Psikolog Klinis',
                    'konseling'       => 'Konseling',
                    default           => 'Session',
                };
                $scheduleDateTime = \Carbon\Carbon::parse($apt->schedule_date . ' ' . $apt->schedule_time);
                $hoursUntil       = \Carbon\Carbon::now()->diffInHours($scheduleDateTime, false);
                $canCancel        = $apt->status === 'scheduled' && $hoursUntil >= 24;
            @endphp
            <span class="ml-auto px-3 py-1.5 rounded-full text-xs font-bold {{ $aptBadge }}">
                {{ ucfirst($apt->status) }}
            </span>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-5">

            {{-- Session Hero --}}
            <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                <div class="flex items-center gap-5">
                    {{-- Psychologist Avatar --}}
                    @php $psyPhoto = asset('img/prof-pic.jpeg'); @endphp
                    @if($psyPhoto)
                        <img src="{{ $psyPhoto }}" alt="{{ $apt->psychologist->name }}" class="w-20 h-20 rounded-2xl object-cover flex-shrink-0">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary to-cta flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                            {{ strtoupper(substr($apt->psychologist->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <p class="text-xs font-bold opacity-40 uppercase tracking-widest mb-1">Your Psychologist</p>
                        <h2 class="text-xl font-bold text-text-main">{{ $apt->psychologist->name }}</h2>
                        <p class="text-sm opacity-60">{{ $apt->psychologist->specialization }}</p>
                        <span class="inline-block mt-2 text-xs font-semibold px-2.5 py-0.5 bg-secondary rounded-full">{{ $serviceLabel }}</span>
                    </div>
                </div>
            </div>

            {{-- When & Where --}}
            <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-5">Your Session Schedule</h2>
                <div class="flex flex-col sm:flex-row gap-5">
                    <div class="flex-1 flex items-center gap-4 p-4 bg-secondary/30 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-primary/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold">Date</p>
                            <p class="font-bold text-text-main">{{ $scheduleDateTime->format('D, d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center gap-4 p-4 bg-secondary/30 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-primary/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold">Time</p>
                            <p class="font-bold text-text-main">{{ $scheduleDateTime->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                {{-- Countdown / past indicator & Join Button --}}
                <div class="mt-4 pt-4 border-t border-secondary/50 text-sm">
                    @if($apt->status === 'canceled')
                        <p class="text-red-500 font-semibold flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            This appointment was canceled.
                        </p>
                    @elseif($scheduleDateTime->isPast() && $apt->status !== 'scheduled')
                        <p class="text-slate-400 font-semibold flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Session has passed.
                        </p>
                    @else
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <p class="text-cta font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Upcoming in {{ max(0, round($hoursUntil)) }} hours
                            </p>
                            
                            @if($apt->status === 'scheduled')
                                <a href="https://meet.google.com/kkm-wjfm-gyc" target="_blank" rel="noopener noreferrer" 
                                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#B18FE4] hover:bg-[#9E7CD1] text-white rounded-xl font-bold transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    Join Google Meet
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Payment Details --}}
            <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-5">Payment</h2>
                <div class="flex items-end justify-between mb-5">
                    <div>
                        <p class="text-xs opacity-50 font-semibold mb-1">Total charged</p>
                        <p class="text-3xl font-black text-text-main">Rp {{ number_format($apt->order->amount ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $orderBadge }}">
                        {{ ucfirst($apt->order->status ?? 'unknown') }}
                    </span>
                </div>

                <div class="space-y-3 border-t border-secondary/50 pt-4 text-sm">
                    <div class="flex justify-between">
                        <span class="opacity-50 font-semibold">Order ID</span>
                        <span class="font-mono text-xs opacity-70 max-w-[200px] text-right truncate">{{ $apt->order_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="opacity-50 font-semibold">Payment Date</span>
                        <span class="font-medium">{{ optional($apt->order)->updated_at?->format('d M Y, H:i') ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="opacity-50 font-semibold">Session Fee</span>
                        <span class="font-medium">Rp {{ number_format($apt->psychologist->price_per_session, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            @if($canCancel)
                <div class="bg-white border border-red-100 rounded-[1.8rem] shadow-soft p-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Cancel Appointment</h2>
                    <p class="text-sm opacity-60 mb-4">You can cancel this appointment until 24 hours before the scheduled time. After that, cancellation is no longer available.</p>
                    <form method="POST" action="{{ route('appointment.cancel', $apt->id) }}"
                          onsubmit="return confirm('Are you sure you want to cancel this appointment? This cannot be undone.')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border-2 border-red-200 text-red-600 hover:bg-red-50 hover:border-red-400 font-bold text-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Cancel This Appointment
                        </button>
                    </form>
                </div>
            @elseif($apt->status === 'scheduled' && !$canCancel)
                <div class="bg-secondary/20 border border-secondary rounded-[1.8rem] p-5 text-sm text-slate-500 flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Cancellation is no longer available — your session starts within 24 hours.
                </div>
            @endif

            {{-- Rating Section --}}
            @if($apt->status === 'completed')
                <div class="bg-white border border-secondary rounded-[1.8rem] shadow-soft p-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Rate Your Session</h2>
                    @if($apt->rating === null)
                        <form method="POST" action="{{ route('appointment.rate', $apt->id) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-text-main">Rating</label>
                                <div class="flex items-center gap-2 flex-row-reverse justify-end" x-data="{ rating: 0, hoverRating: 0 }">
                                    <template x-for="i in 5">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="rating" :value="6 - i" class="hidden" x-model="rating" required>
                                            <svg class="w-8 h-8 transition-colors" 
                                                 :class="{'text-yellow-400': (6 - i) <= rating || (6 - i) <= hoverRating, 'text-slate-200': (6 - i) > rating && (6 - i) > hoverRating}" 
                                                 @mouseenter="hoverRating = (6 - i)" 
                                                 @mouseleave="hoverRating = 0" 
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </label>
                                    </template>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-text-main">Review <span class="font-normal opacity-50">(optional)</span></label>
                                <textarea name="review" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta transition-all" placeholder="How was your session?"></textarea>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold transition-all shadow-sm">
                                Submit Feedback
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $apt->rating ? 'text-yellow-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        @if($apt->review)
                            <p class="text-sm opacity-80 italic mt-2">"{{ $apt->review }}"</p>
                        @endif
                    @endif
                </div>
            @endif

            {{-- Support Action --}}
            <div class="mt-8 flex justify-center pb-10">
                <a href="{{ route('complaints.create', ['appointment_id' => $apt->id]) }}" class="text-sm font-semibold text-slate-400 hover:text-text-main flex items-center gap-2 transition-colors border-b border-transparent hover:border-text-main pb-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Report an Issue
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
