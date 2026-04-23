@extends('layouts.app')

@section('title', $psychologist['name'] . ' - Profile')

@section('content')

<!-- Profile Hero Section -->
<section class="bg-slate-50 pt-16 pb-20 border-b border-primary/20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-20 items-start">
            
            <!-- Left Column: Visuals -->
            <div class="md:col-span-5 lg:col-span-4 flex flex-col gap-6">
                <!-- Large Image -->
                <div class="rounded-2xl overflow-hidden aspect-square md:aspect-[3/4] shadow-soft border border-slate-100 w-full bg-white relative">
                    <img src="{{ $psychologist['image'] }}" alt="{{ $psychologist['name'] }}" class="w-full h-full object-cover">
                </div>
                
                <!-- Specialties Badges -->
                <div>
                    <h3 class="text-sm font-semibold opacity-60 uppercase tracking-wide mb-3">Specialties</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($psychologist['specialties'] as $specialty)
                        <span class="px-4 py-2.5 bg-white text-text-main text-sm font-bold rounded-full shadow-sm border border-secondary text-slate-600">{{ $specialty }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Profile Data -->
            <div class="md:col-span-7 lg:col-span-8 flex flex-col pt-4 md:pt-0">
                
                <!-- Verified Badge -->
                <div class="flex items-center gap-2 mb-4 bg-blue-50 w-max px-4 py-2 rounded-xl border border-blue-100 shadow-sm">
                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-1.998A11.954 11.954 0 0110 1.944zM13.707 9.707a1 1 0 00-1.414-1.414l-3 3-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-bold text-blue-700 tracking-wide">{{ $psychologist['badges'] }}</span>
                </div>

                <!-- Name -->
                <h1 class="text-4xl lg:text-5xl font-bold text-text-main mb-8 leading-tight">{{ $psychologist['name'] }}</h1>

                <!-- Bio -->
                <div class="space-y-4 text-lg opacity-85 leading-relaxed mb-10 max-w-3xl">
                    <p>{{ $psychologist['bio1'] }}</p>
                    <p>{{ $psychologist['bio2'] }}</p>
                </div>

                <!-- Quick Facts Grid -->
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10 bg-white p-8 rounded-2xl shadow-sm border border-secondary">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Experience</p>
                        <p class="font-black text-xl text-text-main">{{ $psychologist['experience'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Languages</p>
                        <p class="font-black text-xl text-text-main">{{ $psychologist['languages'] }}</p>
                    </div>
                    <div class="col-span-2 lg:col-span-1 border-t lg:border-t-0 lg:border-l border-secondary pt-6 lg:pt-0 lg:pl-8">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Session Price</p>
                        <p class="font-black text-2xl text-cta leading-none mt-1">Rp{{ $psychologist['price'] }} <span class="block text-xs font-bold mt-1 text-slate-400 tracking-wider">/ SESSION</span></p>
                    </div>
                </div>

                <!-- CTA -->
                <div>
                    @auth
                        @if(!auth()->user()->is_admin)
                            <a href="/book/{{ $psychologist['id'] }}" class="inline-flex items-center justify-center w-full md:w-auto px-10 py-5 bg-cta hover:bg-cta-hover text-white rounded-2xl font-bold text-lg transition-all shadow-md hover:shadow-xl hover:-translate-y-1">
                                Book a Session with {{ explode(' ', $psychologist['name'])[0] }}
                                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @else
                            <div class="inline-flex items-center gap-3 px-6 py-4 bg-secondary/40 border border-secondary rounded-2xl text-sm font-semibold text-slate-500">
                                <svg class="w-5 h-5 text-cta/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Admin View — Booking disabled
                            </div>
                        @endif
                    @else
                        <a href="/login" class="inline-flex items-center justify-center w-full md:w-auto px-10 py-5 border-2 border-primary/50 hover:border-cta bg-primary/5 hover:bg-primary/10 text-text-main rounded-2xl font-bold text-lg transition-all">
                            <svg class="w-5 h-5 mr-2 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Log In to Book a Session
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Availability & Schedule Section -->
@auth
    @if(!auth()->user()->is_admin)
<section id="schedule" class="py-24 bg-white" x-data="profileSchedule()">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl lg:text-4xl font-bold mb-10">Available Schedules</h2>
        
        <div class="bg-secondary/10 border border-secondary p-8 lg:p-12 rounded-[2rem] shadow-sm">
            
            {{-- ── Step 1: Pick a Date ────────────────────────────────────── --}}
            <p class="text-xs font-bold uppercase tracking-widest opacity-50 mb-4 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-cta text-white text-[10px] flex items-center justify-center font-black">1</span>
                Choose a Date
            </p>
            <div class="flex flex-wrap gap-4 pb-2 mb-8">
                @foreach($dates as $d)
                    @php
                        $carbon    = \Carbon\Carbon::parse($d);
                        $isToday   = $carbon->isToday();
                    @endphp
                    <button type="button"
                        @click="selectDate('{{ $d }}', '{{ $carbon->format('D, M j') }}')"
                        :class="selectedDate === '{{ $d }}'
                            ? 'border-cta bg-primary/20 text-cta shadow-sm scale-105 ring-2 ring-cta/20'
                            : 'border-slate-200 bg-white hover:border-cta/50 text-slate-600'"
                        class="min-w-[90px] flex flex-col items-center p-4 rounded-2xl border-2 transition-all cursor-pointer">
                        <span class="text-xs font-bold uppercase mb-1">{{ $isToday ? 'Today' : $carbon->format('D') }}</span>
                        <span class="text-2xl font-black leading-none">{{ $carbon->format('j') }}</span>
                        <span class="text-xs opacity-60 mt-0.5">{{ $carbon->format('M') }}</span>
                    </button>
                @endforeach
            </div>

            {{-- ── Step 2: Pick a Time ────────────────────────────────────── --}}
            <div x-show="selectedDate !== null"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <div class="h-px w-full bg-slate-200 mb-8"></div>

                <p class="text-xs font-bold uppercase tracking-widest opacity-50 mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-cta text-white text-[10px] flex items-center justify-center font-black">2</span>
                    Choose a Time <span class="font-normal normal-case opacity-70 tracking-normal">(WIB – GMT+7)</span>
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 mb-8">
                    @foreach($timeSlots as $slot)
                        <button type="button"
                            @click="!isBooked('{{ $slot }}') && selectTime('{{ $slot }}')"
                            :disabled="isBooked('{{ $slot }}')"
                            :class="{
                                'opacity-40 cursor-not-allowed bg-slate-50 border-slate-200 text-slate-400': isBooked('{{ $slot }}'),
                                'border-2 border-cta bg-primary/10 text-cta font-bold shadow-md ring-2 ring-cta/20': selectedTime === '{{ $slot }}' && !isBooked('{{ $slot }}'),
                                'border border-slate-200 bg-white hover:border-cta/60 hover:text-cta text-slate-700': selectedTime !== '{{ $slot }}' && !isBooked('{{ $slot }}')
                            }"
                            class="py-4 px-4 rounded-xl text-sm text-center transition-all font-semibold relative">
                            {{ \Carbon\Carbon::createFromFormat('H:i', $slot)->format('H:i') }} WIB
                            <span x-show="isBooked('{{ $slot }}')" class="block text-[10px] font-semibold mt-0.5 opacity-60">Booked</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- ── Confirmation CTA ────────────────────────────────────────── --}}
            <div x-show="selectedDate !== null && selectedTime !== null"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="border-t-2 border-dashed border-primary/40 pt-8">

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 bg-white rounded-2xl p-6 border border-primary/30 shadow-sm">

                    {{-- Summary --}}
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold opacity-50 uppercase tracking-wide mb-0.5">Your selection</p>
                            <p class="font-bold text-text-main" x-text="selectedDate ? (dateLabel + ' · ' + selectedTime + ' WIB') : ''"></p>
                            <p class="text-xs opacity-60 mt-0.5">Service & payment confirmed on the next step</p>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <a :href="`/book/{{ $psychologist['id'] }}?date=${selectedDate}&time=${selectedTime}`"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 whitespace-nowrap flex-shrink-0">
                        Book This Session
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
    @endif
@else
<section class="py-16 bg-white border-t border-secondary/50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-secondary/20 border border-dashed border-primary/40 rounded-[2rem] p-12 text-center">
            <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-text-main mb-3">Log In to See Available Schedules</h3>
            <p class="text-slate-500 mb-7 max-w-md mx-auto">Create an account or log in to view available appointment dates and book a session with this psychologist.</p>
            <div class="flex items-center justify-center gap-4">
                <a href="/login" class="px-7 py-3 bg-cta hover:bg-cta-hover text-white rounded-xl font-semibold transition-all shadow-sm hover:shadow">
                    Log In
                </a>
                <a href="/register" class="px-7 py-3 border-2 border-primary/40 hover:border-cta text-text-main rounded-xl font-semibold transition-all">
                    Create Account
                </a>
            </div>
        </div>
    </div>
</section>
@endauth

<!-- Reviews & Trust Section -->
<section class="py-24 bg-secondary/20 border-t border-secondary">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl lg:text-4xl font-bold mb-12 text-center">What Clients Say About {{ explode(' ', $psychologist['name'])[0] }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @forelse($reviews as $review)
            <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col relative h-full hover:shadow-md transition-shadow">
                <div class="text-6xl text-primary/30 absolute top-6 right-8 font-serif leading-none">"</div>
                <div class="flex text-yellow-400 mb-6 gap-0.5">
                    @for($i=0; $i<5; $i++)
                        <svg class="w-5 h-5 {{ $i < $review->rating ? 'fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor
                </div>
                <p class="opacity-80 leading-relaxed mb-8 flex-grow italic mt-2">"{{ $review->review ?? 'No written feedback provided, but gave a great rating!' }}"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                    <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center font-black text-text-main shadow-sm">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                    <div>
                        <p class="font-bold">{{ $review->user->name }}</p>
                        <p class="text-xs font-semibold opacity-50 uppercase tracking-widest mt-0.5">Verified Client</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-slate-500 py-10 bg-white rounded-2xl border border-slate-100">
                <p>No reviews yet for this psychologist. Be the first to leave a review after your session!</p>
            </div>
            @endforelse

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
const profileBookedSlots = @json($bookedSlots ?? []);

function profileSchedule() {
    return {
        selectedDate: null,
        selectedTime: null,
        dateLabel: '',

        selectDate(date, label) {
            this.selectedDate = date;
            this.selectedTime = null;
            this.dateLabel = label;
        },
        selectTime(time) {
            if (!this.isBooked(time)) {
                this.selectedTime = time;
            }
        },
        isBooked(time) {
            if (!this.selectedDate) return false;
            const slots = profileBookedSlots[this.selectedDate] || [];
            return slots.includes(time);
        },
    };
}
</script>
@endsection
