@extends('layouts.app')

@section('title', $article['title'] . ' | RASA Psychology')

@section('content')
<article class="bg-white min-h-screen">
    <!-- Header Hero -->
    <header class="pt-20 pb-16 bg-slate-50 border-b border-primary/20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="inline-block px-4 py-1.5 bg-primary/20 text-cta font-bold rounded-full text-xs uppercase tracking-wider mb-6">
                {{ $article['category_label'] }}
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-text-main mb-8 leading-tight">
                {{ $article['title'] }}
            </h1>
            <div class="flex items-center justify-center gap-4 text-sm font-medium opacity-70">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    By {{ $article['author'] }}
                </span>
                <span>&bull;</span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $article['date'] }}
                </span>
            </div>
        </div>
    </header>

    <!-- Cover Image -->
    <div class="max-w-5xl mx-auto px-6 -mt-8 relative z-10 hidden md:block">
        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-[400px] object-cover rounded-[2rem] shadow-lg">
    </div>

    <!-- Content Body -->
    <div class="max-w-3xl mx-auto px-6 py-16 text-lg text-text-main/80 leading-relaxed font-medium">
        <div class="md:hidden mb-12">
            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-64 object-cover rounded-2xl shadow-sm">
        </div>
        
        <p class="text-xl md:text-2xl font-semibold text-text-main mb-10 leading-snug italic border-l-4 border-cta pl-6">
            "{{ $article['excerpt'] }}"
        </p>

        <div class="prose prose-lg prose-headings:text-text-main prose-headings:font-bold prose-a:text-cta max-w-none">
            {!! $article['content'] !!}
        </div>
        
        <div class="mt-16 pt-10 border-t border-slate-100 flex items-center justify-between">
            <a href="/articles" class="inline-flex items-center gap-2 font-bold text-slate-500 hover:text-cta transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Articles
            </a>
            <div class="flex gap-2">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center hover:bg-primary/20 hover:text-cta transition-colors"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg></a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center hover:bg-primary/20 hover:text-cta transition-colors"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"></path></svg></a>
            </div>
        </div>
    </div>
</article>
@endsection
