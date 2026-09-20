<table>
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; font-size: 14pt;">REKAPITULASI NILAI TUGAS AKHIR</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Tugas Akhir:</th>
            <th colspan="3">{{ $tugasAkhir->title }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Jurusan:</th>
            <th colspan="3">{{ $tugasAkhir->jurusan->name ?? '-' }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Guru Pembimbing:</th>
            <th colspan="3">{{ $tugasAkhir->guru->name ?? '-' }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Tanggal Export:</th>
            <th colspan="3">{{ $tanggal }}</th>
        </tr>
        <tr>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #f3f4f6;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f3f4f6;">Nama Siswa</th>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #f3f4f6;">Nilai</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f3f4f6;">Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($nilaiList as $index => $item)
            <tr>
                <td style="text-align: center; border: 1px solid #d1d5db;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #d1d5db;">{{ $item->siswa->name ?? '-' }}</td>
                <td style="text-align: center; border: 1px solid #d1d5db;">{{ $item->nilai !== null ? $item->nilai : '-' }}</td>
                <td style="border: 1px solid #d1d5db;">{{ $item->catatan ?? '-' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" style="font-weight: bold; text-align: right; border: 1px solid #000000; background-color: #f3f4f6;">Rata-rata Nilai:</td>
            <td style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #f3f4f6;">{{ $rataRata }}</td>
            <td style="border: 1px solid #000000; background-color: #f3f4f6;"></td>
        </tr>
    </tbody>
</table>
