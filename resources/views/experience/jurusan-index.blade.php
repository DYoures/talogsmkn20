<x-education-layout>
    <x-slot name="title">Konsentrasi Keahlian — SMKN 20 Jakarta</x-slot>

    <style>
        .jurusan-index-card {
            display: block;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.75rem;
            text-decoration: none;
            transition: all 0.28s cubic-bezier(0.22,1,0.36,1);
            position: relative;
            overflow: hidden;
        }
        .jurusan-index-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ff6b00, #f59e0b);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }
        .jurusan-index-card:hover {
            border-color: rgba(255,107,0,0.35);
            box-shadow: 0 8px 32px rgba(255,107,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
            transform: translateY(-4px) !important;
        }
        .jurusan-index-card:hover::after { transform: scaleX(1); }

        @media (prefers-reduced-motion: reduce) {
            .jurusan-index-card {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        .kode-icon {
            width: 3.5rem; height: 3.5rem;
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 0.875rem;
            transition: all 0.25s ease;
            flex-shrink: 0;
        }
        .jurusan-index-card:hover .kode-icon {
            background: #ff6b00 !important;
            color: #fff !important;
            box-shadow: 0 4px 16px rgba(255,107,0,0.35);
        }

        .card-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        @media (min-width: 768px) { .card-grid { grid-template-columns: 1fr 1fr; } }
        @media (min-width: 1280px) { .card-grid { grid-template-columns: 1fr 1fr 1fr 1fr; } }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.2rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid;
        }
        .breadcrumb-bar { display: flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; color: #64748b; }
        .breadcrumb-bar a { color: #64748b; text-decoration: none; }
        .breadcrumb-bar a:hover { color: #ff6b00; }
    </style>

    {{-- HERO --}}
    <div class="edu-anim-item" style="background:linear-gradient(160deg,#0F2B5C 0%,#1A3D7C 60%,#0F2B5C 100%);padding:3rem 0 5rem;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;background:radial-gradient(ellipse 70% 50% at 50% -10%,rgba(255,107,0,0.1),transparent);pointer-events:none;"></div>
        <div style="max-width:80rem;margin:0 auto;padding:0 1rem;position:relative;z-index:1;">
            {{-- Breadcrumb --}}
            <nav class="breadcrumb-bar" style="margin-bottom:1.5rem;color:rgba(255,255,255,0.4);">
                <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.4);" onmouseover="this.style.color='#ff6b00'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Beranda</a>
                <span>›</span>
                <span style="color:rgba(255,255,255,0.75);">Jurusan</span>
            </nav>

            <div style="text-align:center;max-width:36rem;margin:0 auto;">
                <span style="display:inline-block;padding:0.35rem 1rem;border-radius:9999px;background:rgba(255,107,0,0.2);border:1px solid rgba(255,107,0,0.35);color:#ffb366;font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:1.25rem;">
                    Program Pendidikan Unggulan
                </span>
                <h1 style="font-size:clamp(1.75rem,4vw,2.75rem);font-weight:800;color:#fff;line-height:1.2;letter-spacing:-0.02em;margin-bottom:1rem;">
                    Konsentrasi Keahlian<br><span style="color:#ff6b00;">SMKN 20 Jakarta</span>
                </h1>
                <p style="color:rgba(255,255,255,0.65);font-size:0.9375rem;line-height:1.65;">
                    Empat program keahlian unggulan berstandar industri yang membekali siswa dengan kompetensi teknis dan soft skill relevan di era digital.
                </p>
            </div>
        </div>
    </div>

    {{-- CARD GRID --}}
    <div style="max-width:80rem;margin:0 auto;padding:0 1rem;margin-top:-3rem;position:relative;z-index:10;padding-bottom:5rem;">
        <div class="card-grid">
            @forelse($jurusans as $j)
            @php
                $colors = [
                    'bg'     => $j->accentRgba(0.12),
                    'text'   => $j->accent_color,
                    'border' => $j->accentRgba(0.35),
                ];
            @endphp
            <a href="{{ route('jurusan.detail', $j->slug) }}"
               class="edu-anim-item jurusan-index-card"
               id="jurusan-idx-{{ $j->id }}">

                {{-- Header --}}
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.25rem;">
                    <div class="kode-icon" style="background:{{ $colors['bg'] }};color:{{ $colors['text'] }};border:1.5px solid {{ $colors['border'] }};">
                        {{ $j->kode ?? '?' }}
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.35rem;">
                        <span class="tag-pill" style="background:rgba(255,107,0,0.08);color:#ff6b00;border-color:rgba(255,107,0,0.2);">
                            {{ $j->tugas_akhirs_count ?? 0 }} Tugas Akhir
                        </span>
                        @if($j->akreditasi)
                        <span class="tag-pill" style="background:#f0fdf4;color:#15803d;border-color:#bbf7d0;">
                            Akreditasi {{ $j->akreditasi }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Name + Description --}}
                <h3 style="font-size:1.0625rem;font-weight:700;color:#0F172A;margin:0 0 0.625rem;line-height:1.3;">
                    {{ $j->name }}
                </h3>
                <p style="font-size:0.8125rem;color:#64748b;line-height:1.55;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                    {{ $j->description ?? 'Program keahlian unggulan berstandar nasional dan industri terkemuka.' }}
                </p>

                {{-- Stats row --}}
                @if($j->kurikulum || $j->tools_industri)
                <div style="display:flex;gap:1rem;margin-top:1.125rem;padding-top:1rem;border-top:1px solid #f1f5f9;">
                    @if($j->kurikulum)
                    <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.7rem;color:#94a3b8;">
                        <svg style="width:0.875rem;height:0.875rem;color:#ff6b00;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/></svg>
                        {{ count($j->kurikulum) }} Mapel
                    </div>
                    @endif
                    @if($j->tools_industri)
                    <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.7rem;color:#94a3b8;">
                        <svg style="width:0.875rem;height:0.875rem;color:#ff6b00;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                        {{ count($j->tools_industri) }} Tools
                    </div>
                    @endif
                    <div style="margin-left:auto;font-size:0.75rem;font-weight:600;color:#ff6b00;display:flex;align-items:center;gap:0.25rem;">
                        Lihat Detail
                        <svg style="width:0.875rem;height:0.875rem;transition:transform 0.2s;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
                @endif
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:4rem 0;color:#94a3b8;">
                <p>Belum ada data jurusan. Silakan tambahkan lewat Panel Admin.</p>
            </div>
            @endforelse
        </div>

        {{-- CTA --}}
        <div class="edu-anim-item" style="text-align:center;margin-top:3.5rem;">
            <a href="{{ route('experience.3d') }}" class="btn-edu-primary" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;font-size:0.875rem;">
                <svg style="width:1.125rem;height:1.125rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Buka Buku Interaktif 3D
            </a>
        </div>
    </div>
</x-education-layout>
