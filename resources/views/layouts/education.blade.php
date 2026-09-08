<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TALOG20 — Sistem Pengelolaan Tugas Akhir SMKN 20 Jakarta">
    <title>{{ $title ?? 'TALOG20 — SMKN 20 Jakarta' }}</title>
    @include('partials.transition-head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>

        /* ===== Education Entrance Animation System ===== */
        /* Elements start hidden — CSS default state */
        .edu-anim-item {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }
        /* Revealed state — added by IntersectionObserver */
        .edu-anim-item.edu-anim-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Respect reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            .edu-anim-item {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="bg-edu-canvas text-edu-body font-sans antialiased">

{{-- Skyline Wipe Transition Overlay --}}
@include('partials.transition-overlay', ['transitionTheme' => 'education'])

{{-- Navbar --}}
<nav class="edu-navbar shadow-edu-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo-smkn20.webp') }}"
                     alt="Logo SMKN 20 Jakarta"
                     class="h-10 w-auto object-contain group-hover:scale-105 transition-transform duration-200">
                <div class="hidden sm:block">
                    <p class="text-white font-bold text-sm leading-tight tracking-wide">SMKN 20 Jakarta</p>
                    <p class="text-white/60 text-xs">Sistem Tugas Akhir</p>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="edu-nav-link {{ request()->routeIs('home', 'beranda') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('jurusan.index') }}"
                   class="edu-nav-link {{ request()->routeIs('jurusan.index', 'jurusan.detail') ? 'active' : '' }}">Jurusan</a>
                <a href="{{ route('tentang') }}"
                   class="edu-nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
            </div>

            {{-- Auth / User Actions --}}
            <div class="flex items-center gap-3">
                {{-- Theme Switcher Button --}}
                <a href="{{ route('theme.switch', 'futuristic') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 hover:bg-cyan-500/20 border border-white/20 hover:border-cyan-400 text-white text-xs font-semibold transition-all duration-300 shadow-sm"
                   title="Beralih ke Tema Futuristic Digital">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span class="hidden sm:inline">Tema:</span> Cyber
                </a>

                @auth
                    @if(auth()->user()->hasRole('Admin'))
                        <a href="{{ route('admin.dashboard') }}" class="edu-nav-link hidden sm:inline-flex">Admin</a>
                    @elseif(auth()->user()->hasRole('Guru'))
                        <a href="{{ route('guru.tugas-akhir.index') }}" class="edu-nav-link hidden sm:inline-flex">Dashboard Guru</a>
                    @elseif(auth()->user()->hasRole('Siswa'))
                        <a href="{{ route('siswa.tugas-akhir.index') }}" class="edu-nav-link hidden sm:inline-flex">Dashboard Siswa</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-edu-outline text-xs px-4 py-2">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="edu-nav-link hidden sm:inline-flex">Masuk</a>
                    <a href="{{ route('login') }}" class="btn-edu-primary text-xs px-4 py-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Page Content --}}
{{ $slot }}

{{-- Footer --}}
<footer class="bg-edu-navy text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo SMKN 20" class="h-10 w-auto">
                    <div>
                        <p class="font-bold text-white">SMKN 20 Jakarta</p>
                        <p class="text-white/60 text-xs">Sekolah Menengah Kejuruan</p>
                    </div>
                </div>
                <p class="text-white/60 text-sm leading-relaxed">Platform pengelolaan tugas akhir siswa SMKN 20 Jakarta secara digital dan terstruktur.</p>
            </div>
            <div>
                <h4 class="font-semibold text-sm mb-3 text-white/90">Navigasi</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('home') }}" class="hover:text-edu-orange transition-colors">Beranda</a></li>
                    <li><a href="{{ route('jurusan.index') }}" class="hover:text-edu-orange transition-colors">Jurusan</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-edu-orange transition-colors">Tentang</a></li>
                    @guest
                    <li><a href="{{ route('login') }}" class="hover:text-edu-orange transition-colors">Masuk Sistem</a></li>
                    @endguest
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-sm mb-3 text-white/90">Kontak</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li>Jl. Pertanian Raya No.135, Jakarta Timur</li>
                    <li>DKI Jakarta 13120</li>
                    <li class="text-edu-orange">smkn20jkt@gmail.com</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-white/40 text-xs">© {{ date('Y') }} SMKN 20 Jakarta — TALOG20. Semua Hak Dilindungi.</p>
            <p class="text-white/30 text-xs">Dikembangkan dengan ❤️ untuk kemajuan pendidikan</p>
        </div>
    </div>
</footer>

@stack('scripts')
<script>
(function() {
    'use strict';
    
    /**
     * Education Theme — Entrance Animation Controller
     * Uses IntersectionObserver to reveal .edu-anim-item elements
     * with staggered delay as they scroll into viewport.
     */
    function initEduAnimations() {
        var items = document.querySelectorAll('.edu-anim-item');
        if (!items.length) return;

        // Fallback: if IntersectionObserver not supported, show all immediately
        if (!('IntersectionObserver' in window)) {
            items.forEach(function(el) { el.classList.add('edu-anim-visible'); });
            return;
        }

        // Track stagger index per batch of elements entering at roughly the same time
        var revealQueue = [];
        var revealTimer = null;

        function processRevealQueue() {
            revealQueue.forEach(function(el, i) {
                setTimeout(function() {
                    el.classList.add('edu-anim-visible');
                }, i * 90);
            });
            revealQueue = [];
            revealTimer = null;
        }

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    revealQueue.push(entry.target);
                    observer.unobserve(entry.target);

                    // Batch reveals that happen in the same frame
                    if (revealTimer) clearTimeout(revealTimer);
                    revealTimer = setTimeout(processRevealQueue, 30);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -40px 0px'
        });

        items.forEach(function(el) {
            observer.observe(el);
        });
    }

    // Run on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEduAnimations);
    } else {
        initEduAnimations();
    }
})();
</script>
</body>
</html>
