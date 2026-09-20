<x-guru.layout title="Penilaian: {{ $tugasAkhir->title }}">

<div x-data="penilaianTable({
    items: {{ Js::from($items) }},
    tugasId: {{ $tugasAkhir->id }},
    updateUrlPattern: '{{ route('guru.nilai.update', ':id') }}',
    exportUrl: '{{ route('guru.tugas-akhir.export-nilai', $tugasAkhir) }}',
    csrfToken: '{{ csrf_token() }}'
})" class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('guru.nilai.index') }}"
                   class="inline-flex items-center gap-1 text-xs font-medium text-gray-500 dark:text-gray-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali ke Rekap Nilai</span>
                </a>
            </div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $tugasAkhir->title }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                Jurusan: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $tugasAkhir->jurusan?->name ?? 'SMKN 20' }}</span>
                &bull; Guru: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $tugasAkhir->guru?->name ?? '-' }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('guru.tugas-akhir.show', $tugasAkhir) }}"
               class="px-3.5 py-2 text-xs font-medium rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 transition-colors">
                Detail Tugas
            </a>
            <button type="button"
                    @click="triggerExport()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-medium rounded-lg shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Unduh Excel</span>
            </button>
        </div>
    </div>

    {{-- Summary Bar --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 p-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-xs">
        <div class="border-r border-gray-200 dark:border-gray-800 last:border-0 pr-3">
            <span class="text-xs text-gray-500 dark:text-gray-400 block">Total Siswa</span>
            <span class="text-lg font-bold text-gray-900 dark:text-white" x-text="items.length"></span>
        </div>
        <div class="border-r border-gray-200 dark:border-gray-800 last:border-0 pr-3">
            <span class="text-xs text-gray-500 dark:text-gray-400 block">Progres Selesai</span>
            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400" x-text="selesaiCount"></span>
        </div>
        <div class="border-r border-gray-200 dark:border-gray-800 last:border-0 pr-3">
            <span class="text-xs text-gray-500 dark:text-gray-400 block">Sudah Dinilai</span>
            <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400" x-text="dinilaiCount"></span>
        </div>
        <div class="border-r border-gray-200 dark:border-gray-800 last:border-0 pr-3">
            <span class="text-xs text-gray-500 dark:text-gray-400 block">Belum Dinilai</span>
            <span class="text-lg font-bold text-amber-600 dark:text-amber-400" x-text="belumDinilaiCount"></span>
        </div>
        <div>
            <span class="text-xs text-gray-500 dark:text-gray-400 block">Rata-rata Nilai</span>
            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400" x-text="averageScore"></span>
        </div>
    </div>

    {{-- Table of Students --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/60">
                    <tr>
                        <th class="w-12 px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">No</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Status Progres</th>
                        <th class="w-36 px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Nilai (1-100)</th>
                        <th class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Catatan Evaluasi</th>
                        <th class="w-28 px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    <template x-for="(item, index) in items" :key="item.id">
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-4 py-3 text-center text-xs text-gray-500 dark:text-gray-400" x-text="index + 1"></td>
                            <td class="px-5 py-3">
                                <div class="font-medium text-gray-900 dark:text-white" x-text="item.nama"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400" x-text="item.email"></div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <template x-if="item.is_completed">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                        Selesai
                                    </span>
                                </template>
                                <template x-if="!item.is_completed && item.status === 'in_progress'">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                                        Sedang Dikerjakan
                                    </span>
                                </template>
                                <template x-if="!item.is_completed && item.status !== 'in_progress'">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                                        Belum Mulai
                                    </span>
                                </template>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <template x-if="item.is_completed">
                                    <input type="number"
                                           min="1"
                                           max="100"
                                           x-model.number="item.nilai"
                                           @blur="saveItem(item, 'nilai')"
                                           @keydown.enter.prevent="$event.target.blur()"
                                           placeholder="1-100"
                                           class="w-24 text-center px-2.5 py-1.5 text-sm font-semibold rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500" />
                                </template>
                                <template x-if="!item.is_completed">
                                    <div class="flex flex-col items-center">
                                        <input type="text"
                                               disabled
                                               value="-"
                                               class="w-24 text-center px-2.5 py-1.5 text-sm font-semibold rounded-lg border border-dashed border-gray-200 dark:border-gray-800 bg-gray-100 dark:bg-gray-800/50 text-gray-400 dark:text-gray-500 cursor-not-allowed" />
                                        <span class="text-[10px] text-amber-700 dark:text-amber-300 mt-1 leading-tight">Menunggu siswa menyelesaikan</span>
                                    </div>
                                </template>
                            </td>
                            <td class="px-4 py-3">
                                <input type="text"
                                       x-model="item.catatan"
                                       @blur="saveItem(item, 'catatan')"
                                       @keydown.enter.prevent="$event.target.blur()"
                                       placeholder="Tambahkan catatan jika diperlukan..."
                                       class="w-full px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500" />
                            </td>
                            <td class="px-4 py-3 text-center text-xs">
                                <span x-show="item.saving" class="text-gray-500 dark:text-gray-400">Menyimpan...</span>
                                <span x-show="item.saved" class="text-emerald-600 dark:text-emerald-400 font-medium">Tersimpan</span>
                                <span x-show="item.error" class="text-red-600 dark:text-red-400" x-text="item.error"></span>
                                <span x-show="!item.saving && !item.saved && !item.error && item.dinilai_at"
                                      class="text-[10px] text-gray-400 dark:text-gray-500"
                                      x-text="item.dinilai_at"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Export Confirmation Modal --}}
    <div x-show="showExportConfirm" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs"
         @keydown.escape.window="showExportConfirm = false">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 w-full max-w-md mx-4 shadow-xl text-left"
             @click.outside="showExportConfirm = false">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Masih Ada Siswa Belum Dinilai</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Terdapat <strong class="text-gray-900 dark:text-white" x-text="belumDinilaiCount + ' siswa'"></strong> yang belum memiliki nilai pada tugas ini. Apakah Anda tetap ingin mengunduh file rekap Excel sekarang?
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6">
                <button @click="showExportConfirm = false"
                        type="button"
                        class="px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 transition-colors">
                    Batal
                </button>
                <button @click="confirmExport()"
                        type="button"
                        class="px-4 py-2 text-sm rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white font-medium transition-colors">
                    Lanjutkan Unduh
                </button>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('penilaianTable', (config) => ({
        items: config.items.map(item => ({
            ...item,
            saving: false,
            saved: false,
            error: null,
            _lastNilai: item.nilai,
            _lastCatatan: item.catatan
        })),
        tugasId: config.tugasId,
        updateUrlPattern: config.updateUrlPattern,
        exportUrl: config.exportUrl,
        csrfToken: config.csrfToken,
        showExportConfirm: false,

        get selesaiCount() {
            return this.items.filter(i => i.is_completed).length;
        },

        get dinilaiCount() {
            return this.items.filter(i => i.nilai !== null && i.nilai !== '').length;
        },

        get belumDinilaiCount() {
            return this.items.filter(i => i.nilai === null || i.nilai === '').length;
        },

        get averageScore() {
            const graded = this.items.filter(i => i.nilai !== null && i.nilai !== '');
            if (graded.length === 0) return '-';
            const sum = graded.reduce((acc, curr) => acc + Number(curr.nilai), 0);
            return (sum / graded.length).toFixed(1);
        },

        triggerExport() {
            if (this.belumDinilaiCount > 0) {
                this.showExportConfirm = true;
            } else {
                window.location.href = this.exportUrl;
            }
        },

        confirmExport() {
            this.showExportConfirm = false;
            window.location.href = this.exportUrl;
        },

        saveItem(item, field) {
            // Cek jika tidak ada perubahan
            if (field === 'nilai' && item.nilai === item._lastNilai) return;
            if (field === 'catatan' && item.catatan === item._lastCatatan) return;

            // Validasi client-side
            if (field === 'nilai') {
                if (!item.is_completed && item.nilai !== null && item.nilai !== '') {
                    item.error = 'Siswa belum selesai';
                    item.nilai = item._lastNilai;
                    return;
                }

                if (item.nilai !== null && item.nilai !== '') {
                    const num = parseInt(item.nilai);
                    if (isNaN(num) || num < 1 || num > 100) {
                        item.error = 'Harus 1-100';
                        return;
                    }
                    item.nilai = num;
                } else {
                    item.nilai = null;
                }
            }

            item.saving = true;
            item.saved = false;
            item.error = null;

            const url = this.updateUrlPattern.replace(':id', item.id);

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    nilai: item.nilai,
                    catatan: item.catatan
                })
            })
            .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, data })))
            .then(result => {
                item.saving = false;
                if (result.ok && result.data.success) {
                    item.saved = true;
                    item._lastNilai = item.nilai;
                    item._lastCatatan = item.catatan;
                    if (result.data.data && result.data.data.dinilai_at) {
                        item.dinilai_at = result.data.data.dinilai_at;
                    }
                    setTimeout(() => { item.saved = false; }, 2000);
                } else {
                    item.error = (result.data && result.data.message) ? result.data.message : 'Gagal menyimpan';
                }
            })
            .catch(err => {
                item.saving = false;
                item.error = 'Gagal terhubung ke server';
            });
        }
    }));
});
</script>

</x-guru.layout>
