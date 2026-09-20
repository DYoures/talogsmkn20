<x-guru.layout title="Tugas Akhir">

<x-dashboard.page-header title="Tugas Akhir" description="Kelola Tugas Akhir untuk siswa jurusan {{ $guru->jurusan?->name ?? 'SMKN 20' }}.">
    <x-slot:actions>
        <a href="{{ route('guru.tugas-akhir.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-medium rounded-lg shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Buat Tugas Baru</span>
        </a>
    </x-slot:actions>
</x-dashboard.page-header>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <x-dashboard.stat-card title="Total Tugas" :value="$tugasAkhirs->count()" accent="cyan" description="Tugas yang diterbitkan">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Log Progres" :value="$tugasAkhirs->sum('progress_logs_count')" accent="emerald" description="Total respon siswa">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Tugas Aktif" :value="$tugasAkhirs->where('progress_logs_count', '>', 0)->count()" accent="indigo" description="Memiliki update siswa">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>
</div>

@if($tugasAkhirs->isEmpty())
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
        <x-dashboard.empty-state title="Belum ada tugas akhir" description="Mulai dengan membuat tugas akhir pertama untuk siswa jurusan Anda.">
            <x-slot:action>
                <a href="{{ route('guru.tugas-akhir.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-medium rounded-lg transition-colors">
                    Buat Tugas Baru
                </a>
            </x-slot:action>
        </x-dashboard.empty-state>
    </div>
@else
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="border-b border-gray-200 dark:border-gray-800 bg-gray-50/75 dark:bg-gray-800/40">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Judul Tugas</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Log Progress Siswa</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Dibuat Pada</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($tugasAkhirs as $ta)
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition-colors" x-data="{ confirmDelete: false }">
                        <td class="px-5 py-4">
                            <p class="font-medium text-gray-900 dark:text-white mb-0.5">{{ $ta->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm truncate">{{ $ta->description ?? 'Tidak ada deskripsi' }}</p>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-cyan-50 text-cyan-700 border border-cyan-200 dark:bg-cyan-950 dark:text-cyan-300 dark:border-cyan-800">
                                {{ $ta->progress_logs_count }} Update
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400 text-xs">
                            {{ $ta->created_at->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('guru.tugas-akhir.show', $ta) }}"
                                   class="px-3 py-1.5 text-xs rounded-lg bg-cyan-50 hover:bg-cyan-100 text-cyan-700 hover:text-cyan-800 dark:bg-cyan-950 dark:hover:bg-cyan-900 dark:text-cyan-300 transition-colors duration-150 font-medium">
                                    Lihat Progress
                                </a>
                                <a href="{{ route('guru.tugas-akhir.nilai', $ta) }}"
                                   class="px-3 py-1.5 text-xs rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 hover:text-emerald-800 dark:bg-emerald-950 dark:hover:bg-emerald-900 dark:text-emerald-300 transition-colors duration-150 font-medium">
                                    Nilai
                                </a>
                                <a href="{{ route('guru.tugas-akhir.edit', $ta) }}"
                                   class="px-3 py-1.5 text-xs rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 dark:hover:text-white transition-colors duration-150">
                                    Edit
                                </a>
                                <button @click="confirmDelete = true"
                                        type="button"
                                        class="px-3 py-1.5 text-xs rounded-lg bg-red-50 hover:bg-red-100 text-red-700 hover:text-red-800 dark:bg-red-950 dark:hover:bg-red-900 dark:text-red-300 transition-colors duration-150">
                                    Hapus
                                </button>
                            </div>

                            {{-- Delete Confirmation Modal --}}
                            <div x-show="confirmDelete" x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs"
                                 @keydown.escape.window="confirmDelete = false">
                                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 w-full max-w-md mx-4 shadow-xl text-left"
                                     @click.outside="confirmDelete = false">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Hapus Tugas Akhir?</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Menghapus tugas <strong class="text-gray-900 dark:text-white">{{ $ta->title }}</strong> akan
                                                <span class="text-red-700 dark:text-red-300 font-medium">menghapus semua riwayat progress siswa</span> yang terkait dengan tugas ini.
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end gap-3 mt-6">
                                        <button @click="confirmDelete = false"
                                                type="button"
                                                class="px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 transition-colors">
                                            Batal
                                        </button>
                                        <form method="POST" action="{{ route('guru.tugas-akhir.destroy', $ta) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-500 text-white font-medium transition-colors">
                                                Ya, Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

</x-guru.layout>
