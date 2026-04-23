@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- ── Sidebar Navigation ─────────────────────────────────── --}}
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-[2rem] shadow-soft border border-secondary/50 sticky top-28">
                    <h3 class="font-bold text-lg mb-4 text-text-main opacity-60 uppercase tracking-wider text-sm">Main Menu</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/admin/dashboard" class="flex items-center gap-3 py-2 px-4 rounded-xl {{ request()->is('admin/dashboard') ? 'bg-primary/20 text-text-main font-semibold' : 'hover:bg-secondary transition-colors' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Overview
                            </a>
                        </li>
                        <li>
                            <a href="/admin/psychologists" class="flex items-center gap-3 py-2 px-4 rounded-xl {{ request()->is('admin/psychologists*') ? 'bg-primary/20 text-text-main font-semibold' : 'hover:bg-secondary transition-colors' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Psychologists
                            </a>
                        </li>
                        <li>
                            <a href="/admin/patients" class="flex items-center gap-3 py-2 px-4 rounded-xl {{ request()->is('admin/patients*') ? 'bg-primary/20 text-text-main font-semibold' : 'hover:bg-secondary transition-colors' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                Patients
                            </a>
                        </li>
                        <li>
                            <a href="/admin/complaints" class="flex items-center gap-3 py-2 px-4 rounded-xl {{ request()->is('admin/complaints*') ? 'bg-primary/20 text-text-main font-semibold' : 'hover:bg-secondary transition-colors' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Complaints
                            </a>
                        </li>
                        <li>
                            <a href="/admin/articles" class="flex items-center gap-3 py-2 px-4 rounded-xl {{ request()->is('admin/articles*') ? 'bg-primary/20 text-text-main font-semibold' : 'hover:bg-secondary transition-colors' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Articles
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- ── Main Panel ─────────────────────────────────────────── --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Metrics Row --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white p-6 rounded-[2rem] shadow-soft border border-secondary/50">
                        <p class="text-xs font-semibold opacity-60 mb-1 uppercase tracking-wide">Total Appointments</p>
                        <h3 class="text-4xl font-black text-cta">{{ $totalAppointments }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] shadow-soft border border-secondary/50">
                        <p class="text-xs font-semibold opacity-60 mb-1 uppercase tracking-wide">Active Appointments</p>
                        <h3 class="text-4xl font-black text-emerald-500">{{ $activeAppointments }}</h3>
                        <p class="text-[10px] text-emerald-600 font-medium mt-1">Upcoming & scheduled</p>
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] shadow-soft border border-secondary/50">
                        <p class="text-xs font-semibold opacity-60 mb-1 uppercase tracking-wide">Total Patients</p>
                        <h3 class="text-4xl font-black text-cta">{{ $totalPatients }}</h3>
                    </div>
                </div>

                {{-- Appointments Table with toggle --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-soft border border-secondary/50" x-data="{ showPast: false }">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold" x-text="showPast ? 'Past & Canceled Appointments' : 'Active Appointments'"></h2>
                            <p class="text-xs opacity-50 mt-0.5" x-text="showPast ? 'Historical records' : 'Upcoming scheduled sessions'"></p>
                        </div>
                        <button @click="showPast = !showPast"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold border-2 transition-all"
                            :class="showPast
                                ? 'border-cta/40 text-cta bg-primary/10 hover:bg-primary/20'
                                : 'border-slate-200 text-slate-500 hover:border-cta hover:text-cta'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="!showPast" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="showPast" style="display:none" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span x-text="showPast ? '← Back to Active' : 'View Past & Canceled'"></span>
                        </button>
                    </div>

                    {{-- ── Active Appointments Table ── --}}
                    <div x-show="!showPast" x-transition>
                        @if($activeList->isEmpty())
                            <div class="text-center py-10 bg-slate-50 rounded-2xl border border-secondary">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500">No upcoming appointments right now.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm whitespace-nowrap">
                                    <thead class="text-xs uppercase bg-emerald-50 text-emerald-700">
                                        <tr>
                                            <th class="px-5 py-3 font-semibold rounded-l-xl">Patient</th>
                                            <th class="px-5 py-3 font-semibold">Psychologist</th>
                                            <th class="px-5 py-3 font-semibold">Date & Time</th>
                                            <th class="px-5 py-3 font-semibold text-center">Status</th>
                                            <th class="px-5 py-3 font-semibold text-center rounded-r-xl">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-secondary/50">
                                        @foreach($activeList as $apt)
                                        @php
                                            $dt = \Carbon\Carbon::parse($apt->schedule_date . ' ' . $apt->schedule_time);
                                            $isToday = $dt->isToday();
                                        @endphp
                                        <tr class="hover:bg-secondary/10 transition-colors {{ $isToday ? 'bg-emerald-50/50' : '' }}">
                                            <td class="px-5 py-3 font-medium">
                                                {{ $apt->user->name }}
                                                @if($isToday)
                                                    <span class="ml-1 text-[9px] font-bold bg-emerald-500 text-white px-1.5 py-0.5 rounded-full uppercase">Today</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3 opacity-80">{{ $apt->psychologist->name }}</td>
                                            <td class="px-5 py-3">
                                                {{ $dt->format('D, d M Y') }}<br>
                                                <span class="opacity-70 text-xs">{{ $dt->format('h:i A') }}</span>
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700">Scheduled</span>
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <a href="{{ route('admin.appointment.show', $apt->id) }}"
                                                   class="text-xs font-bold text-cta hover:text-cta-hover transition-colors">View →</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- ── Past / Archive Table ── --}}
                    <div x-show="showPast" style="display:none" x-transition>
                        @if($pastList->isEmpty())
                            <div class="text-center py-10 bg-slate-50 rounded-2xl border border-secondary">
                                <p class="text-sm font-semibold text-slate-500">No past or canceled appointments.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm whitespace-nowrap">
                                    <thead class="text-xs uppercase bg-secondary/50 text-text-main/70">
                                        <tr>
                                            <th class="px-5 py-3 font-semibold rounded-l-xl">Patient</th>
                                            <th class="px-5 py-3 font-semibold">Psychologist</th>
                                            <th class="px-5 py-3 font-semibold">Date & Time</th>
                                            <th class="px-5 py-3 font-semibold text-center">Status</th>
                                            <th class="px-5 py-3 font-semibold text-center rounded-r-xl">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-secondary/50">
                                        @foreach($pastList as $apt)
                                        @php
                                            $dt = \Carbon\Carbon::parse($apt->schedule_date . ' ' . $apt->schedule_time);
                                            $aptBadge = match($apt->status) {
                                                'scheduled' => 'bg-slate-100 text-slate-500',
                                                'completed' => 'bg-green-100 text-green-700',
                                                'canceled'  => 'bg-red-100 text-red-600',
                                                default     => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp
                                        <tr class="hover:bg-secondary/10 transition-colors opacity-80">
                                            <td class="px-5 py-3 font-medium">{{ $apt->user->name }}</td>
                                            <td class="px-5 py-3 opacity-80">{{ $apt->psychologist->name }}</td>
                                            <td class="px-5 py-3">
                                                {{ $dt->format('D, d M Y') }}<br>
                                                <span class="opacity-70 text-xs">{{ $dt->format('h:i A') }}</span>
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $aptBadge }}">{{ $apt->status }}</span>
                                            </td>
                                            <td class="px-5 py-3 text-center">
                                                <a href="{{ route('admin.appointment.show', $apt->id) }}"
                                                   class="text-xs font-bold text-cta hover:text-cta-hover transition-colors">View →</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
