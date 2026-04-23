@extends('layouts.app')

@section('title', 'New Article — Admin')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-4xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="/admin/articles" class="text-text-main opacity-50 hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-3xl font-bold">New Article</h1>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm font-medium space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/admin/articles" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Title --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-soft border border-secondary/50 space-y-6">
                <h2 class="font-bold text-lg border-b border-secondary pb-4">Article Info</h2>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Title <span class="text-red-400">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium"
                           placeholder="E.g. 5 Mindfulness Techniques to Ground Yourself">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-text-main mb-2">Category Slug <span class="text-red-400">*</span></label>
                        <select name="category" required
                                class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium">
                            <option value="">— Choose —</option>
                            @foreach([
                                'anxiety'       => 'Anxiety',
                                'stress'        => 'Stress',
                                'self-care'     => 'Self-Care',
                                'relationships' => 'Relationships',
                                'mindfulness'   => 'Mindfulness',
                                'other'         => 'Other',
                            ] as $val => $label)
                                <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-text-main mb-2">Category Label <span class="text-red-400">*</span></label>
                        <input type="text" name="category_label" value="{{ old('category_label') }}" required
                               class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium"
                               placeholder="E.g. Self-Care">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-text-main mb-2">Author <span class="text-red-400">*</span></label>
                        <input type="text" name="author" value="{{ old('author') }}" required
                               class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium"
                               placeholder="E.g. Dr. Budi S.">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-text-main mb-2">Display Date <span class="text-red-400">*</span></label>
                        <input type="text" name="date" value="{{ old('date', now()->format('M d')) }}" required
                               class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium"
                               placeholder="E.g. Oct 12">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Cover Image <span class="font-normal opacity-50">(optional)</span></label>

                    {{-- Upload --}}
                    <label for="photo-upload"
                           class="flex flex-col items-center justify-center gap-2 w-full h-36 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-cta/50 hover:bg-primary/5 cursor-pointer transition-all group">
                        <svg class="w-8 h-8 text-slate-300 group-hover:text-cta transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium text-slate-400 group-hover:text-cta transition-colors" id="photo-label">Click to upload a photo</span>
                        <span class="text-xs text-slate-300">JPG, PNG, WEBP — max 4 MB</span>
                        <input id="photo-upload" type="file" name="photo" accept="image/*" class="hidden"
                               onchange="document.getElementById('photo-label').textContent = this.files[0]?.name ?? 'Click to upload a photo'">
                    </label>

                    {{-- OR divider --}}
                    <div class="flex items-center gap-3 my-4">
                        <div class="flex-1 h-px bg-slate-200"></div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">OR</span>
                        <div class="flex-1 h-px bg-slate-200"></div>
                    </div>

                    {{-- URL fallback --}}
                    <input type="url" name="image" value="{{ old('image') }}"
                           class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium"
                           placeholder="Paste an image URL (e.g. from Unsplash)">
                </div>
            </div>

            {{-- Content --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-soft border border-secondary/50 space-y-6">
                <h2 class="font-bold text-lg border-b border-secondary pb-4">Content</h2>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Excerpt <span class="text-red-400">*</span></label>
                    <textarea name="excerpt" rows="3" required
                              class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium resize-none"
                              placeholder="A short 1-2 sentence teaser shown in article cards.">{{ old('excerpt') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">
                        Article Body <span class="text-red-400">*</span>
                    </label>
                    <textarea name="content" rows="18" required
                              class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium text-sm leading-relaxed"
                              placeholder="Write your article here.

Leave a blank line between paragraphs.

## Use this for a Section Heading

Continue writing the next section here...">{{ old('content') }}</textarea>
                    <div class="mt-2 p-3 bg-secondary/40 rounded-xl text-xs text-slate-500 space-y-1">
                        <p>✦ <strong>New paragraph</strong>: leave a blank line between blocks of text</p>
                        <p>✦ <strong>Section heading</strong>: start a line with <code class="font-mono bg-white px-1 rounded">## Your Heading</code></p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 pb-10">
                <button type="submit"
                    class="px-8 py-3.5 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold transition-all shadow-md hover:shadow-lg inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Publish Article
                </button>
                <a href="/admin/articles" class="px-6 py-3.5 border border-slate-200 rounded-xl font-semibold text-sm hover:border-slate-400 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
