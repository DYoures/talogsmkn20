<x-futuristic-layout>
    <x-slot name="title">Cyber Beranda — TALOG SMKN 20</x-slot>

    {{-- HERO CYBER SECTION --}}
    <section class="relative overflow-hidden pt-16 pb-24 border-b border-cyan-500/20">
        {{-- Background Cyber Glow Effects --}}
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-gradient-to-r from-cyan-500/15 via-purple-600/15 to-emerald-500/10 blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                {{-- Left Text --}}
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="cyber-anim-item inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-300 font-mono text-xs mb-6">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                        <span>[SYS: ONLINE] PROTOKOL TUGAS AKHIR v2.0</span>
                    </div>

                    <h1 class="cyber-anim-item text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.1] font-mono">
                        KARYA NYATA <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-emerald-400">
                            DIGITAL CYBER
                        </span>
                    </h1>

                    <p class="cyber-anim-item mt-6 text-base sm:text-lg text-gray-300 max-w-2xl leading-relaxed">
                        Gerbang komputasi terpadu untuk memantau, membimbing, dan mendokumentasikan karya Tugas Akhir siswa SMKN 20 Jakarta dalam atmosfer WebGL futuristik generasi berikutnya.
                    </p>

                    <div class="cyber-anim-item mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('experience.futuristic-3d') }}" class="btn-cyber-primary text-sm px-6 py-3.5">
                            <svg class="w-4 h-4 text-[#050814]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/></svg>
                            <span>Luncurkan 3D Cyber Core</span>
                        </a>

                        @auth
                            @if(auth()->user()->hasRole('Admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn-cyber-outline text-sm px-6 py-3.5">
                                    Akses Admin &rarr;
                                </a>
                            @elseif(auth()->user()->hasRole('Guru'))
                                <a href="{{ route('guru.tugas-akhir.index') }}" class="btn-cyber-outline text-sm px-6 py-3.5">
                                    Panel Guru &rarr;
                                </a>
                            @elseif(auth()->user()->hasRole('Siswa'))
                                <a href="{{ route('siswa.tugas-akhir.index') }}" class="btn-cyber-outline text-sm px-6 py-3.5">
                                    Panel Siswa &rarr;
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-cyber-outline text-sm px-6 py-3.5">
                                Autentikasi Masuk &rarr;
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- Right Holographic Terminal Window --}}
                <div class="lg:col-span-5 flex justify-center">
                    <div class="cyber-anim-item w-full max-w-md cyber-card p-6 border border-cyan-500/30 shadow-[0_0_40px_rgba(0,240,255,0.15)]">
                        <div class="flex items-center justify-between pb-4 border-b border-cyan-500/20 mb-5 font-mono text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-red-500/80 inline-block"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-500/80 inline-block"></span>
                                <span class="w-3 h-3 rounded-full bg-green-500/80 inline-block"></span>
                                <span class="text-cyan-400 font-bold ml-2">CORE://SMKN20</span>
                            </div>
                            <span class="text-emerald-400 animate-pulse">[SECURE]</span>
                        </div>

                        <div class="space-y-3 font-mono text-xs">
                            <div class="p-3 rounded-lg bg-black/40 border border-cyan-500/20 flex items-center justify-between">
                                <span class="text-gray-400">// WEBGL CORE STATUS:</span>
                                <span class="text-cyan-300 font-bold">READY (60 FPS)</span>
                            </div>
                            <div class="p-3 rounded-lg bg-black/40 border border-purple-500/20 flex items-center justify-between">
                                <span class="text-gray-400">// THEME MATRIX:</span>
                                <span class="text-purple-300 font-bold">FUTURISTIC DIGITAL</span>
                            </div>
                            <div class="p-3 rounded-lg bg-black/40 border border-emerald-500/20 flex items-center justify-between">
                                <span class="text-gray-400">// JURUSAN ACTIVE:</span>
                                <span class="text-emerald-300 font-bold">{{ $jurusans->count() }} DEPARTMENTS</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-cyan-500/20 flex items-center justify-between font-mono text-xs">
                            <span class="text-gray-400">SIMULASI 3D AKTIF</span>
                            <a href="{{ route('experience.futuristic-3d') }}" class="text-cyan-400 hover:text-white transition-colors underline font-bold">
                                Buka Core WebGL &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TELEMETRY STATS SECTION --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="cyber-anim-item cyber-card p-5 text-center">
                <p class="text-3xl font-extrabold text-cyan-400 font-mono">{{ $totalJurusan ?? ($jurusans ? $jurusans->count() : 4) }}</p>
                <p class="text-xs text-gray-400 font-mono uppercase tracking-wider mt-1">// JURUSAN KEJURUAN</p>
            </div>
            <div class="cyber-anim-item cyber-card p-5 text-center">
                <p class="text-3xl font-extrabold text-purple-400 font-mono">{{ $totalTugasAkhir ?? 0 }}</p>
                <p class="text-xs text-gray-400 font-mono uppercase tracking-wider mt-1">// PROYEK AKTIF</p>
            </div>
            <div class="cyber-anim-item cyber-card p-5 text-center">
                <p class="text-3xl font-extrabold text-emerald-400 font-mono">{{ $totalGuru ?? 0 }}</p>
                <p class="text-xs text-gray-400 font-mono uppercase tracking-wider mt-1">// INSTRUKTUR PEMBIMBING</p>
            </div>
            <div class="cyber-anim-item cyber-card p-5 text-center">
                <p class="text-3xl font-extrabold text-amber-400 font-mono">{{ $totalSiswa ?? 0 }}</p>
                <p class="text-xs text-gray-400 font-mono uppercase tracking-wider mt-1">// KADET SISWA</p>
            </div>
        </div>
    </section>

    {{-- SECTION A: KARYA TUGAS AKHIR UNGGULAN (CYBER MATRIX) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="cyber-anim-item flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 font-mono text-xs mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span>// TELEMETRI_PROYEK_UNGGULAN</span>
                </div>
                <h2 class="text-3xl font-extrabold text-white font-mono tracking-tight">
                    SHOWCASE PROYEK TUGAS AKHIR
                </h2>
                <p class="text-gray-400 text-xs font-mono mt-2 max-w-xl">
                    Katalog artefak dan inovasi teknologi hasil pengembangan kadet siswa di bawah supervisi instruktur kejuruan.
                </p>
            </div>
            <div>
                <a href="{{ route('jurusan.index') }}" class="btn-cyber-outline font-mono text-xs inline-flex items-center gap-2 px-4 py-2.5">
                    <span>LIHAT SEMUA MATRIX JURUSAN</span>
                    <span class="text-cyan-400">&rarr;</span>
                </a>
            </div>
        </div>

        @if(isset($recentTugasAkhirs) && $recentTugasAkhirs->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentTugasAkhirs as $ta)
                    @php
                        $logCount = $ta->progressLogs->count();
                        $progressPercent = $logCount > 0 ? min(100, $logCount * 25) : 10;
                    @endphp
                    <div class="cyber-anim-item cyber-card p-5 flex flex-col justify-between hover:border-cyan-400/60 transition-all duration-300 group"
                         style="border-left: 3.5px solid {{ $ta->jurusan->accent_color ?? '#00F0FF' }};">
                        <div>
                            {{-- Header badge --}}
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="cyber-badge text-xs font-mono font-bold"
                                      style="color: {{ $ta->jurusan->accent_color ?? '#00F0FF' }}; border-color: {{ $ta->jurusan ? $ta->jurusan->accentRgba(0.4) : 'rgba(0,240,255,0.4)' }}; background: {{ $ta->jurusan ? $ta->jurusan->accentRgba(0.12) : 'rgba(0,240,255,0.1)' }};">
                                    [{{ $ta->jurusan->kode ?? 'SYS' }}]
                                </span>
                                <span class="text-[11px] font-mono text-emerald-400 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    {{ $logCount }} LOGS
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-base font-bold text-white group-hover:text-cyan-300 transition-colors font-mono line-clamp-2 leading-snug">
                                {{ $ta->title }}
                            </h3>

                            {{-- Description --}}
                            <p class="text-xs text-gray-400 mt-2.5 line-clamp-3 leading-relaxed">
                                {{ $ta->description ?: 'Proyek rekayasa tugas akhir terverifikasi konsentrasi keahlian ' . ($ta->jurusan->name ?? 'SMKN 20') . '.' }}
                            </p>
                        </div>

                        <div class="mt-5 pt-4 border-t border-cyan-500/20 font-mono space-y-3">
                            {{-- Progress Bar --}}
                            <div>
                                <div class="flex justify-between text-[10px] text-gray-400 mb-1">
                                    <span>// SYNC PROGRESS</span>
                                    <span class="text-cyan-400 font-bold">{{ $progressPercent }}%</span>
                                </div>
                                <div class="w-full h-1.5 bg-black/60 rounded-full overflow-hidden border border-cyan-500/20">
                                    <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full" style="width: {{ $progressPercent }}%"></div>
                                </div>
                            </div>

                            {{-- Guru & Detail Link --}}
                            <div class="flex items-center justify-between text-xs pt-1">
                                <span class="text-gray-500 text-[11px] truncate max-w-[130px]">
                                    {{ $ta->guru->name ?? 'Instruktur' }}
                                </span>
                                <a href="{{ route('jurusan.detail', $ta->jurusan->slug ?? 'rpl') }}" class="text-cyan-400 hover:text-white transition-colors text-xs font-bold">
                                    INSPECT &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="cyber-card p-10 text-center border-dashed border-cyan-500/30 font-mono">
                <p class="text-cyan-400 text-sm font-bold">// DATA LOGBOOK KOSONG</p>
                <p class="text-xs text-gray-400 mt-2">Belum ada catatan tugas akhir aktif yang dipublikasikan dalam pangkalan data.</p>
                <div class="mt-4">
                    <a href="{{ route('jurusan.index') }}" class="btn-cyber-primary text-xs px-5 py-2 inline-block">
                        JELAJAHI MATRIX JURUSAN &rarr;
                    </a>
                </div>
            </div>
        @endif
    </section>

    {{-- SECTION B: ALUR PROTOKOL TALOG20 (CYBER) --}}
    <section class="border-y border-cyan-500/20 bg-black/30 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="cyber-anim-item text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/30 text-purple-400 font-mono text-xs mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                    <span>// SIKLUS_SISTEM_OPERASI</span>
                </div>
                <h2 class="text-3xl font-extrabold text-white font-mono tracking-tight">
                    PROTOKOL ALUR KERJA TALOG20
                </h2>
                <p class="text-gray-400 text-xs font-mono mt-3 leading-relaxed">
                    Tiga tahapan siklus sinkronisasi data dari inisiasi instruktur hingga evaluasi berkala tugas akhir.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                {{-- Step 1 --}}
                <div class="cyber-anim-item cyber-card p-7 border border-cyan-500/30 flex flex-col justify-between hover:shadow-[0_0_30px_rgba(0,240,255,0.2)] transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-5 font-mono">
                            <span class="text-2xl font-extrabold text-cyan-400">01//</span>
                            <span class="text-[11px] px-2.5 py-1 rounded bg-cyan-500/10 text-cyan-300 border border-cyan-500/30">
                                INSTRUKTUR
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-white font-mono mb-2">Penetapan Target Riset</h3>
                        <p class="text-xs text-gray-400 leading-relaxed font-sans">
                            Instruktur merumuskan topik tugas akhir berbasis problem industri, menetapkan parameter evaluasi, dan mengarahkan kadet siswa per jurusan.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-cyan-500/20 font-mono text-[11px] text-cyan-400 flex items-center gap-2">
                        <span>&gt;</span> Topik terstandarisasi DUDI
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="cyber-anim-item cyber-card p-7 border border-purple-500/30 flex flex-col justify-between hover:shadow-[0_0_30px_rgba(168,85,247,0.2)] transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-5 font-mono">
                            <span class="text-2xl font-extrabold text-purple-400">02//</span>
                            <span class="text-[11px] px-2.5 py-1 rounded bg-purple-500/10 text-purple-300 border border-purple-500/30">
                                KADET SISWA
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-white font-mono mb-2">Unggah Telemetri Bukti</h3>
                        <p class="text-xs text-gray-400 leading-relaxed font-sans">
                            Siswa mengunggah logbook berkala disertai bukti citra/foto pengerjaan fisik untuk verifikasi keaslian dan progres pengerjaan artefak.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-purple-500/20 font-mono text-[11px] text-purple-400 flex items-center gap-2">
                        <span>&gt;</span> Log otentik & anti-plagiasi
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="cyber-anim-item cyber-card p-7 border border-emerald-500/30 flex flex-col justify-between hover:shadow-[0_0_30px_rgba(16,185,129,0.2)] transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-5 font-mono">
                            <span class="text-2xl font-extrabold text-emerald-400">03//</span>
                            <span class="text-[11px] px-2.5 py-1 rounded bg-emerald-500/10 text-emerald-300 border border-emerald-500/30">
                                INSTRUKTUR GURU
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-white font-mono mb-2">Audit & Evaluasi Telemetri</h3>
                        <p class="text-xs text-gray-400 leading-relaxed font-sans">
                            Guru pembimbing melakukan audit kurva progres real-time, meninjau logbook dan foto bukti fisik, serta membimbing siswa hingga proyek tuntas.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-emerald-500/20 font-mono text-[11px] text-emerald-400 flex items-center gap-2">
                        <span>&gt;</span> Evaluasi terpadu & tervalidasi
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CYBER CORE CTA BANNER --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="cyber-anim-item relative overflow-hidden cyber-card p-10 sm:p-14 text-center border border-cyan-500/40">
            <div class="relative z-10 max-w-2xl mx-auto">
                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo" class="h-16 w-auto mx-auto mb-6 filter drop-shadow-[0_0_15px_rgba(0,240,255,0.7)]">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white font-mono">
                    JELAJAHI 3D EXPERIMENTAL WEBGL
                </h3>
                <p class="text-gray-300 text-sm mt-3 mb-8 font-mono">
                    Pengalaman interaktif partikel kuantum dan geometri organik dalam visualisasi sinematik 3D.
                </p>
                <a href="{{ route('experience.futuristic-3d') }}" class="btn-cyber-primary inline-flex items-center gap-2 px-8 py-4 text-sm">
                    Luncurkan Sekarang &rarr;
                </a>
            </div>
        </div>
    </section>
</x-futuristic-layout>
