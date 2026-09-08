<x-futuristic-layout>
    <x-slot name="title">Dossier Institusi — SMKN 20 Cyber Core</x-slot>

    <div>
        {{-- HERO DOSSIER SECTION --}}
        <section class="cyber-anim-item relative pt-16 pb-20 border-b border-cyan-500/20 overflow-hidden">
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-gradient-to-r from-cyan-500/10 via-purple-600/10 to-emerald-500/10 blur-[120px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl">
                    <div class="flex items-center gap-2 text-xs font-mono text-cyan-400/80 mb-6">
                        <a href="{{ route('home') }}" class="hover:text-cyan-300 transition-colors">[SYS://BERANDA]</a>
                        <span>/</span>
                        <span class="text-white font-bold">[DOSSIER://PROFIL]</span>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-300 font-mono text-xs mb-5">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                        <span>// INSTITUTIONAL_DATABASE_VERIFIED</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white font-mono tracking-tight leading-tight">
                        DOSSIER SMKN 20 &amp; <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-emerald-400">
                            CORE ARSITEKTUR TALOG20
                        </span>
                    </h1>

                    <p class="mt-5 text-sm sm:text-base text-gray-300 font-mono leading-relaxed">
                        Pusat keunggulan vokasi teknologi dan bisnis Jakarta Selatan yang mengintegrasikan pembelajaran berbasis industri dengan infrastruktur pemantauan tugas akhir digital berstandar enterprise.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('jurusan.index') }}" class="btn-cyber-primary text-xs px-6 py-3.5 inline-flex items-center gap-2">
                            <span>BUKA MATRIX KEAHLIAN</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('experience.futuristic-3d') }}" class="btn-cyber-outline text-xs px-6 py-3.5 inline-flex items-center gap-2">
                            <span>LUNCURKAN 3D CORE</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- STATS TELEMETRY --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="cyber-card p-5 text-center">
                    <p class="text-3xl font-extrabold text-cyan-400 font-mono">{{ $totalJurusan ?? 4 }}</p>
                    <p class="text-[11px] text-gray-400 font-mono uppercase tracking-wider mt-1">// SEKTOR KEAHLIAN</p>
                </div>
                <div class="cyber-card p-5 text-center">
                    <p class="text-3xl font-extrabold text-purple-400 font-mono">{{ $totalTugasAkhir ?? 0 }}</p>
                    <p class="text-[11px] text-gray-400 font-mono uppercase tracking-wider mt-1">// TOTAL PROYEK TA</p>
                </div>
                <div class="cyber-card p-5 text-center">
                    <p class="text-3xl font-extrabold text-emerald-400 font-mono">{{ $totalGuru ?? 0 }}</p>
                    <p class="text-[11px] text-gray-400 font-mono uppercase tracking-wider mt-1">// INSTRUKTUR PEMBIMBING</p>
                </div>
                <div class="cyber-card p-5 text-center">
                    <p class="text-3xl font-extrabold text-amber-400 font-mono">{{ $totalSiswa ?? 0 }}</p>
                    <p class="text-[11px] text-gray-400 font-mono uppercase tracking-wider mt-1">// KADET SISWA TERDATA</p>
                </div>
            </div>
        </section>

        {{-- OBJEKTIF & DIREKTIF SECTION --}}
        <section class="cyber-anim-item max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/30 text-purple-400 font-mono text-xs mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                        <span>// PROTOKOL_VISI_MISI</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white font-mono tracking-tight leading-snug">
                        REKAYASA TALENTA VOKASI MASA DEPAN
                    </h2>
                    <p class="text-gray-300 text-xs sm:text-sm mt-4 font-mono leading-relaxed">
                        SMK Negeri 20 Jakarta merupakan institusi pendidikan kejuruan negeri terakreditasi <strong>A</strong> yang berorientasi pada kemajuan teknologi digital, ketangkasan wirausaha, dan kesiapan serapan industri global.
                    </p>

                    <div class="mt-8 space-y-4 font-mono">
                        <div class="cyber-card p-5 border-l-4 border-l-cyan-400">
                            <div class="flex items-center gap-2 text-cyan-400 text-xs font-bold mb-1">
                                <span>[DIRECTIVE: VISI]</span>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed font-sans">
                                Menjadi sentra pendidikan kejuruan unggulan yang mencetak lulusan berakhlak mulia, berintegritas tinggi, kompeten sesuai standar sertifikasi industri, dan adaptif terhadap disrupsi teknologi.
                            </p>
                        </div>

                        <div class="cyber-card p-5 border-l-4 border-l-purple-400">
                            <div class="flex items-center gap-2 text-purple-400 text-xs font-bold mb-1">
                                <span>[DIRECTIVE: MISI]</span>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed font-sans">
                                Mengembangkan ekosistem Teaching Factory terakreditasi, membangun kemitraan strategis DUDI berskala nasional-internasional, dan mengimplementasikan sistem tata kelola digital terpadu.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Right Terminal Hardware Node --}}
                <div class="lg:col-span-5">
                    <div class="cyber-card p-6 border border-cyan-500/40 shadow-[0_0_50px_rgba(0,240,255,0.1)]">
                        <div class="flex items-center justify-between pb-4 border-b border-cyan-500/20 mb-5 font-mono text-xs">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo SMKN 20" class="h-8 w-auto filter drop-shadow-[0_0_8px_rgba(0,240,255,0.8)]">
                                <span class="text-cyan-400 font-bold">NODE://SMKN20_JKT</span>
                            </div>
                            <span class="text-emerald-400 text-[11px]">// AKREDITASI: A</span>
                        </div>

                        <div class="space-y-3 font-mono text-xs">
                            <div class="p-3 bg-black/50 rounded border border-cyan-500/20">
                                <p class="text-gray-400 text-[10px] uppercase">// NPSN &amp; IDENTITAS</p>
                                <p class="text-white font-bold mt-0.5">20102570 • SMK Negeri 20 Jakarta</p>
                            </div>

                            <div class="p-3 bg-black/50 rounded border border-cyan-500/20">
                                <p class="text-gray-400 text-[10px] uppercase">// GEOLOKASI KAMPUS</p>
                                <p class="text-gray-300 text-xs mt-0.5 leading-snug">
                                    Jl. Melati No.24, Cilandak Barat, Jakarta Selatan, DKI Jakarta 12430
                                </p>
                            </div>

                            <div class="p-3 bg-black/50 rounded border border-cyan-500/20">
                                <p class="text-gray-400 text-[10px] uppercase">// HUB KOMUNIKASI</p>
                                <p class="text-cyan-300 text-xs mt-0.5">
                                    smkn20jakarta@gmail.com | (021) 7690626
                                </p>
                            </div>

                            <div class="p-3 bg-black/50 rounded border border-cyan-500/20">
                                <p class="text-gray-400 text-[10px] uppercase">// KONSENTRASI KEAHLIAN TERPASANG</p>
                                <div class="flex flex-wrap gap-1.5 mt-1.5">
                                    <span class="cyber-badge text-[10px]">AKL</span>
                                    <span class="cyber-badge text-[10px]">OTKP</span>
                                    <span class="cyber-badge text-[10px]">BDP</span>
                                    <span class="cyber-badge text-[10px]">RPL</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ARSIP HISTORIS --}}
        <section class="cyber-anim-item border-y border-cyan-500/20 bg-black/30 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 font-mono text-xs mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                        <span>// FRAMEWORK_SPECIFICATION</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-white font-mono tracking-tight">
                        ARSITEKTUR PLATFORM TALOG20
                    </h2>
                    <p class="text-gray-400 text-xs font-mono mt-3 leading-relaxed">
                        Infrastruktur pemantauan tugas akhir dirancang untuk transparansi mutlak, pencegahan plagiarisme, dan kesiapan pameran karya ke publik.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="cyber-card p-6 border border-cyan-500/30">
                        <div class="text-2xl font-mono font-extrabold text-cyan-400 mb-3">[01]</div>
                        <h3 class="text-base font-bold text-white font-mono mb-2">OTENTISITAS LOGBOOK</h3>
                        <p class="text-xs text-gray-400 leading-relaxed font-sans">
                            Setiap pembaruan berkala diwajibkan menyertakan citra bukti fisik pengerjaan artefak guna memverifikasi kemajuan proyek secara terpercaya.
                        </p>
                    </div>

                    <div class="cyber-card p-6 border border-purple-500/30">
                        <div class="text-2xl font-mono font-extrabold text-purple-400 mb-3">[02]</div>
                        <h3 class="text-base font-bold text-white font-mono mb-2">MONITORING DUA ARAH</h3>
                        <p class="text-xs text-gray-400 leading-relaxed font-sans">
                            Instruktur memberikan koreksi dan persetujuan bertahap secara daring, memastikan timeline penyelesaian tugas akhir tepat sasaran.
                        </p>
                    </div>

                    <div class="cyber-card p-6 border border-emerald-500/30">
                        <div class="text-2xl font-mono font-extrabold text-emerald-400 mb-3">[03]</div>
                        <h3 class="text-base font-bold text-white font-mono mb-2">ETALASE PORTOFOLIO DUDI</h3>
                        <p class="text-xs text-gray-400 leading-relaxed font-sans">
                            Karya tugas akhir yang telah diverifikasi guru pembimbing dikompilasi ke dalam repositori digital terstruktur yang dapat diakses oleh mitra industri dan perguruan tinggi vokasi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- INFRASTRUKTUR FASILITAS --}}
        <section class="cyber-anim-item max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="cyber-card p-10 text-center border border-cyan-500/40">
                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo" class="h-16 w-auto mx-auto mb-5 filter drop-shadow-[0_0_15px_rgba(0,240,255,0.7)]">
                <h3 class="text-2xl font-extrabold text-white font-mono">
                    EKPLORASI SEMUA MATRIX KONSENTRASI
                </h3>
                <p class="text-gray-400 text-xs font-mono mt-2 mb-6">
                    Buka katalog kurikulum industri, mata pelajaran keahlian, dan perangkat teknologi per jurusan.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('jurusan.index') }}" class="btn-cyber-primary text-xs px-6 py-3.5 inline-block">
                        BUKA MATRIX JURUSAN &rarr;
                    </a>
                    <a href="{{ route('home') }}" class="btn-cyber-outline text-xs px-6 py-3.5 inline-block">
                        KEMBALI KE BERANDA
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-futuristic-layout>
