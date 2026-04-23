@extends('layouts.app')

@section('title', 'My Profile | RASA Psychology')

@section('content')

<div class="min-h-screen bg-slate-50 py-12 px-4">
    <div class="max-w-3xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-main">My Profile</h1>
            <p class="text-slate-500 mt-1">Manage your personal information and profile photo.</p>
        </div>

        {{-- Success / Error Alerts --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl font-medium text-sm">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" 
              x-data="profileForm()" class="space-y-6">
            @csrf

            {{-- Profile Photo Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-semibold text-text-main mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Profile Photo
                </h2>

                <div class="flex flex-col sm:flex-row items-center gap-8">
                    {{-- Current Avatar Preview --}}
                    <div class="relative group flex-shrink-0">
                        <div id="avatar-preview"
                             class="w-28 h-28 rounded-full overflow-hidden ring-4 ring-primary/30 shadow-lg bg-gradient-to-br from-primary to-cta flex items-center justify-center">
                            @if($user->photo_url)
                                <img src="{{ Storage::url($user->photo_url) }}" 
                                     alt="{{ $user->name }}"
                                     id="avatar-img"
                                     class="w-full h-full object-cover">
                            @else
                                <span id="avatar-initial" class="text-white font-black text-4xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <img id="avatar-img" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        {{-- Camera overlay --}}
                        <label for="photo-input"
                               class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                    </div>

                    <div class="flex flex-col gap-3 text-center sm:text-left">
                        <div>
                            <p class="font-semibold text-text-main">{{ $user->name }}</p>
                            <p class="text-slate-400 text-sm">{{ $user->email }}</p>
                        </div>
                        <label for="photo-input"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary/10 hover:bg-primary/20 text-cta font-semibold rounded-xl cursor-pointer transition-colors text-sm border border-primary/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload New Photo
                        </label>
                        <p class="text-xs text-slate-400">JPG, PNG or WebP. Max 2MB.</p>
                        <input id="photo-input" type="file" name="photo" accept="image/*" 
                               class="hidden" @change="previewPhoto($event)">
                    </div>
                </div>
            </div>

            {{-- Personal Information Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-semibold text-text-main mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Personal Information
                </h2>

                <div class="space-y-5">
                    {{-- Full Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-text-main mb-2">Full Name</label>
                        <input type="text" id="name" name="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-text-main font-medium text-sm focus:bg-white transition-all"
                               placeholder="Your full name" required>
                    </div>

                    {{-- Email (read only) --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-text-main mb-2">
                            Email Address
                            <span class="ml-2 text-xs font-normal text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Cannot be changed</span>
                        </label>
                        <input type="email" id="email" 
                               value="{{ $user->email }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 font-medium text-sm cursor-not-allowed"
                               disabled>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-text-main mb-2">Phone Number <span class="text-slate-400 font-normal">(optional)</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </span>
                            <input type="tel" id="phone" name="phone" 
                                   value="{{ old('phone', $user->phone) }}"
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-text-main font-medium text-sm focus:bg-white transition-all"
                                   placeholder="+62 812 3456 7890">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between gap-4">
                <a href="/dashboard" 
                   class="px-6 py-3 rounded-xl border border-slate-200 font-semibold text-slate-600 hover:bg-slate-50 transition-colors text-sm">
                    ← Back to My Booking
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-cta hover:bg-cta-hover text-white rounded-xl font-semibold transition-all shadow-sm hover:shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>

    </div>
</div>

@endsection

@section('scripts')
<script>
    function profileForm() {
        return {
            previewPhoto(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.getElementById('avatar-img');
                    const initial = document.getElementById('avatar-initial');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    if (initial) initial.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>
@endsection
