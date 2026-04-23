@extends('layouts.app')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center p-6 bg-secondary/20 relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-primary/20 rounded-full blur-3xl -translate-y-1/2 -translate-x-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary/20 rounded-full blur-3xl translate-y-1/2 translate-x-1/2"></div>

    <div class="w-full max-w-[420px] relative z-10 my-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <img src="{{ asset('img/logo.png') }}" alt="RASA Logo" class="h-20 w-auto object-contain mx-auto mb-4">
            <h1 class="text-3xl font-bold text-text-main mb-2">Create an Account</h1>
            <p class="text-[15px] opacity-70">Begin your journey to mental clarity today.</p>
        </div>

        <div class="bg-white p-8 sm:p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-secondary">
            
            <!-- Google Auth Button -->
            <button class="w-full flex items-center justify-center gap-3 px-4 py-4 border-2 border-secondary rounded-xl hover:bg-secondary/50 transition-all font-semibold text-text-main mb-8 shadow-sm">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Sign up with Google
            </button>

            <!-- Explicit Text Separator -->
            <div class="relative flex items-center justify-center mb-8">
                <div class="border-t border-secondary w-full"></div>
                <div class="absolute bg-white px-5 text-xs font-bold uppercase text-text-main/40 tracking-widest">Or sign up with email</div>
            </div>

            <!-- Email Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold mb-2 opacity-90">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-5 py-3.5 bg-secondary/30 border border-secondary rounded-xl focus:bg-white focus:border-primary transition-all text-sm outline-none @error('name') border-red-500 @enderror" placeholder="John Doe" required autofocus>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold mb-2 opacity-90">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-5 py-3.5 bg-secondary/30 border border-secondary rounded-xl focus:bg-white focus:border-primary transition-all text-sm outline-none @error('email') border-red-500 @enderror" placeholder="you@example.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-semibold mb-2 opacity-90">Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" class="w-full px-5 py-3.5 bg-secondary/30 border border-secondary rounded-xl focus:bg-white focus:border-primary transition-all text-sm outline-none pr-12" placeholder="••••••••" required>
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-text-main/50 hover:text-cta transition-colors focus:outline-none" tabindex="-1">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <p class="text-[11px] opacity-60 mt-1.5">Must be at least 8 characters.</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold text-[15px] transition-all shadow-md hover:shadow-lg">
                        Create Account
                    </button>
                </div>
                
                <p class="text-[11px] text-center opacity-60 mt-4 leading-relaxed">
                    By creating an account, you agree to our <a href="/privacy" class="underline hover:text-cta">Terms of Service</a> and <a href="/privacy" class="underline hover:text-cta">Privacy Policy</a>.
                </p>
            </form>
        </div>
        
        <div class="mt-8 text-center space-y-4">
            <p class="text-sm font-medium opacity-90">
                Already have an account? <a href="/login" class="text-cta hover:text-cta-hover font-bold transition-colors">Log in</a>
            </p>
        </div>
    </div>
</div>
@endsection
