<x-siswa.layout title="Update Progress Tugas Akhir">
<div>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('siswa.tugas-akhir.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-white">{{ $tugasAkhir->title }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Kolom Kiri: Detail Tugas & Form --}}
        <div class="space-y-6">
            {{-- Info Tugas --}}
            <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
                <div class="flex items-center gap-2 mb-3 text-xs text-gray-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Guru Pembuat: <span class="font-medium text-gray-300">{{ $tugasAkhir->guru->name }}</span>
                </div>
                <h3 class="text-sm font-semibold text-gray-300 mb-2">Instruksi Tugas:</h3>
                <div class="text-sm text-gray-400 whitespace-pre-wrap leading-relaxed">{{ $tugasAkhir->description ?? 'Tidak ada deskripsi spesifik.' }}</div>
            </div>

            {{-- Form Update Progress --}}
            <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
                <h3 class="text-base font-bold text-white mb-4">Update Progress Baru</h3>
                <form method="POST" action="{{ route('siswa.progress.store', $tugasAkhir) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-300 mb-1.5">Status Saat Ini <span class="text-red-400">*</span></label>
                            <select id="status" name="status" required
                                    class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                                <option value="in_progress">Dalam Proses Pengerjaan</option>
                                <option value="completed">Selesai</option>
                            </select>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-300 mb-1.5">Catatan Progress</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('notes') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-emerald-500 transition-colors resize-none"
                                      placeholder="Contoh: Saya sudah menyelesaikan bagian frontend..."></textarea>
                            @error('notes')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div x-data="{ fileName: '', previewUrl: '' }">
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Foto Bukti Progress</label>
                            <div class="relative">
                                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg" class="hidden"
                                       @change="fileName = $event.target.files[0]?.name; 
                                                const reader = new FileReader();
                                                reader.onload = (e) => { previewUrl = e.target.result };
                                                if($event.target.files[0]) reader.readAsDataURL($event.target.files[0]);
                                                else previewUrl = '';">
                                <label for="photo" class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-gray-800 border-2 border-gray-700 border-dashed rounded-lg appearance-none cursor-pointer hover:border-emerald-500 focus:outline-none"
                                       x-show="!previewUrl">
                                    <span class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                        <span class="font-medium text-gray-400" x-text="fileName || 'Klik untuk upload foto (Max 5MB)'"></span>
                                    </span>
                                </label>
                                
                                <div x-show="previewUrl" class="relative rounded-lg overflow-hidden border border-gray-700 w-full h-48 bg-gray-800">
                                    <img :src="previewUrl" class="w-full h-full object-contain">
                                    <button type="button" @click="previewUrl = ''; fileName = ''; document.getElementById('photo').value = ''" 
                                            class="absolute top-2 right-2 p-1.5 bg-gray-900/80 text-white rounded-md hover:bg-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>
                            @error('photo')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-gray-800">
                        <button type="submit"
                                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 focus:outline-none transition-colors">
                            Kirim Progress
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Progress --}}
        <div>
            <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden h-full flex flex-col max-h-[800px]">
                <div class="px-5 py-4 border-b border-gray-800 bg-gray-900 shrink-0">
                    <h3 class="text-sm font-semibold text-white">Riwayat Progress Saya</h3>
                </div>

                <div class="p-5 overflow-y-auto flex-1">
                    @if($logs->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-400 text-sm">Anda belum mengirimkan progress untuk tugas ini.</p>
                        </div>
                    @else
                        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-800 before:to-transparent">
                            @foreach($logs as $index => $log)
                            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                {{-- Marker --}}
                                <div class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-800 bg-gray-900 text-gray-500 group-hover:text-emerald-400 group-hover:border-emerald-500/50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-colors z-10">
                                    @if($log->status === 'completed')
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @endif
                                </div>
                                
                                {{-- Card --}}
                                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-lg bg-gray-800/50 border border-gray-700/50 hover:bg-gray-800 transition-colors">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold {{ $log->status === 'completed' ? 'text-green-400' : 'text-amber-400' }}">
                                            {{ $log->status === 'completed' ? 'Selesai' : 'Proses' }}
                                        </span>
                                        <time class="text-[10px] text-gray-500">{{ $log->created_at->format('d M, H:i') }}</time>
                                    </div>
                                    @if($log->notes)
                                        <p class="text-sm text-gray-300 mb-3">{{ $log->notes }}</p>
                                    @endif
                                    @if($log->photo_path)
                                        <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank" class="block rounded overflow-hidden border border-gray-700 mt-2">
                                            <img src="{{ asset('storage/' . $log->photo_path) }}" class="w-full h-auto object-cover max-h-32" alt="Progress">
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-siswa.layout>
