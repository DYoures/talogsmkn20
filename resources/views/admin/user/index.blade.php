<x-admin.layout title="Manajemen User">

<x-dashboard.page-header title="Pengguna" description="Kelola akun Guru, Siswa, dan Admin di sistem.">
    <x-slot:actions>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah User</span>
        </a>
    </x-slot:actions>
</x-dashboard.page-header>

@if($users->isEmpty())
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
        <x-dashboard.empty-state title="Belum ada user terdaftar" description="Tambahkan user baru untuk memulai pengelolaan hak akses di sistem.">
            <x-slot:action>
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
                    Tambah User
                </a>
            </x-slot:action>
        </x-dashboard.empty-state>
    </div>
@else
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="border-b border-gray-200 dark:border-gray-800 bg-gray-50/75 dark:bg-gray-800/40">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Jurusan</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($users as $user)
                    @php $role = $user->getRoleNames()->first() ?? '—'; @endphp
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition-colors" x-data="{ confirmDelete: false }">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                        <td class="px-5 py-3.5">
                            @php
                                $roleColors = [
                                    'Admin' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800',
                                    'Guru'  => 'bg-cyan-50 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800',
                                    'Siswa' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800',
                                ];
                                $roleColor = $roleColors[$role] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700';
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-md text-xs font-medium {{ $roleColor }}">{{ $role }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400">{{ $user->jurusan?->name ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-right">
                            @if($user->email !== 'admin@talogsmkn20.local' && $user->id !== auth()->id())
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="px-3 py-1.5 text-xs rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 dark:hover:text-white transition-colors duration-150">
                                    Edit
                                </a>
                                <button @click="confirmDelete = true"
                                        class="px-3 py-1.5 text-xs rounded-lg bg-red-50 hover:bg-red-100 text-red-700 hover:text-red-800 dark:bg-red-950 dark:hover:bg-red-900 dark:text-red-300 transition-colors duration-150">
                                    Hapus
                                </button>
                            </div>
                            @else
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="px-3 py-1.5 text-xs rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 dark:hover:text-white transition-colors duration-150">
                                    Edit
                                </a>
                                <span class="text-xs text-amber-700 dark:text-amber-400 font-medium">Utama</span>
                            </div>
                            @endif

                            {{-- Delete Confirmation Modal --}}
                            <div x-show="confirmDelete" x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs"
                                 @keydown.escape.window="confirmDelete = false">
                                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 w-full max-w-md mx-4 shadow-xl text-left"
                                     @click.outside="confirmDelete = false">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Hapus User?</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Anda akan menghapus akun <strong class="text-gray-900 dark:text-white">{{ $user->name }}</strong> ({{ $role }}).
                                            </p>
                                            @if($role === 'Guru')
                                            <p class="text-xs text-red-700 dark:text-red-300 mt-2 font-medium">Semua Tugas Akhir yang dibuat oleh guru ini dan log progress siswa terkait akan ikut terhapus permanen.</p>
                                            @elseif($role === 'Siswa')
                                            <p class="text-xs text-red-700 dark:text-red-300 mt-2 font-medium">Seluruh riwayat log progress siswa ini akan ikut terhapus permanen.</p>
                                            @endif
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end gap-3 mt-6">
                                        <button @click="confirmDelete = false"
                                                type="button"
                                                class="px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 transition-colors">
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
    </div>
@endif

</x-admin.layout>
