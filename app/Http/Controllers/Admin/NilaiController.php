<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NilaiTugasExport;
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\NilaiTugas;
use App\Models\TugasAkhir;
use App\Models\TugasAkhirProgressLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    public function index()
    {
        // Admin melihat semua tugas akhir dikelompokkan per jurusan
        $jurusans = Jurusan::with(['tugasAkhirs' => function ($q) {
            $q->with(['guru', 'nilaiTugas'])->latest();
        }])->orderBy('name')->get();

        foreach ($jurusans as $jurusan) {
            $totalSiswaJurusan = User::role('Siswa')->where('jurusan_id', $jurusan->id)->count();

            foreach ($jurusan->tugasAkhirs as $ta) {
                $ta->total_siswa = $totalSiswaJurusan;

                $completedStudentIds = TugasAkhirProgressLog::where('tugas_akhir_id', $ta->id)
                    ->where('status', 'completed')
                    ->distinct('siswa_id')
                    ->pluck('siswa_id');
                $ta->selesai_count = $completedStudentIds->count();

                $dinilaiList = $ta->nilaiTugas->whereNotNull('nilai');
                $ta->dinilai_count = $dinilaiList->count();
                $ta->rata_rata = $dinilaiList->count() > 0 ? round($dinilaiList->avg('nilai'), 1) : null;
            }
        }

        return view('admin.nilai.index', compact('jurusans'));
    }

    public function show(TugasAkhir $tugasAkhir)
    {
        // Sinkronkan seluruh siswa di jurusan tugas akhir
        $siswaList = User::role('Siswa')->where('jurusan_id', $tugasAkhir->jurusan_id)->get();
        foreach ($siswaList as $siswa) {
            NilaiTugas::firstOrCreate([
                'tugas_akhir_id' => $tugasAkhir->id,
                'siswa_id' => $siswa->id,
            ]);
        }

        $nilaiList = $tugasAkhir->nilaiTugas()
            ->with('siswa')
            ->get()
            ->sortBy(fn($item) => $item->siswa->name ?? '');

        $progressLogs = TugasAkhirProgressLog::where('tugas_akhir_id', $tugasAkhir->id)
            ->get()
            ->groupBy('siswa_id');

        $items = $nilaiList->map(function ($item) use ($progressLogs) {
            $studentLogs = $progressLogs->get($item->siswa_id);
            $latestLog = $studentLogs ? $studentLogs->sortByDesc('id')->first() : null;
            $isCompleted = $latestLog && $latestLog->status === 'completed';
            $status = $latestLog ? $latestLog->status : 'pending';

            return [
                'id' => $item->id,
                'siswa_id' => $item->siswa_id,
                'nama' => $item->siswa->name ?? '-',
                'email' => $item->siswa->email ?? '-',
                'nilai' => $item->nilai,
                'catatan' => $item->catatan ?? '',
                'is_completed' => $isCompleted,
                'status' => $status,
                'status_label' => match($status) {
                    'completed' => 'Selesai',
                    'in_progress' => 'Sedang Dikerjakan',
                    default => 'Belum Mulai',
                },
                'dinilai_at' => $item->dinilai_at?->format('d/m/Y H:i'),
            ];
        })->values();

        return view('admin.nilai.show', [
            'tugasAkhir' => $tugasAkhir->load(['jurusan', 'guru']),
            'items' => $items,
        ]);
    }

    public function update(Request $request, NilaiTugas $nilaiTugas): JsonResponse
    {
        $validated = $request->validate([
            'nilai' => 'nullable|integer|min:1|max:100',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $isCompleted = $nilaiTugas->isStudentCompleted();
        if (!$isCompleted && array_key_exists('nilai', $validated) && $validated['nilai'] !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Nilai hanya boleh diisi apabila siswa telah menyelesaikan tugas.',
            ], 422);
        }

        $updateData = [];
        if (array_key_exists('nilai', $validated)) {
            $updateData['nilai'] = $validated['nilai'];
            if ($validated['nilai'] !== null) {
                $updateData['dinilai_oleh'] = Auth::id();
                $updateData['dinilai_at'] = now();
            } else {
                $updateData['dinilai_oleh'] = null;
                $updateData['dinilai_at'] = null;
            }
        }

        if (array_key_exists('catatan', $validated)) {
            $updateData['catatan'] = $validated['catatan'];
        }

        $nilaiTugas->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Data nilai berhasil disimpan.',
            'data' => [
                'id' => $nilaiTugas->id,
                'nilai' => $nilaiTugas->nilai,
                'catatan' => $nilaiTugas->catatan,
                'dinilai_at' => $nilaiTugas->dinilai_at?->format('d/m/Y H:i'),
            ],
        ]);
    }

    public function export(TugasAkhir $tugasAkhir)
    {
        $slug = Str::slug($tugasAkhir->title, '_');
        $fileName = "Nilai_{$slug}_" . now()->format('Ymd_His') . ".xlsx";

        return Excel::download(new NilaiTugasExport($tugasAkhir), $fileName);
    }
}
