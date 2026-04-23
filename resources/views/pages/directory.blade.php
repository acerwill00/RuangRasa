@extends('layouts.app')

@section('title', 'Our Psychologists | RASA Psychology')

@section('content')

<div x-data="{
    query: '',
    topic: '',
    time: 'anytime',
    activeSection: 'all',
    psychologistsData: {{ json_encode($psychologists) }},
    get isFiltering() {
        return this.query.trim().length > 0 || this.topic !== '' || this.time !== 'anytime' || this.activeSection !== 'all';
    },
    matchesFilter(id) {
        let p = this.psychologistsData[id];
        if (!p) return false;
        
        if (this.activeSection !== 'all') {
            if (!p.swimlanes.includes(this.activeSection)) return false;
        }
        if (this.query.trim().length > 0) {
            const q = this.query.toLowerCase();
            const matchesName = p.name.toLowerCase().includes(q);
            const matchesSpec = p.specialties.some(s => s.toLowerCase().includes(q));
            if (!matchesName && !matchesSpec) return false;
        }
        if (this.topic !== '') {
            const matchesTopic = p.specialties.some(s => s.toLowerCase() === this.topic.toLowerCase() || s.toLowerCase().includes(this.topic.toLowerCase()));
            if (!matchesTopic) return false;
        }
        if (this.time !== 'anytime') {
            const timeMap = {
                'today': ['Today'],
                'tomorrow': ['Tomorrow'],
                'this_weekend': ['Sat', 'Sun'],
                'next_week': ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']
            };
            const validTokens = timeMap[this.time] || [];
            const hasSchedule = p.schedules.some(sch => 
                validTokens.some(token => sch.includes(token))
            );
            if (!hasSchedule) return false;
        }
        return true;
    },
    clearFilters() {
        this.query = '';
        this.topic = '';
        this.time = 'anytime';
        this.activeSection = 'all';
    }
}">

<!-- Header & Smart Filter -->
<section class="pt-16 pb-12 bg-slate-50 border-b border-primary/10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-10 text-text-main">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight" x-show="activeSection === 'all'">Find the Right <span class="text-cta">Support</span> for You</h1>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight" x-show="activeSection === 'today'" style="display: none;">Available <span class="text-cta">Today</span></h1>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight" x-show="activeSection === 'evening'" style="display: none;">Evening & <span class="text-cta">Weekend</span></h1>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight" x-show="activeSection === 'highly_recommended'" style="display: none;">Highly <span class="text-cta">Recommended</span></h1>
            
            <p class="opacity-80 text-lg mb-8">Browse our verified clinical psychologists. Choose someone who aligns with your current needs in a safe, warm environment.</p>
            
            <!-- Search Bar -->
            <div class="relative max-w-2xl mx-auto group shadow-soft rounded-full">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-cta transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <!-- Binding input to query -->
                <input type="text" x-model="query" class="block w-full pl-14 pr-[120px] py-4 rounded-full border-2 border-transparent bg-white focus:outline-none focus:border-cta focus:ring-4 focus:ring-primary/20 transition-all text-base placeholder-slate-400 font-medium text-text-main" placeholder="Search by name, expertise, or symptoms...">
                <button @click="query = document.querySelector('input').value" class="absolute inset-y-2 right-2 px-6 bg-cta hover:bg-cta-hover text-white font-bold rounded-full transition-all shadow-sm hover:shadow active:scale-95 flex items-center">
                    Search
                </button>
            </div>
        </div>
        
        <!-- Filter Strip -->
        <div class="flex flex-col lg:flex-row items-center justify-between gap-4 bg-white p-3 rounded-[2rem] shadow-sm border border-secondary lg:rounded-full relative z-10">
            <div class="flex overflow-x-auto gap-2 pb-2 lg:pb-0 w-full lg:w-auto hide-scrollbar px-2 pl-4 lg:pl-2">
                <button @click="time = 'anytime'" :class="time === 'anytime' ? 'bg-primary/20 text-cta shadow-sm cursor-default' : 'bg-slate-50 border border-slate-100 hover:border-cta hover:text-cta text-slate-600 focus:ring-2 focus:ring-primary/50'" class="whitespace-nowrap px-6 py-2.5 font-bold rounded-full text-sm transition-all border border-transparent">Anytime</button>
                
                <button @click="time = 'today'" :class="time === 'today' ? 'bg-primary/20 text-cta shadow-sm cursor-default' : 'bg-slate-50 border border-slate-100 hover:border-cta hover:text-cta text-slate-600 focus:ring-2 focus:ring-primary/50'" class="whitespace-nowrap px-6 py-2.5 font-bold rounded-full text-sm transition-all border border-transparent">Today</button>
                
                <button @click="time = 'tomorrow'" :class="time === 'tomorrow' ? 'bg-primary/20 text-cta shadow-sm cursor-default' : 'bg-slate-50 border border-slate-100 hover:border-cta hover:text-cta text-slate-600 focus:ring-2 focus:ring-primary/50'" class="whitespace-nowrap px-6 py-2.5 font-bold rounded-full text-sm transition-all border border-transparent">Tomorrow</button>
                
                <button @click="time = 'this_weekend'" :class="time === 'this_weekend' ? 'bg-primary/20 text-cta shadow-sm cursor-default' : 'bg-slate-50 border border-slate-100 hover:border-cta hover:text-cta text-slate-600 focus:ring-2 focus:ring-primary/50'" class="whitespace-nowrap px-6 py-2.5 font-bold rounded-full text-sm transition-all border border-transparent">This Weekend</button>
                
                <button @click="time = 'next_week'" :class="time === 'next_week' ? 'bg-primary/20 text-cta shadow-sm cursor-default' : 'bg-slate-50 border border-slate-100 hover:border-cta hover:text-cta text-slate-600 focus:ring-2 focus:ring-primary/50'" class="whitespace-nowrap px-6 py-2.5 font-bold rounded-full text-sm transition-all border border-transparent">Next Week</button>
            </div>
            
            <div class="w-full lg:w-auto px-2 pr-4 lg:pr-2 flex items-center gap-2">
                <button x-show="isFiltering" @click="clearFilters()" class="whitespace-nowrap px-4 py-2 hover:bg-slate-100 text-slate-400 hover:text-red-500 rounded-full text-sm font-bold transition-all flex items-center gap-1" style="display: none;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Clear Filter
                </button>

                <select x-model="topic" class="w-full lg:w-auto pl-5 pr-12 py-2.5 bg-slate-50 border border-slate-200 rounded-full text-sm font-bold text-slate-600 hover:border-cta focus:border-cta outline-none transition-colors appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%2364748B%22%3E%3Cpath%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.2rem_1.2rem] bg-no-repeat bg-[right_0.75rem_center]">
                    <option value="">Filter by Topic</option>
                    <option value="anxiety">Anxiety</option>
                    <option value="burnout">Burnout</option>
                    <option value="relationships">Relationships</option>
                    <option value="trauma">Trauma</option>
                    <option value="stress">Stress</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Hide scrollbar class safely applied inline for the swimlanes -->
