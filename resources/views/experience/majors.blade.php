<x-education-layout>
    <x-slot name="title">Konsentrasi Keahlian — SMKN 20 Jakarta</x-slot>

    <div class="bg-gradient-to-b from-edu-navy via-[#0F2B5C] to-edu-canvas text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-3.5 py-1 rounded-full bg-edu-orange/20 text-edu-orange text-xs font-bold uppercase tracking-wider mb-4 border border-edu-orange/30">
                Program Pendidikan Unggulan
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold font-display tracking-tight">
                Konsentrasi Keahlian SMKN 20
            </h1>
            <p class="text-white/70 max-w-2xl mx-auto text-sm sm:text-base mt-4">
                SMKN 20 Jakarta membekali peserta didik dengan kompetensi keahlian yang relevan dengan kebutuhan industri digital masa kini.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($jurusans as $j)
                <div class="edu-card p-8 group relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border-2 border-transparent hover:border-edu-orange">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-orange-50 text-edu-orange flex items-center justify-center font-extrabold text-lg border border-orange-200 group-hover:bg-edu-orange group-hover:text-white transition-colors duration-300">
                                {{ $j->kode }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-edu-navy group-hover:text-edu-orange transition-colors">
                                    {{ $j->nama }}
                                </h3>
                                <p class="text-xs text-edu-muted font-medium mt-1">Konsentrasi Keahlian SMKN 20</p>
                            </div>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-edu-navy">
                            {{ $j->tugas_akhirs_count ?? 0 }} Tugas Akhir
                        </span>
                    </div>

                    {{-- Description with rich hover state --}}
                    <div class="mt-6 pt-6 border-t border-edu-border">
                        <h4 class="text-xs font-bold text-edu-orange uppercase tracking-wider mb-2">Deskripsi & Kompetensi</h4>
                        <p class="text-sm text-edu-body leading-relaxed group-hover:text-edu-navy transition-colors">
                            {{ $j->deskripsi ?? 'Kompetensi keahlian dengan fokus pada keahlian praktis, sertifikasi industri, dan kewirausahaan modern.' }}
                        </p>
                    </div>

                    <div class="mt-6 flex items-center justify-between pt-4 border-t border-dashed border-edu-border text-xs">
                        <span class="text-edu-muted">Status: <strong class="text-emerald-600">Aktif</strong></span>
                        @auth
                            @if(auth()->user()->hasRole('Admin'))
                                <a href="{{ route('admin.jurusan.edit', $j) }}" class="text-edu-orange font-semibold hover:underline">
                                    Edit Jurusan &rarr;
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-16 text-edu-muted">
                    <p>Belum ada data jurusan yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('experience.3d') }}" class="btn-edu-primary inline-flex items-center gap-2 px-6 py-3 text-sm">
                &larr; Kembali ke Buku 3D
            </a>
            <a href="{{ route('home') }}" class="btn-edu-outline ml-4 px-6 py-3 text-sm">
                Menuju Beranda &rarr;
            </a>
        </div>
    </div>
</x-education-layout>
