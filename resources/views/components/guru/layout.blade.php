<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel Guru — TALOG20">
    <title>{{ $title ?? 'Panel Guru' }} — TALOG20</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased" x-data="{ sidebarOpen: false }">
<div class="flex h-screen overflow-hidden bg-gray-950">

    {{-- Sidebar --}}
    <aside class="flex flex-col w-64 shrink-0 bg-gray-900 border-r border-gray-800"
           :class="sidebarOpen ? 'block' : 'hidden lg:flex'">
        
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
            <div class="w-8 h-8 rounded-lg bg-cyan-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-white tracking-wide">TALOG20</p>
                <p class="text-xs text-gray-400">Panel Guru</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('guru.tugas-akhir.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('guru.tugas-akhir.*') ? 'bg-cyan-600/20 text-cyan-400' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                Tugas Akhir
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
            <p class="text-xs text-gray-500 truncate">Guru {{ auth()->user()->jurusan?->name ?? '' }}</p>
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
