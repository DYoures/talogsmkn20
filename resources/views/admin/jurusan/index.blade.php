<x-admin.layout title="Manajemen Jurusan">

<x-dashboard.page-header title="Jurusan" description="Kelola daftar jurusan yang tersedia di SMKN 20.">
    <x-slot:actions>
        <a href="{{ route('admin.jurusan.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-xs transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jurusan
        </a>
    </x-slot:actions>
</x-dashboard.page-header>

@if($jurusans->isEmpty())
    <x-dashboard.empty-state
        title="Belum ada jurusan"
        description="Tambahkan jurusan pertama untuk memulai pengelolaan data SMKN 20.">
        <x-slot:action>
            <a href="{{ route('admin.jurusan.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jurusan
            </a>
        </x-slot:action>
    </x-dashboard.empty-state>
@else
    <x-dashboard.table>
        <x-slot:header>
            <tr>
                <th class="px-5 py-3">Nama Jurusan</th>
                <th class="px-5 py-3">Aksen</th>
                <th class="px-5 py-3">Deskripsi</th>
                <th class="px-5 py-3 text-center">User</th>
                <th class="px-5 py-3 text-center">Tugas Akhir</th>
                <th class="px-5 py-3 text-right">Aksi</th>
            </tr>
        </x-slot:header>

        @foreach($jurusans as $jurusan)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-100" x-data="{ confirmDelete: false }">
            <td class="px-5 py-3.5 font-medium text-gray-900 dark:text-white">
                <div class="flex items-center gap-2.5">
                    <span class="w-3 h-3 rounded-full shrink-0 border border-black/10 dark:border-white/20"
                          style="background-color: {{ $jurusan->accent_color }};"></span>
                    <span>{{ $jurusan->name }}</span>
                    @if($jurusan->kode)
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-gray-100 text-gray-800 border border-gray-300 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700">
                            {{ $jurusan->kode }}
                        </span>
                    @endif
                </div>
            </td>
            <td class="px-5 py-3.5">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-mono bg-gray-100 text-gray-800 border border-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700">
                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $jurusan->accent_color }};"></span>
                    {{ $jurusan->accent_color }}
                </span>
            </td>
            <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400 max-w-xs truncate">{{ $jurusan->description ?? '—' }}</td>
            <td class="px-5 py-3.5 text-center">
                <span class="px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950 dark:text-indigo-300 dark:border-indigo-800">{{ $jurusan->users_count }}</span>
            </td>
            <td class="px-5 py-3.5 text-center">
                <span class="px-2 py-0.5 rounded-md text-xs font-medium bg-cyan-50 text-cyan-700 border border-cyan-200 dark:bg-cyan-950 dark:text-cyan-300 dark:border-cyan-800">{{ $jurusan->tugas_akhirs_count }}</span>
            </td>
            <td class="px-5 py-3.5 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.jurusan.edit', $jurusan) }}"
                        class="px-3 py-1.5 text-xs rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 dark:hover:text-white transition-colors duration-150">
                        Edit
                    </a>
                    <button @click="confirmDelete = true"
                            class="px-3 py-1.5 text-xs rounded-lg bg-red-50 hover:bg-red-100 text-red-700 hover:text-red-800 dark:bg-red-950 dark:hover:bg-red-900 dark:text-red-300 transition-colors duration-150">
                        Hapus
                    </button>
                </div>

                {{-- Delete Confirmation Modal --}}
                <div x-show="confirmDelete" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs"
                     @keydown.escape.window="confirmDelete = false">
                    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-red-800 rounded-xl p-6 w-full max-w-md mx-4 shadow-2xl"
                         @click.outside="confirmDelete = false">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-950 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Hapus Jurusan?</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Menghapus jurusan <strong class="text-gray-900 dark:text-gray-200">{{ $jurusan->name }}</strong> akan
                                    <span class="text-red-700 dark:text-red-400 font-medium">menghapus semua data terkait</span> secara permanen:
                                </p>
                                <ul class="mt-2 text-xs text-red-700 dark:text-red-300 space-y-0.5 list-disc list-inside">
                                    <li>{{ $jurusan->tugas_akhirs_count }} Tugas Akhir</li>
                                    <li>Seluruh log progress siswa di jurusan ini</li>
                                    <li>Relasi jurusan pada {{ $jurusan->users_count }} user</li>
                                </ul>
                                <p class="text-xs text-gray-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-3 mt-5">
                            <button @click="confirmDelete = false"
                                    class="px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 transition-colors duration-100">
                                Batal
                            </button>
                            <form method="POST" action="{{ route('admin.jurusan.destroy', $jurusan) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors duration-100">
                                    Ya, Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </x-dashboard.table>
@endif

</x-admin.layout>
