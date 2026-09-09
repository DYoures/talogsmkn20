<x-futuristic-layout>
    <x-slot name="title">{{ $jurusan->name }} — Cyber Core SMKN 20</x-slot>

    @php
        $cyber = [
            'color'  => $jurusan->accent_color,
            'glow'   => $jurusan->accentRgba(0.25),
            'border' => $jurusan->accentRgba(0.4),
        ];
    @endphp

    <style>
        /* Cyber entry animations */
        .cyber-enter { animation: cyberIn 0.5s cubic-bezier(0.22,1,0.36,1) both; }
        .cyber-content-enter { animation: cyberContentIn 0.65s cubic-bezier(0.22,1,0.36,1) 0.1s both; }
        @keyframes cyberIn { from{opacity:0;transform:translateY(-20px);filter:blur(4px)} to{opacity:1;transform:translateY(0);filter:blur(0)} }
        @keyframes cyberContentIn { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }

        /* Cyber card container */
        .cyber-card {
            background: rgba(5,8,20,0.75);
            border: 1px solid rgba(6,182,212,0.2);
            border-radius: 0.875rem;
            padding: 1.75rem;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        .cyber-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg,transparent,rgba(6,182,212,0.45),transparent);
        }

        /* Cyber layout grids */
        .cyber-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }
        @media (min-width: 1024px) {
            .cyber-hero-grid { grid-template-columns: 2fr 1fr; align-items: start; }
        }

        .cyber-content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        @media (min-width: 1024px) {
            .cyber-content-grid { grid-template-columns: 1fr 360px; align-items: start; }
        }

        .cyber-mapel-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
        @media (min-width: 580px) {
            .cyber-mapel-grid { grid-template-columns: 1fr 1fr; }
        }

        /* Cyber module item */
        .cyber-mapel-item {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(139,92,246,0.15);
            background: rgba(139,92,246,0.04);
            font-size: 0.8rem;
            color: #94a3b8;
            transition: all 0.2s ease;
        }
        .cyber-mapel-item:hover {
            border-color: rgba(139,92,246,0.4);
            background: rgba(139,92,246,0.1);
            color: #e2e8f0;
        }

        /* Cyber tool chip */
        .cyber-tool-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.7rem;
            border-radius: 0.35rem;
            background: rgba(6,182,212,0.07);
            border: 1px solid rgba(6,182,212,0.22);
            color: #67e8f9;
            font-size: 0.7rem;
            font-weight: 600;
            font-family: monospace;
            letter-spacing: 0.03em;
            transition: all 0.2s ease;
        }
        .cyber-tool-chip:hover {
            background: rgba(6,182,212,0.15);
            box-shadow: 0 0 8px rgba(6,182,212,0.2);
        }

        /* Cyber career item */
        .cyber-career-item {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(6,182,212,0.1);
            background: rgba(6,182,212,0.03);
            font-size: 0.8rem;
            color: #94a3b8;
            transition: all 0.2s ease;
        }
        .cyber-career-item:hover {
            border-color: rgba(6,182,212,0.35);
            background: rgba(6,182,212,0.08);
            color: #e2e8f0;
        }

        /* Cyber other link */
        .cyber-other-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(6,182,212,0.1);
            background: rgba(6,182,212,0.02);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .cyber-other-link:hover {
            border-color: rgba(6,182,212,0.35);
            background: rgba(6,182,212,0.07);
        }

        /* Stat grid in hero */
        .cyber-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }
        .cyber-stat-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border-radius: 0.625rem;
            background: rgba(6,182,212,0.05);
            border: 1px solid rgba(6,182,212,0.15);
        }

        /* Breadcrumb */
        .cyber-breadcrumb { display: flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-family: monospace; color: #4b5563; margin-bottom: 2rem; }
        .cyber-breadcrumb a { color: #4b5563; text-decoration: none; transition: color 0.2s; }
        .cyber-breadcrumb a:hover { color: #22d3ee; }

        .tools-wrap { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    </style>

    {{-- ========== HERO ========== --}}
    <section class="cyber-enter" style="position:relative;overflow:hidden;padding:4rem 0 5rem;border-bottom:1px solid rgba(6,182,212,0.1);">
        <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:700px;height:300px;background:radial-gradient(ellipse at center,{{ $cyber['glow'] }},transparent 70%);pointer-events:none;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="position:relative;z-index:1;">
            {{-- Breadcrumb --}}
            <nav class="cyber-breadcrumb">
                <a href="{{ route('home') }}">~/beranda</a>
                <span>/</span>
                <a href="{{ route('home') }}#jurusan">jurusan</a>
                <span>/</span>
                <span style="color:{{ $cyber['color'] }};">{{ strtolower($jurusan->kode ?? '??') }}</span>
            </nav>

            <div class="cyber-hero-grid">
                {{-- LEFT --}}
                <div data-shared-id="jurusan-{{ $jurusan->id }}">
                    {{-- Kode badge + status --}}
                    <div style="display:flex;align-items:center;gap:0.875rem;flex-wrap:wrap;margin-bottom:1.5rem;">
                        <span style="font-family:monospace;font-weight:700;font-size:1.1rem;padding:0.625rem 1.125rem;border-radius:0.5rem;color:{{ $cyber['color'] }};border:1px solid {{ $cyber['border'] }};background:rgba(0,0,0,0.4);text-shadow:0 0 12px {{ $cyber['glow'] }};letter-spacing:0.05em;">
                            [{{ $jurusan->kode ?? '??' }}]
                        </span>
                        <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.35rem 0.85rem;border-radius:9999px;background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.25);color:#34d399;font-size:0.7rem;font-family:monospace;">
                            <span style="width:0.5rem;height:0.5rem;border-radius:50%;background:#34d399;animation:ping 1.5s infinite;"></span>
                            AKREDITASI {{ $jurusan->akreditasi ?? 'A' }} // AKTIF
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 style="font-family:monospace;font-size:clamp(1.5rem,3.5vw,2.75rem);font-weight:800;color:#fff;line-height:1.2;letter-spacing:-0.01em;margin-bottom:1rem;">
                        <span style="color:{{ $cyber['color'] }};">&gt;</span> {{ $jurusan->name }}
                    </h1>

                    <p style="color:#9ca3af;font-size:0.9375rem;line-height:1.65;max-width:36rem;">
                        {{ $jurusan->description }}
                    </p>

                    {{-- CTAs --}}
                    <div style="display:flex;flex-wrap:wrap;gap:0.75rem;margin-top:2rem;">
                        <a href="{{ route('home') }}#jurusan"
                           id="btn-back-cyber"
                           class="btn-cyber-outline"
                           style="display:inline-flex;align-items:center;gap:0.5rem;font-size:0.875rem;padding:0.625rem 1.25rem;">
                            <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali
                        </a>
                        <a href="{{ route('experience.futuristic-3d') }}"
                           id="btn-open-cyber-3d"
                           class="btn-cyber-primary"
                           style="display:inline-flex;align-items:center;gap:0.5rem;font-size:0.875rem;padding:0.625rem 1.25rem;">
                            <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5"/></svg>
                            Buka Cyber 3D
                        </a>
                    </div>
                </div>

                {{-- RIGHT: Stats --}}
                <div class="cyber-card">
                    <p style="color:rgba(6,182,212,0.5);font-size:0.65rem;font-family:monospace;letter-spacing:0.12em;margin-bottom:1rem;">// STATISTIK_NODE</p>
                    <div class="cyber-stats-grid">
                        <div class="cyber-stat-box">
                            <p style="font-family:monospace;font-weight:700;font-size:1.75rem;color:#fff;margin:0;">{{ $jurusan->tugas_akhirs_count ?? 0 }}</p>
                            <p style="font-family:monospace;font-size:0.65rem;color:#4b5563;margin:0.25rem 0 0;letter-spacing:0.08em;">TASKS</p>
                        </div>
                        <div class="cyber-stat-box">
                            <p style="font-family:monospace;font-weight:700;font-size:1.75rem;color:#fff;margin:0;">{{ count($jurusan->kurikulum ?? []) }}</p>
                            <p style="font-family:monospace;font-size:0.65rem;color:#4b5563;margin:0.25rem 0 0;letter-spacing:0.08em;">MODULES</p>
                        </div>
                        <div class="cyber-stat-box">
                            <p style="font-family:monospace;font-weight:700;font-size:1.75rem;color:#fff;margin:0;">{{ count($jurusan->prospek_karir ?? []) }}</p>
                            <p style="font-family:monospace;font-size:0.65rem;color:#4b5563;margin:0.25rem 0 0;letter-spacing:0.08em;">CAREERS</p>
                        </div>
                        <div class="cyber-stat-box">
                            <p style="font-family:monospace;font-weight:700;font-size:1.75rem;color:#fff;margin:0;">{{ count($jurusan->tools_industri ?? []) }}</p>
                            <p style="font-family:monospace;font-size:0.65rem;color:#4b5563;margin:0.25rem 0 0;letter-spacing:0.08em;">TOOLS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== MAIN CONTENT ========== --}}
    <section class="cyber-content-enter" style="max-width:80rem;margin:0 auto;padding:3.5rem 1rem;">
        <div class="cyber-content-grid">

            {{-- LEFT --}}
            <div style="display:flex;flex-direction:column;gap:2rem;">

                {{-- Kurikulum --}}
                @if($jurusan->kurikulum && count($jurusan->kurikulum) > 0)
                <div class="cyber-card">
                    <p style="color:rgba(139,92,246,0.5);font-size:0.65rem;font-family:monospace;letter-spacing:0.12em;margin-bottom:1rem;">// MODUL_KURIKULUM</p>
                    <h2 style="font-family:monospace;font-size:0.9375rem;font-weight:700;color:#e2e8f0;margin:0 0 1.25rem;">
                        <span style="color:#a78bfa;">&gt;</span> Kurikulum &amp; Mata Pelajaran
                    </h2>
                    <div class="cyber-mapel-grid">
                        @foreach($jurusan->kurikulum as $index => $mapel)
                        <div class="cyber-mapel-item">
                            <span style="color:#a78bfa;font-family:monospace;font-size:0.7rem;flex-shrink:0;margin-top:0.1rem;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ $mapel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Tools --}}
                @if($jurusan->tools_industri && count($jurusan->tools_industri) > 0)
                <div class="cyber-card">
                    <p style="color:rgba(6,182,212,0.5);font-size:0.65rem;font-family:monospace;letter-spacing:0.12em;margin-bottom:1rem;">// TECH_STACK</p>
                    <h2 style="font-family:monospace;font-size:0.9375rem;font-weight:700;color:#e2e8f0;margin:0 0 1.25rem;">
                        <span style="color:#22d3ee;">&gt;</span> Tools &amp; Teknologi Industri
                    </h2>
                    <div class="tools-wrap">
                        @foreach($jurusan->tools_industri as $tool)
                        <span class="cyber-tool-chip"><span style="color:#0891b2;">$</span> {{ $tool }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- RIGHT --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;">

                {{-- Karir --}}
                @if($jurusan->prospek_karir && count($jurusan->prospek_karir) > 0)
                <div class="cyber-card">
                    <p style="color:rgba(52,211,153,0.5);font-size:0.65rem;font-family:monospace;letter-spacing:0.12em;margin-bottom:1rem;">// CAREER_NODES</p>
                    <h2 style="font-family:monospace;font-size:0.875rem;font-weight:700;color:#e2e8f0;margin:0 0 1rem;">
                        <span style="color:#34d399;">&gt;</span> Prospek Karir
                    </h2>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;">
                        @foreach($jurusan->prospek_karir as $karir)
                        <div class="cyber-career-item">
                            <span style="color:#34d399;font-size:0.875rem;flex-shrink:0;margin-top:0.05rem;">▹</span>
                            <span>{{ $karir }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Other Jurusans --}}
                @if($otherJurusans->isNotEmpty())
                <div class="cyber-card">
                    <p style="color:rgba(6,182,212,0.5);font-size:0.65rem;font-family:monospace;letter-spacing:0.12em;margin-bottom:1rem;">// OTHER_NODES</p>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;">
                        @foreach($otherJurusans as $other)
                        <a href="{{ route('jurusan.detail', $other->slug) }}"
                           class="cyber-other-link jurusan-nav-link"
                           data-slug="{{ $other->slug }}">
                            <span style="color:{{ $other->accent_color }};font-family:monospace;font-size:0.7rem;width:3rem;flex-shrink:0;">[{{ $other->kode }}]</span>
                            <span style="color:#6b7280;font-family:monospace;font-size:0.75rem;flex:1;">{{ $other->name }}</span>
                            <svg style="width:0.875rem;height:0.875rem;color:rgba(6,182,212,0.4);flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                @guest
                <div class="cyber-card" style="text-align:center;">
                    <p style="color:#22d3ee;font-family:monospace;font-size:0.7rem;letter-spacing:0.1em;margin:0 0 0.5rem;">// ACCESS_REQUIRED</p>
                    <p style="color:#6b7280;font-size:0.75rem;margin:0 0 1rem;line-height:1.5;">Autentikasi diperlukan untuk mengakses sistem monitoring</p>
                    <a href="{{ route('login') }}" class="btn-cyber-primary" style="font-size:0.75rem;padding:0.5rem 1.25rem;display:inline-block;font-family:monospace;">
                        AUTHENTICATE →
                    </a>
                </div>
                @endguest
            </div>

        </div>
    </section>
</x-futuristic-layout>
