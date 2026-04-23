<div class="relative w-full" x-data="{
    paused: false,
    speed: 1,
    scrollLeftManual() {
        this.$refs.slider.scrollBy({ left: -320, behavior: 'smooth' });
    },
    scrollRightManual() {
        this.$refs.slider.scrollBy({ left: 320, behavior: 'smooth' });
    },
    init() {
        const slider = this.$refs.slider;
        const autoScroll = () => {
            if (!this.paused) {
                slider.scrollLeft += this.speed;
                if (slider.scrollLeft >= slider.scrollWidth / 2) {
                    slider.scrollLeft -= slider.scrollWidth / 2;
                }
            }
            requestAnimationFrame(autoScroll);
        };
        requestAnimationFrame(autoScroll);
    }
}" @mouseenter="paused = true" @mouseleave="paused = false" @touchstart="paused = true" @touchend="paused = false">
    <!-- Navigation Arrows -->
    <button @click="scrollLeftManual" class="hidden md:flex absolute left-0 top-[40%] -translate-y-1/2 -translate-x-5 z-10 w-12 h-12 bg-text-main text-white rounded-full items-center justify-center shadow-lg hover:bg-cta transition-colors focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
    </button>

    <button @click="scrollRightManual" class="hidden md:flex absolute right-0 top-[40%] -translate-y-1/2 translate-x-5 z-10 w-12 h-12 bg-text-main text-white rounded-full items-center justify-center shadow-lg hover:bg-cta transition-colors focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    </button>

    <!-- Custom inline style just for hiding the scrollbar specifically here without heavy config -->
    <style>
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <!-- Container -->
    <div x-ref="slider" class="flex overflow-x-auto gap-6 pb-8 scrollbar-none pt-4 px-2 -mx-2 hover:cursor-grab active:cursor-grabbing">
        
        @php
        $doctors = [
            [
                'name' => 'Clara J. M. Psi., Psikolog',
                'image' => asset('img/prof-pic.jpeg'),
                'rating' => '4.9/5.0',
                'reviews' => '50+',
                'original_price' => '349.000',
                'discount' => '-28%',
                'price' => '249.000',
                'schedules' => ['Senin, 18:00 WIB', 'Selasa, 10:00 WIB']
            ],
            [
                'name' => 'Budi S. M. Psi., Psikolog',
                'image' => asset('img/prof-pic.jpeg'),
                'rating' => '5.0/5.0',
                'reviews' => '120+',
                'original_price' => '400.000',
                'discount' => '-25%',
                'price' => '300.000',
                'schedules' => ['Rabu, 14:00 WIB', 'Kamis, 15:30 WIB']
            ],
            [
                'name' => 'Dr. Andini R. Psikolog',
                'image' => asset('img/prof-pic.jpeg'),
                'rating' => '4.8/5.0',
                'reviews' => '35+',
                'original_price' => '300.000',
                'discount' => '-16%',
                'price' => '250.000',
                'schedules' => ['Jumat, 16:00 WIB', 'Sabtu, 09:00 WIB']
            ],
            [
                'name' => 'Rizky A. M. Psi., Psikolog',
                'image' => asset('img/prof-pic.jpeg'),
                'rating' => '4.9/5.0',
                'reviews' => '80+',
                'original_price' => '350.000',
                'discount' => '-20%',
                'price' => '280.000',
                'schedules' => ['Senin, 13:00 WIB', 'Selasa, 14:00 WIB']
            ],
            [
                'name' => 'Fahri Z. Psikolog',
                'image' => asset('img/prof-pic.jpeg'),
                'rating' => '4.7/5.0',
                'reviews' => '42+',
                'original_price' => '320.000',
                'discount' => '-15%',
                'price' => '272.000',
                'schedules' => ['Kamis, 19:00 WIB', 'Jumat, 13:00 WIB']
            ],
            [
                'name' => 'Sinta M. Psikolog',
                'image' => asset('img/prof-pic.jpeg'),
                'rating' => '5.0/5.0',
                'reviews' => '200+',
                'original_price' => '450.000',
                'discount' => '-30%',
                'price' => '315.000',
                'schedules' => ['Senin, 09:00 WIB', 'Selasa, 16:30 WIB']
            ],
            [
                'name' => 'Dimas W. M. Psi., Psikolog',
                'image' => asset('img/prof-pic.jpeg'),
                'rating' => '4.8/5.0',
                'reviews' => '65+',
                'original_price' => '380.000',
                'discount' => '-21%',
                'price' => '300.000',
                'schedules' => ['Rabu, 10:00 WIB', 'Sabtu, 14:00 WIB']
            ]
        ];
        // Duplicate array for seamless infinite looping scroll
        $doctors = array_merge($doctors, $doctors);
        @endphp

        <!-- Cards loop -->
        @foreach($doctors as $doctor)
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 min-w-[300px] shrink-0 p-5 flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative group">
            
            <!-- Dynamic Image Hover Effect Optional Wrapper -->
            <a href="/psychologist/budi" class="block rounded-xl overflow-hidden aspect-square bg-secondary/30 mb-4 relative flex-shrink-0">
                <img src="{{ $doctor['image'] }}" alt="Photo of {{ $doctor['name'] }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
            </a>

            <!-- License Badge -->
            <div class="flex items-center gap-1.5 mb-2">
                <svg class="w-[15px] h-[15px] text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-1.998A11.954 11.954 0 0110 1.944zM13.707 9.707a1 1 0 00-1.414-1.414l-3 3-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Psikolog Berlisensi</span>
            </div>

            <!-- Name -->
            <a href="/psychologist/budi" class="group-hover:text-cta transition-colors">
                <h3 class="text-xl font-bold mb-1.5">{{ $doctor['name'] }}</h3>
            </a>

            <!-- Rating -->
            <div class="flex items-center gap-1.5 mb-6 pb-6 border-b border-gray-100">
                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                <span class="text-sm font-bold text-amber-500">{{ $doctor['rating'] }}</span>
                <span class="text-[13px] text-slate-400 font-medium">({{ $doctor['reviews'] }} reviews)</span>
            </div>

            <!-- Pricing Area -->
            <div class="mb-6 flex-grow">
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-xs text-slate-400 line-through font-medium">Rp{{ $doctor['original_price'] }}</span>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">{{ $doctor['discount'] }}</span>
                </div>
                <div class="text-xl font-bold text-text-main group-hover:text-cta transition-colors">
                    Rp{{ $doctor['price'] }} <span class="text-xs text-slate-400 font-normal">/ session</span>
                </div>
            </div>

            <!-- Schedule Buttons -->
            <div class="mt-auto">
                <p class="text-[11px] font-bold text-slate-400 mb-2.5 uppercase tracking-wider">Jadwal Tercepat</p>
                <div class="space-y-2">
                    @foreach($doctor['schedules'] as $schedule)
                    <a href="/book" class="block w-full py-2.5 border-2 border-gray-200 rounded-xl text-sm font-semibold text-slate-500 hover:border-cta hover:text-cta tracking-wide transition-colors text-center focus:outline-none focus:ring-2 focus:ring-primary/50">
                        {{ $schedule }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
        @endforeach

    </div>
</div>
