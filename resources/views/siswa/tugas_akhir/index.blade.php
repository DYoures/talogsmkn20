<x-siswa.layout title="Tugas Akhir Saya">
<div class="mb-6">
    <h2 class="text-xl font-bold text-white">Tugas Akhir Saya</h2>
    <p class="text-sm text-gray-400 mt-0.5">Daftar tugas akhir untuk jurusan {{ $siswa->jurusan?->name ?? '' }}</p>
</div>

@if($tugasAkhirs->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 bg-gray-900 rounded-xl border border-gray-800 text-center">
        <svg class="w-12 h-12 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
        <p class="text-gray-400 text-sm">Belum ada tugas akhir dari guru jurusan Anda.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($tugasAkhirs as $ta)
        <div class="bg-gray-900 rounded-xl border border-gray-800 hover:border-emerald-500/50 transition-colors flex flex-col overflow-hidden">
            <div class="p-5 flex-1">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-gray-500 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Guru: {{ $ta->guru->name }}
                    </span>
                    @php
                        $statusColors = [
                            'pending' => 'bg-gray-500/10 text-gray-400',
                            'in_progress' => 'bg-amber-500/10 text-amber-400',
                            'completed' => 'bg-green-500/10 text-green-400',
                        ];
                        $statusLabels = [
                            'pending' => 'Belum Mulai',
                            'in_progress' => 'Proses',
                            'completed' => 'Selesai',
                        ];
                        $color = $statusColors[$ta->current_status] ?? $statusColors['pending'];
                        $label = $statusLabels[$ta->current_status] ?? 'Unknown';
                    @endphp
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide {{ $color }}">
                        {{ $label }}
                    </span>
                </div>
                <h3 class="text-lg font-bold text-white mb-2 line-clamp-2">{{ $ta->title }}</h3>
                <p class="text-sm text-gray-400 line-clamp-3">{{ $ta->description }}</p>
            </div>
            <div class="px-5 py-4 bg-gray-800/30 border-t border-gray-800 flex items-center justify-between">
                <span class="text-xs text-gray-500">
                    {{ $ta->last_update ? 'Update: ' . \Carbon\Carbon::parse($ta->last_update)->diffForHumans() : 'Belum ada progress' }}
                </span>
                <a href="{{ route('siswa.tugas-akhir.show', $ta) }}"
                   class="text-sm font-medium text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-1">
                    Lihat & Update <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif
</x-siswa.layout>
