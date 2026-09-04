<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TALOG20 Digital — Portal Tugas Akhir SMKN 20 Cyber Experience">
    <title>{{ $title ?? 'TALOG20 Cyber — SMKN 20 Jakarta' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-[#050814] text-gray-200 font-sans antialiased crt-scanlines selection:bg-cyan-500 selection:text-black">

{{-- Cyber Navbar --}}
<nav class="sticky top-0 z-50 bg-[#0A0F24]/80 backdrop-blur-xl border-b border-cyan-500/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div class="relative">
                    <img src="{{ asset('images/logo-smkn20.webp') }}"
                         alt="Logo SMKN 20"
                         class="h-10 w-auto object-contain filter drop-shadow-[0_0_10px_rgba(0,240,255,0.7)] group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-cyan-400 rounded-full animate-ping"></span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <p class="text-white font-bold text-sm tracking-widest font-mono uppercase">TALOG20</p>
                        <span class="cyber-badge text-[9px] py-0.5 px-1.5">CYBER</span>
                    </div>
                    <p class="text-cyan-400/70 text-[11px] font-mono tracking-wider">SMKN 20 JAKARTA</p>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-2 font-mono text-xs">
                <a href="{{ route('home') }}" class="px-3 py-2 text-cyan-300 hover:text-white hover:bg-cyan-500/10 rounded-lg transition-colors">
                    // BERANDA
                </a>
                <a href="{{ route('experience.futuristic-3d') }}" class="px-3 py-2 text-purple-300 hover:text-white hover:bg-purple-500/10 rounded-lg transition-colors flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse"></span>
                    // 3D CORE
                </a>
                <a href="{{ route('experience.majors') }}" class="px-3 py-2 text-gray-400 hover:text-cyan-300 hover:bg-white/5 rounded-lg transition-colors">
                    // JURUSAN
                </a>
            </div>

            {{-- Right Actions & Theme Switcher --}}
            <div class="flex items-center gap-3">
                {{-- Theme Switch Button --}}
                <a href="{{ route('theme.switch', 'education') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/40 text-amber-300 text-xs font-mono transition-all duration-300"
                   title="Ganti ke Tema Education">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="hidden sm:inline">Tema:</span> Edukasi
                </a>

                @auth
                    @if(auth()->user()->hasRole('Admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn-cyber-outline text-xs py-1.5 px-3 rounded-lg hidden sm:inline-flex">
                            ADMIN CONSOLE
                        </a>
                    @elseif(auth()->user()->hasRole('Guru'))
                        <a href="{{ route('guru.tugas-akhir.index') }}" class="btn-cyber-outline text-xs py-1.5 px-3 rounded-lg hidden sm:inline-flex">
                            GURU CONSOLE
                        </a>
                    @elseif(auth()->user()->hasRole('Siswa'))
                        <a href="{{ route('siswa.tugas-akhir.index') }}" class="btn-cyber-outline text-xs py-1.5 px-3 rounded-lg hidden sm:inline-flex">
                            SISWA CONSOLE
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 text-red-400 text-xs font-mono transition-colors">
                            DISCONNECT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-cyber-primary text-xs py-1.5 px-4 rounded-lg">
                        ACCESS LOGIN
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Main Content --}}
<main>
    {{ $slot }}
</main>

{{-- Cyber Footer --}}
<footer class="bg-[#03050c] border-t border-cyan-500/20 text-gray-400 font-mono text-xs mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="SMKN 20" class="h-8 w-auto filter drop-shadow-[0_0_8px_rgba(0,240,255,0.5)]">
                <div>
                    <p class="text-white font-bold tracking-wider">SMKN 20 JAKARTA // TALOG20</p>
                    <p class="text-gray-500 text-[10px]">EXPERIMENTAL FUTURISTIC WEBGL EXPERIENCE</p>
                </div>
            </div>

            <div class="flex items-center gap-6 text-[11px] text-cyan-400/80">
                <span>[SYS: ONLINE]</span>
                <span>[SEC: ENCRYPTED]</span>
                <span>[VERSION: 2.0.0]</span>
            </div>

            <p class="text-gray-600 text-[11px]">
                &copy; {{ date('Y') }} SMKN 20 Jakarta. All circuits reserved.
            </p>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
