@extends('layouts.app')

@section('title', 'Report an Issue — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-2xl mx-auto px-6">
        <div class="flex items-center gap-4 mb-8">
            <a href="/dashboard" class="text-text-main opacity-50 hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-2xl font-bold">Report an Issue</h1>
        </div>

        <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 p-8">
            <p class="text-text-main/70 mb-6">If you experienced any issues with your session, our platform, or a psychologist, please let us know. Our support team will review it.</p>
            
            <form method="POST" action="{{ route('complaints.store') }}" class="space-y-5">
                @csrf
                
                @if($appointmentId)
                    <input type="hidden" name="appointment_id" value="{{ $appointmentId }}">
                    <div class="bg-primary/10 p-4 rounded-xl border border-primary/20 text-sm mb-4">
                        <span class="font-bold">Linked Appointment:</span> ID #{{ $appointmentId }}
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main">Subject</label>
                    <input type="text" name="subject" required class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta transition-all font-medium" placeholder="E.g., Connection issue during session">
                    @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main">Description</label>
                    <textarea name="description" rows="5" required class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta transition-all font-medium" placeholder="Please describe the issue in detail..."></textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full px-6 py-3.5 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold transition-all shadow-sm text-[15px]">
                        Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
