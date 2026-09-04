<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TALOG20 — Pengalaman 3D Cyber WebGL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/futuristic-3d.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { overflow: hidden; background: #050814; font-family: 'Space Grotesk', sans-serif; }
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
            background: rgba(10, 15, 36, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 240, 255, 0.3);
            border-radius: 14px;
            padding: 8px 18px;
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.15);
        }
        .cyber-brand img { height: 42px; width: auto; filter: drop-shadow(0 0 8px rgba(0,240,255,0.6)); }
        .cyber-brand .brand-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.04em;
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
            padding: 6px 14px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
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

        /* Majors floating telemetry stream */
        .majors-stream {
            position: fixed;
            left: 24px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: auto;
            max-width: 280px;
        }
        .stream-card {
            background: rgba(10, 15, 36, 0.65);
            backdrop-filter: blur(12px);
            border-left: 3px solid #00F0FF;
            border-top: 1px solid rgba(0, 240, 255, 0.15);
            border-bottom: 1px solid rgba(0, 240, 255, 0.15);
            border-right: 1px solid rgba(0, 240, 255, 0.15);
            border-radius: 0 10px 10px 0;
            padding: 10px 14px;
            transition: all 0.3s ease;
        }
        .stream-card:hover {
            border-left-color: #B026FF;
            background: rgba(176, 38, 255, 0.15);
            transform: translateX(6px);
        }
        .stream-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            color: #00F0FF;
        }
        .stream-name {
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            margin-top: 2px;
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
        }
        .cyber-hint {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: rgba(0, 240, 255, 0.7);
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        /* Warp speed transition overlay */
        #cyber-warp-overlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle, #00F0FF 0%, #B026FF 40%, #050814 100%);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 9999;
        }
        #cyber-warp-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        @media (max-width: 768px) {
            .majors-stream { display: none; }
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

        {{-- Left Majors Telemetry Stream --}}
        <div class="majors-stream">
            @php
                $jurusanList = $jurusans ?? collect();
            @endphp
            @foreach($jurusanList->take(4) as $j)
                <div class="stream-card">
                    <span class="stream-code">[{{ $j->kode }}]</span>
                    <p class="stream-name">{{ $j->nama }}</p>
                </div>
            @endforeach
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

    <div id="cyber-warp-overlay"></div>

    <script>
    window.TALOG20_DATA = {
        jurusans: @json($jurusans ?? []),
        logoUrl: "{{ asset('images/logo-smkn20.webp') }}",
        berandaUrl: "{{ route('home') }}",
    };
    </script>
</body>
</html>
