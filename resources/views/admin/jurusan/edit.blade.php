<x-admin.layout title="Edit Jurusan">
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.jurusan.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-white">Edit Jurusan</h2>
            <p class="text-gray-400 text-xs mt-0.5">Ubah data konsentrasi keahlian dan konten detail publik</p>
        </div>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6">
        <form method="POST" action="{{ route('admin.jurusan.update', $jurusan) }}">
            @csrf
            @method('PUT')
            <div class="space-y-6">

                {{-- Nama + Kode --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Nama Jurusan <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $jurusan->name) }}"
                               placeholder="contoh: Rekayasa Perangkat Lunak"
                               class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors">
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="kode" class="block text-sm font-medium text-gray-300 mb-1.5">Kode</label>
                        <input type="text" id="kode" name="kode" value="{{ old('kode', $jurusan->kode) }}"
                               placeholder="BR / BD / RPL / LPS / AKL / MPLB"
                               class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('kode') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors uppercase">
                        @error('kode')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="Deskripsi singkat jurusan yang tampil di kartu beranda..."
                              class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors resize-none">{{ old('description', $jurusan->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Akreditasi --}}
                <div class="max-w-xs">
                    <label for="akreditasi" class="block text-sm font-medium text-gray-300 mb-1.5">Akreditasi</label>
                    <select id="akreditasi" name="akreditasi"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                        <option value="A" {{ old('akreditasi', $jurusan->akreditasi) === 'A' ? 'selected' : '' }}>A (Unggul)</option>
                        <option value="B" {{ old('akreditasi', $jurusan->akreditasi) === 'B' ? 'selected' : '' }}>B (Baik Sekali)</option>
                        <option value="C" {{ old('akreditasi', $jurusan->akreditasi) === 'C' ? 'selected' : '' }}>C (Baik)</option>
                        <option value="Belum Terakreditasi" {{ old('akreditasi', $jurusan->akreditasi) === 'Belum Terakreditasi' ? 'selected' : '' }}>Belum Terakreditasi</option>
                    </select>
                </div>

                {{-- Warna Aksen Identitas Jurusan (Curated Presets) --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Warna Aksen Identitas <span class="text-red-400">*</span>
                        </label>
                        <span class="text-xs text-gray-500">Preset terkurasi untuk tema Edukasi & Futuristic</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                        @foreach($presetColors as $preset)
                            @php
                                $currentColor = old('accent_color', $jurusan->accent_color ?? '#8B5CF6');
                                $isSelected = strtolower($currentColor) === strtolower($preset['hex']);
                            @endphp
                            <label class="relative flex items-center gap-3 p-3 bg-gray-800/80 border {{ $isSelected ? 'border-indigo-500 ring-2 ring-indigo-500/30' : 'border-gray-700/80' }} rounded-xl cursor-pointer hover:border-gray-500 transition-all group color-option"
                                   data-hex="{{ $preset['hex'] }}"
                                   data-name="{{ $preset['name'] }}">
                                <input type="radio" name="accent_color" value="{{ $preset['hex'] }}"
                                       {{ $isSelected ? 'checked' : '' }}
                                       class="sr-only color-radio">
                                <span class="w-6 h-6 rounded-full shrink-0 border border-white/20 transition-transform group-hover:scale-110"
                                      style="background-color: {{ $preset['hex'] }}; box-shadow: 0 0 10px {{ $preset['hex'] }}50;"></span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-white truncate">{{ $preset['name'] }}</p>
                                    <p class="text-[10px] font-mono text-gray-400">{{ $preset['hex'] }}</p>
                                </div>
                                <span class="radio-check-indicator absolute top-2 right-2 w-2 h-2 rounded-full {{ $isSelected ? 'block' : 'hidden' }}"
                                      style="background-color: {{ $preset['hex'] }}; box-shadow: 0 0 6px {{ $preset['hex'] }};"></span>
                            </label>
                        @endforeach
                    </div>

                    {{-- Live Preview Box --}}
                    @php
                        $activeHex = old('accent_color', $jurusan->accent_color ?? '#8B5CF6');
                    @endphp
                    <div class="p-4 bg-gray-950/70 border border-gray-800 rounded-xl">
                        <p class="text-[11px] font-mono text-gray-400 mb-2 uppercase tracking-wider">// Live Visual Preview (Aksen Kartu, Badge & 3D)</p>
                        <div class="flex items-center gap-4 flex-wrap">
                            {{-- Mini Badge --}}
                            <div id="preview-badge" class="px-3 py-1 rounded-md text-xs font-mono font-bold border transition-all"
                                 style="color: {{ $activeHex }}; background: {{ $jurusan->accentRgba(0.14) }}; border-color: {{ $jurusan->accentRgba(0.45) }};">
                                [ <span id="preview-kode-text">{{ $jurusan->kode ?: 'JUR' }}</span> // 01 ]
                            </div>
                            {{-- Mini Card Preview --}}
                            <div id="preview-card" class="px-4 py-2 rounded-r-lg bg-gray-900 text-xs text-white font-medium border border-gray-800 transition-all"
                                 style="border-left: 4px solid {{ $activeHex }}; box-shadow: 0 0 15px {{ $jurusan->accentRgba(0.15) }};">
                                <span class="text-gray-400 text-[10px] block">// CONTOH KARTU JURUSAN</span>
                                <span id="preview-name-text">{{ $jurusan->name ?: 'Nama Jurusan' }}</span>
                            </div>
                        </div>
                    </div>
                    @error('accent_color')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-gray-800">

                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Konten Halaman Detail (satu item per baris)</p>

                {{-- Kurikulum --}}
                <div>
                    <label for="kurikulum" class="block text-sm font-medium text-gray-300 mb-1.5">
                        Kurikulum / Mata Pelajaran
                        <span class="text-gray-500 font-normal ml-1 text-xs">(satu item per baris)</span>
                    </label>
                    <textarea id="kurikulum" name="kurikulum" rows="8"
                              placeholder="Pemrograman Dasar & Algoritma&#10;Pemrograman Berorientasi Objek&#10;Pengembangan Web&#10;..."
                              class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('kurikulum') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors font-mono resize-y">{{ old('kurikulum', is_array($jurusan->kurikulum) ? implode("\n", $jurusan->kurikulum) : '') }}</textarea>
                    @error('kurikulum')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prospek Karir --}}
                <div>
                    <label for="prospek_karir" class="block text-sm font-medium text-gray-300 mb-1.5">
                        Prospek Karir
                        <span class="text-gray-500 font-normal ml-1 text-xs">(satu karir per baris)</span>
                    </label>
                    <textarea id="prospek_karir" name="prospek_karir" rows="8"
                              placeholder="Web Developer / Full-Stack Developer&#10;Mobile App Developer&#10;Software Engineer&#10;..."
                              class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('prospek_karir') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors font-mono resize-y">{{ old('prospek_karir', is_array($jurusan->prospek_karir) ? implode("\n", $jurusan->prospek_karir) : '') }}</textarea>
                    @error('prospek_karir')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tools Industri --}}
                <div>
                    <label for="tools_industri" class="block text-sm font-medium text-gray-300 mb-1.5">
                        Tools & Teknologi Industri
                        <span class="text-gray-500 font-normal ml-1 text-xs">(satu tool per baris)</span>
                    </label>
                    <textarea id="tools_industri" name="tools_industri" rows="6"
                              placeholder="VS Code&#10;Git & GitHub&#10;Laravel&#10;React.js&#10;..."
                              class="w-full px-4 py-2.5 bg-gray-800 border {{ $errors->has('tools_industri') ? 'border-red-500' : 'border-gray-700' }} rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition-colors font-mono resize-y">{{ old('tools_industri', is_array($jurusan->tools_industri) ? implode("\n", $jurusan->tools_industri) : '') }}</textarea>
                    @error('tools_industri')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preview link --}}
                @if($jurusan->slug)
                <div class="bg-gray-800/50 rounded-lg px-4 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400">Preview halaman detail publik:</p>
                        <p class="text-xs text-indigo-400 font-mono mt-0.5">/jurusan/{{ $jurusan->slug }}</p>
                    </div>
                    <a href="{{ route('jurusan.detail', $jurusan->slug) }}" target="_blank"
                       class="text-xs text-indigo-400 hover:text-indigo-300 border border-indigo-500/30 hover:border-indigo-400 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Buka Preview
                    </a>
                </div>
                @endif

            </div>

            <div class="flex items-center gap-3 mt-8 pt-5 border-t border-gray-800">
                <button type="submit"
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.jurusan.index') }}"
                   class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const colorOptions = document.querySelectorAll('.color-option');
    const badge = document.getElementById('preview-badge');
    const card = document.getElementById('preview-card');
    const nameInput = document.getElementById('name');
    const kodeInput = document.getElementById('kode');
    const previewName = document.getElementById('preview-name-text');
    const previewKode = document.getElementById('preview-kode-text');

    function hexToRgb(hex) {
        hex = hex.replace('#', '');
        if (hex.length === 3) hex = hex.split('').map(c => c + c).join('');
        const num = parseInt(hex, 16);
        return {
            r: (num >> 16) & 255,
            g: (num >> 8) & 255,
            b: num & 255
        };
    }

    function updateColor(hex) {
        if (!hex) return;
        const rgb = hexToRgb(hex);
        if (badge) {
            badge.style.color = hex;
            badge.style.background = `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.14)`;
            badge.style.borderColor = `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.45)`;
        }
        if (card) {
            card.style.borderLeftColor = hex;
            card.style.boxShadow = `0 0 15px rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.15)`;
        }
    }

    colorOptions.forEach(opt => {
        opt.addEventListener('click', () => {
            const radio = opt.querySelector('.color-radio');
            if (radio) radio.checked = true;
            const hex = opt.dataset.hex;

            colorOptions.forEach(o => {
                o.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500/30');
                o.classList.add('border-gray-700/80');
                const ind = o.querySelector('.radio-check-indicator');
                if (ind) ind.classList.add('hidden');
            });
            opt.classList.remove('border-gray-700/80');
            opt.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500/30');
            const indicator = opt.querySelector('.radio-check-indicator');
            if (indicator) indicator.classList.remove('hidden');

            updateColor(hex);
        });
    });

    if (nameInput && previewName) {
        nameInput.addEventListener('input', () => {
            previewName.textContent = nameInput.value.trim() || 'Nama Jurusan';
        });
    }

    if (kodeInput && previewKode) {
        kodeInput.addEventListener('input', () => {
            previewKode.textContent = kodeInput.value.trim().toUpperCase() || 'JUR';
        });
    }
});
</script>
</x-admin.layout>