<style>
    .swimlane::-webkit-scrollbar { display: none; }
    .swimlane { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- Directory Content -->
<section class="pt-8 pb-24 bg-white min-h-[500px]">
    <div class="max-w-7xl mx-auto px-6">
        
        <!-- INITIAL DEFAULT STATE: SWIMLANES -->
        <div x-show="!isFiltering" x-transition>
            
            <!-- SECTION A: Available Today -->
            <div class="relative mb-20">
                <div class="flex justify-between items-end mb-8 pl-2">
                    <div>
                        <h2 class="text-3xl font-bold text-text-main flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse ring-4 ring-emerald-100"></span>
                            Available Today
                        </h2>
                        <p class="text-[15px] opacity-60 mt-1.5 font-medium">Get immediate support from verified professionals.</p>
                    </div>
                    <button @click.prevent="activeSection = 'today'" class="text-sm font-bold text-cta hover:text-cta-hover transition-colors hidden sm:flex items-center gap-1 border-b-2 border-cta/30 pb-0.5">
                        View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
                
                <div class="flex overflow-x-auto gap-6 pb-6 pt-2 snap-x swimlane -mx-6 px-6 relative z-0">
                    @foreach($psychologists as $id => $p)
                        @if(in_array('today', $p['swimlanes'] ?? []))
                            <x-directory-card 
                                id="{{ $id }}"
                                name="{{ $p['name'] }}" 
                                image="{{ $p['image'] }}"
                                rating="{{ $p['rating'] ?? '5.0' }}"
                                sessions="{{ $p['sessions'] ?? '50+' }}"
                                original-price="{{ $p['original_price'] ?? null }}"
                                discount="{{ $p['discount'] ?? null }}"
                                price="{{ $p['price'] }}"
                                :schedules="$p['schedules'] ?? []"
                            />
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- SECTION B: Evening & Weekend -->
            <div class="relative mb-20">
                <div class="flex justify-between items-end mb-8 pl-2">
                    <div>
                        <h2 class="text-3xl font-bold text-text-main">
                            Evening & Weekend
                        </h2>
                        <p class="text-[15px] opacity-60 mt-1.5 font-medium">Professionals offering off-hours scheduling for busy workers.</p>
                    </div>
                    <button @click.prevent="activeSection = 'evening'" class="text-sm font-bold text-cta hover:text-cta-hover transition-colors hidden sm:flex items-center gap-1 border-b-2 border-cta/30 pb-0.5">
                        View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
                
                <div class="flex overflow-x-auto gap-6 pb-6 pt-2 snap-x swimlane -mx-6 px-6 relative z-0">
                    @foreach($psychologists as $id => $p)
                        @if(in_array('evening', $p['swimlanes'] ?? []))
                            <x-directory-card 
                                id="{{ $id }}"
                                name="{{ $p['name'] }}" 
                                image="{{ $p['image'] }}"
                                rating="{{ $p['rating'] ?? '5.0' }}"
                                sessions="{{ $p['sessions'] ?? '50+' }}"
                                original-price="{{ $p['original_price'] ?? null }}"
                                discount="{{ $p['discount'] ?? null }}"
                                price="{{ $p['price'] }}"
                                :schedules="$p['schedules'] ?? []"
                            />
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- SECTION C: Highly Recommended -->
            <div class="relative">
                <div class="flex justify-between items-end mb-8 pl-2">
                    <div>
                        <h2 class="text-3xl font-bold text-text-main">
                            Highly Recommended
                        </h2>
                        <p class="text-[15px] opacity-60 mt-1.5 font-medium">Top-rated counselors according to patient feedback.</p>
                    </div>
                    <button @click.prevent="activeSection = 'highly_recommended'" class="text-sm font-bold text-cta hover:text-cta-hover transition-colors hidden sm:flex items-center gap-1 border-b-2 border-cta/30 pb-0.5">
                        View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
                
                <div class="flex overflow-x-auto gap-6 pb-6 pt-2 snap-x swimlane -mx-6 px-6 relative z-0">
                    @foreach($psychologists as $id => $p)
                        @if(in_array('highly_recommended', $p['swimlanes'] ?? []))
                            <x-directory-card 
                                id="{{ $id }}"
                                name="{{ $p['name'] }}" 
                                image="{{ $p['image'] }}"
                                rating="{{ $p['rating'] ?? '5.0' }}"
                                sessions="{{ $p['sessions'] ?? '50+' }}"
                                original-price="{{ $p['original_price'] ?? null }}"
                                discount="{{ $p['discount'] ?? null }}"
                                price="{{ $p['price'] }}"
                                :schedules="$p['schedules'] ?? []"
                            />
                        @endif
                    @endforeach
                </div>
            </div>
            
        </div>


        <!-- FILTERED STATE: FLAT GRID -->
        <div x-show="isFiltering" style="display: none;" x-transition>
            
            <!-- Active Filters Display -->
            <div class="mb-8 flex flex-wrap items-center gap-2">
                <span class="text-sm font-semibold text-text-main/70 mr-2">Applied Filters:</span>
                
                <!-- Search Query Pill -->
                <span x-show="query.trim() !== ''" class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 border border-slate-200 rounded-lg text-sm font-medium text-slate-700">
                    Search: <b x-text="query"></b>
                    <button @click="query = ''" class="hover:text-red-500 transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </span>
                
                <!-- Topic Filter Pill -->
                <span x-show="topic !== ''" class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 border border-slate-200 rounded-lg text-sm font-medium text-slate-700">
                    Topic: <b x-text="topic.charAt(0).toUpperCase() + topic.slice(1)"></b>
                    <button @click="topic = ''" class="hover:text-red-500 transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </span>
                
                <!-- Time Filter Pill -->
                <span x-show="time !== 'anytime'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 border border-slate-200 rounded-lg text-sm font-medium text-slate-700">
                    Time: <b x-text="time.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ')"></b>
                    <button @click="time = 'anytime'" class="hover:text-red-500 transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </span>

                <!-- Category/Section Fill Pill -->
                <span x-show="activeSection !== 'all'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/20 border border-primary/30 rounded-lg text-sm font-medium text-cta">
                    Category: <b x-text="activeSection.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ')"></b>
                    <button @click="activeSection = 'all'" class="hover:text-red-500 transition-colors"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </span>
                
                <button @click="clearFilters()" class="ml-2 text-xs font-bold text-cta hover:text-red-500 transition-colors underline decoration-cta/30 hover:decoration-red-500/30 underline-offset-2">Clear All</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-12 gap-x-6">
                @foreach($psychologists as $id => $p)
                    <div x-show="matchesFilter('{{ $id }}')" class="w-full max-w-[400px] mx-auto md:max-w-none transition-all duration-300">
                        <x-directory-card 
                            id="{{ $id }}"
                            name="{{ $p['name'] }}" 
                            image="{{ $p['image'] }}"
                            rating="{{ $p['rating'] ?? '5.0' }}"
                            sessions="{{ $p['sessions'] ?? '50+' }}"
                            original-price="{{ $p['original_price'] ?? null }}"
                            discount="{{ $p['discount'] ?? null }}"
                            price="{{ $p['price'] }}"
                            :schedules="$p['schedules'] ?? []"
                        />
                    </div>
                @endforeach
            </div>

            <!-- Empty State Fallback -->
            <div x-show="Object.keys(psychologistsData).filter(id => matchesFilter(id)).length === 0" class="text-center py-20 bg-slate-50 rounded-[2rem] border border-slate-200" style="display: none;">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm mb-4 border border-secondary text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 14a4 4 0 100-8 4 4 0 000 8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-text-main mb-2">No Psychologists Found</h3>
                <p class="opacity-70 max-w-md mx-auto mb-6">We couldn't find anyone matching your exact specific criteria. Try adjusting your search query or filters.</p>
                <button @click="clearFilters()" class="text-cta hover:text-cta-hover font-bold border-b-2 border-cta/30 hover:border-cta transition-all">Clear All Filters</button>
            </div>
            
        </div>

    </div>
</section>

</div>
@endsection
