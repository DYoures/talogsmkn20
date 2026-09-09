<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TALOG20 — Pengalaman 3D Buku</title>
    @include('partials.transition-head')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/education-book.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { overflow: hidden; background: #091E42; }
        #book-canvas { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; }

        /* HUD overlay */
        #hud {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 10;
        }

        /* Top left branding */
        #brand-badge {
            position: fixed;
            top: 24px; left: 24px;
            display: flex; align-items: center; gap: 12px;
            pointer-events: auto;
            opacity: 0;
            transition: opacity 0.8s ease;
        }
        #brand-badge img { height: 48px; width: auto; filter: drop-shadow(0 0 12px rgba(255,107,0,0.5)); }
        #brand-badge .brand-text { color: white; }
        #brand-badge .brand-text p:first-child { font-size: 14px; font-weight: 700; letter-spacing: 0.05em; }
        #brand-badge .brand-text p:last-child { font-size: 11px; color: rgba(255,255,255,0.6); }

        /* Bottom CTA */
        #bottom-cta {
            position: fixed;
            bottom: 48px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            pointer-events: auto;
            opacity: 0;
            transition: opacity 1s ease;
        }
        #cta-hint {
            color: rgba(255,255,255,0.5);
            font-size: 12px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            animation: pulseText 2s ease-in-out infinite;
        }
        @keyframes pulseText {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* Beranda button */
        #btn-beranda {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 36px;
            background: linear-gradient(135deg, #FF6B00, #E55F00);
            color: white;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            letter-spacing: 0.04em;
            box-shadow: 0 8px 32px rgba(255,107,0,0.4), 0 2px 8px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        #btn-beranda:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 12px 40px rgba(255,107,0,0.55), 0 4px 12px rgba(0,0,0,0.35);
        }
        #btn-beranda svg { width: 18px; height: 18px; }

        /* Skip button */
        #btn-skip {
            position: fixed;
            top: 24px; right: 24px;
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 18px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.7);
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            pointer-events: auto;
            transition: all 0.3s ease;
            opacity: 0;
        }
        #btn-skip:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        /* Page info panel */
        #page-info {
            position: fixed;
            right: 32px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.8s ease;
        }
        .page-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        .page-dot.active {
            background: #FF6B00;
            width: 8px; height: 24px;
            border-radius: 4px;
            box-shadow: 0 0 8px rgba(255,107,0,0.6);
        }

        /* Jurusan Hover Tooltip (Section 21) - Solid luxury navy, zero backdrop blur lag */
        #jurusan-tooltip {
            position: fixed;
            top: 0;
            left: 0;
            width: 320px;
            max-width: calc(100vw - 32px);
            background: #081A3A;
            border: 1.5px solid rgba(255, 107, 0, 0.65);
            border-radius: 14px;
            padding: 16px 20px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6), 0 0 24px rgba(255, 107, 0, 0.25);
            pointer-events: none;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            will-change: transform, opacity;
            transition: opacity 0.18s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.18s;
            color: white;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        #jurusan-tooltip.visible {
            opacity: 1;
            visibility: visible;
        }
        .tooltip-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .tooltip-badge {
            background: linear-gradient(135deg, #FF6B00, #E55F00);
            color: white;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .tooltip-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.65);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }
        .tooltip-title {
            font-size: 16px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 8px;
            line-height: 1.35;
            font-family: 'Outfit', 'Inter', sans-serif;
        }
        .tooltip-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.55;
            margin-bottom: 12px;
        }
        .tooltip-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
        }
        .tooltip-footer span:last-child {
            color: #FFA500;
            font-weight: 600;
        }

        /* Slide navigation arrows */
        .slide-nav-btn {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            z-index: 50;
            display: none; /* hidden by default, JS shows/hides */
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 107, 0, 0.85);
            border: 2px solid rgba(255, 255, 255, 0.25);
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255, 107, 0, 0.5);
            transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease, opacity 0.3s ease;
            pointer-events: auto;
            opacity: 0;
        }
        .slide-nav-btn.visible {
            display: flex;
            opacity: 1;
        }
        .slide-nav-btn:hover {
            background: #E55F00;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 8px 28px rgba(255, 107, 0, 0.7);
        }
        .slide-nav-btn svg { width: 20px; height: 20px; pointer-events: none; }
        #btn-slide-prev { left: calc(50% - 290px); }
        #btn-slide-next { right: calc(50% - 290px); }

        /* Slide indicator */
        #slide-indicator {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: none;
            align-items: center;
            gap: 6px;
            z-index: 50;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        #slide-indicator.visible {
            display: flex;
            opacity: 1;
        }
        .slide-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
            transition: all 0.3s ease;
        }
        .slide-dot.active {
            background: #FF6B00;
            width: 18px;
            border-radius: 3.5px;
            box-shadow: 0 0 6px rgba(255, 107, 0, 0.6);
        }

        /* Mobile fallback */
        @media (max-width: 640px) {
            #btn-beranda { padding: 12px 28px; font-size: 14px; }
            #brand-badge img { height: 36px; }
            #jurusan-tooltip { width: 280px; padding: 14px 16px; }
            #btn-slide-prev { left: 8px; }
            #btn-slide-next { right: 8px; }
        }
    </style>
</head>
<body>
    <canvas id="book-canvas"></canvas>

    {{-- Jurusan Hover Tooltip (Section 21) --}}
    <div id="jurusan-tooltip">
        <div class="tooltip-header">
            <span class="tooltip-badge" id="tooltip-badge">RPL</span>
            <span class="tooltip-label">Konsentrasi Keahlian</span>
        </div>
        <h3 class="tooltip-title" id="tooltip-title">Rekayasa Perangkat Lunak</h3>
        <p class="tooltip-desc" id="tooltip-desc">Deskripsi jurusan dari database...</p>
        <div class="tooltip-footer">
            <span>SMKN 20 Jakarta</span>
            <span>Program Keahlian &rarr;</span>
        </div>
    </div>

    <div id="hud">
        {{-- Brand top-left --}}
        <div id="brand-badge">
            <img src="{{ asset('images/logo-smkn20.webp') }}" alt="SMKN 20">
            <div class="brand-text">
                <p>SMKN 20 Jakarta</p>
                <p>Tugas Akhir Siswa</p>
            </div>
        </div>

        {{-- Skip button --}}
        <a id="btn-skip" href="{{ route('home') }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Lewati
        </a>

        {{-- Page indicator dots --}}
        <div id="page-info">
            <div class="page-dot active" data-page="0"></div>
            <div class="page-dot" data-page="1"></div>
            <div class="page-dot" data-page="2"></div>
            <div class="page-dot" data-page="3"></div>
        </div>

        {{-- Bottom CTA --}}
        <div id="bottom-cta">
            <span id="cta-hint">Klik buku untuk membuka</span>
            <a id="btn-beranda" href="{{ route('home') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Masuk ke Beranda
            </a>
        </div>
    </div>

    {{-- Slide navigation buttons (shown by JS when jurusans > 4) --}}
    <button id="btn-slide-prev" class="slide-nav-btn" aria-label="Slide sebelumnya">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button id="btn-slide-next" class="slide-nav-btn" aria-label="Slide berikutnya">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    </button>

    {{-- Slide page indicator dots --}}
    <div id="slide-indicator"></div>

    {{-- Pass jurusan data to JS --}}
    <script>
    window.TALOG20_DATA = {
        jurusans: @json($jurusans ?? []),
        logoUrl: "{{ asset('images/logo-smkn20.webp') }}",
        berandaUrl: "{{ route('home') }}",
    };
    </script>

    @stack('scripts')
</body>
</html>
