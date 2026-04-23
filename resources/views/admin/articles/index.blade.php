@extends('layouts.app')

@section('title', 'Manage Articles — Admin')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-6xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Articles</h1>
                <p class="text-sm opacity-60 mt-1">{{ $articles->count() }} article{{ $articles->count() !== 1 ? 's' : '' }} published</p>
            </div>
            <a href="/admin/articles/create"
               class="inline-flex items-center gap-2 px-6 py-3 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                New Article
            </a>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Article List --}}
        @if($articles->isEmpty())
            <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-secondary rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-cta/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold mb-2">No articles yet</h2>
                <p class="text-sm opacity-60 mb-5">Create your first article to share with users.</p>
                <a href="/admin/articles/create" class="inline-flex items-center gap-2 px-6 py-3 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold text-sm transition-all shadow-md">
                    Write First Article
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($articles as $article)
                    <div class="bg-white rounded-[1.8rem] shadow-soft border border-secondary/50 p-6 flex gap-5 items-start hover:border-primary/30 transition-all">

                        {{-- Thumbnail --}}
                        @if($article->image)
                            <img src="{{ $article->image }}" alt="{{ $article->title }}"
                                 class="w-20 h-20 rounded-2xl object-cover flex-shrink-0">
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-secondary flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-cta/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="text-xs font-bold px-2.5 py-0.5 bg-primary/20 text-text-main/70 rounded-full">
                                    {{ $article->category_label }}
                                </span>
                                <span class="text-xs opacity-50">{{ $article->date }} · {{ $article->author }}</span>
                            </div>
                            <h2 class="font-bold text-text-main text-base leading-snug mb-1">{{ $article->title }}</h2>
                            <p class="text-sm opacity-60 line-clamp-2">{{ $article->excerpt }}</p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex-shrink-0 flex flex-col gap-2 items-end">
                            <a href="/article/{{ $article->slug }}" target="_blank"
                               class="text-xs font-semibold text-slate-400 hover:text-cta transition-colors">
                                Preview ↗
                            </a>
                            <a href="/admin/articles/{{ $article->id }}/edit"
                               class="text-xs font-bold px-4 py-2 border border-slate-200 rounded-xl hover:border-cta hover:text-cta transition-all">
                                Edit
                            </a>
                            <form method="POST" action="/admin/articles/{{ $article->id }}"
                                  onsubmit="return confirm('Delete this article? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs font-bold px-4 py-2 border border-red-100 text-red-400 rounded-xl hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
