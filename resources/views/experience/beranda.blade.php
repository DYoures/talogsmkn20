<x-education-layout>
    <x-slot name="title">Beranda — TALOG SMKN 20 Jakarta</x-slot>

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-edu-navy via-[#0c244d] to-edu-canvas pt-12 pb-20 sm:pt-16 sm:pb-28">
        {{-- Background decorative grid & glow circles --}}
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(255,107,0,0.15),rgba(255,255,255,0))]"></div>
        <div class="absolute top-10 left-1/4 w-72 h-72 bg-edu-orange/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                {{-- Left content --}}
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="edu-anim-item inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white text-xs font-semibold uppercase tracking-wider mb-6">
                        <span class="w-2 h-2 rounded-full bg-edu-orange animate-ping"></span>
                        <span>Portal Tugas Akhir Resmi SMKN 20 Jakarta</span>
                    </div>

                    <h1 class="edu-anim-item text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.15] font-display">
                        Karya Nyata, <span class="text-transparent bg-clip-text bg-gradient-to-r from-edu-orange to-amber-300">Generasi Juara</span> Menuju Masa Depan
                    </h1>

                    <p class="edu-anim-item mt-6 text-base sm:text-lg text-white/80 max-w-2xl leading-relaxed">
                        Selamat datang di <strong>TALOG20</strong>, platform digital kolaboratif untuk memonitor, membimbing, dan memamerkan karya inovatif Tugas Akhir siswa SMKN 20 Jakarta.
                    </p>

                    <div class="edu-anim-item mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        {{-- 3D Experience button --}}
                        <a href="{{ route('experience.3d') }}" class="btn-edu-primary shadow-edu-md flex items-center gap-2 px-6 py-3.5 text-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Buka Buku Interaktif 3D</span>
                        </a>

                        @auth
                            @if(auth()->user()->hasRole('Admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn-edu-outline text-white border-white/30 hover:bg-white/10 px-6 py-3.5 text-sm">
                                    Panel Admin &rarr;
                                </a>
                            @elseif(auth()->user()->hasRole('Guru'))
                                <a href="{{ route('guru.tugas-akhir.index') }}" class="btn-edu-outline text-white border-white/30 hover:bg-white/10 px-6 py-3.5 text-sm">
                                    Kelola Tugas Akhir &rarr;
                                </a>
                            @elseif(auth()->user()->hasRole('Siswa'))
                                <a href="{{ route('siswa.tugas-akhir.index') }}" class="btn-edu-outline text-white border-white/30 hover:bg-white/10 px-6 py-3.5 text-sm">
                                    Lihat Progres Saya &rarr;
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-edu-outline text-white border-white/30 hover:bg-white/10 px-6 py-3.5 text-sm">
                                Masuk ke Akun
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- Right interactive card preview --}}
                <div class="lg:col-span-5 flex justify-center">
                    <div class="edu-anim-item relative w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 shadow-2xl hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-5">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
                                <div>
                                    <p class="text-white font-bold text-sm">SMKN 20 Jakarta</p>
                                    <p class="text-white/60 text-xs">Akreditasi A • Jakarta Selatan</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-edu-orange/20 text-edu-orange text-xs font-bold border border-edu-orange/30">
                                3D Active
                            </span>
                        </div>

                        <div class="space-y-3.5">
                            <div class="bg-white/10 rounded-xl p-3.5 border border-white/10 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-edu-orange/20 flex items-center justify-center text-edu-orange font-bold text-xs">
                                        AKL
                                    </div>
                                    <span class="text-white text-xs font-medium">Akuntansi & Keuangan Lembaga</span>
                                </div>
                                <span class="text-white/60 text-xs font-mono">&check;</span>
                            </div>

                            <div class="bg-white/10 rounded-xl p-3.5 border border-white/10 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-300 font-bold text-xs">
                                        OTKP
                                    </div>
                                    <span class="text-white text-xs font-medium">Otomatisasi Tata Kelola Perkantoran</span>
                                </div>
                                <span class="text-white/60 text-xs font-mono">&check;</span>
                            </div>

                            <div class="bg-white/10 rounded-xl p-3.5 border border-white/10 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-300 font-bold text-xs">
                                        BDP
                                    </div>
                                    <span class="text-white text-xs font-medium">Bisnis Daring & Pemasaran</span>
                                </div>
                                <span class="text-white/60 text-xs font-mono">&check;</span>
                            </div>

                            <div class="bg-white/10 rounded-xl p-3.5 border border-white/10 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-300 font-bold text-xs">
                                        RPL
                                    </div>
                                    <span class="text-white text-xs font-medium">Rekayasa Perangkat Lunak</span>
                                </div>
                                <span class="text-white/60 text-xs font-mono">&check;</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-white/70">
                            <span>Buku 3D WebGL Siap Diputar</span>
                            <a href="{{ route('experience.3d') }}" class="text-edu-orange font-semibold hover:underline">
                                Buka Sekarang &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="bg-white rounded-2xl shadow-edu-md border border-edu-border grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-edu-border">
            <div class="edu-anim-item p-6 text-center">
                <p class="text-3xl font-extrabold text-edu-navy font-display">{{ $totalJurusan ?? ($jurusans ? $jurusans->count() : 0) }}</p>
                <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Konsentrasi Keahlian</p>
            </div>
            <div class="edu-anim-item p-6 text-center">
                <p class="text-3xl font-extrabold text-edu-orange font-display">{{ $totalTugasAkhir ?? 0 }}</p>
                <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Tugas Akhir Aktif</p>
            </div>
            <div class="edu-anim-item p-6 text-center">
                <p class="text-3xl font-extrabold text-edu-navy font-display">{{ $totalGuru ?? 0 }}</p>
                <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Guru Pembimbing</p>
            </div>
            <div class="edu-anim-item p-6 text-center">
                <p class="text-3xl font-extrabold text-edu-orange font-display">{{ $totalSiswa ?? 0 }}</p>
                <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Siswa Terdaftar</p>
            </div>
        </div>
    </section>

    {{-- SECTION A: KARYA TUGAS AKHIR UNGGULAN --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="edu-anim-item flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100/80 text-edu-orange text-xs font-bold uppercase tracking-wider mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-edu-orange"></span>
                    Showcase Portofolio
                </div>
                <h2 class="text-3xl font-extrabold text-edu-navy font-display tracking-tight">
                    Karya Tugas Akhir Unggulan
                </h2>
                <p class="text-edu-muted text-sm mt-2 max-w-xl">
                    Portofolio inovasi dan proyek nyata hasil kolaborasi siswa SMKN 20 di bawah bimbingan guru profesional.
                </p>
            </div>
            <div>
                <a href="{{ route('jurusan.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-edu-orange hover:text-amber-600 transition-colors bg-orange-50 hover:bg-orange-100/80 px-4 py-2.5 rounded-xl border border-orange-200/60 shadow-sm">
                    <span>Lihat Semua Konsentrasi Keahlian</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
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
                    <div class="edu-anim-item edu-card flex flex-col justify-between p-5 hover:-translate-y-1.5 transition-all duration-300 group border border-edu-border bg-white rounded-2xl shadow-sm hover:shadow-edu-md">
                        <div>
                            {{-- Header badge --}}
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold border transition-colors"
                                      style="color: {{ $ta->jurusan->accent_color ?? '#0F2B5C' }}; background-color: {{ $ta->jurusan ? $ta->jurusan->accentRgba(0.1) : 'rgba(15,43,92,0.05)' }}; border-color: {{ $ta->jurusan ? $ta->jurusan->accentRgba(0.25) : 'rgba(15,43,92,0.1)' }};">
                                    {{ $ta->jurusan->kode ?? 'SMK' }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    {{ $logCount }} Update
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-base font-bold text-edu-navy line-clamp-2 group-hover:text-edu-orange transition-colors leading-snug">
                                {{ $ta->title }}
                            </h3>

                            {{-- Description --}}
                            <p class="text-xs text-edu-body mt-2 line-clamp-3 leading-relaxed">
                                {{ $ta->description ?: 'Proyek tugas akhir terverifikasi pada konsentrasi keahlian ' . ($ta->jurusan->name ?? 'SMKN 20') . '.' }}
                            </p>
                        </div>

                        <div class="mt-5 pt-4 border-t border-edu-border/80 space-y-3">
                            {{-- Progress Bar --}}
                            <div>
                                <div class="flex justify-between text-[11px] text-edu-muted font-medium mb-1">
                                    <span>Estimasi Progres</span>
                                    <span class="font-bold text-edu-navy">{{ $progressPercent }}%</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-edu-orange to-amber-400 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                                </div>
                            </div>

                            {{-- Guru & Siswa --}}
                            <div class="flex items-center justify-between text-[11px] text-edu-muted pt-1">
                                <div class="flex items-center gap-1.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-edu-orange shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span class="truncate">{{ $ta->guru->name ?? 'Guru Pembimbing' }}</span>
                                </div>
                                <a href="{{ route('jurusan.detail', $ta->jurusan->slug ?? 'rpl') }}" class="text-edu-orange font-semibold hover:underline shrink-0 text-xs">
                                    Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-edu-canvas border-2 border-dashed border-edu-border rounded-2xl p-10 text-center">
                <div class="w-14 h-14 rounded-2xl bg-orange-100 text-edu-orange flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-base font-bold text-edu-navy">Belum Ada Tugas Akhir Dipublikasikan</h3>
                <p class="text-xs text-edu-muted max-w-md mx-auto mt-1.5">
                    Tugas akhir yang ditambahkan oleh Guru Pembimbing akan tampil di sini sebagai showcase karya inovatif siswa.
                </p>
                <div class="mt-5">
                    <a href="{{ route('jurusan.index') }}" class="btn-edu-primary inline-flex items-center gap-2 px-5 py-2.5 text-xs">
                        Jelajahi Konsentrasi Keahlian &rarr;
                    </a>
                </div>
            </div>
        @endif
    </section>

    {{-- SECTION B: ALUR KERJA TALOG20 --}}
    <section class="bg-white border-y border-edu-border py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="edu-anim-item text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100/70 text-blue-700 text-xs font-bold uppercase tracking-wider mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                    SOP Bimbingan Terpadu
                </div>
                <h2 class="text-3xl font-extrabold text-edu-navy font-display tracking-tight">
                    Alur Kerja Kolaboratif TALOG20
                </h2>
                <p class="text-edu-muted text-sm mt-3 leading-relaxed">
                    Satu siklus pembimbingan terstruktur dari penetapan judul hingga evaluasi tuntas portofolio siswa.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                {{-- Connector line for desktop --}}
                <div class="hidden md:block absolute top-14 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-orange-200 via-blue-200 to-emerald-200 -z-0"></div>

                {{-- Step 1 --}}
                <div class="edu-anim-item relative z-10 bg-edu-canvas border border-edu-border rounded-2xl p-7 hover:border-edu-orange/50 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-edu-orange flex items-center justify-center font-display font-extrabold text-lg shadow-sm border border-orange-200/50">
                                01
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-orange-50 text-edu-orange text-[11px] font-bold border border-orange-100">
                                Guru Pembimbing
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-edu-navy mb-2">Penetapan & Penugasan TA</h3>
                        <p class="text-xs text-edu-body leading-relaxed">
                            Guru pembimbing merumuskan topik tugas akhir berbasis problem solving industri, menentukan parameter penilaian, dan mengarahkan siswa binaan per jurusan.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-edu-border/80 flex items-center gap-2 text-xs text-edu-muted font-medium">
                        <svg class="w-4 h-4 text-edu-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Topik terstandarisasi kompetensi SMK</span>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="edu-anim-item relative z-10 bg-edu-canvas border border-edu-border rounded-2xl p-7 hover:border-blue-300 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-display font-extrabold text-lg shadow-sm border border-blue-200/50">
                                02
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                Siswa Binaan
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-edu-navy mb-2">Dokumentasi Foto Bukti</h3>
                        <p class="text-xs text-edu-body leading-relaxed">
                            Siswa mengunggah logbook berkala disertai foto bukti fisik pengerjaan karya nyata, kendala teknis, serta catatan solusi yang telah diterapkan.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-edu-border/80 flex items-center gap-2 text-xs text-edu-muted font-medium">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Bukti otentik & anti-plagiarisme</span>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="edu-anim-item relative z-10 bg-edu-canvas border border-edu-border rounded-2xl p-7 hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-display font-extrabold text-lg shadow-sm border border-emerald-200/50">
                                03
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-100">
                                Guru Pembimbing
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-edu-navy mb-2">Monitoring & Evaluasi Real-Time</h3>
                        <p class="text-xs text-edu-body leading-relaxed">
                            Guru pembimbing memantau kurva progres karya siswa secara berkala, meninjau catatan logbook dan bukti foto yang dikirimkan, serta memastikan target tercapai.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-edu-border/80 flex items-center gap-2 text-xs text-edu-muted font-medium">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Transparan, terdokumentasi, dan terukur</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA BANNER --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="edu-anim-item relative overflow-hidden bg-gradient-to-r from-edu-navy to-[#0F2B5C] rounded-3xl p-8 sm:p-12 text-center text-white shadow-2xl">
            <div class="relative z-10 max-w-2xl mx-auto">
                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo" class="h-16 w-auto mx-auto mb-6 drop-shadow-lg">
                <h3 class="text-2xl sm:text-3xl font-extrabold font-display">
                    Rasakan Pengalaman Interaktif 3D Buku TALOG20
                </h3>
                <p class="text-white/70 text-sm mt-3 mb-8">
                    Jelajahi konsentrasi keahlian SMKN 20 Jakarta melalui visualisasi 3D WebGL yang dinamis dan modern.
                </p>
                <a href="{{ route('experience.3d') }}" class="btn-edu-primary inline-flex items-center gap-2 px-8 py-4 text-base">
                    Buka Pengalaman 3D Sekarang &rarr;
                </a>
            </div>
        </div>
    </section>

</x-education-layout>
