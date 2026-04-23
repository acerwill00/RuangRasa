@extends('layouts.app')

@section('title', 'Add Psychologist')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-3xl mx-auto px-6">
        <div class="flex items-center gap-4 mb-8">
            <a href="/admin/psychologists" class="text-text-main opacity-60 hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-3xl font-bold">Add Psychologist</h1>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-soft border border-secondary/50">
            <form action="/admin/psychologists" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Full Name & Title</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium" placeholder="E.g. Dr. Jane Doe, M.Psi">
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}" required class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium" placeholder="E.g. Individual Therapy, Family Counseling">
                    @error('specialization') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Price per Session (Rp)</label>
                    <input type="number" name="price_per_session" value="{{ old('price_per_session') }}" required class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium" placeholder="250000">
                    @error('price_per_session') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Biography</label>
                    <textarea name="bio" rows="4" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium">{{ old('bio') }}</textarea>
                    @error('bio') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Profile Photo (Optional)</label>
                    <input type="file" name="photo" accept="image/*" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta font-medium">
                    @error('photo') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-secondary/50">
                    <button type="submit" class="px-8 py-3 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold transition-all shadow-md">
                        Save Psychologist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
