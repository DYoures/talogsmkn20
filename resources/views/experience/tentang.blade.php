<x-education-layout>
    <x-slot name="title">Tentang SMKN 20 & TALOG20</x-slot>

    <div>
        {{-- HERO SECTION --}}
        <section class="edu-anim-item relative bg-gradient-to-br from-edu-navy via-[#002244] to-[#0D3B66] text-white py-16 sm:py-24 overflow-hidden">
            {{-- Decorative bg --}}
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-edu-orange/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full bg-blue-400/10 blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl">
                    <nav class="flex items-center gap-2 text-xs text-white/60 mb-6 font-medium">
                        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                        <span>/</span>
                        <span class="text-edu-orange font-semibold">Tentang</span>
                    </nav>

                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white text-xs font-semibold uppercase tracking-wider mb-5">
                        <span class="w-2 h-2 rounded-full bg-edu-orange"></span>
                        Profil Lembaga & Ekosistem Digital
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-display">
                        SMKN 20 Jakarta & Inovasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-edu-orange to-amber-300">TALOG20</span>
                    </h1>

                    <p class="mt-5 text-base sm:text-lg text-white/80 leading-relaxed">
                        Mewujudkan pendidikan vokasi bermutu tinggi, berkarakter, dan berdaya saing global melalui sinergi kurikulum industri serta transformasi pemantauan tugas akhir digital yang transparan.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('jurusan.index') }}" class="btn-edu-primary inline-flex items-center gap-2 px-6 py-3 text-sm">
                            <span>Jelajahi Konsentrasi Keahlian</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('experience.3d') }}" class="btn-edu-outline text-white border-white/30 hover:bg-white/10 px-6 py-3 text-sm">
                            Pengalaman Buku 3D &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- STATS BAR --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
            <div class="bg-white rounded-2xl shadow-edu-md border border-edu-border grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-edu-border">
                <div class="p-6 text-center">
                    <p class="text-3xl font-extrabold text-edu-navy font-display">{{ $totalJurusan ?? 4 }}</p>
                    <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Konsentrasi Keahlian</p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-3xl font-extrabold text-edu-orange font-display">{{ $totalTugasAkhir ?? 0 }}</p>
                    <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Tugas Akhir Aktif</p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-3xl font-extrabold text-edu-navy font-display">{{ $totalGuru ?? 0 }}</p>
                    <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Guru Pembimbing</p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-3xl font-extrabold text-edu-orange font-display">{{ $totalSiswa ?? 0 }}</p>
                    <p class="text-xs text-edu-muted uppercase tracking-wider font-semibold mt-1">Siswa Terdaftar</p>
                </div>
            </div>
        </section>

        {{-- VISI & MISI SECTION --}}
        <section class="edu-anim-item max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100/80 text-edu-orange text-xs font-bold uppercase tracking-wider mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-edu-orange"></span>
                        Visi & Misi Sekolah
                    </div>
                    <h2 class="text-3xl font-extrabold text-edu-navy font-display tracking-tight leading-snug">
                        Mendidik Talenta Muda Berstandar Unggul
                    </h2>
                    <p class="text-edu-body text-sm mt-4 leading-relaxed">
                        SMKN 20 Jakarta merupakan Sekolah Menengah Kejuruan Negeri terakreditasi <strong>A</strong> yang berlokasi strategis di Cilandak Barat, Jakarta Selatan. Kami berkomitmen menyelenggarakan pembelajaran inovatif yang menautkan kurikulum vokasi dengan kebutuhan riil Dunia Usaha dan Dunia Industri (DUDI).
                    </p>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-orange-50/70 border border-orange-100">
                            <div class="w-10 h-10 rounded-lg bg-edu-orange text-white flex items-center justify-center shrink-0 font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-edu-navy">Visi SMKN 20</h3>
                                <p class="text-xs text-edu-body mt-1 leading-relaxed">
                                    Menjadi lembaga pendidikan kejuruan berprestasi unggul, menghasilkan tamatan yang religius, cerdas, kompeten, mandiri, dan berdaya saing global.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-xl bg-blue-50/70 border border-blue-100">
                            <div class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-edu-navy">Misi Pendidikan</h3>
                                <p class="text-xs text-edu-body mt-1 leading-relaxed">
                                    Menyelenggarakan pembelajaran berbasis Teaching Factory dan proyek riil, memperkuat budaya kerja industri, serta mengoptimalkan sarana teknologi informasi terkini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- School info card --}}
                <div class="bg-gradient-to-br from-edu-canvas to-white border border-edu-border rounded-3xl p-8 shadow-sm">
                    <div class="flex items-center gap-4 border-b border-edu-border pb-6 mb-6">
                        <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo SMKN 20" class="h-16 w-auto drop-shadow-sm">
                        <div>
                            <h3 class="text-lg font-bold text-edu-navy">SMK Negeri 20 Jakarta</h3>
                            <p class="text-xs text-edu-muted">NPSN: 20102570 • Akreditasi A</p>
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
                                Sekolah Menengah Kejuruan Negeri
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-edu-orange shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <p class="font-bold text-edu-navy">Alamat Kampus</p>
                                <p class="text-edu-body mt-0.5">Jl. Melati No.24, RT.13/RW.10, Cilandak Barat, Kec. Cilandak, Kota Jakarta Selatan, DKI Jakarta 12430</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-edu-orange shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <div>
                                <p class="font-bold text-edu-navy">Kontak & Informasi</p>
                                <p class="text-edu-body mt-0.5">smkn20jakarta@gmail.com | (021) 7690626</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-edu-orange shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <div>
                                <p class="font-bold text-edu-navy">Pilar Kejuruan Unggulan</p>
                                <p class="text-edu-body mt-0.5">AKL (Akuntansi), MPLB/OTKP (Manajemen Perkantoran), PM/BDP (Pemasaran), dan PPLG/RPL (Rekayasa Perangkat Lunak).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- MENGENAL PLATFORM TALOG20 --}}
        <section class="edu-anim-item bg-white border-y border-edu-border py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100/80 text-edu-orange text-xs font-bold uppercase tracking-wider mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-edu-orange"></span>
                        Platform Digital
                    </div>
                    <h2 class="text-3xl font-extrabold text-edu-navy font-display tracking-tight">
                        Mengenal Sistem TALOG20
                    </h2>
                    <p class="text-edu-muted text-sm mt-3 leading-relaxed">
                        TALOG20 (Tugas Akhir & Logbook Online SMKN 20) lahir untuk menggantikan pola pembimbingan manual menjadi sistem pelaporan digital yang transparan, terdokumentasi, dan terintegrasi.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-7 rounded-2xl bg-edu-canvas border border-edu-border hover:border-edu-orange/40 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-orange-100 text-edu-orange flex items-center justify-center mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-edu-navy mb-2">Otentisitas & Validitas</h3>
                        <p class="text-xs text-edu-body leading-relaxed">
                            Setiap catatan progres siswa wajib disertai bukti fisik orisinal (foto karya/tangkapan layar log pengerjaan) untuk menjamin keaslian proses pembuatan karya.
                        </p>
                    </div>

                    <div class="p-7 rounded-2xl bg-edu-canvas border border-edu-border hover:border-blue-300 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-edu-navy mb-2">Monitoring Real-Time</h3>
                        <p class="text-xs text-edu-body leading-relaxed">
                            Guru pembimbing dapat memantau linimasa penyelesaian tugas akhir secara real-time, meninjau catatan dan bukti foto logbook siswa, serta memberi arahan bimbingan hingga tugas akhir tuntas.
                        </p>
                    </div>

                    <div class="p-7 rounded-2xl bg-edu-canvas border border-edu-border hover:border-emerald-300 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-edu-navy mb-2">Showcase Portofolio Vokasi</h3>
                        <p class="text-xs text-edu-body leading-relaxed">
                            Karya tugas akhir yang telah tuntas dan disetujui guru pembimbing diarsipkan dalam format portofolio digital yang siap dipamerkan ke mitra industri dan masyarakat luas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA SECTION --}}
        <section class="edu-anim-item max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="relative overflow-hidden bg-gradient-to-r from-edu-navy to-[#0F2B5C] rounded-3xl p-8 sm:p-12 text-center text-white shadow-2xl">
                <div class="relative z-10 max-w-2xl mx-auto">
                    <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo" class="h-16 w-auto mx-auto mb-6 drop-shadow-lg">
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-display">
                        Jelajahi Konsentrasi Keahlian SMKN 20
                    </h3>
                    <p class="text-white/70 text-sm mt-3 mb-8">
                        Ketahui profil kompetensi, mata pelajaran unggulan, prospek karir, dan tools industri dari 4 jurusan kami.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('jurusan.index') }}" class="btn-edu-primary inline-flex items-center gap-2 px-8 py-3.5 text-sm">
                            Lihat Daftar Jurusan &rarr;
                        </a>
                        <a href="{{ route('home') }}" class="btn-edu-outline text-white border-white/30 hover:bg-white/10 px-8 py-3.5 text-sm">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-education-layout>
