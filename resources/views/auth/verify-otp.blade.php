@extends('layouts.app')

@section('title', 'Verify Email — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 flex items-center justify-center min-h-[calc(100vh-80px)] py-10 px-6">
    <div class="max-w-md w-full bg-white rounded-[2rem] shadow-soft border border-secondary/50 p-8 md:p-10 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-bl-full -z-10"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-cta/5 rounded-tr-full -z-10"></div>

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4 text-cta">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-text-main mb-2">Check your email</h1>
            <p class="text-sm text-text-main/60 leading-relaxed">
                We've sent a 6-digit verification code to <br>
                <span class="font-bold text-text-main">{{ $email }}</span>
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('verification.verify') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="code" class="block text-sm font-bold text-text-main mb-2 text-center">Verification Code</label>
                <input type="text" id="code" name="code" required maxlength="6" pattern="\d{6}" 
                       class="w-full px-5 py-4 text-center text-2xl tracking-[0.5em] font-bold rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta focus:ring-4 focus:ring-primary/20 transition-all placeholder:font-normal placeholder:tracking-normal placeholder:text-base placeholder:text-slate-400"
                       placeholder="••••••" autocomplete="one-time-code">
                @error('code')
                    <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-3.5 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 text-[15px]">
                Verify & Continue
            </button>
        </form>

        <div class="mt-8 text-center border-t border-secondary/50 pt-6">
            <p class="text-sm text-text-main/60 mb-3">Didn't receive the code?</p>
            <form action="{{ route('verification.resend') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="text-cta hover:text-cta-hover font-bold text-sm transition-colors focus:outline-none border-b-2 border-transparent hover:border-cta pb-0.5">
                    Resend Code
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
