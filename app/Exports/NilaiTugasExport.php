<?php

namespace App\Exports;

use App\Models\TugasAkhir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiTugasExport implements FromView, ShouldAutoSize, WithStyles
{
    protected TugasAkhir $tugasAkhir;

    public function __construct(TugasAkhir $tugasAkhir)
    {
        $this->tugasAkhir = $tugasAkhir;
    }

    public function view(): View
    {
        $this->tugasAkhir->load(['jurusan', 'guru']);

        $nilaiList = $this->tugasAkhir->nilaiTugas()
            ->with('siswa')
            ->get()
            ->sortBy(fn($item) => $item->siswa->name ?? '');

        $sudahDinilai = $nilaiList->whereNotNull('nilai');
        $rataRata = $sudahDinilai->count() > 0 ? round($sudahDinilai->avg('nilai'), 1) : '-';

        return view('exports.nilai_tugas', [
            'tugasAkhir' => $this->tugasAkhir,
            'nilaiList' => $nilaiList,
            'rataRata' => $rataRata,
            'tanggal' => now()->translatedFormat('d F Y H:i'),
        ]);
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 13]],
            7 => ['font' => ['bold' => true]],
        ];
    }
}
