<x-guest-layout>
    <div class="login-bg-wrapper min-h-screen flex items-center justify-center p-3 sm:p-5 lg:p-6 relative">
        {{-- Background isometric grid --}}
        <div class="login-iso-grid"></div>

        {{-- Background subtle ambient orbs --}}
        <div class="absolute top-1/6 left-12 w-80 h-80 bg-blue-600/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-12 right-12 w-80 h-80 bg-amber-500/8 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Main Split Card Container (Stage 1 - Scaled to ~80% Proportion) --}}
        <div class="login-stage-1 login-card-shell relative z-10 w-full max-w-4xl rounded-2xl sm:rounded-3xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">

            {{-- ─────────────────────────────────────────────────────────────
                 LEFT COLUMN: Branding & Login Form (Clean Light Theme)
                 ───────────────────────────────────────────────────────────── --}}
            <div class="lg:col-span-7 p-5 sm:p-7 lg:p-8 flex flex-col justify-between bg-white">

                <div>
                    {{-- Header / Brand Row (Stage 2) --}}
                    <div class="login-stage-2 flex items-center justify-between mb-5 sm:mb-6">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <div class="relative">
                                <div class="absolute -inset-1 rounded-full bg-amber-400/25 blur-sm group-hover:bg-amber-400/40 transition-all"></div>
                                <img src="{{ asset('images/logo-smkn20.webp') }}"
                                     alt="Logo SMKN 20"
                                     class="h-9 w-auto relative z-10 filter drop-shadow-[0_2px_5px_rgba(245,158,11,0.25)]">
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-base text-slate-900 tracking-wider font-display">TALOG20</span>
                                    <span class="text-[9px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-800 font-mono">
                                        PORTAL
                                    </span>
                                </div>
                                <p class="text-[10px] text-slate-500 font-medium">SMKN 20 Jakarta</p>
                            </div>
                        </a>

                        <a href="{{ route('home') }}"
                           class="text-[11px] text-slate-600 hover:text-slate-900 transition-colors flex items-center gap-1.5 py-1 px-2.5 rounded-full hover:bg-slate-100 border border-slate-200">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Beranda</span>
                        </a>
                    </div>

                    {{-- Title & Headline (Stage 2) --}}
                    <div class="login-stage-2 mb-5 sm:mb-6">
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight leading-snug mb-1.5 font-display">
                            Ruang Karya & Bimbingan Tugas Akhir
                        </h1>
                        <p class="text-xs text-slate-600 leading-relaxed max-w-md">
                            Masuk ke akun Anda untuk mengelola tugas akhir, memantau progres bimbingan, dan mendokumentasikan karya kejuruan.
                        </p>
                    </div>

                    {{-- Session Status --}}
                    <x-auth-session-status class="mb-3.5" :status="session('status')" />

                    {{-- Login Form (Stage 3 Staggered) --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-3 sm:space-y-3.5">
                        @csrf

                        {{-- Email Field (Stage 3-1) --}}
                        <div class="login-stage-3-1">
                            <label for="email" class="block text-[11px] font-semibold text-slate-700 mb-1 uppercase tracking-wider">
                                Email Akun Sekolah
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                       autocomplete="username"
                                       placeholder="nama@talogsmkn20.local"
                                       class="login-input w-full pl-9 pr-3.5 py-2 rounded-lg text-xs sm:text-[13px] font-medium">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-600" />
                        </div>

                        {{-- Password Field (Stage 3-2) --}}
                        <div class="login-stage-3-2" x-data="{ show: false }">
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kata Sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-[11px] text-amber-600 hover:text-amber-700 font-semibold transition-colors">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password"
                                       :type="show ? 'text' : 'password'"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="••••••••"
                                       class="login-input w-full pl-9 pr-10 py-2 rounded-lg text-xs sm:text-[13px] font-medium">
                                <button type="button"
                                        @click="show = !show"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none"
                                        aria-label="Tampilkan kata sandi">
                                    <svg x-show="!show" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" x-cloak class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-600" />
                        </div>

                        {{-- Remember Me (Stage 3-3) --}}
                        <div class="login-stage-3-3 pt-0.5">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <input id="remember_me"
                                       type="checkbox"
                                       name="remember"
                                       class="w-3.5 h-3.5 rounded bg-white border-slate-300 text-amber-500 focus:ring-amber-400 cursor-pointer">
                                <span class="ms-2 text-xs text-slate-600 group-hover:text-slate-900 transition-colors">
                                    Ingat saya di perangkat ini
                                </span>
                            </label>
                        </div>

                        {{-- Submit Button (Stage 3-4) --}}
                        <div class="login-stage-3-4 pt-1.5">
                            <button type="submit"
                                    class="login-btn-primary w-full py-2.5 px-4 rounded-lg text-xs sm:text-[13px] flex items-center justify-center gap-2 cursor-pointer font-bold">
                                <span>Masuk ke Sistem</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Information Card at Bottom (Stage 3-4) --}}
                <div class="login-stage-3-4 mt-5 pt-3.5 border-t border-slate-100">
                    <div class="p-2.5 sm:p-3 rounded-lg bg-slate-50 border border-slate-200/80 flex items-start gap-2.5">
                        <div class="w-5 h-5 rounded-md bg-amber-500/10 border border-amber-400/30 flex items-center justify-center shrink-0 mt-0.5 text-amber-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-[10.5px] text-slate-600 leading-relaxed">
                            <strong class="text-slate-900 font-semibold">Kebijakan Akun:</strong> Akun Guru, Siswa, dan Admin dikelola langsung oleh Administrator Sekolah. Hubungi admin kejuruan jika memerlukan pembuatan atau pemulihan akun.
                        </p>
                    </div>
                </div>

            </div>

            {{-- ─────────────────────────────────────────────────────────────
                 RIGHT COLUMN: The Arch Dome Visual Panel (Academic Open Book)
                 ───────────────────────────────────────────────────────────── --}}
            <div class="lg:col-span-5 bg-gradient-to-br from-[#0B2148] via-[#0F2B5C] to-[#163C7A] border-t lg:border-t-0 lg:border-l border-slate-200/60 p-5 sm:p-6 lg:p-7 flex items-center justify-center relative overflow-hidden">

                {{-- Arch Frame (Stage 1) --}}
                <div class="login-stage-1 login-arch-frame relative w-full flex items-center justify-center">

                    {{-- Academic Navy Canvas --}}
                    <div class="login-arch-canvas"></div>

                    {{-- Luminous Horizon Glow Beam --}}
                    <div class="login-arch-beam"></div>

                    {{-- Floating particle dust --}}
                    <div class="login-particle w-1.5 h-1.5 top-1/4 left-1/3" style="animation-delay: 0s;"></div>
                    <div class="login-particle w-1 h-1 top-1/2 left-2/3" style="animation-delay: 2.5s;"></div>
                    <div class="login-particle w-2 h-2 top-3/4 left-1/4" style="animation-delay: 4.5s;"></div>
                    <div class="login-particle w-1 h-1 top-1/6 right-1/4" style="animation-delay: 1.2s;"></div>

                    {{-- SVG Architectural Vector: Open Book & Academic Illumination (Stage 4) --}}
                    <svg class="login-stage-4 absolute inset-0 w-full h-full"
                         viewBox="0 0 300 440"
                         fill="none"
                         xmlns="http://www.w3.org/2000/svg">

                        <defs>
                            {{-- Radiant Rays Gradient --}}
                            <linearGradient id="rayGrad" x1="150" y1="210" x2="150" y2="40" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#F59E0B" stop-opacity="0.8" />
                                <stop offset="60%" stop-color="#FF6B00" stop-opacity="0.3" />
                                <stop offset="100%" stop-color="#FCD34D" stop-opacity="0" />
                            </linearGradient>

                            {{-- Book Core Glow --}}
                            <radialGradient id="bookCoreGlow" cx="150" cy="215" r="90" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#F59E0B" stop-opacity="0.45" />
                                <stop offset="45%" stop-color="#FF6B00" stop-opacity="0.18" />
                                <stop offset="100%" stop-color="#0F2B5C" stop-opacity="0" />
                            </radialGradient>

                            {{-- Left Page Gradient --}}
                            <linearGradient id="pageLeftGrad" x1="60" y1="235" x2="150" y2="215" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#0D2654" />
                                <stop offset="70%" stop-color="#143973" />
                                <stop offset="100%" stop-color="#1D4A8F" />
                            </linearGradient>

                            {{-- Right Page Gradient --}}
                            <linearGradient id="pageRightGrad" x1="240" y1="235" x2="150" y2="215" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#0D2654" />
                                <stop offset="70%" stop-color="#143973" />
                                <stop offset="100%" stop-color="#1D4A8F" />
                            </linearGradient>

                            {{-- Rising Golden Knowledge Ribbon --}}
                            <linearGradient id="ribbonGrad" x1="150" y1="215" x2="150" y2="60" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#FF6B00" />
                                <stop offset="50%" stop-color="#F59E0B" />
                                <stop offset="100%" stop-color="#FDE68A" />
                            </linearGradient>
                        </defs>

                        {{-- Background Arch Dome Guides --}}
                        <path d="M 28 135 C 28 65, 82 22, 150 22 C 218 22, 272 65, 272 135"
                              stroke="rgba(245, 158, 11, 0.35)"
                              stroke-width="1.2"
                              stroke-dasharray="4 5" />
                        <path d="M 40 145 C 40 80, 88 36, 150 36 C 212 36, 260 80, 260 145"
                              stroke="rgba(255, 255, 255, 0.12)"
                              stroke-width="0.8" />

                        {{-- Ambient Core Glow around Open Book --}}
                        <circle cx="150" cy="210" r="90" fill="url(#bookCoreGlow)" />

                        {{-- Radiant Fan of Knowledge Rays (Stage 4) --}}
                        <g class="draw-ray" stroke="url(#rayGrad)" stroke-width="1.2" stroke-linecap="round">
                            <line x1="150" y1="205" x2="68" y2="88" stroke-dasharray="2 3" opacity="0.65" />
                            <line x1="150" y1="205" x2="105" y2="58" opacity="0.8" />
                            <line x1="150" y1="205" x2="150" y2="46" stroke-width="1.6" opacity="0.9" />
                            <line x1="150" y1="205" x2="195" y2="58" opacity="0.8" />
                            <line x1="150" y1="205" x2="232" y2="88" stroke-dasharray="2 3" opacity="0.65" />
                        </g>

                        {{-- Concentric Knowledge Waves --}}
                        <circle cx="150" cy="205" r="55" stroke="rgba(245, 158, 11, 0.2)" stroke-width="0.75" stroke-dasharray="3 4" />
                        <circle cx="150" cy="205" r="88" stroke="rgba(255, 255, 255, 0.1)" stroke-width="0.75" stroke-dasharray="4 6" />

                        {{-- Rising Arc / Golden Ribbon of Discovery --}}
                        <path class="draw-spiral"
                              d="M 150 205 C 138 165, 105 145, 122 112 C 134 90, 166 98, 172 75 C 176 60, 164 45, 150 36"
                              stroke="url(#ribbonGrad)"
                              stroke-width="1.5"
                              stroke-linecap="round" />

                        {{-- Academic Star / Beacon of Wisdom at (150, 142) --}}
                        <g transform="translate(150, 142)">
                            <circle cx="0" cy="0" r="14" fill="rgba(245, 158, 11, 0.18)" />
                            <polygon points="0,-12 3,-3 12,0 3,3 0,12 -3,3 -12,0 -3,-3"
                                     fill="#FCD34D"
                                     filter="drop-shadow(0 0 6px rgba(245, 158, 11, 0.8))" />
                            <circle cx="0" cy="0" r="2" fill="#FFFFFF" />
                        </g>

                        {{-- Subtle Floating Stars of Knowledge --}}
                        <circle cx="88" cy="115" r="1.5" fill="#FCD34D" opacity="0.7" />
                        <circle cx="212" cy="115" r="1.5" fill="#FCD34D" opacity="0.7" />
                        <circle cx="68" cy="165" r="1.2" fill="#FFFFFF" opacity="0.55" />
                        <circle cx="232" cy="165" r="1.2" fill="#FFFFFF" opacity="0.55" />

                        {{-- ──────────────────────────────────────────────────────────
                             THE OPEN BOOK (Multi-layered 3D Book Silhouette)
                             ────────────────────────────────────────────────────────── --}}
                        {{-- Book Pedestal / Stand Shadow --}}
                        <path d="M 108 248 L 150 238 L 192 248 L 150 256 Z"
                              fill="rgba(8, 22, 48, 0.85)"
                              stroke="rgba(245, 158, 11, 0.25)"
                              stroke-width="0.8" />

                        {{-- Layer 1: Bottom Base Pages (Shadow layer) --}}
                        <path d="M 150 236 C 114 230, 72 238, 54 246 C 54 233, 72 222, 112 216 C 128 214, 142 218, 150 236 Z"
                              fill="rgba(11, 33, 72, 0.9)"
                              stroke="rgba(245, 158, 11, 0.35)"
                              stroke-width="0.9" />
                        <path d="M 150 236 C 186 230, 228 238, 246 246 C 246 233, 228 222, 188 216 C 172 214, 158 218, 150 236 Z"
                              fill="rgba(11, 33, 72, 0.9)"
                              stroke="rgba(245, 158, 11, 0.35)"
                              stroke-width="0.9" />

                        {{-- Layer 2: Middle Open Pages --}}
                        <path class="draw-page"
                              d="M 150 232 C 112 225, 70 232, 52 240 C 52 224, 70 213, 110 207 C 128 204, 142 210, 150 232 Z"
                              fill="url(#pageLeftGrad)"
                              stroke="#F59E0B"
                              stroke-width="1.2" />
                        <path class="draw-page"
                              d="M 150 232 C 188 225, 230 232, 248 240 C 248 224, 230 213, 190 207 C 172 204, 158 210, 150 232 Z"
                              fill="url(#pageRightGrad)"
                              stroke="#F59E0B"
                              stroke-width="1.2" />

                        {{-- Book Spine Fold Highlight --}}
                        <line x1="150" y1="205" x2="150" y2="236"
                              stroke="#FCD34D"
                              stroke-width="1.8"
                              stroke-linecap="round" />

                        {{-- Text Lines on Open Pages (Representing knowledge & curriculum) --}}
                        <g stroke-linecap="round">
                            {{-- Left page lines --}}
                            <line x1="72" y1="222" x2="130" y2="216" stroke="rgba(245, 158, 11, 0.65)" stroke-width="1.2" />
                            <line x1="70" y1="228" x2="134" y2="222" stroke="rgba(255, 255, 255, 0.4)" stroke-width="0.9" />
                            <line x1="68" y1="234" x2="136" y2="228" stroke="rgba(255, 255, 255, 0.3)" stroke-width="0.9" />

                            {{-- Right page lines --}}
                            <line x1="170" y1="216" x2="228" y2="222" stroke="rgba(245, 158, 11, 0.65)" stroke-width="1.2" />
                            <line x1="166" y1="222" x2="230" y2="228" stroke="rgba(255, 255, 255, 0.4)" stroke-width="0.9" />
                            <line x1="164" y1="228" x2="232" y2="234" stroke="rgba(255, 255, 255, 0.3)" stroke-width="0.9" />
                        </g>

                        {{-- Floating Top Page Turning Upward (Sign of active learning) --}}
                        <path d="M 150 220 C 132 205, 96 200, 78 208 C 88 196, 122 195, 150 212 Z"
                              fill="rgba(245, 158, 11, 0.25)"
                              stroke="#FCD34D"
                              stroke-width="1"
                              stroke-dasharray="2 3" />

                        {{-- ──────────────────────────────────────────────────────────
                             ACADEMIC TYPOGRAPHY & IDENTITY OF SMKN 20 JAKARTA
                             ────────────────────────────────────────────────────────── --}}
                        {{-- School Title Header --}}
                        <g transform="translate(150, 290)">
                            <text x="0" y="0"
                                  text-anchor="middle"
                                  font-family="'Plus Jakarta Sans', system-ui, sans-serif"
                                  font-size="10.5"
                                  font-weight="800"
                                  fill="#FCD34D"
                                  letter-spacing="0.16em">
                                SMKN 20 JAKARTA
                            </text>
                            <text x="0" y="14"
                                  text-anchor="middle"
                                  font-family="'Plus Jakarta Sans', system-ui, sans-serif"
                                  font-size="7.5"
                                  font-weight="500"
                                  fill="rgba(255, 255, 255, 0.85)"
                                  letter-spacing="0.04em">
                                Pusat Dokumentasi & Tugas Akhir
                            </text>
                        </g>

                        {{-- Decorative Academic Laurel / Separator --}}
                        <g transform="translate(150, 322)">
                            <line x1="-55" y1="0" x2="-10" y2="0" stroke="rgba(245, 158, 11, 0.45)" stroke-width="0.8" />
                            <polygon points="0,-3.5 3.5,0 0,3.5 -3.5,0" fill="#F59E0B" />
                            <line x1="10" y1="0" x2="55" y2="0" stroke="rgba(245, 158, 11, 0.45)" stroke-width="0.8" />
                        </g>

                        {{-- Vocational Mottos / Core Values --}}
                        <text x="150" y="342"
                              text-anchor="middle"
                              font-family="'JetBrains Mono', monospace"
                              font-size="6.8"
                              font-weight="600"
                              fill="rgba(253, 230, 138, 0.8)"
                              letter-spacing="0.12em">
                            UNGGUL • MANDIRI • BERKARYA
                        </text>

                        {{-- Bottom Academic Badge --}}
                        <g transform="translate(150, 378)">
                            <rect x="-65" y="-11" width="130" height="22" rx="11"
                                  fill="rgba(10, 28, 62, 0.9)"
                                  stroke="rgba(245, 158, 11, 0.5)"
                                  stroke-width="1.1" />
                            <text x="0" y="3.5"
                                  text-anchor="middle"
                                  font-family="'JetBrains Mono', monospace"
                                  font-size="8"
                                  font-weight="bold"
                                  fill="#FCD34D"
                                  letter-spacing="0.1em">
                                TALOG20 // EDUCATION
                            </text>
                        </g>
                    </svg>

                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
