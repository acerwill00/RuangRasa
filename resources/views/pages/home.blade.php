@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 lg:py-32 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block py-1.5 px-4 bg-primary/20 text-text-main font-medium rounded-full text-sm">
            Compassionate Tele-Counseling
        </span>
        <h1 class="text-5xl lg:text-6xl font-bold leading-tight text-text-main">
            Your Path to <span class="text-cta">Mental Clarity</span> Starts Here.
        </h1>
        <p class="text-lg opacity-80 max-w-xl leading-relaxed">
            Book a session with empathetic psychologists. Calm, safe, confidential. We created a frictionless space so you can focus entirely on your wellbeing.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 pt-4">
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="/our-psychologist" class="px-8 py-4 bg-cta hover:bg-cta-hover text-white text-center rounded-xl font-semibold transition-all shadow-soft hover:shadow-lg hover:-translate-y-0.5">
                    Explore Psychologists
                </a>
            @else
                <a href="/book" class="px-8 py-4 bg-cta hover:bg-cta-hover text-white text-center rounded-xl font-semibold transition-all shadow-soft hover:shadow-lg hover:-translate-y-0.5">
                    Book a Session
                </a>
            @endif
            <a href="/about" class="px-8 py-4 bg-secondary text-text-main text-center rounded-xl font-semibold hover:bg-secondary/70 transition-all">
                Learn More
            </a>
        </div>
    </div>
    <div class="flex-1 w-full relative">
        <div class="absolute inset-0 bg-primary/20 rounded-full blur-3xl scale-90 -z-10"></div>
        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&q=80&w=1000" alt="Smiling professional counselor in a warm, welcoming environment" class="rounded-[2rem] shadow-soft object-cover aspect-[4/3] w-full">
    </div>
</section>

<!-- Trust Signals (Logos) -->
<section class="bg-secondary/30 py-12 border-y border-secondary">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <p class="text-sm font-medium opacity-60 mb-8 uppercase tracking-widest">Certified & Trusted By</p>
        <div class="flex flex-wrap justify-center items-center gap-10 md:gap-20 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="font-bold text-xl flex items-center gap-2"><div class="w-6 h-6 bg-text-main rounded-md"></div> HIMPSI</div>
            <div class="font-bold text-xl flex items-center gap-2"><div class="w-6 h-6 rounded-full border-2 border-text-main"></div> Mental Health Org</div>
            <div class="font-bold text-xl flex items-center gap-2"><div class="w-6 h-6 bg-text-main rotate-45"></div> SafeCare</div>
            <div class="font-bold text-xl flex items-center gap-2"><div class="w-6 h-px bg-text-main"></div> Wellness Association</div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="max-w-7xl mx-auto px-6 py-24">
    <div class="text-center max-w-2xl mx-auto mb-16">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Simple, Frictionless Booking</h2>
        <p class="opacity-80 text-lg">Three steps to connect with a professional who understands you. We handle the rest.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative">
        <!-- Connecting Line (Desktop) -->
        <div class="hidden md:block absolute top-[50px] left-[15%] right-[15%] h-px bg-primary/50 -z-10"></div>
        
        <!-- Step 1 -->
        <div class="text-center relative">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-soft border-4 border-secondary text-3xl font-bold text-cta">1</div>
            <h3 class="text-xl font-semibold mb-3">Select Psychologist</h3>
            <p class="opacity-80 text-sm leading-relaxed px-4">Browse our curated list of experts and find someone who fits your specific needs and preferences.</p>
        </div>
        
        <!-- Step 2 -->
        <div class="text-center relative">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-soft border-4 border-secondary text-3xl font-bold text-cta">2</div>
            <h3 class="text-xl font-semibold mb-3">Book Schedule</h3>
            <p class="opacity-80 text-sm leading-relaxed px-4">Pick a time slot that works best for your routine. We offer flexible availability, including weekends.</p>
        </div>
        
        <!-- Step 3 -->
        <div class="text-center relative">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-soft border-4 border-secondary text-3xl font-bold text-cta">3</div>
            <h3 class="text-xl font-semibold mb-3">Confirm & Pay</h3>
            <p class="opacity-80 text-sm leading-relaxed px-4">Complete a secure payment process. Get ready for your safe and confidential session.</p>
        </div>
    </div>
</section>

