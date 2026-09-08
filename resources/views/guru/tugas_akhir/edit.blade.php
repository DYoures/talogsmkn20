<x-guru.layout title="Edit Tugas Akhir">
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('guru.tugas-akhir.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-white">Edit Tugas Akhir</h2>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
        <form method="POST" action="{{ route('guru.tugas-akhir.update', $tugasAkhir) }}">
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
