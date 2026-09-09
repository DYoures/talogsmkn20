<x-guru.layout title="Edit Tugas Akhir">
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('guru.tugas-akhir.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-white">Edit Tugas Akhir</h2>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
        <form method="POST" action="{{ route('guru.tugas-akhir.update', $tugasAkhir) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-1.5">Judul Tugas <span class="text-red-400">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $tugasAkhir->title) }}" required
                           class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-cyan-500 transition-colors">
                    @error('title')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi / Instruksi</label>
                    <textarea id="description" name="description" rows="6"
                              class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-cyan-500 transition-colors resize-none">{{ old('description', $tugasAkhir->description) }}</textarea>
                    @error('description')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div x-data="{ fileName: '', dragging: false, removeExisting: false }">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Lampiran File (opsional, maks 100MB)</label>

                    @if($tugasAkhir->file_path)
                    <div class="flex items-center justify-between gap-3 mb-2 px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg"
                         x-show="!removeExisting">
                        <a href="{{ $tugasAkhir->fileUrl() }}" target="_blank" class="text-sm text-cyan-400 hover:text-cyan-300 truncate">
                            {{ $tugasAkhir->file_original_name }} ({{ $tugasAkhir->humanFileSize() }})
                        </a>
                        <button type="button" @click="removeExisting = true" class="text-xs text-red-400 hover:text-red-300 shrink-0">Hapus</button>
                    </div>
                    <input type="hidden" name="remove_file" :value="removeExisting ? 1 : 0">
                    @endif

                    <div class="relative" x-show="{{ $tugasAkhir->file_path ? '!removeExisting || fileName' : 'true' }}">
                        <input type="file" id="file" name="file" class="hidden" x-ref="fileInput"
                               accept=".pdf,.zip,.rar,.7z,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.webp"
                               @change="fileName = $event.target.files[0]?.name || ''">
                        <label for="file"
                               class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-gray-800 border-2 rounded-lg appearance-none cursor-pointer focus:outline-none"
                               :class="dragging ? 'border-cyan-500 bg-gray-800/70' : 'border-gray-700 border-dashed hover:border-cyan-500'"
                               @dragover.prevent="dragging = true"
                               @dragleave.prevent="dragging = false"
                               @drop.prevent="dragging = false; $refs.fileInput.files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0]?.name || ''">
                            <span class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                <span class="font-medium text-gray-400" x-text="fileName || 'Klik atau drag file baru ke sini untuk mengganti'"></span>
                            </span>
                        </label>
                    </div>
                    @error('file')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-800">
                <button type="submit"
                        class="px-5 py-2.5 bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-medium rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('guru.tugas-akhir.index') }}"
                   class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</x-guru.layout>
