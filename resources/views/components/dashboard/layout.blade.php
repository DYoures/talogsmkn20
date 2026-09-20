@props([
    'role' => 'admin',
    'title' => 'Dashboard',
    'subtitle' => null,
])

@php
    $role = strtolower($role);
    if (!in_array($role, ['admin', 'guru', 'siswa'])) {
        $userRole = auth()->user()?->getRoleNames()->first();
        $role = strtolower($userRole ?? 'admin');
    }

    $roleConfig = [
        'admin' => [
            'label' => 'Ruang Admin',
            'badgeClass' => 'bg-indigo-600 text-white',
            'activeClass' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 font-semibold border-l-2 border-indigo-600 dark:border-indigo-400',
            'inactiveClass' => 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
        ],
        'guru' => [
            'label' => 'Ruang Guru',
            'badgeClass' => 'bg-cyan-600 text-white',
            'activeClass' => 'bg-cyan-50 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300 font-semibold border-l-2 border-cyan-600 dark:border-cyan-400',
            'inactiveClass' => 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
        ],
        'siswa' => [
            'label' => 'Ruang Siswa',
            'badgeClass' => 'bg-emerald-600 text-white',
            'activeClass' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 font-semibold border-l-2 border-emerald-600 dark:border-emerald-400',
            'inactiveClass' => 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
        ],
    ][$role] ?? [
        'label' => 'Ruang Dashboard',
        'badgeClass' => 'bg-indigo-600 text-white',
        'activeClass' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 font-semibold border-l-2 border-indigo-600 dark:border-indigo-400',
        'inactiveClass' => 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
    ];
@endphp

<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50 dark:bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TALOG20 — Platform Portofolio & Tugas Akhir SMKN 20 Jakarta">
    <title>{{ $title ? $title . ' — ' : '' }}TALOG20</title>
    <style>
        html { background-color: #f9fafb; color-scheme: light; }
        html.dark { background-color: #030712; color-scheme: dark; }
    </style>
    <script>
        (function() {
            try {
                var m = localStorage.getItem('talog-color-mode');
                var isDark = (m === 'dark') || (!m || m === 'auto' ? (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) : false);
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white"
      x-data="{ sidebarOpen: false }"
      @keydown.window.escape="sidebarOpen = false">

<div class="flex h-screen overflow-hidden bg-gray-50 dark:bg-gray-950">

    {{-- Mobile Sidebar Backdrop Overlay --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-gray-900/60 backdrop-blur-xs lg:hidden"
         aria-hidden="true"
         x-cloak>
    </div>

    {{-- Sidebar Drawer --}}
    <aside class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transition-transform duration-200 ease-in-out lg:static lg:translate-x-0 shrink-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           aria-label="Navigasi Utama">

        {{-- Brand / Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg {{ $roleConfig['badgeClass'] }} flex items-center justify-center shrink-0 shadow-xs">
                    @if($role === 'admin')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    @elseif($role === 'guru')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    @endif
                </div>
                <div>
                    <span class="text-sm font-bold text-gray-900 dark:text-white tracking-wide block leading-tight">TALOG20</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 block">{{ $roleConfig['label'] }}</span>
                </div>
            </div>

            {{-- Close button for mobile drawer --}}
            <button type="button"
                    @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800"
                    aria-label="Tutup Navigasi">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Nav Links --}}
        <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto">
            @if($role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? $roleConfig['activeClass'] : $roleConfig['inactiveClass'] }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.jurusan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-150 {{ request()->routeIs('admin.jurusan.*') ? $roleConfig['activeClass'] : $roleConfig['inactiveClass'] }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Jurusan</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-150 {{ request()->routeIs('admin.users.*') ? $roleConfig['activeClass'] : $roleConfig['inactiveClass'] }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Manajemen User</span>
                </a>

                <a href="{{ route('admin.nilai.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-150 {{ request()->routeIs('admin.nilai.*') ? $roleConfig['activeClass'] : $roleConfig['inactiveClass'] }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Nilai</span>
                </a>
            @elseif($role === 'guru')
                <a href="{{ route('guru.tugas-akhir.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-150 {{ request()->routeIs('guru.tugas-akhir.*') ? $roleConfig['activeClass'] : $roleConfig['inactiveClass'] }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span>Tugas Akhir</span>
                </a>

                <a href="{{ route('guru.nilai.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-150 {{ request()->routeIs('guru.nilai.*') ? $roleConfig['activeClass'] : $roleConfig['inactiveClass'] }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Nilai</span>
                </a>
            @elseif($role === 'siswa')
                <a href="{{ route('siswa.tugas-akhir.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-150 {{ request()->routeIs('siswa.tugas-akhir.*') ? $roleConfig['activeClass'] : $roleConfig['inactiveClass'] }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span>Tugas Akhir Saya</span>
                </a>
            @endif

            {{-- Optional menu slot for role extensions (e.g. Nilai future slot) --}}
            @if(isset($customMenu))
                {{ $customMenu }}
            @endif

            {{-- Divider & Shared Utilities --}}
            <div class="pt-4 border-t border-gray-200 dark:border-gray-800 mt-4 space-y-1">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors duration-150">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Ke Beranda</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-700 dark:text-gray-300 dark:hover:bg-red-950 dark:hover:text-red-400 transition-colors duration-150">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        {{-- User profile footer in sidebar --}}
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-700 dark:text-gray-200 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        @if($role === 'siswa')
                            Siswa {{ auth()->user()->jurusan?->name ?? '' }}
                        @elseif($role === 'guru')
                            Guru {{ auth()->user()->jurusan?->name ?? '' }}
                        @else
                            {{ auth()->user()->getRoleNames()->first() ?? 'Administrator' }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Column --}}
    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

        {{-- Topbar --}}
        <header class="flex items-center justify-between px-4 sm:px-6 py-3.5 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button"
                        class="lg:hidden p-1.5 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        @click="sidebarOpen = !sidebarOpen"
                        aria-label="Buka Navigasi">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="min-w-0">
                    <h1 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate">
                        {{ $title }}
                    </h1>
                    @if($subtitle)
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate hidden sm:block">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <x-mode-switch />
                <div class="hidden sm:block text-xs font-medium text-gray-500 dark:text-gray-400 border-l border-gray-200 dark:border-gray-800 pl-3">
                    {{ now()->translatedFormat('d M Y') }}
                </div>
            </div>
        </header>

        {{-- Flash Notification Alerts --}}
        @if(session('success') || session('error'))
            <div class="px-4 sm:px-6 pt-4 shrink-0">
                @if(session('success'))
                    <div class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-950 dark:border-emerald-800 dark:text-emerald-300 text-sm" role="alert">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-800 dark:bg-red-950 dark:border-red-800 dark:text-red-300 text-sm" role="alert">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Scrollable Page Body --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 animate-dash-fade-in"
              @animationend.once="$el.classList.remove('animate-dash-fade-in')">
            {{ $slot }}
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
