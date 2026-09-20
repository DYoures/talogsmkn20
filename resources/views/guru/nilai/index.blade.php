<x-guru.layout title="Nilai Tugas Akhir">

<x-dashboard.page-header title="Sistem Nilai Tugas Akhir" description="Input, pantau, dan ekspor nilai tugas akhir siswa jurusan {{ $guru->jurusan?->name ?? 'SMKN 20' }}.">
</x-dashboard.page-header>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
    <x-dashboard.stat-card title="Total Tugas" :value="$tugasAkhirs->count()" accent="cyan" description="Tugas yang dinilai">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Total Siswa" :value="$tugasAkhirs->first()?->total_siswa ?? 0" accent="indigo" description="Siswa dalam jurusan">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Sudah Dinilai" :value="$tugasAkhirs->sum('dinilai_count')" accent="emerald" description="Total nilai masuk">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    @php
        $semuaNilai = $tugasAkhirs->flatMap->nilaiTugas->whereNotNull('nilai');
        $overallAvg = $semuaNilai->count() > 0 ? round($semuaNilai->avg('nilai'), 1) : '-';
    @endphp
    <x-dashboard.stat-card title="Rata-rata Keseluruhan" :value="$overallAvg" accent="amber" description="Rerata nilai siswa">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>
</div>

@if($tugasAkhirs->isEmpty())
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
        <x-dashboard.empty-state title="Belum Ada Tugas Akhir" description="Buat tugas akhir terlebih dahulu untuk mulai menilai siswa.">
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
                <thead class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/60">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Judul Tugas</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Progres Selesai</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Status Nilai</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Rata-rata</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($tugasAkhirs as $ta)
                    @php
                        $belumDinilai = $ta->total_siswa - $ta->dinilai_count;
                        $exportUrl = route('guru.tugas-akhir.export-nilai', $ta);
                    @endphp
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors"
                        x-data="{ showConfirmModal: false }">
                        <td class="px-5 py-4">
                            <div class="font-medium text-gray-900 dark:text-white">{{ $ta->title }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $ta->jurusan?->name ?? 'SMKN 20' }}</div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                {{ $ta->selesai_count }} / {{ $ta->total_siswa }} Selesai
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($ta->dinilai_count === $ta->total_siswa && $ta->total_siswa > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-cyan-50 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-300">
                                    Lengkap ({{ $ta->dinilai_count }}/{{ $ta->total_siswa }})
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                                    {{ $ta->dinilai_count }} / {{ $ta->total_siswa }} Dinilai
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $ta->rata_rata ?? '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('guru.tugas-akhir.nilai', $ta) }}"
                                   class="px-3 py-1.5 text-xs font-medium rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white transition-colors duration-150">
                                    Input Nilai
                                </a>

                                <button type="button"
                                        @click="if ({{ $belumDinilai }} > 0) { showConfirmModal = true; } else { window.location.href = '{{ $exportUrl }}'; }"
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 dark:hover:text-white transition-colors duration-150 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>Excel</span>
                                </button>
                            </div>

                            {{-- Modal Konfirmasi Export Excel --}}
                            <div x-show="showConfirmModal" x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs"
                                 @keydown.escape.window="showConfirmModal = false">
                                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 w-full max-w-md mx-4 shadow-xl text-left"
                                     @click.outside="showConfirmModal = false">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Masih Ada Siswa Belum Dinilai</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Terdapat <strong class="text-gray-900 dark:text-white">{{ $belumDinilai }} siswa</strong> yang belum memiliki nilai pada tugas ini. Apakah Anda tetap ingin mengunduh file rekap Excel sekarang?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end gap-3 mt-6">
                                        <button @click="showConfirmModal = false"
                                                type="button"
                                                class="px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 transition-colors">
                                            Batal
                                        </button>
                                        <a href="{{ $exportUrl }}"
                                           @click="showConfirmModal = false"
                                           class="px-4 py-2 text-sm rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white font-medium transition-colors">
                                            Lanjutkan Unduh
                                        </a>
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
