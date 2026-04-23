@extends('layouts.app')

@section('title', 'My Bookings — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 min-h-[calc(100vh-80px)]">
    <div class="max-w-5xl mx-auto px-6 py-10">

        {{-- ── Welcome Hero ──────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-bold text-text-main">
                    Welcome back, {{ explode(' ', auth()->user()->name)[0] }} 👋
                </h1>
                <p class="text-sm opacity-60 mt-1">Here are all your counseling sessions.</p>
            </div>
            <a href="/our-psychologist"
               class="inline-flex items-center gap-2 px-6 py-3 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Book New Session
            </a>
        </div>

        {{-- ── Flash Messages ────────────────────────────────────────────── --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── Empty State ───────────────────────────────────────────────── --}}
        @if($appointments->isEmpty())
            <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-6 bg-secondary rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-cta/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold mb-2 text-text-main">No sessions yet</h2>
                <p class="text-sm opacity-60 mb-6 max-w-xs mx-auto">You haven't booked any counseling sessions. Take the first step toward feeling better.</p>
                <a href="/our-psychologist" class="inline-flex items-center gap-2 px-8 py-3 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    Meet Our Psychologists
                </a>
            </div>

        {{-- ── Appointment Cards ─────────────────────────────────────────── --}}
        @else
            <div class="space-y-4">
                @foreach($appointments as $apt)
                    @php
                        $orderStatus = $apt->order->status ?? 'unknown';
                        $aptStatus   = $apt->status;

                        $orderBadge = match($orderStatus) {
                            'success'            => 'bg-green-100 text-green-700',
                            'pending'            => 'bg-yellow-100 text-yellow-700',
                            'failed', 'canceled' => 'bg-red-100 text-red-700',
                            default              => 'bg-slate-100 text-slate-600',
                        };
                        $aptBadge = match($aptStatus) {
                            'scheduled' => 'bg-blue-100 text-blue-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'canceled'  => 'bg-red-100 text-red-700',
                            default     => 'bg-slate-100 text-slate-600',
                        };

                        $scheduleDateTime = \Carbon\Carbon::parse($apt->schedule_date . ' ' . $apt->schedule_time);
                        $isPast           = $scheduleDateTime->isPast();
                        $hoursUntil       = \Carbon\Carbon::now()->diffInHours($scheduleDateTime, false);
                        $canCancel        = $aptStatus === 'scheduled' && $hoursUntil >= 24;

                        $photo = asset('img/prof-pic.jpeg');

                        $serviceLabel = match($apt->service_type ?? '') {
                            'psikolog_klinis' => 'Psikolog Klinis',
                            'konseling'       => 'Konseling',
                            default           => 'Session',
                        };
                    @endphp

                    <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6 flex flex-col sm:flex-row sm:items-center gap-5 transition-all hover:shadow-md hover:border-primary/30">

                        {{-- Avatar --}}
                        <div class="flex-shrink-0">
                            @if($photo)
                                <img src="{{ $photo }}" alt="{{ $apt->psychologist->name }}" class="w-16 h-16 rounded-2xl object-cover">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center text-text-main font-bold text-xl">
                                    {{ substr($apt->psychologist->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        {{-- Main info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h2 class="font-bold text-text-main text-base">{{ $apt->psychologist->name }}</h2>
                                <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-secondary text-text-main/70">{{ $serviceLabel }}</span>
                            </div>
                            <p class="text-sm opacity-60 mb-3">{{ $apt->psychologist->specialization ?? 'Psychologist' }}</p>

                            <div class="flex flex-wrap gap-2 items-center text-xs font-semibold">
                                {{-- Date/Time chip --}}
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-secondary/60 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $scheduleDateTime->format('D, d M Y') }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-secondary/60 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $scheduleDateTime->format('h:i A') }}
                                </span>

                                {{-- Status badges --}}
                                <span class="px-3 py-1.5 rounded-full {{ $orderBadge }}">
                                    Payment: {{ ucfirst($orderStatus) }}
                                </span>
                                <span class="px-3 py-1.5 rounded-full {{ $aptBadge }}">
                                    {{ ucfirst($aptStatus) }}
                                </span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex-shrink-0">
                            <a href="{{ route('appointment.show', $apt->id) }}"
                               class="text-xs font-bold px-4 py-2 border border-slate-200 rounded-xl hover:border-cta hover:text-cta transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
