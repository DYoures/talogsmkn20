<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TALOG20 — Memuat...</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        @keyframes book-page-flip {
            0% { transform: rotateY(0deg); }
            50% { transform: rotateY(-20deg); }
            100% { transform: rotateY(0deg); }
        }
        .book-animate { animation: book-page-flip 1.5s ease-in-out infinite; }
        .spin-slow { animation: spin-slow 3s linear infinite; }

        /* Loading screen particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(242, 183, 5, 0.4);
            animation: floatParticle linear infinite;
        }
        @keyframes floatParticle {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-20px) scale(1); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="edu-loading-screen" id="loadingScreen">
        {{-- Floating particles --}}
        @for($i = 0; $i < 8; $i++)
        <div class="particle"
             style="width: {{ rand(4,12) }}px; height: {{ rand(4,12) }}px; left: {{ rand(5,95) }}%; animation-duration: {{ rand(4,8) }}s; animation-delay: {{ $i * 0.5 }}s;"></div>
        @endfor

        {{-- Logo --}}
        <div class="relative mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <img src="{{ asset('images/logo-smkn20.webp') }}"
                 alt="SMKN 20 Jakarta"
                 class="h-24 w-auto object-contain mx-auto filter drop-shadow-[0_0_24px_rgba(242,183,5,0.5)]">
        </div>

        {{-- Title --}}
        <div class="text-center mb-8 animate-fade-in" style="animation-delay:0.4s;">
            <h1 class="text-2xl font-bold text-white font-display tracking-wide">SMKN 20 Jakarta</h1>
            <p class="text-white/60 text-sm mt-1">Sistem Pengelolaan Tugas Akhir</p>
        </div>

        {{-- Book icon / progress --}}
        <div class="mb-8 animate-fade-in" style="animation-delay:0.6s;">
            <svg class="w-16 h-16 text-edu-gold book-animate mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>

        {{-- Progress bar --}}
        <div class="w-64 mb-4 animate-fade-in" style="animation-delay:0.8s;">
            <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                <div id="loadingBar" class="h-full bg-gradient-to-r from-edu-gold to-edu-gold-light rounded-full transition-all duration-300" style="width:0%"></div>
            </div>
        </div>
        <p id="loadingText" class="text-white/50 text-xs animate-fade-in" style="animation-delay:1s;">Menyiapkan pengalaman belajar...</p>
    </div>

    <script>
    (function() {
        const bar = document.getElementById('loadingBar');
        const text = document.getElementById('loadingText');
        const msgs = [
            'Menyiapkan pengalaman belajar...',
            'Memuat data jurusan...',
            'Menyiapkan buku interaktif...',
            'Hampir siap...',
        ];
        let progress = 0;
        let msgIdx = 0;

        const interval = setInterval(() => {
            progress += Math.random() * 18 + 8;
            if (progress >= 100) { progress = 100; clearInterval(interval); }
            bar.style.width = progress + '%';
            msgIdx = Math.min(Math.floor(progress / 25), msgs.length - 1);
            text.textContent = msgs[msgIdx];
            if (progress >= 100) {
                setTimeout(() => {
                    window.location.href = "{{ route('experience.3d') }}";
                }, 400);
            }
        }, 350);
    })();
    </script>
</body>
</html>
