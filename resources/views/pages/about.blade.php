@extends('layouts.app')

@section('content')
<!-- Hero / Header -->
<section class="bg-primary/10 py-16 md:py-24 border-b border-primary/20 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/20 to-transparent -z-10"></div>
    <div class="max-w-4xl mx-auto px-6 text-center">
        <span class="text-cta font-bold tracking-widest uppercase text-sm mb-4 block">About Us</span>
        <h1 class="text-4xl md:text-6xl font-bold mb-6">Democratizing Mental Wellbeing in Indonesia.</h1>
        <p class="text-lg md:text-xl opacity-80 leading-relaxed">
            RASA Psychology was founded on a very simple belief: getting professional help for your mind should be as normal, safe, and frictionless as getting help for your body.
        </p>
    </div>
</section>

<!-- Mission Block -->
<section class="max-w-7xl mx-auto px-6 py-20 lg:py-28">
    <div class="flex flex-col lg:flex-row gap-16 lg:gap-24 items-center">
        <div class="flex-1 space-y-6">
            <h2 class="text-3xl lg:text-4xl font-bold mb-2">Our Mission</h2>
            <div class="w-16 h-1.5 bg-cta rounded-full mb-6"></div>
            <div class="space-y-6 text-lg opacity-80 leading-relaxed">
                <p>We aim to completely remove the friction and stigma associated with seeking mental health support. In many cultures, admitting you need a therapist is heavily misunderstood. We are here to reframe it as an act of profound strength and self-awareness.</p>
                <p>By leveraging secure technology to provide seamless tele-counseling, we connect you with empathetic, licensed professionals from the quiet privacy of your own safe space. No waiting rooms. No judgment. Just healing.</p>
            </div>
        </div>
        <div class="flex-1 w-full relative">
            <div class="absolute inset-0 bg-primary/30 rounded-[2.5rem] rotate-3 scale-105 -z-10 transition-transform"></div>
            <div class="bg-white rounded-[2.5rem] p-10 md:p-14 flex flex-col justify-center border-2 border-secondary shadow-soft h-full">
                <blockquote class="text-2xl md:text-3xl font-medium leading-normal mb-8">
                    "Mental health is not a destination, but a process. It's about <span class="text-cta">how you drive</span>, not where you're going."
                </blockquote>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center font-bold text-text-main text-xl">R</div>
                    <div>
                        <p class="font-bold text-lg">The Founders</p>
                        <p class="text-sm opacity-60">RASA Psychology</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Credentials Block -->
<section class="bg-secondary/40 py-24 border-y border-secondary">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Uncompromising Standards</h2>
            <p class="opacity-80 text-lg max-w-2xl mx-auto">Every psychologist on our platform undergoes a severe vetting process. You deserve the absolute highest standard of care.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Credential 1 -->
            <div class="bg-white p-10 rounded-[2rem] shadow-sm text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center text-cta mx-auto mb-6 rotate-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-xl mb-3">SIPP Licensed</h3>
                <p class="opacity-70 leading-relaxed text-sm">100% of our clinical psychologists hold an active Surat Izin Praktik Psikolog. We verify every credential.</p>
            </div>
            
            <!-- Credential 2 -->
            <div class="bg-white p-10 rounded-[2rem] shadow-md text-center border-2 border-primary/40 relative scale-105 z-10 hidden md:block">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-cta text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-sm">Non-Negotiable</div>
                <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center text-cta mx-auto mb-6 -rotate-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.041a21.34 21.34 0 002.752 2.478M15 4.632c-1.22-.6-2.583-.932-4-.932-5.523 0-10 4.477-10 10 0 1.05.163 2.061.464 3.016"></path></svg>
                </div>
                <h3 class="font-bold text-xl mb-3">Ethics Bound</h3>
                <p class="opacity-70 leading-relaxed text-sm">Strictly bound by the Indonesian Psychological Association (HIMPSI) Code of Ethics for all practices.</p>
            </div>
            
            <!-- Mobile Ver. Credential 2 -->
            <div class="bg-white p-10 rounded-[2rem] shadow-sm text-center md:hidden border border-primary/20 relative">
                <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center text-cta mx-auto mb-6 -rotate-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.041a21.34 21.34 0 002.752 2.478M15 4.632c-1.22-.6-2.583-.932-4-.932-5.523 0-10 4.477-10 10 0 1.05.163 2.061.464 3.016"></path></svg>
                </div>
                <h3 class="font-bold text-xl mb-3">Ethics Bound</h3>
                <p class="opacity-70 leading-relaxed text-sm">Strictly bound by the Indonesian Psychological Association (HIMPSI) Code of Ethics for all practices.</p>
            </div>
            
            <!-- Credential 3 -->
            <div class="bg-white p-10 rounded-[2rem] shadow-sm text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center text-cta mx-auto mb-6 rotate-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="font-bold text-xl mb-3">Continuous Learning</h3>
                <p class="opacity-70 leading-relaxed text-sm">Our team engages in mandatory continuous peer reviews and modern counseling methodology workshops.</p>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Block (Prominent) -->
<section class="max-w-5xl mx-auto px-6 py-24 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-cta text-white mb-8 shadow-lg shadow-cta/30">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
    </div>
    <h2 class="text-4xl font-bold mb-8">Our Privacy Commitment</h2>
    <div class="bg-white border-2 border-primary/30 p-10 md:p-14 rounded-[2.5rem] shadow-soft text-left relative overflow-hidden">
        <div class="absolute top-0 left-0 w-2 h-full bg-cta"></div>
        <p class="text-lg opacity-90 mb-6 leading-relaxed font-medium">
            What you discuss in therapy stays in therapy. We do <span class="font-bold border-b-2 border-cta">not</span> record video or audio of your counseling sessions. Any notes taken by your psychologist are encrypted end-to-end and stored safely, strictly adhering to global medical data privacy standards. 
        </p>
        <div class="bg-secondary/30 p-6 rounded-2xl border border-secondary flex items-start gap-4">
            <svg class="w-6 h-6 text-cta mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            <p class="opacity-100 font-semibold text-text-main leading-relaxed">
                We will never sell your data, email, or session history to third parties, advertising networks, or data brokers. Your trust is our foundation.
            </p>
        </div>
    </div>
</section>

@endsection
