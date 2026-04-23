@extends('layouts.app')

@section('title', 'Choose Service — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-6xl mx-auto px-6">

        {{-- ── Progress Bar ──────────────────────────────────────────────── --}}
        @php $hasPreselectedSchedule = session('booking.date') && session('booking.time'); @endphp
        <div class="mb-12 mt-4 px-4 md:px-10">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1.5 bg-white rounded-full -z-10 shadow-sm border border-secondary/50"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 {{ $hasPreselectedSchedule ? 'w-2/3' : 'w-1/3' }} h-1.5 bg-cta rounded-full -z-10 transition-all"></div>

                {{-- Step 1 — Done --}}
                <a href="/our-psychologist" class="flex flex-col items-center gap-2 bg-secondary/10 hover:bg-secondary/20 transition-colors py-1 px-1 md:px-2 rounded-lg cursor-pointer group">
                    <div class="w-8 h-8 rounded-full bg-cta text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-text-main hidden md:block opacity-80 group-hover:opacity-100">1. Psych</span>
                </a>

                {{-- Step 2 — Active --}}
                <div class="flex flex-col items-center gap-2 cursor-default">
                    <div class="w-10 h-10 rounded-full bg-primary text-text-main ring-4 ring-white flex items-center justify-center font-bold text-lg shadow-soft">2</div>
                    <span class="text-xs font-bold text-cta bg-white px-2 py-0.5 rounded shadow-sm">2. Service</span>
                </div>

                {{-- Step 3 — Done if pre-selected, otherwise locked --}}
                @if($hasPreselectedSchedule)
                    <div class="flex flex-col items-center gap-2 bg-secondary/10 py-1 px-1 md:px-2 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-cta text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-xs font-semibold text-text-main hidden md:block opacity-80">3. Schedule</span>
                    </div>
                @else
                    <div class="flex flex-col items-center gap-2 bg-secondary/10 py-1 px-1 md:px-2 rounded-lg text-text-main/40">
                        <div class="w-8 h-8 rounded-full bg-white border border-secondary flex items-center justify-center font-bold text-sm shadow-sm">3</div>
                        <span class="text-xs font-medium hidden md:block">3. Schedule</span>
                    </div>
                @endif

                {{-- Step 4 — Locked --}}
                <div class="flex flex-col items-center gap-2 bg-secondary/10 py-1 px-1 md:px-2 rounded-lg text-text-main/40">
                    <div class="w-8 h-8 rounded-full bg-white border border-secondary flex items-center justify-center font-bold text-sm shadow-sm">4</div>
                    <span class="text-xs font-medium hidden md:block">4. Payment</span>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto mt-8 mb-24">

            {{-- ── Psychologist Card ────────────────────────────────────── --}}
            <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 p-6 mb-8 flex items-center gap-5">
                @php
                    $photo = asset('img/prof-pic.jpeg');
                @endphp
                <img src="{{ $photo }}" alt="{{ $psychologist->name }}" class="w-16 h-16 rounded-2xl object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-text-main text-lg leading-tight truncate">{{ $psychologist->name }}</p>
                    <p class="text-sm opacity-60 mt-0.5">{{ $psychologist->specialization ?? 'Clinical Psychologist' }}</p>
                </div>
                <a href="/psychologist/{{ $psychologist->id }}" class="text-xs font-semibold text-cta hover:underline flex-shrink-0">Change</a>
            </div>

            {{-- ── Header ──────────────────────────────────────────────── --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-3 text-text-main">Select Session Type</h1>
                <p class="opacity-70 text-lg">Choose the type of support you need.</p>
            </div>

            {{-- ── Service Cards ────────────────────────────────────────── --}}
            <form method="POST" action="/book/{{ $psychologist->id }}" id="service-form">
                @csrf
                <input type="hidden" name="service_type" id="service_type_input" value="">

                <div class="grid grid-cols-1 gap-5" id="service-cards">
                    {{-- Psikolog Klinis --}}
                    <button type="button"
                        data-service="psikolog_klinis"
                        data-price="{{ number_format($psychologist->price_per_session, 0, ',', '.') }}"
                        onclick="selectService('psikolog_klinis')"
                        class="service-card bg-white p-8 lg:p-10 rounded-[2rem] border-2 border-transparent hover:border-cta/50 shadow-sm hover:shadow-lg transition-all flex items-center justify-between group cursor-pointer relative overflow-hidden text-left w-full">
                        <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-14 h-14 bg-secondary rounded-2xl flex items-center justify-center text-text-main/70 group-hover:bg-primary/20 group-hover:text-cta transition-colors flex-shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold mb-1.5 group-hover:text-cta transition-colors">Clinical Psychologist</h3>
                                <p class="opacity-70 text-[15px] font-medium max-w-sm">Assists in exploring issues more deeply, understanding disruptive patterns, and receiving structured interventions.</p>
                            </div>
                        </div>
                        <div class="relative z-10 text-right pr-2 flex-shrink-0 ml-4">
                            <span class="block font-black text-xl text-text-main mb-2">Rp {{ number_format($psychologist->price_per_session, 0, ',', '.') }}</span>
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full border-2 border-slate-200 group-hover:border-cta group-hover:bg-cta group-hover:text-white transition-all text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </button>

                    {{-- Konseling --}}
                    <button type="button"
                        data-service="konseling"
                        data-price="150.000"
                        onclick="selectService('konseling')"
                        class="service-card bg-white p-8 lg:p-10 rounded-[2rem] border-2 border-transparent hover:border-cta/50 shadow-sm hover:shadow-lg transition-all flex items-center justify-between group cursor-pointer relative overflow-hidden text-left w-full">
                        <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-14 h-14 bg-secondary rounded-2xl flex items-center justify-center text-text-main/70 group-hover:bg-primary/20 group-hover:text-cta transition-colors flex-shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold mb-1.5 group-hover:text-cta transition-colors">Counseling with a Counselor</h3>
                                <p class="opacity-70 text-[15px] font-medium max-w-sm">Accompanied by a trained counselor who listens without judgment in a safe and supportive sharing session.</p>
                            </div>
                        </div>
                        <div class="relative z-10 text-right pr-2 flex-shrink-0 ml-4">
                            <span class="block font-black text-xl text-text-main mb-2">Rp 150.000</span>
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full border-2 border-slate-200 group-hover:border-cta group-hover:bg-cta group-hover:text-white transition-all text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </button>
                </div>
            </form>

            <a href="/our-psychologist" class="mt-8 text-sm font-bold opacity-60 hover:opacity-100 hover:text-cta transition-colors flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Psychologists
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function selectService(type) {
    // Highlight the selected card
    document.querySelectorAll('.service-card').forEach(card => {
        card.classList.remove('border-cta', 'shadow-lg', 'scale-[1.01]');
        card.classList.add('border-transparent');
    });
    const selected = document.querySelector(`[data-service="${type}"]`);
    selected.classList.remove('border-transparent');
    selected.classList.add('border-cta', 'shadow-lg', 'scale-[1.01]');

    // Set the hidden input and submit
    document.getElementById('service_type_input').value = type;

    // Brief visual delay for the highlight to show before submitting
    setTimeout(() => document.getElementById('service-form').submit(), 200);
}
</script>
@endsection
