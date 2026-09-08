<x-futuristic-layout>
    <x-slot name="title">Matrix Konsentrasi — SMKN 20 Cyber Core</x-slot>

    <style>
        .cyber-jidx-card {
            display: block;
            text-decoration: none;
            background: rgba(5,8,20,0.75);
            border: 1px solid rgba(6,182,212,0.18);
            border-radius: 0.875rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
            backdrop-filter: blur(8px);
        }
        .cyber-jidx-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg,transparent,rgba(6,182,212,0.4),transparent);
            transform: scaleX(0.3);
            transition: transform 0.3s ease;
        }
        .cyber-jidx-card:hover {
            border-color: rgba(6,182,212,0.45);
            box-shadow: 0 0 30px rgba(6,182,212,0.1), 0 4px 16px rgba(0,0,0,0.3);
            transform: translateY(-3px) !important;
        }
        .cyber-jidx-card:hover::before { transform: scaleX(1); }

        @media (prefers-reduced-motion: reduce) {
            .cyber-jidx-card {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }

        .cyber-jidx-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        @media (min-width: 768px) { .cyber-jidx-grid { grid-template-columns: 1fr 1fr; } }
        @media (min-width: 1280px) { .cyber-jidx-grid { grid-template-columns: 1fr 1fr 1fr 1fr; } }
    </style>

    {{-- HERO --}}
    <section class="cyber-anim-item" style="position:relative;overflow:hidden;padding:4rem 0 5rem;border-bottom:1px solid rgba(6,182,212,0.1);">
        <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:600px;height:250px;background:radial-gradient(ellipse at center,rgba(6,182,212,0.1),transparent 70%);pointer-events:none;"></div>
        <div style="max-width:80rem;margin:0 auto;padding:0 1rem;position:relative;z-index:1;text-align:center;">
            {{-- Breadcrumb --}}
            <div style="display:flex;align-items:center;justify-content:center;gap:0.35rem;font-size:0.7rem;font-family:monospace;color:#4b5563;margin-bottom:1.5rem;">
                <a href="{{ route('home') }}" style="color:#4b5563;text-decoration:none;" onmouseover="this.style.color='#22d3ee'" onmouseout="this.style.color='#4b5563'">~/beranda</a>
                <span>/</span>
                <span style="color:#22d3ee;">jurusan</span>
            </div>

            <span style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.35rem 1rem;border-radius:9999px;background:rgba(6,182,212,0.08);border:1px solid rgba(6,182,212,0.25);color:#67e8f9;font-size:0.7rem;font-family:monospace;letter-spacing:0.08em;margin-bottom:1.25rem;">
                <span style="width:0.5rem;height:0.5rem;border-radius:50%;background:#22d3ee;animation:ping 1.5s infinite;"></span>
                [SYS: MATRIX_KONSENTRASI — AKTIF]
            </span>

            <h1 style="font-family:monospace;font-size:clamp(1.5rem,4vw,2.75rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:1rem;">
                <span style="color:#22d3ee;">&gt;</span> MATRIX KONSENTRASI<br>
                <span style="background:linear-gradient(90deg,#22d3ee,#a78bfa,#34d399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">SMKN 20 CYBER CORE</span>
            </h1>
            <p style="color:#6b7280;font-family:monospace;font-size:0.875rem;line-height:1.65;max-width:28rem;margin:0 auto;">
                Empat node keahlian berstandar industri digital generasi berikutnya.
            </p>
        </div>
    </section>

    {{-- CARD GRID --}}
    <div style="max-width:80rem;margin:0 auto;padding:3rem 1rem 5rem;">
        <div class="cyber-jidx-grid">
            @forelse($jurusans as $j)
            @php
                $cColor = [
                    'main' => $j->accent_color,
                    'glow' => $j->accentRgba(0.15),
                ];
            @endphp
            <a href="{{ route('jurusan.detail', $j->slug) }}"
               class="cyber-anim-item cyber-jidx-card"
               style="border-left: 3px solid {{ $j->accent_color }};">

                {{-- Kode badge --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
                    <span style="font-family:monospace;font-weight:700;font-size:0.875rem;color:{{ $cColor['main'] }};padding:0.35rem 0.875rem;border-radius:0.375rem;background:{{ $cColor['glow'] }};border:1px solid {{ str_replace('0.15', '0.3', $cColor['glow']) }};">
                        [{{ $j->kode ?? '??' }}]
                    </span>
                    <span style="font-family:monospace;font-size:0.65rem;color:#4b5563;">
                        {{ $j->tugas_akhirs_count ?? 0 }} TASKS
                    </span>
                </div>

                <h3 style="font-family:monospace;font-size:0.9375rem;font-weight:700;color:#e2e8f0;margin:0 0 0.625rem;line-height:1.3;">
                    {{ $j->name }}
                </h3>
                <p style="font-size:0.775rem;color:#6b7280;line-height:1.55;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                    {{ $j->description ?? 'Program keahlian berstandar industri digital.' }}
                </p>

                @if($j->kurikulum || $j->tools_industri)
                <div style="display:flex;gap:1rem;margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(6,182,212,0.1);font-family:monospace;font-size:0.65rem;color:#4b5563;">
                    @if($j->kurikulum)
                    <span style="color:rgba(167,139,250,0.8);">{{ count($j->kurikulum) }} MODULES</span>
                    @endif
                    @if($j->tools_industri)
                    <span style="color:rgba(6,182,212,0.8);">{{ count($j->tools_industri) }} TOOLS</span>
                    @endif
                    <span style="margin-left:auto;color:{{ $cColor['main'] }};">AKSES →</span>
                </div>
                @endif
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:4rem 0;color:#4b5563;font-family:monospace;">
                <p>// BELUM ADA DATA NODE KONSENTRASI</p>
            </div>
            @endforelse
        </div>

        <div class="cyber-anim-item" style="text-align:center;margin-top:3rem;">
            <a href="{{ route('experience.futuristic-3d') }}" class="btn-cyber-primary" style="display:inline-flex;align-items:center;gap:0.5rem;font-size:0.875rem;padding:0.75rem 1.75rem;">
                <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5"/></svg>
                Luncurkan 3D Cyber Core
            </a>
        </div>
    </div>

</x-futuristic-layout>
