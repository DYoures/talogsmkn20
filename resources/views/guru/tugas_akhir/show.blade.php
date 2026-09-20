<x-guru.layout title="Detail Tugas Akhir">

<x-dashboard.page-header
    :title="$tugasAkhir->title"
    :back-url="route('guru.tugas-akhir.index')"
    description="Detail penugasan dan riwayat seluruh progres yang dikumpulkan siswa.">
    <x-slot:actions>
        <a href="{{ route('guru.tugas-akhir.nilai', $tugasAkhir) }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-xs sm:text-sm font-medium rounded-lg shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Input Nilai</span>
        </a>
        <a href="{{ route('guru.tugas-akhir.export-nilai', $tugasAkhir) }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 dark:hover:text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Excel</span>
        </a>
        <a href="{{ route('guru.tugas-akhir.edit', $tugasAkhir) }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 dark:hover:text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>Edit Tugas</span>
        </a>
    </x-slot:actions>
</x-dashboard.page-header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom Kiri: Detail Tugas --}}
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 shadow-xs">
            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Deskripsi & Instruksi</h3>
            <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">@linkify($tugasAkhir->description ?? 'Tidak ada instruksi spesifik.')</div>

            @if($tugasAkhir->file_path)
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Lampiran Panduan</p>
                <a href="{{ $tugasAkhir->fileUrl() }}" target="_blank"
                   class="flex items-center gap-2 px-3 py-2 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800/80 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="truncate flex-1">{{ $tugasAkhir->file_original_name }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 shrink-0">({{ $tugasAkhir->humanFileSize() }})</span>
                </a>
            </div>
            @endif

            <dl class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800 space-y-2 text-xs">
                <div class="flex items-center justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Dibuat Pada</dt>
                    <dd class="font-medium text-gray-800 dark:text-gray-200">{{ $tugasAkhir->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-gray-500 dark:text-gray-400">Total Progres</dt>
                    <dd class="font-medium text-cyan-700 dark:text-cyan-400">{{ $logs->count() }} pembaruan</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Kolom Kanan: Log Progress Siswa --}}
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50/75 dark:bg-gray-800/40 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Log Progress Siswa</h3>
                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ $logs->count() }} Catatan</span>
            </div>

            @if($logs->isEmpty())
                <x-dashboard.empty-state
                    title="Belum ada progres siswa"
                    description="Belum ada siswa yang mengumpulkan catatan progres untuk tugas ini." />
            @else
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($logs as $log)
                    <div class="p-5 hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition-colors">
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-cyan-50 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($log->siswa->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $log->siswa->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div>
                                <x-dashboard.badge-status :status="$log->status" />
                            </div>
                        </div>

                        @if($log->notes)
                        <div class="bg-gray-50 dark:bg-gray-800/60 border border-gray-200 dark:border-gray-700/60 rounded-lg p-3 text-sm text-gray-700 dark:text-gray-300 mb-3 leading-relaxed">
                            @linkify($log->notes)
                        </div>
                        @endif

                        @if($log->photo_path)
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank"
                               class="inline-block rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-cyan-500 transition-colors max-w-sm">
                                <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Foto Progress" class="w-full h-auto max-h-48 object-cover">
                            </a>
                        </div>
                        @endif

                        @if($log->files->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($log->files as $file)
                            <a href="{{ $file->url() }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-md text-xs text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 transition-colors">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="truncate max-w-[12rem]">{{ $file->original_name }}</span>
                                <span class="text-gray-500 dark:text-gray-400">({{ $file->humanSize() }})</span>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

</x-guru.layout>
