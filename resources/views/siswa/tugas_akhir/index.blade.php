<x-siswa.layout title="Tugas Akhir Saya">

<x-dashboard.page-header
    title="Tugas Akhir Saya"
    description="Daftar tugas akhir dan riwayat progres untuk jurusan {{ $siswa->jurusan?->name ?? 'SMKN 20' }}." />

{{-- Summary Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <x-dashboard.stat-card title="Total Tugas" :value="$tugasAkhirs->count()" accent="emerald">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Selesai" :value="$tugasAkhirs->where('current_status', 'completed')->count()" accent="emerald">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Dikerjakan" :value="$tugasAkhirs->where('current_status', 'in_progress')->count()" accent="cyan">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Belum Mulai" :value="$tugasAkhirs->where('current_status', 'pending')->count()" accent="amber">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>
</div>

@if($tugasAkhirs->isEmpty())
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
        <x-dashboard.empty-state
            title="Belum ada tugas akhir"
            description="Guru pembimbing jurusan Anda belum menerbitkan tugas akhir." />
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($tugasAkhirs as $ta)
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 hover:border-emerald-400 dark:hover:border-emerald-600 transition-colors flex flex-col overflow-hidden shadow-xs">
            <div class="p-5 flex-1 flex flex-col">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1.5 truncate">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="truncate">{{ $ta->guru->name }}</span>
                    </span>
                    <x-dashboard.badge-status :status="$ta->current_status" />
                </div>

                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 leading-snug">
                    {{ $ta->title }}
                </h3>
                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed flex-1">
                    {{ $ta->description ?? 'Tidak ada instruksi spesifik.' }}
                </p>
            </div>

            <div class="px-5 py-3.5 bg-gray-50/75 dark:bg-gray-800/40 border-t border-gray-200 dark:border-gray-800 flex items-center justify-between gap-3 text-xs">
                <span class="text-gray-500 dark:text-gray-400 truncate">
                    {{ $ta->last_update ? 'Update: ' . \Carbon\Carbon::parse($ta->last_update)->diffForHumans() : 'Belum ada progress' }}
                </span>
                <a href="{{ route('siswa.tugas-akhir.show', $ta) }}"
                   class="font-medium text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 transition-colors inline-flex items-center gap-1 shrink-0">
                    <span>Lihat & Update</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif

</x-siswa.layout>
