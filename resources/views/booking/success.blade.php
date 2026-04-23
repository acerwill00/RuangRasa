@extends('layouts.app')

@section('title', 'Booking Successful — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)] flex flex-col justify-center items-center">
    <div class="max-w-xl w-full px-6">
        <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 p-8 md:p-12 text-center animate-page">
            
            {{-- Success Icon --}}
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-500 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>

            <h1 class="text-3xl font-bold text-text-main mb-3">Booking Confirmed!</h1>
            <p class="text-text-main/70 mb-8 leading-relaxed">
                Your session with <span class="font-bold text-text-main">{{ $appointment->psychologist->name }}</span> has been successfully scheduled. We have sent a confirmation to your email.
            </p>

            {{-- Appointment Summary Card --}}
            <div class="bg-secondary/20 border border-secondary rounded-2xl p-5 mb-8 text-left relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary/10 rounded-bl-full -z-10"></div>
                
                @php
                    $dt = \Carbon\Carbon::parse($appointment->schedule_date . ' ' . $appointment->schedule_time);
                    $endTime = $dt->copy()->addHour();
                    $serviceLabel = $appointment->service_type === 'psikolog_klinis' ? 'Clinical Psychologist' : 'Counseling with Counselor';
                    
                    // Google Calendar Link Generation
                    // Convert times to UTC for Google Calendar
                    $startUtc = $dt->copy()->timezone('UTC')->format('Ymd\THis\Z');
                    $endUtc = $endTime->copy()->timezone('UTC')->format('Ymd\THis\Z');
                    $title = urlencode("Session with {$appointment->psychologist->name}");
                    $details = urlencode("{$serviceLabel} session.\nOrder ID: {$appointment->order_id}\n\nPlease prepare for the session 10 minutes early.");
                    $location = urlencode("Online (Link will be provided)");
                    $gcalLink = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$title}&dates={$startUtc}/{$endUtc}&details={$details}&location={$location}";
                @endphp

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[11px] font-bold text-text-main/50 uppercase tracking-wider mb-0.5">Date & Time</p>
                        <p class="font-semibold text-text-main">{{ $dt->format('l, d M Y') }}</p>
                        <p class="text-sm font-medium text-text-main/80">{{ $dt->format('h:i A') }} - {{ $endTime->format('h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-text-main/50 uppercase tracking-wider mb-0.5">Service</p>
                        <p class="font-semibold text-text-main">{{ $serviceLabel }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <a href="{{ $gcalLink }}" target="_blank" rel="noopener noreferrer" 
                   class="w-full flex items-center justify-center gap-2 py-3.5 bg-[#4285F4] hover:bg-[#3367D6] text-white rounded-xl font-semibold transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.2 14.2L11 13V7h1.5v5.2l4.5 2.7-.8 1.3z"/>
                    </svg>
                    Add to Google Calendar
                </a>

                <a href="https://meet.google.com/kkm-wjfm-gyc" target="_blank" rel="noopener noreferrer" 
                   class="w-full flex items-center justify-center gap-2 py-3.5 bg-[#B18FE4] hover:bg-[#9E7CD1] text-white rounded-xl font-semibold transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Save Google Meet Link
                </a>
                
                <a href="/dashboard" class="w-full block py-3.5 bg-secondary/30 hover:bg-secondary/50 text-text-main rounded-xl font-bold transition-all border border-transparent hover:border-secondary shadow-sm hover:shadow">
                    Go to My Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
