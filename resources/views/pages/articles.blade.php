@extends('layouts.app')

@section('content')
<div x-data="{ filter: 'all' }">
    <!-- Header -->
    <section class="max-w-7xl mx-auto px-6 pt-16 pb-12">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 text-text-main">Mental Health Resources</h1>
            <p class="opacity-80 text-lg">Insights, tips, and guidance written by professionals to help you navigate life's challenges safely.</p>
        </div>
        
        <!-- Category Pills -->
        <div class="flex flex-wrap justify-center gap-3">
            <button @click="filter = 'all'" 
                    :class="filter === 'all' ? 'bg-text-main text-white cursor-default shadow-md' : 'bg-secondary text-text-main hover:bg-primary/30 border border-secondary transition-colors hover:shadow-sm'"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all">
                All Articles
            </button>
            <button @click="filter = 'anxiety'" 
                    :class="filter === 'anxiety' ? 'bg-text-main text-white cursor-default shadow-md' : 'bg-secondary text-text-main hover:bg-primary/30 border border-secondary transition-colors hover:shadow-sm'"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all">
                Anxiety
            </button>
            <button @click="filter = 'stress'" 
                    :class="filter === 'stress' ? 'bg-text-main text-white cursor-default shadow-md' : 'bg-secondary text-text-main hover:bg-primary/30 border border-secondary transition-colors hover:shadow-sm'"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all">
                Stress
            </button>
            <button @click="filter = 'self-care'" 
                    :class="filter === 'self-care' ? 'bg-text-main text-white cursor-default shadow-md' : 'bg-secondary text-text-main hover:bg-primary/30 border border-secondary transition-colors hover:shadow-sm'"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all">
                Self-Care
            </button>
            <button @click="filter = 'relationships'" 
                    :class="filter === 'relationships' ? 'bg-text-main text-white cursor-default shadow-md' : 'bg-secondary text-text-main hover:bg-primary/30 border border-secondary transition-colors hover:shadow-sm'"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all">
                Relationships
            </button>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="max-w-7xl mx-auto px-6 pb-24 min-h-[500px]">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @foreach($articles as $article)
            <article x-show="filter === 'all' || filter === '{{ $article['category'] }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-[1.5rem] shadow-soft overflow-hidden border border-secondary flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all group">
                <a href="/article/{{ $article['slug'] }}" class="overflow-hidden block">
                    <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                </a>
                <div class="p-7 flex flex-col flex-grow">
                    <div class="mb-3 flex justify-between items-center">
                        <span class="text-xs font-bold bg-primary/20 text-cta px-3 py-1 rounded-md uppercase tracking-wider">{{ $article['category_label'] }}</span>
                        <span class="text-[11px] font-semibold opacity-50">{{ $article['date'] }}</span>
                    </div>
                    <a href="/article/{{ $article['slug'] }}">
                        <h2 class="text-xl font-bold mb-3 leading-snug group-hover:text-cta transition-colors text-text-main">{{ $article['title'] }}</h2>
                    </a>
                    <p class="text-sm opacity-70 mb-6 flex-grow line-clamp-3 leading-relaxed text-text-main">{{ $article['excerpt'] }}</p>
                    <div class="pt-4 border-t border-secondary mt-auto flex justify-between items-center">
                        <a href="/article/{{ $article['slug'] }}" class="inline-flex items-center gap-2 font-bold text-text-main hover:text-cta transition-colors text-sm">
                            Read Article <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach

        </div>

        <!-- Inline CTA Banner -->
        <div class="mt-20 bg-primary/20 rounded-[2.5rem] p-8 md:p-14 flex flex-col lg:flex-row items-center justify-between gap-10 border border-primary/40 relative overflow-hidden shadow-soft">
            <div class="absolute -right-32 -top-32 w-96 h-96 bg-primary/40 rounded-full blur-[80px] pointer-events-none"></div>
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-white/40 rounded-full blur-[60px] pointer-events-none"></div>
            
            <div class="relative z-10 max-w-2xl text-center lg:text-left">
                <span class="block text-cta font-bold tracking-widest uppercase text-sm mb-3">Professional Support</span>
                <h3 class="text-3xl md:text-4xl font-bold mb-4 text-text-main">Talk to a psychologist about these topics.</h3>
                <p class="opacity-80 text-lg leading-relaxed text-text-main">Reading articles is a great start, but talking works. Our empathetic professionals can provide personalized, actionable strategies tailored to your exact situation in a safe environment.</p>
            </div>
            
            <div class="relative z-10 flex-shrink-0 w-full lg:w-auto">
                <a href="/our-psychologist" class="block w-full text-center px-10 py-5 bg-cta hover:bg-cta-hover text-white rounded-2xl font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-1 text-lg">
                    Book a Session Now
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
