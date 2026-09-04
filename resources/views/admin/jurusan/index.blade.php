<x-admin.layout title="Manajemen Jurusan">
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Jurusan</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola daftar jurusan yang tersedia di SMKN 20</p>
    </div>
    <a href="{{ route('admin.jurusan.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Jurusan
    </a>
</div>

@if($jurusans->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <svg class="w-12 h-12 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
        <p class="text-gray-400 text-sm">Belum ada jurusan. Tambahkan jurusan pertama.</p>
    </div>
@else
    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800 text-left">
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Jurusan</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">User</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Tugas Akhir</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($jurusans as $jurusan)
                <tr class="hover:bg-gray-800/50 transition-colors" x-data="{ confirmDelete: false }">
                    <td class="px-5 py-3.5 font-medium text-white">{{ $jurusan->name }}</td>
                    <td class="px-5 py-3.5 text-gray-400 max-w-xs truncate">{{ $jurusan->description ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs bg-violet-500/10 text-violet-400">{{ $jurusan->users_count }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs bg-cyan-500/10 text-cyan-400">{{ $jurusan->tugas_akhirs_count }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.jurusan.edit', $jurusan) }}"
                               class="px-3 py-1.5 text-xs rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-300 hover:text-white transition-colors">
                                Edit
                            </a>
                            <button @click="confirmDelete = true"
                                    class="px-3 py-1.5 text-xs rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 transition-colors">
                                Hapus
                            </button>
                        </div>

                        {{-- Delete Confirmation Modal --}}
                        <div x-show="confirmDelete" x-cloak
                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
                             @keydown.escape.window="confirmDelete = false">
                            <div class="bg-gray-900 border border-red-500/30 rounded-xl p-6 w-full max-w-md mx-4 shadow-2xl"
                                 @click.outside="confirmDelete = false">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <h3 class="font-semibold text-white">Hapus Jurusan?</h3>
                                        <p class="text-sm text-gray-400 mt-1">
                                            Menghapus jurusan <strong class="text-gray-200">{{ $jurusan->name }}</strong> akan
                                            <span class="text-red-400 font-medium">menghapus semua data terkait</span> secara permanen, termasuk:
                                        </p>
                                        <ul class="mt-2 text-xs text-red-300 space-y-0.5 list-disc list-inside">
                                            <li>{{ $jurusan->tugas_akhirs_count }} Tugas Akhir</li>
                                            <li>Seluruh log progress dari siswa di jurusan ini</li>
                                            <li>Relasi jurusan pada {{ $jurusan->users_count }} user</li>
                                        </ul>
                                        <p class="text-xs text-gray-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end gap-3 mt-5">
                                    <button @click="confirmDelete = false"
                                            class="px-4 py-2 text-sm rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 transition-colors">
                                        Batal
                                    </button>
                                    <form method="POST" action="{{ route('admin.jurusan.destroy', $jurusan) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-500 text-white font-medium transition-colors">
                                            Ya, Hapus Permanen
                                        </button>
                                    </form>
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
</x-admin.layout>
