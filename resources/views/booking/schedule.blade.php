@extends('layouts.app')

@section('title', 'Pick a Schedule — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]" x-data="scheduleWizard()">
    <div class="max-w-6xl mx-auto px-6">

        {{-- ── Progress Bar ──────────────────────────────────────────────── --}}
        <div class="mb-12 mt-4 px-4 md:px-10">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1.5 bg-white rounded-full -z-10 shadow-sm border border-secondary/50"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-2/3 h-1.5 bg-cta rounded-full -z-10"></div>

                {{-- Step 1 — Done --}}
                <a href="/our-psychologist" class="flex flex-col items-center gap-2 bg-secondary/10 hover:bg-secondary/20 transition-colors py-1 px-1 md:px-2 rounded-lg group">
                    <div class="w-8 h-8 rounded-full bg-cta text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-text-main hidden md:block opacity-80">1. Psych</span>
                </a>

                {{-- Step 2 — Done --}}
                <a href="/book/{{ $psychologist->id }}" class="flex flex-col items-center gap-2 bg-secondary/10 hover:bg-secondary/20 transition-colors py-1 px-1 md:px-2 rounded-lg group">
                    <div class="w-8 h-8 rounded-full bg-cta text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-text-main hidden md:block opacity-80">2. Service</span>
                </a>

                {{-- Step 3 — Active --}}
                <div class="flex flex-col items-center gap-2 cursor-default">
                    <div class="w-10 h-10 rounded-full bg-primary text-text-main ring-4 ring-white flex items-center justify-center font-bold text-lg shadow-soft">3</div>
                    <span class="text-xs font-bold text-cta bg-white px-2 py-0.5 rounded shadow-sm">3. Schedule</span>
                </div>

                {{-- Step 4 — Locked --}}
                <div class="flex flex-col items-center gap-2 bg-secondary/10 py-1 px-1 md:px-2 rounded-lg text-text-main/40">
                    <div class="w-8 h-8 rounded-full bg-white border border-secondary flex items-center justify-center font-bold text-sm shadow-sm">4</div>
                    <span class="text-xs font-medium hidden md:block">4. Payment</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ── Main Column ─────────────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-soft border border-secondary/50">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold mb-2">Pick Your Ideal Time</h1>
                        <p class="opacity-70 text-sm flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Times shown in WIB (GMT+7)
                        </p>
                    </div>

                    {{-- ── Date Strip ─────────────────────────────────── --}}
                    <div class="mb-8">
                        <h2 class="font-semibold text-sm uppercase tracking-wider mb-4 opacity-60">Next 7 Days</h2>
                        <div class="flex overflow-x-auto gap-3 pb-4 pt-2 px-1 -mx-1 hide-scrollbar">
                            @foreach($dates as $d)
                                @php
                                    $carbon    = \Carbon\Carbon::parse($d);
                                    $dayName   = $carbon->format('D');
                                    $dayNum    = $carbon->format('j');
                                    $monthName = $carbon->format('M');
                                    $isToday   = $carbon->isToday();
                                @endphp
                                <button type="button"
                                    @click="selectDate('{{ $d }}')"
                                    :class="selectedDate === '{{ $d }}'
                                        ? 'border-cta bg-primary/10 text-cta shadow-sm scale-105'
                                        : 'border-secondary hover:border-primary/50 hover:bg-secondary/40'"
                                    class="min-w-[72px] flex flex-col items-center p-3 rounded-2xl border-2 transition-all cursor-pointer">
                                    <span class="text-xs font-semibold uppercase mb-0.5">
                                        {{ $isToday ? 'Today' : $dayName }}
                                    </span>
                                    <span class="text-2xl font-bold leading-none">{{ $dayNum }}</span>
                                    <span class="text-xs opacity-60 mt-0.5">{{ $monthName }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Time Slots ──────────────────────────────────── --}}
                    <div>
                        <h2 class="font-semibold text-sm uppercase tracking-wider mb-4 opacity-60 flex items-center gap-2">
                            <svg class="w-4 h-4 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="selectedDateLabel"></span>
                        </h2>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3" x-show="selectedDate">
                            @foreach($timeSlots as $slot)
                                <button type="button"
                                    @click="selectTime('{{ $slot }}')"
                                    :disabled="isBooked('{{ $slot }}')"
                                    :class="{
                                        'opacity-40 cursor-not-allowed bg-secondary/20 border-secondary': isBooked('{{ $slot }}'),
                                        'border-2 border-cta bg-primary/10 text-cta font-bold shadow-md': selectedTime === '{{ $slot }}' && !isBooked('{{ $slot }}'),
                                        'border border-secondary hover:bg-primary/10 hover:border-primary hover:text-cta cursor-pointer': selectedTime !== '{{ $slot }}' && !isBooked('{{ $slot }}')
                                    }"
                                    class="py-3 px-4 rounded-xl text-sm text-center transition-all relative overflow-hidden">
                                    {{ \Carbon\Carbon::createFromFormat('H:i', $slot)->format('h:i A') }}
                                    <span x-show="isBooked('{{ $slot }}')" class="block text-[10px] font-semibold mt-0.5 opacity-70">Booked</span>
                                    <div x-show="selectedTime === '{{ $slot }}' && !isBooked('{{ $slot }}')" class="absolute bottom-0 left-0 w-full h-0.5 bg-cta"></div>
                                </button>
                            @endforeach
                        </div>

                        <div x-show="!selectedDate" class="py-8 text-center opacity-50 text-sm">
                            ← Select a date to see available slots
                        </div>
                    </div>

                    {{-- ── Validation errors ───────────────────────────── --}}
                    @if($errors->any())
                        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- ── Submit Form ─────────────────────────────────── --}}
                    <form method="POST" action="/book/{{ $psychologist->id }}/schedule" id="schedule-form" class="mt-8">
                        @csrf
                        <input type="hidden" name="date" :value="selectedDate">
                        <input type="hidden" name="time" :value="selectedTime">

                        <button type="button"
                            @click="submitSchedule"
                            :disabled="!selectedDate || !selectedTime"
                            :class="(!selectedDate || !selectedTime) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-cta-hover hover:shadow-lg hover:-translate-y-0.5'"
                            class="w-full py-4 bg-cta text-white rounded-xl font-bold transition-all shadow-md text-[15px] flex items-center justify-center gap-2">
                            Continue to Payment
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Sidebar Summary ──────────────────────────────────────── --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-soft border border-secondary/50 sticky top-28">
                    <h3 class="font-bold text-lg mb-6 flex items-center justify-between">
                        Booking Summary
                    </h3>

                    @php
                        $photo = asset('img/prof-pic.jpeg');
                        $serviceLabel = $booking['service_type'] === 'psikolog_klinis' ? 'Psikolog Klinis' : 'Konseling';
                    @endphp

                    <div class="flex gap-4 mb-6 bg-secondary/20 p-4 rounded-xl border border-secondary">
                        <img src="{{ $photo }}" alt="{{ $booking['psychologist']->name }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0">
                        <div class="flex flex-col justify-center min-w-0">
                            <p class="font-bold text-sm truncate">{{ $booking['psychologist']->name }}</p>
                            <p class="text-xs opacity-70">{{ $booking['psychologist']->specialization ?? 'Psychologist' }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6 text-sm divide-y divide-secondary">
                        <div class="flex justify-between items-center py-2">
                            <span class="opacity-70 font-medium">Service</span>
                            <span class="font-semibold text-right">{{ $serviceLabel }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="opacity-70 font-medium">Duration</span>
                            <span class="font-semibold">60 Minutes</span>
                        </div>
                        <div class="flex justify-between items-center py-2 bg-primary/5 -mx-4 px-4 rounded-lg border border-primary/20">
                            <span class="opacity-80 font-medium">Date & Time</span>
                            <span class="font-bold text-cta text-right" x-text="selectedDate ? selectedDateShort + ' · ' + selectedTimeLabel : '—'"></span>
                        </div>
                    </div>

                    <div class="pt-4 border-t-2 border-dashed border-secondary">
                        <div class="flex justify-between items-end">
                            <span class="font-semibold opacity-70">Total Amount</span>
                            <span class="font-bold text-2xl text-cta">Rp {{ number_format($booking['service_price'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Booked slots from PHP — keyed by date, value is array of 'HH:MM' strings
const bookedSlots = @json($bookedSlots);

function scheduleWizard() {
    return {
        selectedDate: '',
        selectedTime: '',

        get selectedDateLabel() {
            if (!this.selectedDate) return 'Select a date';
            const d = new Date(this.selectedDate + 'T00:00:00');
            return 'Slots for ' + d.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short' });
        },
        get selectedDateShort() {
            if (!this.selectedDate) return '';
            const d = new Date(this.selectedDate + 'T00:00:00');
            return d.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short' });
        },
        get selectedTimeLabel() {
            if (!this.selectedTime) return '';
            const [h, m] = this.selectedTime.split(':');
            const d = new Date();
            d.setHours(parseInt(h), parseInt(m));
            return d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
        },

        selectDate(date) {
            this.selectedDate = date;
            this.selectedTime = ''; // reset time when date changes
        },
        selectTime(time) {
            if (!this.isBooked(time)) {
                this.selectedTime = time;
            }
        },
        isBooked(time) {
            if (!this.selectedDate) return false;
            const slots = bookedSlots[this.selectedDate] || [];
            return slots.includes(time);
        },
        submitSchedule() {
            if (!this.selectedDate || !this.selectedTime) return;
            document.getElementById('schedule-form').submit();
        }
    };
}
</script>
@endsection
