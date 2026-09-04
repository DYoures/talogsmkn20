<x-guru.layout title="Tugas Akhir">
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Tugas Akhir</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola Tugas Akhir untuk siswa jurusan {{ $guru->jurusan?->name ?? '' }}</p>
    </div>
    <a href="{{ route('guru.tugas-akhir.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Buat Tugas Baru
    </a>
</div>

@if($tugasAkhirs->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <svg class="w-12 h-12 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
        <p class="text-gray-400 text-sm">Belum ada tugas akhir yang Anda buat.</p>
    </div>
@else
    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800 text-left">
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Judul Tugas</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Log Progress Siswa</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Dibuat Pada</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($tugasAkhirs as $ta)
                <tr class="hover:bg-gray-800/50 transition-colors" x-data="{ confirmDelete: false }">
                    <td class="px-5 py-4">
                        <p class="font-medium text-white mb-0.5">{{ $ta->title }}</p>
                        <p class="text-xs text-gray-400 max-w-sm truncate">{{ $ta->description }}</p>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-cyan-500/10 text-cyan-400">
                            {{ $ta->progress_logs_count }} Update
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-400">
                        {{ $ta->created_at->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('guru.tugas-akhir.show', $ta) }}"
                               class="px-3 py-1.5 text-xs rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 hover:text-indigo-300 transition-colors">
                                Lihat Progress
                            </a>
                            <a href="{{ route('guru.tugas-akhir.edit', $ta) }}"
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
                                        <h3 class="font-semibold text-white">Hapus Tugas Akhir?</h3>
                                        <p class="text-sm text-gray-400 mt-1">
                                            Menghapus tugas <strong class="text-gray-200">{{ $ta->title }}</strong> akan
                                            <span class="text-red-400 font-medium">menghapus semua riwayat progress siswa</span> yang terkait dengan tugas ini.
                                        </p>
                                        <p class="text-xs text-gray-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end gap-3 mt-5">
                                    <button @click="confirmDelete = false"
                                            class="px-4 py-2 text-sm rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 transition-colors">
                                        Batal
                                    </button>
                                    <form method="POST" action="{{ route('guru.tugas-akhir.destroy', $ta) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-500 text-white font-medium transition-colors">
                                            Ya, Hapus
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
</x-guru.layout>
