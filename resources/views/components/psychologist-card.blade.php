@props(['name', 'image', 'experience', 'specialties', 'price'])

<div class="bg-white rounded-2xl shadow-soft overflow-hidden flex flex-col h-full border border-secondary/50 group hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
    <!-- Image -->
    <div class="aspect-[4/3] relative overflow-hidden bg-secondary/30">
        <img src="{{ $image }}" alt="Portrait of {{ $name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
    </div>
    
    <!-- Content -->
    <div class="p-6 flex-grow flex flex-col">
        <h2 class="text-xl font-bold mb-1 text-text-main">{{ $name }}</h2>
        
        <!-- Specialties Tags -->
        <div class="flex flex-wrap gap-2 mb-4 mt-2">
            @foreach($specialties as $specialty)
                <span class="text-xs font-semibold px-2.5 py-1 bg-secondary text-text-main/80 rounded-md">
                    {{ $specialty }}
                </span>
            @endforeach
        </div>
        
        <p class="text-sm opacity-80 mb-6 flex-grow line-clamp-3 leading-relaxed">
            {{ $experience }}
        </p>
        
        <!-- Footer / Pricing / CTA -->
        <div class="pt-5 border-t border-secondary flex items-center justify-between mt-auto">
            <div>
                <p class="text-[11px] uppercase tracking-wider opacity-60 font-semibold mb-0.5">Session Price</p>
                <p class="font-bold text-cta">Rp {{ $price }}</p>
            </div>
            <a href="/book/{{ Str::slug($name) }}" class="px-5 py-2.5 bg-primary/20 text-cta-hover font-bold rounded-xl hover:bg-cta hover:text-white transition-colors text-sm shadow-sm">
                Book Now
            </a>
        </div>
    </div>
</div>
