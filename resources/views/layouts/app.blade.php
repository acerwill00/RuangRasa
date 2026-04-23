<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RASA Psychology') | Mental Clarity Starts Here</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for rapid UI testing) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#DAC4F7',
                        secondary: '#E8F1F2',
                        background: '#FFFFFF',
                        'text-main': '#00263E',
                        cta: '#B18FE4',
                        'cta-hover': '#9B74DE',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 10px 25px -5px rgba(0, 38, 62, 0.05), 0 8px 10px -6px rgba(0, 38, 62, 0.01)',
                    }
                }
            }
        }
    </script>
    
    {{-- Local Vite/Tailwind directive (uncomment for production) --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <!-- Alpine.js (for simple UI interactions) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html { zoom: 0.9; }
        body { background-color: theme('colors.background'); color: theme('colors.text-main'); }
        /* Add global soft focus styles, removing aggressive rings */
        input:focus, textarea:focus, select:focus {
            outline: none !important;
            border-color: theme('colors.primary') !important;
            box-shadow: 0 0 0 3px rgba(218, 196, 247, 0.4) !important;
        }
        /* Page Load Animation */
        @keyframes pageFadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-page {
            animation: pageFadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        /* Dropdown animation */
        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .dropdown-animate {
            animation: dropdownFadeIn 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col selection:bg-primary selection:text-text-main pb-20 lg:pb-0 select-none" oncopy="return false;" oncut="return false;">

    <!-- Navigation -->
    <nav class="bg-background/80 backdrop-blur-md sticky top-0 z-50 border-b border-secondary">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('img/logo.png') }}" alt="RASA Logo" class="h-12 w-auto object-contain">
            </a>

            <!-- Desktop Links -->
            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="/services" class="relative group transition-colors {{ request()->is('services*') ? 'text-cta font-semibold' : 'hover:text-cta' }}">
                    Services
                    <span class="absolute -bottom-1 left-0 h-0.5 bg-cta transition-all duration-300 {{ request()->is('services*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="/our-psychologist" class="relative group transition-colors {{ request()->is('our-psychologist*') || request()->is('psychologist*') ? 'text-cta font-semibold' : 'hover:text-cta' }}">
                    Our Psychologist
                    <span class="absolute -bottom-1 left-0 h-0.5 bg-cta transition-all duration-300 {{ request()->is('our-psychologist*') || request()->is('psychologist*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="/articles" class="relative group transition-colors {{ request()->is('article*') ? 'text-cta font-semibold' : 'hover:text-cta' }}">
                    Articles
                    <span class="absolute -bottom-1 left-0 h-0.5 bg-cta transition-all duration-300 {{ request()->is('article*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="/about" class="relative group transition-colors {{ request()->is('about*') ? 'text-cta font-semibold' : 'hover:text-cta' }}">
                    About
                    <span class="absolute -bottom-1 left-0 h-0.5 bg-cta transition-all duration-300 {{ request()->is('about*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
            </div>

            <!-- Actions -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- Book Session Button (only for non-admin patients) --}}
                    @if(!auth()->user()->is_admin)
                        <a href="/our-psychologist" class="px-5 py-2.5 bg-cta hover:bg-cta-hover text-white rounded-xl font-semibold transition-all shadow-sm hover:shadow text-sm">
                            Book Session
                        </a>
                    @endif

                    {{-- Notifications Dropdown --}}
                    <div x-data="{ open: false, unreadCount: {{ auth()->user()->unreadNotifications->count() }} }" class="relative" @click.outside="open = false">
                        <button @click="open = !open; if(open && unreadCount > 0) { fetch('/notifications/mark-read', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}}); unreadCount = 0; }" 
                            class="relative p-2 text-slate-500 hover:text-cta transition-colors focus:outline-none rounded-full hover:bg-slate-50 mt-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span x-show="unreadCount > 0" style="display: none;" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             style="display: none;"
                             class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden z-50">
                            
                            <div class="px-4 py-3 bg-secondary/30 border-b border-slate-100 flex justify-between items-center">
                                <p class="font-semibold text-text-main text-sm">Notifications</p>
                            </div>

                            <div class="max-h-80 overflow-y-auto">
                                @forelse(auth()->user()->notifications()->take(10)->get() as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors {{ $notification->read_at ? 'opacity-70' : 'bg-primary/5' }}">
                                        <p class="text-sm font-semibold text-text-main">{{ $notification->data['title'] }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-sm text-slate-500">
                                        No notifications yet.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- User Dropdown --}}
                    <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                        <button @click="open = !open" id="user-menu-btn"
                            class="flex items-center gap-2 pl-1 pr-3 py-1 rounded-full border-2 border-transparent hover:border-primary/50 transition-all focus:outline-none focus:border-cta">
                            {{-- Avatar --}}
                            @if(auth()->user()->photo_url)
                                <img src="{{ Storage::url(auth()->user()->photo_url) }}" 
                                     alt="{{ auth()->user()->name }}"
                                     class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/40">
                            @else
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary to-cta flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="text-sm font-medium text-text-main hidden lg:inline max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                            <svg x-bind:class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             style="display: none;"
                             class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden z-50">
                            
                            {{-- User Info Header --}}
                            <div class="px-4 py-3 bg-secondary/30 border-b border-slate-100">
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Signed in as</p>
                                <p class="font-semibold text-text-main truncate text-sm mt-0.5">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Menu Items --}}
                            <div class="py-1.5">
                                @if(!auth()->user()->is_admin)
                                    <a href="/profile" 
                                       class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-primary/10 hover:text-cta transition-colors {{ request()->is('profile*') ? 'bg-primary/10 text-cta' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        My Profile
                                    </a>
                                    <a href="/dashboard" 
                                       class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-primary/10 hover:text-cta transition-colors {{ request()->is('dashboard*') ? 'bg-primary/10 text-cta' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        My Booking
                                    </a>
                                @else
                                    <a href="/admin/dashboard" 
                                       class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-primary/10 hover:text-cta transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        Dashboard
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-slate-100 py-1.5">
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-500 hover:bg-red-50 transition-colors text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <a href="/login" class="px-4 py-2 font-medium hover:text-cta transition-colors text-sm">Log In</a>
                    <a href="/login" id="book-session-btn"
                       class="px-5 py-2.5 bg-cta hover:bg-cta-hover text-white rounded-xl font-semibold transition-all shadow-sm hover:shadow text-sm">
                        Book Session
                    </a>
                @endauth
            </div>
            
            <!-- Mobile Menu Btn -->
            <button class="md:hidden p-2 text-text-main">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow animate-page">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-secondary/40 pt-16 pb-8 border-t border-secondary mt-20">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-5 gap-10">
            <div class="col-span-1 md:col-span-2">
                <a href="/" class="inline-block mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="RASA Logo" class="h-12 w-auto object-contain">
                </a>
                <p class="text-sm opacity-80 max-w-sm">A warm, safe space for your mental wellbeing. Connect with empathetic professionals ready to listen.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Explore</h4>
                <ul class="space-y-2 text-sm opacity-80">
                    <li><a href="/services" class="hover:text-cta">Therapy Services</a></li>
                    <li><a href="/articles" class="hover:text-cta">Articles & Resources</a></li>
                    <li><a href="/our-psychologist" class="hover:text-cta">Our Psychologist</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Support</h4>
                <ul class="space-y-2 text-sm opacity-80">
                    <li><a href="/faq" class="hover:text-cta">FAQ</a></li>
                    <li><a href="/privacy" class="hover:text-cta">Privacy Policy</a></li>
                    <li><a href="/contact" class="hover:text-cta">Contact Us</a></li>
                </ul>
            </div>
            <div class="text-center md:text-left">
                <h4 class="font-semibold mb-4 text-text-main">Our Social Media</h4>
                <div class="flex items-center justify-center md:justify-start gap-5">
                    <a href="https://www.instagram.com/rasa.psycenter/" target="_blank" rel="noopener noreferrer" class="text-cta hover:text-cta-hover transition-transform hover:scale-110 drop-shadow-sm" aria-label="Instagram">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="https://wa.me/0895339669579" target="_blank" rel="noopener noreferrer" class="text-cta hover:text-cta-hover transition-transform hover:scale-110 drop-shadow-sm" aria-label="WhatsApp">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.818-.728-1.372-1.626-1.532-1.924-.16-.299-.017-.46.132-.609.133-.133.298-.348.446-.521.144-.174.192-.297.288-.496.096-.198.048-.372-.025-.521-.075-.15-.67-1.62-.92-2.219-.24-.582-.486-.5-.674-.509-.174-.008-.376-.008-.577-.008-.201 0-.528.075-.804.372-.275.297-1.047 1.026-1.047 2.5s1.072 2.894 1.22 3.093c.148.199 2.106 3.257 5.105 4.558.714.31 1.27.495 1.704.634.715.228 1.365.195 1.876.118.577-.087 1.758-.72 2.005-1.415.247-.696.247-1.293.173-1.415-.074-.124-.275-.199-.572-.348zM12.012 21.037h-.005c-1.637 0-3.242-.44-4.647-1.272l-.334-.198-3.456.906.924-3.37-.217-.346c-.914-1.458-1.396-3.144-1.396-4.887 0-5.048 4.108-9.155 9.16-9.155 2.446 0 4.745.953 6.474 2.684a9.1 9.1 0 0 1 2.68 6.467c-.001 5.047-4.11 9.154-9.16 9.154A9.15 9.15 0 0 1 12.012 21.037z" /><path d="M12.012 0C5.387 0 0 5.385 0 12.012c0 2.115.553 4.181 1.605 6.002L.031 24l6.118-1.605c1.782.955 3.791 1.456 5.858 1.456h.005C18.63 23.851 24 18.468 24 12.012 24 8.795 22.748 5.762 20.473 3.484 18.204 1.206 15.174 0 12.012 0zm0 1.986c2.68 0 5.198 1.043 7.091 2.937 1.892 1.892 2.934 4.411 2.934 7.089.001 5.524-4.495 10.016-10.02 10.016a10.02 10.02 0 0 1-5.111-1.402l-.366-.217-3.799.996.999-3.7-.238-.378A10.016 10.016 0 0 1 1.986 12.011C1.986 6.486 6.486 1.986 12.012 1.986"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-text-main/10 mt-12 pt-8 text-center text-sm opacity-60">
            &copy; {{ date('Y') }} RASA Psychology. All rights reserved.
        </div>
    </footer>

    @yield('scripts')

    {{-- Login Success Welcome Animation --}}
    @if(session('login_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userName = @json(session('login_success'));
            
            // Step 1: "You are logged in!"
            Swal.fire({
                icon: 'success',
                title: 'You are logged in!',
                text: '✓ Authentication successful',
                timer: 1400,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#fff',
                color: '#00263E',
                iconColor: '#B18FE4',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    title: 'font-bold text-xl',
                },
                didClose: () => {
                    // Step 2: "Welcome back {name}"
                    Swal.fire({
                        html: `
                            <div style="padding: 8px 0;">
                                <div style="font-size: 2.5rem; margin-bottom: 8px;">👋</div>
                                <p style="font-size: 1.1rem; font-weight: 700; color: #00263E; margin: 0 0 4px;">Welcome back,</p>
                                <p style="font-size: 1.5rem; font-weight: 800; color: #B18FE4; margin: 0;">${userName}!</p>
                                <p style="font-size: 0.85rem; color: #94a3b8; margin-top: 8px;">We're glad you're here. 💜</p>
                            </div>
                        `,
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        background: '#fff',
                        customClass: {
                            popup: 'rounded-2xl shadow-xl border border-slate-100',
                        },
                    });
                }
            });
        });
    </script>
    @endif
</body>
</html>
