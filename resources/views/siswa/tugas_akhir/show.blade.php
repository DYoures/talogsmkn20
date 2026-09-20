<x-siswa.layout title="Update Progress Tugas Akhir">

<x-dashboard.page-header
    :title="$tugasAkhir->title"
    :back-url="route('siswa.tugas-akhir.index')"
    description="Kirim catatan progres baru dan pantau riwayat perkembangan tugas akhir Anda.">
</x-dashboard.page-header>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Kolom Kiri: Detail Tugas & Form Update --}}
    <div class="space-y-6">
        {{-- Info Tugas --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 shadow-xs">
            <div class="flex items-center gap-2 mb-3 text-xs text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Guru Pembimbing: <strong class="text-gray-800 dark:text-gray-200 font-semibold">{{ $tugasAkhir->guru->name }}</strong></span>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Instruksi Tugas</h3>
            <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">@linkify($tugasAkhir->description ?? 'Tidak ada deskripsi spesifik.')</div>

            @if($tugasAkhir->file_path)
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Lampiran Berkas dari Guru</p>
                <a href="{{ $tugasAkhir->fileUrl() }}" target="_blank"
                   class="flex items-center gap-2 px-3 py-2 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800/80 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="truncate flex-1">{{ $tugasAkhir->file_original_name }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 shrink-0">({{ $tugasAkhir->humanFileSize() }})</span>
                </a>
            </div>
            @endif
        </div>

        {{-- Form Update Progress --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 sm:p-6 shadow-xs">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Update Progress Baru</h3>
            <form method="POST" action="{{ route('siswa.progress.store', $tugasAkhir) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status Pengerjaan <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                            <option value="in_progress">Dalam Proses Pengerjaan</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan Progress</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="w-full px-4 py-2.5 bg-white dark:bg-gray-800 border {{ $errors->has('notes') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }} rounded-lg text-gray-900 dark:text-white text-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-emerald-500 transition-colors resize-none"
                                  placeholder="Contoh: Menyelesaikan desain UI dan integrasi database..."></textarea>
                        @error('notes')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div x-data="{ fileName: '', previewUrl: '' }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Foto Bukti Progress</label>
                        <div class="relative">
                            <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg" class="hidden"
                                   @change="fileName = $event.target.files[0]?.name; 
                                            const reader = new FileReader();
                                            reader.onload = (e) => { previewUrl = e.target.result };
                                            if($event.target.files[0]) reader.readAsDataURL($event.target.files[0]);
                                            else previewUrl = '';">
                            <label for="photo" class="flex flex-col items-center justify-center w-full h-28 px-4 transition bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg appearance-none cursor-pointer hover:border-emerald-500 focus:outline-none"
                                   x-show="!previewUrl">
                                <span class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-500 dark:text-gray-400 text-xs sm:text-sm" x-text="fileName || 'Klik untuk upload foto bukti (Maks 5MB)'"></span>
                                </span>
                            </label>
                            
                            <div x-show="previewUrl" class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 w-full h-44 bg-gray-50 dark:bg-gray-800">
                                <img :src="previewUrl" class="w-full h-full object-contain">
                                <button type="button" @click="previewUrl = ''; fileName = ''; document.getElementById('photo').value = ''" 
                                        class="absolute top-2 right-2 p-1.5 bg-gray-900/80 text-white rounded-md hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('photo')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div x-data="{ files: [], dragging: false,
                                    addFiles(fileList) {
                                         const list = Array.from(fileList);
                                         const dt = new DataTransfer();
                                         this.files = this.files.concat(list);
                                         this.files.forEach(f => dt.items.add(f));
                                         $refs.filesInput.files = dt.files;
                                    },
                                    removeFile(index) {
                                         this.files.splice(index, 1);
                                         const dt = new DataTransfer();
                                         this.files.forEach(f => dt.items.add(f));
                                         $refs.filesInput.files = dt.files;
                                    } }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">File Lampiran (opsional, maks 100MB/file)</label>
                        <div class="relative">
                            <input type="file" id="files" name="files[]" multiple class="hidden" x-ref="filesInput"
                                   accept=".pdf,.zip,.rar,.7z,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.webp"
                                   @change="addFiles($event.target.files)">
                            <label for="files"
                                   class="flex flex-col items-center justify-center w-full h-24 px-4 transition bg-gray-50 dark:bg-gray-800 border-2 rounded-lg appearance-none cursor-pointer focus:outline-none"
                                   :class="dragging ? 'border-emerald-500 bg-emerald-50/50 dark:bg-gray-800/70' : 'border-gray-300 dark:border-gray-700 border-dashed hover:border-emerald-500'"
                                   @dragover.prevent="dragging = true"
                                   @dragleave.prevent="dragging = false"
                                   @drop.prevent="dragging = false; addFiles($event.dataTransfer.files)">
                                <span class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Klik atau drag berkas dokumen / ZIP ke sini</span>
                                </span>
                            </label>
                        </div>
                        <ul class="mt-2 space-y-1" x-show="files.length > 0">
                            <template x-for="(file, index) in files" :key="file.name + file.size">
                                <li class="flex items-center justify-between gap-2 px-3 py-1.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md text-xs text-gray-700 dark:text-gray-300">
                                    <span class="truncate" x-text="file.name"></span>
                                    <button type="button" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 shrink-0 font-medium" @click="removeFile(index)">Hapus</button>
                                </li>
                            </template>
                        </ul>
                        @error('files')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        @error('files.*')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-gray-200 dark:border-gray-800">
                    <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 rounded-lg shadow-xs text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 focus:outline-none transition-colors">
                        Kirim Progress
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Kolom Kanan: Riwayat Progress --}}
    <div>
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden h-full flex flex-col shadow-xs">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50/75 dark:bg-gray-800/40 shrink-0 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Riwayat Progress Saya</h3>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $logs->count() }} Entri</span>
            </div>

            <div class="p-5 overflow-y-auto flex-1 max-h-[750px]">
                @if($logs->isEmpty())
                    <x-dashboard.empty-state
                        title="Belum ada riwayat progress"
                        description="Kirimkan update progres pertama Anda menggunakan formulir di sebelah kiri." />
                @else
                    <div class="space-y-4">
                        @foreach($logs as $index => $log)
                        <div class="p-4 rounded-xl bg-gray-50/80 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-800 hover:border-gray-300 dark:hover:border-gray-700 transition-colors">
                            <div class="flex items-center justify-between gap-3 mb-2.5">
                                <x-dashboard.badge-status :status="$log->status" />
                                <time class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                </time>
                            </div>

                            @if($log->notes)
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-3 whitespace-pre-wrap leading-relaxed">@linkify($log->notes)</p>
                            @endif

                            @if($log->photo_path)
                                <div class="mt-2.5">
                                    <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank"
                                       class="inline-block rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-emerald-500 transition-colors max-w-sm">
                                        <img src="{{ asset('storage/' . $log->photo_path) }}" class="w-full h-auto max-h-48 object-cover" alt="Foto Progres">
                                    </a>
                                </div>
                            @endif

                            @if($log->files->isNotEmpty())
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($log->files as $file)
                                    <a href="{{ $file->url() }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-md text-xs text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 transition-colors">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="truncate max-w-[12rem]">{{ $file->original_name }}</span>
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
</div>

</x-siswa.layout>
