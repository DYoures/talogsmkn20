<x-admin.layout title="Rekapitulasi Nilai per Jurusan">

<x-dashboard.page-header title="Sistem Nilai Tugas Akhir" description="Pantau, kelola, dan ekspor nilai seluruh tugas akhir siswa yang dikelompokkan per jurusan.">
</x-dashboard.page-header>

@php
    $totalJurusan = $jurusans->count();
    $totalSemuaTugas = $jurusans->sum(fn($j) => $j->tugasAkhirs->count());
    $semuaNilaiAdmin = $jurusans->flatMap->tugasAkhirs->flatMap->nilaiTugas->whereNotNull('nilai');
    $overallRataRata = $semuaNilaiAdmin->count() > 0 ? round($semuaNilaiAdmin->avg('nilai'), 1) : '-';
@endphp

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <x-dashboard.stat-card title="Total Jurusan" :value="$totalJurusan" accent="indigo" description="Jurusan terdaftar">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Total Tugas Akhir" :value="$totalSemuaTugas" accent="cyan" description="Seluruh jurusan">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>

    <x-dashboard.stat-card title="Rata-rata Sekolah" :value="$overallRataRata" accent="emerald" description="Rerata seluruh tugas">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </x-slot:icon>
    </x-dashboard.stat-card>
</div>

{{-- Grouped per Jurusan --}}
<div class="space-y-8">
    @forelse($jurusans as $jurusan)
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-xs">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50/75 dark:bg-gray-800/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                    <h2 class="font-bold text-gray-900 dark:text-white text-base">{{ $jurusan->name }}</h2>
                    <span class="text-xs px-2 py-0.5 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                        {{ $jurusan->code ?? 'JURUSAN' }}
                    </span>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $jurusan->tugasAkhirs->count() }} Tugas Diterbitkan
                </div>
            </div>

            @if($jurusan->tugasAkhirs->isEmpty())
                <div class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada tugas akhir pada jurusan ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="border-b border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                            <tr>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Judul Tugas</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Guru</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Progres</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Nilai Masuk</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Rata-rata</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @foreach($jurusan->tugasAkhirs as $ta)
                            @php
                                $belumDinilai = $ta->total_siswa - $ta->dinilai_count;
                                $exportUrl = route('admin.tugas-akhir.export-nilai', $ta);
                            @endphp
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors"
                                x-data="{ showConfirmModal: false }">
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $ta->title }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-xs text-gray-600 dark:text-gray-400">
                                    {{ $ta->guru?->name ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                        {{ $ta->selesai_count }} / {{ $ta->total_siswa }} Selesai
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($ta->dinilai_count === $ta->total_siswa && $ta->total_siswa > 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                                            Lengkap ({{ $ta->dinilai_count }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                                            {{ $ta->dinilai_count }} / {{ $ta->total_siswa }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ $ta->rata_rata ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.tugas-akhir.nilai', $ta) }}"
                                           class="px-3 py-1 text-xs font-medium rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white transition-colors duration-150">
                                            Kelola Nilai
                                        </a>

                                        <button type="button"
                                                @click="if ({{ $belumDinilai }} > 0) { showConfirmModal = true; } else { window.location.href = '{{ $exportUrl }}'; }"
                                                class="px-3 py-1 text-xs font-medium rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 transition-colors duration-150 flex items-center gap-1">
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
                                                   class="px-4 py-2 text-sm rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-medium transition-colors">
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
            @endif
        </div>
    @empty
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
            <x-dashboard.empty-state title="Belum Ada Jurusan" description="Tambahkan jurusan terlebih dahulu di halaman manajemen jurusan." />
        </div>
    @endforelse
</div>

</x-admin.layout>
