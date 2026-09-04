<x-guru.layout title="Detail Tugas Akhir">
<div>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('guru.tugas-akhir.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-white">{{ $tugasAkhir->title }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Tugas --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
                <h3 class="text-sm font-semibold text-gray-300 mb-3">Deskripsi Tugas</h3>
                <div class="text-sm text-gray-400 whitespace-pre-wrap leading-relaxed">{{ $tugasAkhir->description ?? 'Tidak ada deskripsi.' }}</div>
                
                <div class="mt-5 pt-4 border-t border-gray-800">
                    <p class="text-xs text-gray-500">Dibuat pada: {{ $tugasAkhir->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Logs: {{ $logs->count() }} pembaruan</p>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Log Progress Siswa --}}
        <div class="lg:col-span-2">
            <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-800">
                    <h3 class="text-sm font-semibold text-white">Log Progress Siswa</h3>
                </div>

                @if($logs->isEmpty())
                    <div class="p-10 text-center">
                        <p class="text-gray-400 text-sm">Belum ada siswa yang mengumpulkan progres.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-800">
                        @foreach($logs as $log)
                        <div class="p-5 hover:bg-gray-800/30 transition-colors">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div>
                                    <p class="font-medium text-white text-sm">{{ $log->siswa->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
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
                                        $color = $statusColors[$log->status] ?? $statusColors['pending'];
                                        $label = $statusLabels[$log->status] ?? 'Unknown';
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-md text-xs font-medium {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($log->notes)
                            <div class="bg-gray-800/50 rounded-lg p-3 text-sm text-gray-300 mb-3">
                                {{ $log->notes }}
                            </div>
                            @endif

                            @if($log->photo_path)
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank" class="block w-48 h-32 rounded-lg overflow-hidden border border-gray-700 hover:border-cyan-500 transition-colors">
                                    <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Foto Progress" class="w-full h-full object-cover">
                                </a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-guru.layout>
