<x-admin.layout title="Dashboard">

<x-dashboard.page-header title="Dashboard Admin" description="Ringkasan data dan aksi cepat untuk pengelolaan TALOG20." />

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    <x-dashboard.stat-card title="Jurusan" :value="$stats['jurusan']" accent="indigo" :href="route('admin.jurusan.index')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Pengguna" :value="$stats['users']" accent="indigo" :href="route('admin.users.index')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Guru" :value="$stats['guru']" accent="cyan" description="Pengguna aktif">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Siswa" :value="$stats['siswa']" accent="emerald" description="Terdaftar">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>
</div>

{{-- Quick Actions + System Info --}}
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-dashboard.card title="Aksi Cepat">
        <div class="space-y-3">
            <a href="{{ route('admin.jurusan.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-800 hover:bg-indigo-50 hover:text-indigo-700 dark:hover:bg-indigo-950/40 dark:hover:text-indigo-300 border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-800 transition-colors duration-150">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jurusan Baru
            </a>
            <a href="{{ route('admin.users.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-800 hover:bg-indigo-50 hover:text-indigo-700 dark:hover:bg-indigo-950/40 dark:hover:text-indigo-300 border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-800 transition-colors duration-150">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User Baru
            </a>
        </div>
    </x-dashboard.card>

    <x-dashboard.card title="Info Sistem">
        <dl class="space-y-2.5 text-sm">
            <div class="flex items-center justify-between">
                <dt class="text-gray-600 dark:text-gray-400">Laravel</dt>
                <dd class="font-medium text-gray-900 dark:text-gray-100">v{{ app()->version() }}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-gray-600 dark:text-gray-400">PHP</dt>
                <dd class="font-medium text-gray-900 dark:text-gray-100">{{ PHP_VERSION }}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-gray-600 dark:text-gray-400">Database</dt>
                <dd class="font-medium text-emerald-700 dark:text-emerald-400">Terhubung</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-gray-600 dark:text-gray-400">Tugas Akhir</dt>
                <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $stats['tugas_akhir'] }}</dd>
            </div>
        </dl>
    </x-dashboard.card>
</div>

</x-admin.layout>
