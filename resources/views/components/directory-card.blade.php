@props(['id', 'name', 'image', 'rating', 'sessions', 'originalPrice', 'discount', 'price', 'schedules'])

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 min-w-[320px] w-80 p-5 flex flex-col hover:shadow-md transition-all duration-300 group relative">
    
    <!-- Image -->
    <div class="rounded-xl overflow-hidden aspect-[4/5] bg-secondary/30 mb-4 relative flex-shrink-0">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
    </div>

    <!-- Content -->
    <div class="flex-grow flex flex-col">
        <!-- Trust Badge -->
        <div class="flex items-center gap-1.5 mb-2">
            <svg class="w-4 h-4 text-secondary/80 fill-current bg-blue-500 rounded-full p-0.5" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Licensed Professional</span>
        </div>

        <!-- Name & Rating -->
        <h3 class="text-xl font-bold text-text-main mb-1.5 truncate">{{ $name }}</h3>
        
        <div class="flex items-center gap-1.5 mb-5 pb-5 border-b border-slate-100">
            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            <span class="text-sm font-bold text-amber-500">{{ $rating }}</span>
            <span class="text-[13px] text-slate-400 font-medium">({{ $sessions }} sessions)</span>
        </div>

        <!-- Pricing -->
        <div class="mb-5 flex-grow">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="text-xs text-slate-400 line-through font-medium">Rp{{ $originalPrice }}</span>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">{{ $discount }}</span>
            </div>
            <div class="text-2xl font-black text-text-main tracking-tight">
                Rp{{ $price }} <span class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">/ session</span>
            </div>
        </div>

        <!-- Quick Schedules -->
        <div class="mb-6">
            @auth
                <p class="text-[11px] font-bold text-slate-400 mb-2.5 uppercase tracking-wider">Earliest availability:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($schedules as $schedule)
                        <button class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-slate-500 hover:border-cta hover:text-cta transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 shadow-sm">
                            {{ $schedule }}
                        </button>
                    @endforeach
                </div>
            @else
                <a href="/login" class="flex items-center gap-2 px-3 py-2.5 bg-slate-50 border border-dashed border-slate-300 rounded-xl text-xs font-semibold text-slate-400 hover:border-cta hover:text-cta transition-colors">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Log in to see available slots
                </a>
            @endauth
        </div>

        <!-- Footer Dual CTAs -->
        <div class="flex items-center gap-3 mt-auto pt-2">
            <a href="/psychologist/{{ $id ?? 'clara' }}" class="flex-1 py-3.5 text-center rounded-xl font-bold text-sm text-cta hover:bg-primary/10 transition-colors border-2 border-transparent">
                View Profile
            </a>
            <a href="/book/{{ $id ?? 'clara' }}" class="flex-1 py-3.5 text-center bg-cta hover:bg-cta-hover text-white rounded-xl font-bold text-sm shadow-sm hover:shadow transition-all hover:-translate-y-0.5">
                Book Session
            </a>
        </div>
    </div>
</div>
