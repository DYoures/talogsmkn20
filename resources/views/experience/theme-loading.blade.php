<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TALOG20 — Transisi Visual...</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { overflow: hidden; }

        @keyframes warpGlow {
            0% { transform: scale(0.8); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(0.8); opacity: 0.3; }
        }
        .glow-pulse { animation: warpGlow 2s ease-in-out infinite; }

        @keyframes scanMove {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(1000%); }
        }
        .scan-laser { animation: scanMove 1.5s linear infinite; }
    </style>
</head>
<body class="{{ $target === 'futuristic' ? 'bg-[#050814] text-cyan-300 font-mono crt-scanlines' : 'bg-gradient-to-b from-edu-navy to-[#0F2B5C] text-white font-sans' }} flex items-center justify-center min-h-screen">

    @if($target === 'futuristic')
        {{-- CYBER TRANSITION SCREEN --}}
        <div class="text-center px-4 max-w-md relative z-10">
            <div class="relative w-28 h-28 mx-auto mb-8 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-2 border-cyan-400/40 border-dashed animate-spin" style="animation-duration: 6s;"></div>
                <div class="absolute inset-2 rounded-full border-2 border-purple-500/50 animate-ping" style="animation-duration: 2s;"></div>
                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo" class="h-16 w-auto relative z-10 filter drop-shadow-[0_0_12px_rgba(0,240,255,0.8)]">
            </div>

            <p class="text-xs text-cyan-400 tracking-widest uppercase mb-2">// SISTEM BERALIH</p>
            <h2 class="text-2xl font-bold text-white tracking-wider mb-3">MEMUAT FUTURISTIC DIGITAL</h2>
            <p class="text-xs text-gray-400 mb-8">[ Mengkonfigurasi WebGL Core & Matriks Cyber... ]</p>

            {{-- Progress bar cyber --}}
            <div class="w-64 mx-auto h-1.5 bg-black/60 rounded-full overflow-hidden border border-cyan-500/30">
                <div id="pBar" class="h-full bg-gradient-to-r from-cyan-400 via-purple-500 to-emerald-400 transition-all duration-200" style="width: 0%"></div>
            </div>
            <p id="pText" class="text-[11px] text-cyan-400/70 mt-3 font-mono">0%</p>
        </div>
    @else
        {{-- EDUCATION TRANSITION SCREEN --}}
        <div class="text-center px-4 max-w-md relative z-10">
            <div class="relative w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full bg-edu-orange/20 blur-xl glow-pulse"></div>
                <img src="{{ asset('images/logo-smkn20.webp') }}" alt="Logo" class="h-16 w-auto relative z-10 filter drop-shadow-[0_0_15px_rgba(255,107,0,0.6)]">
            </div>

            <p class="text-xs text-edu-orange font-bold tracking-widest uppercase mb-2">Transisi Tema</p>
            <h2 class="text-2xl font-bold text-white tracking-wide mb-3">Memuat Tema Education</h2>
            <p class="text-xs text-white/70 mb-8">Menyiapkan atmosfer akademik & ruang belajar...</p>

            {{-- Progress bar education --}}
            <div class="w-64 mx-auto h-1.5 bg-white/10 rounded-full overflow-hidden">
                <div id="pBar" class="h-full bg-gradient-to-r from-edu-orange to-amber-300 transition-all duration-200" style="width: 0%"></div>
            </div>
            <p id="pText" class="text-xs text-white/60 mt-3">0%</p>
        </div>
    @endif

    <script>
    (function() {
        const bar = document.getElementById('pBar');
        const text = document.getElementById('pText');
        let progress = 0;

        const interval = setInterval(() => {
            progress += Math.random() * 25 + 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
            }
            bar.style.width = progress + '%';
            text.textContent = Math.round(progress) + '%';

            if (progress >= 100) {
                setTimeout(() => {
                    window.location.href = "{{ route('home') }}";
                }, 300);
            }
        }, 120);
    })();
    </script>
</body>
</html>
