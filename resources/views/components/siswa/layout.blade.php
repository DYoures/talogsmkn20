<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ruang Siswa — TALOG20">
    <title>{{ $title ?? 'Ruang Siswa' }} — TALOG20</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased" x-data="{ sidebarOpen: false }">
<div class="flex h-screen overflow-hidden bg-gray-950">

    {{-- Sidebar --}}
    <aside class="flex flex-col w-64 shrink-0 bg-gray-900 border-r border-gray-800"
           :class="sidebarOpen ? 'block' : 'hidden lg:flex'">
        
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
            <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-white tracking-wide">TALOG20</p>
                <p class="text-xs text-gray-400">Ruang Siswa</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('siswa.tugas-akhir.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('siswa.tugas-akhir.*') ? 'bg-emerald-600/20 text-emerald-400' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                Tugas Akhir Saya
            </a>

            <div class="pt-4 border-t border-gray-800 mt-4">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    Ke Beranda
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-red-900/40 hover:text-red-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        {{-- User info --}}
        <div class="px-4 py-3 border-t border-gray-800">
            <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-500 truncate">Siswa {{ auth()->user()->jurusan?->name ?? '' }}</p>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex flex-col flex-1 overflow-hidden">
        
        {{-- Topbar --}}
        <header class="flex items-center justify-between px-6 py-4 bg-gray-900 border-b border-gray-800 shrink-0">
            <button class="lg:hidden text-gray-400 hover:text-white" @click="sidebarOpen = !sidebarOpen">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
            <h1 class="text-lg font-semibold text-white">{{ $title ?? 'Dashboard' }}</h1>
            <div class="text-sm text-gray-400">{{ now()->format('d M Y') }}</div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm mb-2">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm mb-2">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
