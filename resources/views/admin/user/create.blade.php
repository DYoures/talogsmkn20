<x-admin.layout title="Tambah User">
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-white">Tambah User Baru</h2>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="Nama user">
                        @error('name')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="user@talogsmkn20.local">
                        @error('email')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="Min. 8 karakter">
                        @error('password')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1.5">Konfirmasi Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="Ulangi password">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-300 mb-1.5">Role <span class="text-red-400">*</span></label>
                        <select id="role" name="role"
                                class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('role')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jurusan_id" class="block text-sm font-medium text-gray-300 mb-1.5">Jurusan</label>
                        <select id="jurusan_id" name="jurusan_id"
                                class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('jurusan_id') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->name }}
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs text-gray-500">Wajib diisi untuk Guru dan Siswa.</p>
                        @error('jurusan_id')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-800">
                <button type="submit"
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
                    Buat User
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</x-admin.layout>
