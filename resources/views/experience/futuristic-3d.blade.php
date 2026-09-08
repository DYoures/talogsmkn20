<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TALOG20 — Pengalaman 3D Cyber WebGL</title>

    {{-- Typography --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @include('partials.transition-head')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/futuristic-3d.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            overflow: hidden;
            background: #050814;
            font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #ffffff;
            user-select: none;
        }
        #cyber-canvas { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; }

        /* HUD overlay */
        #cyber-hud {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 20;
            opacity: 0;
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Top Bar */
        .hud-top {
            position: fixed;
            top: 24px; left: 24px; right: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            pointer-events: auto;
        }

        /* Brand */
        .cyber-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(10, 16, 38, 0.75);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(0, 240, 255, 0.28);
            border-radius: 14px;
            padding: 8px 18px;
            box-shadow: 0 0 24px rgba(0, 240, 255, 0.12);
        }
        .cyber-brand img { height: 42px; width: auto; filter: drop-shadow(0 0 10px rgba(0,240,255,0.7)); }
        .cyber-brand .brand-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.04em;
            font-family: 'Space Grotesk', sans-serif;
        }
        .cyber-brand .brand-sub {
            color: #00F0FF;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.1em;
        }

        /* Telemetry status badge */
        .telemetry-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: #00FF88;
            background: rgba(0, 255, 136, 0.1);
            border: 1px solid rgba(0, 255, 136, 0.3);
            padding: 7px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.1);
        }
        .telemetry-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #00FF88;
            box-shadow: 0 0 10px #00FF88;
            animation: pulseDot 1.5s infinite;
        }
        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.8); }
        }

        /* Majors floating telemetry stream (Left Side) */
        /* Majors floating telemetry stream (Left Side) */
        .majors-stream-wrapper {
            position: fixed;
            left: 28px;
            top: 88px;
            bottom: 96px;
            width: 256px;
            z-index: 25;
            pointer-events: none; /* Allow through to canvas except on actual elements */
        }

        .majors-stream {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 9px;
            pointer-events: auto;
            overflow-y: auto;
            overflow-x: hidden !important; /* Strictly disable horizontal scroll */
            padding: 2px 4px 2px 2px;
            /* Hide scrollbar visually */
            scrollbar-width: none;
        }
        .majors-stream::-webkit-scrollbar { display: none; }

        /* Scroll hint: bottom fade gradient overlay */
        .majors-stream-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 72px;
            background: linear-gradient(to bottom, transparent 0%, rgba(4, 10, 18, 0.92) 100%);
            pointer-events: none;
            border-radius: 0 0 8px 8px;
        }
        /* Scroll arrow indicator */
        .majors-stream-wrapper::before {
            content: '⌄';
            position: absolute;
            bottom: 6px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(0, 240, 255, 0.6);
            font-size: 18px;
            line-height: 1;
            pointer-events: none;
            z-index: 2;
            animation: bounceDown 1.8s ease-in-out infinite;
        }
        @keyframes bounceDown {
            0%, 100% { transform: translateX(-50%) translateY(0); opacity: 0.6; }
            50% { transform: translateX(-50%) translateY(3px); opacity: 1; }
        }

        .stream-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: rgba(0, 240, 255, 0.85);
            letter-spacing: 0.08em;
            padding: 4px 6px;
            margin-bottom: 2px;
        }
        .stream-header-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #00F0FF;
            box-shadow: 0 0 8px #00F0FF;
            animation: pulseDot 2s infinite;
        }

        .stream-card {
            background: rgba(8, 14, 34, 0.82);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 240, 255, 0.18);
            border-left: 3.5px solid var(--card-accent, #00F0FF);
            border-radius: 4px 10px 10px 4px;
            padding: 10px 13px;
            position: relative;
            transition: all 0.22s cubic-bezier(0.2, 0.9, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            flex-shrink: 0;
            width: 100%;
            box-sizing: border-box;
        }
        .stream-card:hover,
        .stream-card.is-active {
            transform: translateX(6px); /* Smooth slide to the right away from viewport edge */
            background: rgba(12, 22, 50, 0.94);
            border-color: var(--card-accent, #00F0FF);
            box-shadow: 0 0 24px rgba(0, 240, 255, 0.22), 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .stream-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
        }
        .stream-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 4px;
            border: 1px solid;
            letter-spacing: 0.05em;
        }
        .stream-tasks {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.6);
        }
        .stream-name {
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.35;
            transition: color 0.2s ease;
        }
        .stream-card:hover .stream-name,
        .stream-card.is-active .stream-name {
            color: var(--card-accent, #00F0FF);
        }
        .stream-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }

        /* Hover Flyout Drawer / Floating Telemetry Card (Right Side HUD, outside 3D orbit) */
        .cyber-flyout-drawer {
            position: fixed;
            right: 28px;
            top: 50%;
            left: auto;
            width: 305px;
            max-width: calc(100vw - 56px);
            background: rgba(6, 12, 28, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-accent, #00F0FF);
            border-right: 3.5px solid var(--card-accent, #00F0FF);
            border-radius: 12px 4px 4px 12px;
            padding: 16px 16px 14px 16px;
            box-shadow: 0 0 35px rgba(0, 240, 255, 0.18), 0 16px 36px rgba(0, 0, 0, 0.75);
            opacity: 0;
            pointer-events: none;
            transform: translateY(-50%) translateX(20px);
            transition: opacity 0.26s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.26s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.26s ease,
                        box-shadow 0.26s ease;
            z-index: 50;
            overflow: hidden; /* contain progress bar */
        }
        .cyber-flyout-drawer.active {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(-50%) translateX(0);
        }

        /* Grace period progress bar — thin neon line at bottom */
        .drawer-grace-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2.5px;
            background: var(--card-accent, #00F0FF);
            box-shadow: 0 0 8px var(--card-accent, #00F0FF), 0 0 20px var(--card-accent, #00F0FF);
            transform-origin: left center;
            transform: scaleX(1);
            opacity: 0;
            pointer-events: none;
            /* No CSS transition here — controlled purely by JS/GSAP for precision */
        }
        .drawer-grace-bar.is-draining {
            opacity: 1;
        }

        .drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            font-family: 'JetBrains Mono', monospace;
            border-bottom: 1px solid rgba(0, 240, 255, 0.2);
            padding-bottom: 8px;
            margin-bottom: 9px;
            flex-wrap: wrap;
        }
        .drawer-title {
            color: var(--card-accent, #00F0FF);
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: 0.05em;
            white-space: nowrap;
            min-width: 0;
        }
        .drawer-badge {
            color: #00FF88;
            background: rgba(0, 255, 136, 0.12);
            border: 1px solid rgba(0, 255, 136, 0.25);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8.5px;
            font-weight: 700;
            letter-spacing: 0.03em;
            white-space: nowrap;
            flex-shrink: 0;
            max-width: 100%;
        }
        .drawer-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.35;
            margin-bottom: 8px;
        }
        .drawer-desc {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 12px;
        }
        .drawer-tools {
            margin-bottom: 13px;
        }
        .drawer-tools-label {
            display: block;
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            color: rgba(0, 240, 255, 0.75);
            margin-bottom: 6px;
            letter-spacing: 0.08em;
        }
        .drawer-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 4.5px;
            align-items: center;
        }
        .drawer-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9.5px;
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 4px;
            padding: 2.5px 7px;
            white-space: nowrap;
            max-width: 100%;
        }
        .drawer-tag-extra {
            color: var(--card-accent, #00F0FF);
            background: rgba(0, 240, 255, 0.1);
            border-color: rgba(0, 240, 255, 0.3);
            font-weight: 800;
        }
        .drawer-action {
            display: block;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 10px;
        }
        .drawer-link {
            width: 100%;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--card-accent, #00F0FF);
            background: rgba(0, 240, 255, 0.06);
            border: 1px solid rgba(0, 240, 255, 0.22);
            border-radius: 6px;
            padding: 7px 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            letter-spacing: 0.06em;
            transition: all 0.2s ease;
        }
        .drawer-link:hover {
            background: var(--card-accent, #00F0FF);
            color: #050814;
            box-shadow: 0 0 18px var(--card-accent, #00F0FF);
        }
        .drawer-arrow {
            transition: transform 0.2s ease;
        }
        .drawer-link:hover .drawer-arrow {
            transform: translateX(3px);
        }

        /* Bottom CTA */
        .bottom-actions {
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            pointer-events: auto;
            z-index: 25;
        }
        .cyber-hint {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: rgba(0, 240, 255, 0.85);
            letter-spacing: 0.18em;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(0, 240, 255, 0.5);
        }

        @media (max-width: 900px) {
            .majors-stream-wrapper { display: none; }
            .cyber-brand { padding: 6px 12px; }
            .cyber-brand img { height: 32px; }
            .telemetry-tag { display: none; }
        }
    </style>
</head>
<body class="crt-scanlines">
    <canvas id="cyber-canvas"></canvas>

    <div id="cyber-hud">
        {{-- Top Bar --}}
        <div class="hud-top">
            <div class="cyber-brand">
                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="SMKN 20">
                <div>
                    <p class="brand-title">TALOG20 DIGITAL</p>
                    <p class="brand-sub">// SMKN 20 EXPERIMENTAL WEBGL</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="telemetry-tag">
                    <span class="telemetry-dot"></span>
                    <span>ORBIT: STABLE // SYS: ONLINE</span>
                </div>

                <a href="{{ route('home') }}" class="btn-cyber-outline text-xs py-2 px-4 rounded-full">
                    Lewati &rarr;
                </a>
            </div>
        </div>

        {{-- Left Majors Telemetry Stream (Database-Driven) --}}
        <div class="majors-stream-wrapper">
        <div class="majors-stream" id="majors-stream">
            <div class="stream-header">
                <span class="stream-header-dot"></span>
                <span class="stream-header-title">// MATRIX KEAHLIAN [{{ count($jurusans ?? []) }} NODES]</span>
            </div>

            @php
                $jurusanList = $jurusans ?? collect();
            @endphp
            @foreach($jurusanList as $j)
                @php
                    $colors = [
                        'color'  => $j->accent_color,
                        'bg'     => $j->accentRgba(0.14),
                        'border' => $j->accentRgba(0.45),
                    ];
                @endphp
                <div class="stream-card group"
                     data-kode="{{ $j->kode }}"
                     data-name="{{ $j->name }}"
                     data-title="DATA KONSENTRASI: {{ $j->kode }}"
                     data-badge="TERAKREDITASI {{ $j->akreditasi ?? 'A' }}"
                     data-desc="{{ $j->description ?? 'Kompetensi keahlian unggulan berstandar industri teknologi tinggi.' }}"
                     data-tools="{{ json_encode(array_values(array_slice($j->tools_industri ?? [], 0, 3))) }}"
                     data-tools-extra="{{ count($j->tools_industri ?? []) > 3 ? '+'.(count($j->tools_industri) - 3) : '' }}"
                     data-link="{{ route('jurusan.detail', $j->slug) }}"
                     data-color="{{ $colors['color'] }}"
                     style="--card-accent: {{ $colors['color'] }};">
                    <div class="stream-card-main">
                        <div class="stream-card-top">
                            <span class="stream-code" style="color: {{ $colors['color'] }}; background: {{ $colors['bg'] }}; border-color: {{ $colors['border'] }};">
                                [ {{ $j->kode }} // 0{{ $loop->iteration }} ]
                            </span>
                            <span class="stream-tasks">{{ $j->tugas_akhirs_count ?? 0 }} Proyek</span>
                        </div>
                        <h4 class="stream-name">{{ $j->name }}</h4>
                        <div class="stream-meta">
                            <span>Akreditasi {{ $j->akreditasi ?? 'A' }}</span>
                            <span>•</span>
                            <span>{{ count($j->kurikulum ?? []) }} Mapel</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>{{-- /majors-stream-wrapper --}}

        {{-- Standalone Floating Telemetry Flyout Drawer (Docked to right side, outside 3D orbit) --}}
        <div id="cyber-flyout-drawer" class="cyber-flyout-drawer stream-drawer">
            <div class="drawer-grace-bar" id="drawer-grace-bar"></div>
            <div class="drawer-header">
                <span class="drawer-title flyout-title">// KONSENTRASI: RPL</span>
                <span class="drawer-badge flyout-badge">TERAKREDITASI A</span>
            </div>
            <h4 class="drawer-name flyout-name">Rekayasa Perangkat Lunak</h4>
            <p class="drawer-desc flyout-desc">Kompetensi keahlian unggulan berstandar industri teknologi tinggi.</p>
            <div class="drawer-tools flyout-tools-wrapper">
                <span class="drawer-tools-label">// STACK INDUSTRI:</span>
                <div class="drawer-tags flyout-tags">
                    <span class="drawer-tag">VS Code</span>
                    <span class="drawer-tag">Git & GitHub</span>
                    <span class="drawer-tag">Laravel</span>
                    <span class="drawer-tag drawer-tag-extra">+6</span>
                </div>
            </div>
            <div class="drawer-action">
                <a href="#" class="drawer-link flyout-link">
                    <span>BUKA DETAIL JURUSAN</span>
                    <span class="drawer-arrow">&rarr;</span>
                </a>
            </div>
        </div>

        {{-- Bottom CTA --}}
        <div class="bottom-actions">
            <span class="cyber-hint">[ GERBANG DIGITAL AKTIF ]</span>
            <a id="btn-beranda-cyber" href="{{ route('home') }}" class="btn-cyber-primary text-sm px-8 py-4">
                <svg class="w-5 h-5 text-[#050814]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Masuk ke Beranda Cyber</span>
            </a>
        </div>
    </div>

    @include('partials.transition-overlay', ['transitionTheme' => 'futuristic'])

    <script>
    window.TALOG20_DATA = {
        jurusans: @json($jurusans ?? []),
        logoUrl: "{{ asset('images/logo-smkn20.webp') }}",
        berandaUrl: "{{ route('home') }}",
    };
    </script>
</body>
</html>