<!-- Featured Experts -->
<section class="bg-secondary/20 py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Empathetic Professionals</h2>
                <p class="opacity-80 text-lg">Licensed clinical psychologists ready to listen and help you heal.</p>
            </div>
            <a href="/our-psychologist" class="font-medium text-cta hover:text-cta-hover transition-colors whitespace-nowrap">Explore All Psychologists &rarr;</a>
        </div>
        
        <div class="pt-6">
            <x-psychologist-carousel />
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="max-w-7xl mx-auto px-6 py-24">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Stories of Healing</h2>
        <p class="opacity-80 text-lg">Real experiences from our community. (Names anonymized for privacy)</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Testimonial 1 -->
        <div class="bg-white p-8 rounded-2xl shadow-soft border border-secondary/50 relative">
            <div class="text-6xl text-primary/30 absolute top-4 right-6 font-serif">"</div>
            <div class="flex text-yellow-400 mb-6">
                @for($i=0; $i<5; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                @endfor
            </div>
            <p class="opacity-90 mb-8 leading-relaxed">"The platform felt safe from the moment I logged in. Finding a scheduled time was frictionless, and my therapist really helped me navigate a severe burnout period at work."</p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center font-bold text-sm text-text-main">A</div>
                <div>
                    <p class="font-semibold text-sm">A***</p>
                    <p class="text-xs opacity-60">Burnout Counseling</p>
                </div>
            </div>
        </div>
        
        <!-- Testimonial 2 -->
        <div class="bg-white p-8 rounded-2xl shadow-soft border border-secondary/50 relative">
            <div class="text-6xl text-primary/30 absolute top-4 right-6 font-serif">"</div>
            <div class="flex text-yellow-400 mb-6">
                @for($i=0; $i<5; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                @endfor
            </div>
            <p class="opacity-90 mb-8 leading-relaxed">"I was hesitant about tele-counseling, but the UI is so calming and the video quality was great. My psychologist Bimo was incredibly empathetic and an active listener."</p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center font-bold text-sm text-text-main">R</div>
                <div>
                    <p class="font-semibold text-sm">R*** T.</p>
                    <p class="text-xs opacity-60">Couples Therapy</p>
                </div>
            </div>
        </div>
        
        <!-- Testimonial 3 -->
        <div class="bg-white p-8 rounded-2xl shadow-soft border border-secondary/50 relative">
            <div class="text-6xl text-primary/30 absolute top-4 right-6 font-serif">"</div>
            <div class="flex text-yellow-400 mb-6">
                @for($i=0; $i<5; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                @endfor
            </div>
            <p class="opacity-90 mb-8 leading-relaxed">"A truly frictionless experience from start to finish. Knowing pricing upfront and seeing the credentials immediately built the trust I needed to take the first step."</p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center font-bold text-sm text-text-main">N</div>
                <div>
                    <p class="font-semibold text-sm">N***</p>
                    <p class="text-xs opacity-60">Anxiety Counseling</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Articles / Journal Section ─────────────────────────────────────── --}}
@if($articles->isNotEmpty())
<section class="bg-secondary/20 py-24">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4">
            <div>
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-cta mb-3 bg-primary/20 px-3 py-1 rounded-full">Mental Health Resources</span>
                <h2 class="text-3xl md:text-4xl font-bold text-text-main">From Our Journal</h2>
                <p class="opacity-70 text-lg mt-2">Insights and guidance written by our clinical team.</p>
            </div>
            <a href="/articles" class="inline-flex items-center gap-2 font-semibold text-cta hover:text-cta-hover transition-colors whitespace-nowrap border-b-2 border-cta/30 hover:border-cta pb-0.5">
                Browse All Articles
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($articles as $index => $article)
            @php
                $readingMins = max(2, (int) ceil(str_word_count(strip_tags($article->content ?? $article->excerpt ?? '')) / 200));
                $categories = ['Mindfulness', 'Anxiety', 'Relationships', 'Burnout', 'Trauma'];
                $cat = $categories[$index % count($categories)];
                $catColors = [
                    'Mindfulness'  => 'bg-emerald-100 text-emerald-700',
                    'Anxiety'      => 'bg-blue-100 text-blue-700',
                    'Relationships'=> 'bg-rose-100 text-rose-700',
                    'Burnout'      => 'bg-orange-100 text-orange-700',
                    'Trauma'       => 'bg-purple-100 text-purple-700',
                ];
                $color = $catColors[$cat];
            @endphp
            <a href="/article/{{ $article->slug }}"
               class="group bg-white rounded-[1.5rem] shadow-soft border border-secondary/50 overflow-hidden flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

                {{-- Gradient Header --}}
                <div class="h-3 bg-gradient-to-r from-cta/60 via-primary to-cta/40 group-hover:from-cta group-hover:to-primary/80 transition-all duration-500"></div>

                <div class="p-7 flex flex-col flex-1">
                    {{-- Category + Read time --}}
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $color }}">{{ $cat }}</span>
                        <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $readingMins }} min read
                        </span>
                    </div>

                    {{-- Title --}}
                    <h3 class="text-lg font-bold text-text-main mb-3 leading-snug group-hover:text-cta transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h3>

                    {{-- Excerpt --}}
                    <p class="text-sm opacity-70 leading-relaxed line-clamp-3 flex-1 mb-6">
                        {{ $article->excerpt }}
                    </p>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-4 border-t border-secondary/50">
                        <span class="text-[11px] text-slate-400 font-medium">
                            {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}
                        </span>
                        <span class="text-xs font-bold text-cta group-hover:gap-2 flex items-center gap-1 transition-all">
                            Read Article
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>
@endif

@endsection
