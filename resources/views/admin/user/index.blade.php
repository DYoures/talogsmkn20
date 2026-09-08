<x-admin.layout title="Manajemen User">
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Pengguna</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola akun Guru, Siswa, dan Admin di sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah User
    </a>
</div>

@if($users->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <svg class="w-12 h-12 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
        <p class="text-gray-400 text-sm">Belum ada user terdaftar.</p>
    </div>
@else
    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800 text-left">
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Role</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Jurusan</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($users as $user)
                @php $role = $user->getRoleNames()->first() ?? '—'; @endphp
                <tr class="hover:bg-gray-800/50 transition-colors" x-data="{ confirmDelete: false }">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 text-xs font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-400">{{ $user->email }}</td>
                    <td class="px-5 py-3.5">
                        @php
                            $roleColors = [
                                'Admin'       => 'bg-indigo-500/10 text-indigo-400',
                                'Guru'        => 'bg-cyan-500/10 text-cyan-400',
                                'Siswa'       => 'bg-emerald-500/10 text-emerald-400',
                            ];
                            $roleColor = $roleColors[$role] ?? 'bg-gray-500/10 text-gray-400';
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleColor }}">{{ $role }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-400">{{ $user->jurusan?->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-right">
                        @if($user->email !== 'admin@talogsmkn20.local' && $user->id !== auth()->id())
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="px-3 py-1.5 text-xs rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-300 hover:text-white transition-colors">
                                Edit
                            </a>
                            <button @click="confirmDelete = true"
                                    class="px-3 py-1.5 text-xs rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 transition-colors">
                                Hapus
                            </button>
                        </div>
                        @else
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="px-3 py-1.5 text-xs rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-300 hover:text-white transition-colors">
                                Edit
                            </a>
                            <span class="text-xs text-amber-500/80 italic">Utama</span>
                        </div>
                        @endif

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
                                        <h3 class="font-semibold text-white">Hapus User?</h3>
                                        <p class="text-sm text-gray-400 mt-1">
                                            Anda akan menghapus akun <strong class="text-gray-200">{{ $user->name }}</strong> ({{ $role }}).
                                        </p>
                                        @if($role === 'Guru')
                                        <p class="text-xs text-red-300 mt-2">⚠️ Semua Tugas Akhir yang dibuat oleh guru ini dan log progress siswa terkait akan ikut terhapus permanen.</p>
                                        @elseif($role === 'Siswa')
                                        <p class="text-xs text-red-300 mt-2">⚠️ Seluruh riwayat log progress siswa ini akan ikut terhapus permanen.</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end gap-3 mt-5">
                                    <button @click="confirmDelete = false"
                                            class="px-4 py-2 text-sm rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 transition-colors">
                                        Batal
                                    </button>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
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
</x-admin.layout>
