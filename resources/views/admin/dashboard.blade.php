<x-admin.layout title="Dashboard">
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

    {{-- Stat: Jurusan --}}
    <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-400">Total Jurusan</p>
            <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['jurusan'] }}</p>
        <a href="{{ route('admin.jurusan.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 mt-1 inline-block">Kelola →</a>
    </div>

    {{-- Stat: Total User --}}
    <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-400">Total Pengguna</p>
            <div class="w-9 h-9 rounded-lg bg-violet-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['users'] }}</p>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-violet-400 hover:text-violet-300 mt-1 inline-block">Kelola →</a>
    </div>

    {{-- Stat: Guru --}}
    <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-400">Guru</p>
            <div class="w-9 h-9 rounded-lg bg-cyan-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['guru'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Pengguna aktif</p>
    </div>

    {{-- Stat: Siswa --}}
    <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-400">Siswa</p>
            <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['siswa'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Terdaftar</p>
    </div>
</div>

{{-- Quick links --}}
<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
        <h3 class="text-sm font-semibold text-gray-300 mb-3">Aksi Cepat</h3>
        <div class="space-y-2">
            <a href="{{ route('admin.jurusan.create') }}"
               class="flex items-center gap-2 text-sm text-indigo-400 hover:text-indigo-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Jurusan Baru
            </a>
            <a href="{{ route('admin.users.create') }}"
               class="flex items-center gap-2 text-sm text-violet-400 hover:text-violet-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah User Baru
            </a>
        </div>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
        <h3 class="text-sm font-semibold text-gray-300 mb-3">Info Sistem</h3>
        <div class="space-y-1 text-sm text-gray-400">
            <p>Laravel <span class="text-gray-200">v{{ app()->version() }}</span></p>
            <p>PHP <span class="text-gray-200">{{ PHP_VERSION }}</span></p>
            <p>Database <span class="text-emerald-400">Terhubung</span></p>
        </div>
    </div>
</div>
</x-admin.layout>
