@extends('layouts.app')

@section('title', 'Appointment #{{ $apt->id }} — Admin')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-4xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="/admin/dashboard" class="text-text-main opacity-50 hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Appointment Detail</h1>
                <p class="text-xs opacity-50 mt-0.5">ID #{{ $apt->id }} &middot; Order {{ $apt->order_id }}</p>
            </div>

            {{-- Status badge --}}
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
            @endphp
            <div class="ml-auto flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $aptBadge }}">
                    {{ ucfirst($apt->status) }}
                </span>
                
                @if($apt->status === 'scheduled')
                    <form action="{{ route('admin.appointment.complete', $apt) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 rounded-full text-xs font-bold bg-green-500 text-white hover:bg-green-600 shadow-sm transition-colors"
                            onclick="return confirm('Are you sure you want to mark this session as completed? This will notify the patient and ask for a review.')">
                            Mark as Completed
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Left column: Patient + Psychologist --}}
            <div class="md:col-span-2 space-y-5">

                {{-- Patient Card --}}
                <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Patient</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-cta flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            {{ strtoupper(substr($apt->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-text-main text-base">{{ $apt->user->name }}</p>
                            <p class="text-sm opacity-60">{{ $apt->user->email }}</p>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-secondary/50 grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Registered</p>
                            <p class="font-medium">{{ $apt->user->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">User ID</p>
                            <p class="font-medium">#{{ $apt->user->id }}</p>
                        </div>
                    </div>
                </div>

                {{-- Psychologist Card --}}
                <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Psychologist</h2>
                    <div class="flex items-center gap-4">
                        @php $psyPhoto = asset('img/prof-pic.jpeg'); @endphp
                        @if($psyPhoto)
                            <img src="{{ $psyPhoto }}" alt="{{ $apt->psychologist->name }}" class="w-14 h-14 rounded-2xl object-cover flex-shrink-0">
                        @else
                            <div class="w-14 h-14 rounded-2xl bg-primary flex items-center justify-center text-text-main font-bold text-xl flex-shrink-0">
                                {{ strtoupper(substr($apt->psychologist->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-text-main text-base">{{ $apt->psychologist->name }}</p>
                            <p class="text-sm opacity-60">{{ $apt->psychologist->specialization }}</p>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-secondary/50 text-sm">
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Rate per Session</p>
                            <p class="font-bold text-cta text-base">Rp {{ number_format($apt->psychologist->price_per_session, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Session Details --}}
                <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Session Details</h2>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Date</p>
                            <p class="font-semibold">{{ $scheduleDateTime->format('D, d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Time</p>
                            <p class="font-semibold">{{ $scheduleDateTime->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Service Type</p>
                            <p class="font-semibold">{{ $serviceLabel }}</p>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Session Status</p>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold {{ $aptBadge }}">{{ ucfirst($apt->status) }}</span>
                        </div>
                    </div>
                    @if($apt->notes)
                        <div class="mt-4 pt-4 border-t border-secondary/50">
                            <p class="text-xs opacity-50 font-semibold mb-1">Notes</p>
                            <p class="text-sm opacity-80">{{ $apt->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right column: Payment --}}
            <div class="space-y-5">

                {{-- Payment Card --}}
                <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Payment</h2>
                    <p class="text-3xl font-black text-cta mb-1">
                        Rp {{ number_format($apt->order->amount ?? 0, 0, ',', '.') }}
                    </p>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold {{ $orderBadge }} mb-5">
                        {{ ucfirst($apt->order->status ?? 'unknown') }}
                    </span>

                    <div class="space-y-3 text-sm border-t border-secondary/50 pt-4">
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Order ID</p>
                            <p class="font-mono text-xs break-all opacity-80">{{ $apt->order_id }}</p>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Payment Created</p>
                            <p class="font-medium">{{ optional($apt->order)->created_at?->format('d M Y H:i') ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs opacity-50 font-semibold mb-0.5">Last Updated</p>
                            <p class="font-medium">{{ optional($apt->order)->updated_at?->format('d M Y H:i') ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Appointment Timeline --}}
                <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6">
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Timeline</h2>
                    <div class="space-y-4 text-sm">
                        <div class="flex gap-3 items-start">
                            <div class="w-2 h-2 rounded-full bg-cta mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-semibold">Appointment Created</p>
                                <p class="text-xs opacity-50">{{ $apt->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @if($apt->status === 'canceled')
                        <div class="flex gap-3 items-start">
                            <div class="w-2 h-2 rounded-full bg-red-400 mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-semibold text-red-600">Appointment Canceled</p>
                                <p class="text-xs opacity-50">{{ $apt->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @elseif($apt->status === 'completed')
                        <div class="flex gap-3 items-start">
                            <div class="w-2 h-2 rounded-full bg-green-400 mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-semibold text-green-600">Session Completed</p>
                                <p class="text-xs opacity-50">{{ $apt->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="flex gap-3 items-start">
                            <div class="w-2 h-2 rounded-full {{ $scheduleDateTime->isPast() ? 'bg-slate-300' : 'bg-primary border-2 border-cta' }} mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-semibold {{ $scheduleDateTime->isPast() ? 'opacity-50' : '' }}">Scheduled Session</p>
                                <p class="text-xs opacity-50">{{ $scheduleDateTime->format('D, d M Y · H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
