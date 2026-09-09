<x-education-layout>
    <x-slot name="title">{{ $jurusan->name }} — Konsentrasi Keahlian SMKN 20 Jakarta</x-slot>

    @php
        $accentColor = $jurusan->accent_color;
        $accents = [
            'badge_bg'  => "linear-gradient(135deg, {$accentColor}, " . $jurusan->accentRgba(0.8) . ")",
            'hero_from' => $jurusan->accentRgba(0.25),
            'glow'      => $jurusan->accentRgba(0.18),
        ];
    @endphp

    <style>
        /* Entry animations */
        .detail-hero-enter  { animation: heroSlideIn  0.6s cubic-bezier(0.22,1,0.36,1) both; }
        .detail-content-enter { animation: contentFadeUp 0.7s cubic-bezier(0.22,1,0.36,1) 0.15s both; }
        @keyframes heroSlideIn  { from{opacity:0;transform:translateY(-24px)} to{opacity:1;transform:translateY(0)} }
        @keyframes contentFadeUp{ from{opacity:0;transform:translateY(32px)}  to{opacity:1;transform:translateY(0)} }

        /* Section cards */
        .detail-section-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        /* Kurikulum items */
        .mapel-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        .mapel-item:hover {
            border-color: rgba(255,107,0,0.3);
            background: #fff7f0;
        }

        /* Tool chips */
        .tool-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            background: rgba(255,107,0,0.08);
            border: 1px solid rgba(255,107,0,0.2);
            color: #ff6b00;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .tool-chip:hover {
            background: rgba(255,107,0,0.15);
            border-color: rgba(255,107,0,0.4);
            transform: translateY(-1px);
        }

        /* Career cards */
        .career-card {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.25s ease;
        }
        .career-card:hover {
            border-color: #ff6b00;
            background: #fff7f0;
            transform: translateX(4px);
        }

        /* Other jurusan nav */
        .other-jurusan-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .other-jurusan-link:hover {
            border-color: rgba(255,107,0,0.3);
            background: #fff7f0;
        }
        .other-jurusan-link .kode-badge {
            width: 2.5rem; height: 2.5rem;
            display: flex; align-items: center; justify-content: center;
            border-radius: 0.5rem;
            background: #fff7f0;
            color: #ff6b00;
            font-size: 0.7rem;
            font-weight: 700;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .other-jurusan-link:hover .kode-badge {
            background: #ff6b00;
            color: #fff;
        }
        .other-jurusan-link .link-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: #334155;
            flex: 1;
            transition: color 0.2s;
        }
        .other-jurusan-link:hover .link-name { color: #ff6b00; }

        /* Stat box inside hero */
        .hero-stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 1rem;
            padding: 1.25rem;
        }
        .stat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0;
        }
        .stat-row + .stat-row { border-top: 1px solid rgba(255,255,255,0.1); }

        /* Breadcrumb */
        .detail-breadcrumb a { color: rgba(255,255,255,0.45); text-decoration: none; transition: color 0.2s; }
        .detail-breadcrumb a:hover { color: #ff6b00; }
        .detail-breadcrumb .sep { color: rgba(255,255,255,0.25); margin: 0 0.35rem; }
        .detail-breadcrumb .current { color: rgba(255,255,255,0.8); }

        /* Hero layout */
        .detail-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }
        @media (min-width: 1024px) {
            .detail-hero-grid { grid-template-columns: 2fr 1fr; align-items: start; }
        }

        /* Content layout */
        .detail-content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        @media (min-width: 1024px) {
            .detail-content-grid { grid-template-columns: 1fr 380px; align-items: start; }
        }

        /* Kurikulum grid */
        .kurikulum-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.625rem;
        }
        @media (min-width: 640px) {
            .kurikulum-grid { grid-template-columns: 1fr 1fr; }
        }

        /* Tools wrap */
        .tools-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 0.625rem;
        }
    </style>

    {{-- ========== HERO SECTION ========== --}}
    <section class="relative overflow-hidden detail-hero-enter"
             style="background: linear-gradient(160deg, {{ $accents['hero_from'] }} 0%, #0c244d 50%, #F8FAFC 100%); padding-top: 3rem; padding-bottom: 6rem;">

        {{-- Radial glow --}}
        <div style="position:absolute;inset:0;background:radial-gradient(ellipse 70% 60% at 50% -10%, {{ $accents['glow'] }}, transparent);pointer-events:none;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="detail-breadcrumb" style="display:flex;align-items:center;font-size:0.75rem;font-weight:500;margin-bottom:2rem;">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="sep">›</span>
                <a href="{{ route('home') }}#jurusan">Jurusan</a>
                <span class="sep">›</span>
                <span class="current">{{ $jurusan->kode ?? $jurusan->name }}</span>
            </nav>

            <div class="detail-hero-grid">

                {{-- LEFT: Main info --}}
                <div data-shared-id="jurusan-{{ $jurusan->id }}">
                    {{-- Kode badge + Akreditasi --}}
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                        <span style="background:{{ $accents['badge_bg'] }};color:#fff;font-weight:700;font-size:1.25rem;padding:0.625rem 1.25rem;border-radius:0.875rem;letter-spacing:0.05em;box-shadow:0 4px 16px rgba(0,0,0,0.25);">
                            {{ $jurusan->kode ?? '—' }}
                        </span>
                        <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.375rem 0.875rem;border-radius:9999px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.8);font-size:0.75rem;font-weight:600;">
                            <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Akreditasi {{ $jurusan->akreditasi ?? 'A' }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 style="font-size:clamp(1.75rem,4vw,3rem);font-weight:800;color:#fff;line-height:1.15;letter-spacing:-0.02em;margin-bottom:1rem;">
                        {{ $jurusan->name }}
                    </h1>

                    {{-- Description --}}
                    <p style="color:rgba(255,255,255,0.7);font-size:1rem;line-height:1.65;max-width:36rem;">
                        {{ $jurusan->description }}
                    </p>

                    {{-- CTAs --}}
                    <div style="display:flex;flex-wrap:wrap;gap:0.75rem;margin-top:2rem;">
                        <a href="{{ route('home') }}#jurusan"
                           id="btn-back-to-beranda"
                           style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.625rem 1.25rem;border-radius:0.75rem;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.25);color:#fff;font-size:0.875rem;font-weight:500;text-decoration:none;transition:all 0.2s;"
                           onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                            <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('experience.3d') }}"
                           id="btn-open-3d"
                           class="btn-edu-primary"
                           style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.625rem 1.25rem;font-size:0.875rem;">
                            <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Buka Buku 3D
                        </a>
                    </div>
                </div>

                {{-- RIGHT: Stats --}}
                <div class="hero-stat-card">
                    <p style="color:rgba(255,255,255,0.45);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:1rem;">Statistik Jurusan</p>
                    <div class="stat-row">
                        <span style="color:rgba(255,255,255,0.65);font-size:0.875rem;">Tugas Akhir Aktif</span>
                        <span style="color:#fff;font-weight:700;font-size:1.5rem;">{{ $jurusan->tugas_akhirs_count ?? 0 }}</span>
                    </div>
                    <div class="stat-row">
                        <span style="color:rgba(255,255,255,0.65);font-size:0.875rem;">Mata Pelajaran</span>
                        <span style="color:#fff;font-weight:700;font-size:1.5rem;">{{ count($jurusan->kurikulum ?? []) }}</span>
                    </div>
                    <div class="stat-row">
                        <span style="color:rgba(255,255,255,0.65);font-size:0.875rem;">Prospek Karir</span>
                        <span style="color:#fff;font-weight:700;font-size:1.5rem;">{{ count($jurusan->prospek_karir ?? []) }}</span>
                    </div>
                    <div class="stat-row">
                        <span style="color:rgba(255,255,255,0.65);font-size:0.875rem;">Tools Industri</span>
                        <span style="color:#fff;font-weight:700;font-size:1.5rem;">{{ count($jurusan->tools_industri ?? []) }}</span>
                    </div>
                </div>

            </div>{{-- /detail-hero-grid --}}
        </div>
    </section>

    {{-- ========== MAIN CONTENT ========== --}}
    <section class="detail-content-enter" style="max-width:80rem;margin:0 auto;padding:4rem 1rem;">
        <div class="detail-content-grid">

            {{-- LEFT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:2rem;">

                {{-- Kurikulum --}}
                @if($jurusan->kurikulum && count($jurusan->kurikulum) > 0)
                <div class="detail-section-card" id="section-kurikulum">
                    <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.5rem;">
                        <div style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:#fff3e6;color:#ff6b00;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:1.25rem;height:1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <h2 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Kurikulum &amp; Mata Pelajaran</h2>
                            <p style="font-size:0.75rem;color:#64748b;margin:0.25rem 0 0;">Kompetensi yang dipelajari selama 3 tahun</p>
                        </div>
                    </div>
                    <div class="kurikulum-grid">
                        @foreach($jurusan->kurikulum as $index => $mapel)
                        <div class="mapel-item">
                            <span style="flex-shrink:0;width:1.5rem;height:1.5rem;border-radius:0.375rem;background:rgba(255,107,0,0.12);color:#ff6b00;font-size:0.7rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin-top:0.1rem;">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span style="font-size:0.8125rem;color:#334155;line-height:1.45;">{{ $mapel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Tools Industri --}}
                @if($jurusan->tools_industri && count($jurusan->tools_industri) > 0)
                <div class="detail-section-card" id="section-tools">
                    <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.5rem;">
                        <div style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:1.25rem;height:1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h2 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Tools &amp; Teknologi Industri</h2>
                            <p style="font-size:0.75rem;color:#64748b;margin:0.25rem 0 0;">Software dan platform yang digunakan di dunia kerja</p>
                        </div>
                    </div>
                    <div class="tools-wrap">
                        @foreach($jurusan->tools_industri as $tool)
                        <span class="tool-chip">
                            <svg style="width:0.75rem;height:0.75rem;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ $tool }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>{{-- /left column --}}

            {{-- RIGHT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;">

                {{-- Prospek Karir --}}
                @if($jurusan->prospek_karir && count($jurusan->prospek_karir) > 0)
                <div class="detail-section-card" id="section-karir">
                    <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.25rem;">
                        <div style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:1.25rem;height:1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h2 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Prospek Karir</h2>
                            <p style="font-size:0.75rem;color:#64748b;margin:0.25rem 0 0;">Peluang karir lulusan</p>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;">
                        @foreach($jurusan->prospek_karir as $karir)
                        <div class="career-card">
                            <div style="flex-shrink:0;width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center;">
                                <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span style="font-size:0.8125rem;color:#334155;line-height:1.45;">{{ $karir }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Other Jurusans --}}
                @if($otherJurusans->isNotEmpty())
                <div class="detail-section-card" id="section-other-jurusans">
                    <h3 style="font-size:0.9375rem;font-weight:700;color:#0F172A;margin:0 0 1rem;">Jurusan Lainnya</h3>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;">
                        @foreach($otherJurusans as $other)
                        <a href="{{ route('jurusan.detail', $other->slug) }}"
                           class="other-jurusan-link jurusan-nav-link"
                           data-slug="{{ $other->slug }}">
                            <span class="kode-badge" style="background: {{ $other->accentRgba(0.12) }}; color: {{ $other->accent_color }};">{{ $other->kode }}</span>
                            <span class="link-name">{{ $other->name }}</span>
                            <svg style="width:1rem;height:1rem;color:#cbd5e1;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Login CTA (guest only) --}}
                @guest
                <div style="background:linear-gradient(135deg,#0F2B5C,#1A3D7C);border-radius:1rem;padding:1.5rem;text-align:center;color:#fff;">
                    <svg style="width:2.5rem;height:2.5rem;margin:0 auto 0.75rem;color:#ff6b00;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <p style="font-weight:700;font-size:0.875rem;margin:0 0 0.25rem;">Pantau Tugas Akhir</p>
                    <p style="color:rgba(255,255,255,0.6);font-size:0.75rem;margin:0 0 1rem;line-height:1.5;">Login untuk mengakses sistem monitoring tugas akhir siswa</p>
                    <a href="{{ route('login') }}" class="btn-edu-primary" style="font-size:0.75rem;padding:0.5rem 1.25rem;display:inline-block;">
                        Masuk Sekarang
                    </a>
                </div>
                @endguest

            </div>{{-- /right column --}}
        </div>{{-- /detail-content-grid --}}
    </section>

</x-education-layout>
