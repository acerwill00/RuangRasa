@extends('layouts.app')

@section('content')
<section class="bg-secondary/10 py-16 lg:py-24 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 text-text-main">Our Services</h1>
            <p class="text-lg opacity-80 leading-relaxed text-text-main">A safe space for your healing journey, both personally and within a community.</p>
        </div>

        <div class="space-y-12 pb-16">
            
            <!-- Service Section 1: Konseling (Split Layout) -->
            <div class="bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-secondary/50 relative transition-shadow hover:shadow-md">
                <h2 class="text-3xl font-bold mb-8 text-text-main border-b border-secondary/50 pb-5 text-center">Counseling</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Left Column (Psikolog Klinis) -->
                    <div class="flex flex-col h-full bg-secondary/5 p-6 rounded-2xl border border-secondary/30">
                        <h3 class="text-2xl font-bold text-text-main mb-4">Clinical Psychologist</h3>
                        <p class="text-text-main leading-relaxed opacity-80 mb-8 flex-grow">
                            For those needing professional help. Assisting in exploring issues deeply, understanding disruptive patterns, and receiving interventions.
                        </p>
                        <a href="/our-psychologist" class="block w-full py-3.5 border-2 border-cta text-cta hover:bg-cta hover:text-white text-center rounded-xl font-bold transition-all">
                            Choose a Clinical Psychologist
                        </a>
                    </div>
                    
                    <!-- Right Column (Konseling dengan Konselor) -->
                    <div class="flex flex-col h-full bg-secondary/5 p-6 rounded-2xl border border-secondary/30">
                        <h3 class="text-2xl font-bold text-text-main mb-4">Counseling with a Counselor</h3>
                        <p class="text-text-main leading-relaxed opacity-80 mb-8 flex-grow">
                            For those needing a safe space to share. Accompanied by a trained counselor who listens without judgment.
                        </p>
                        <a href="/our-psychologist" class="block w-full py-3.5 border-2 border-cta text-cta hover:bg-cta hover:text-white text-center rounded-xl font-bold transition-all">
                            Choose a Counselor
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Section 2: Group Healing Session (Standard Card) -->
            <div class="bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-secondary/50 text-center transition-shadow hover:shadow-md">
                <h2 class="text-3xl font-bold mb-6 text-text-main border-b border-secondary/50 pb-5 text-center">Group Healing Session</h2>
                
                <p class="text-text-main leading-relaxed text-[17px] opacity-80 mb-10 max-w-4xl mx-auto">
                    For your community, organization, or group wanting to discuss a specific theme. We are ready to lead sessions on mental health such as stress, burnout, relationship issues, mental readiness for new environments, and other topics according to your needs.
                </p>
                
                <a href="https://wa.me/0895339669579" target="_blank" rel="noopener noreferrer" class="inline-block w-full md:w-auto px-8 py-3.5 bg-cta hover:bg-cta-hover text-white text-center rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                    Contact Us for Group Sessions
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
