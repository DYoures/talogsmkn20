<x-admin.layout title="Edit Jurusan">
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.jurusan.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-white">Edit Jurusan</h2>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
        <form method="POST" action="{{ route('admin.jurusan.update', $jurusan) }}">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Nama Jurusan <span class="text-red-400">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $jurusan->name) }}"
                           class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors resize-none">{{ old('description', $jurusan->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-800">
                <button type="submit"
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
                    Perbarui Jurusan
                </button>
                <a href="{{ route('admin.jurusan.index') }}"
                   class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</x-admin.layout>
