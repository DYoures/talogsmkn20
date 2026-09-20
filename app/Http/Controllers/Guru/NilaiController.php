<?php

namespace App\Http\Controllers\Guru;

use App\Exports\NilaiTugasExport;
use App\Http\Controllers\Controller;
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
        $guru = Auth::user();

        // Ambil semua tugas akhir milik guru dengan data nilai & progres
        $tugasAkhirs = TugasAkhir::where('guru_id', $guru->id)
            ->with(['jurusan', 'nilaiTugas'])
            ->latest()
            ->get();

        $tugasAkhirs->each(function ($ta) {
            $totalSiswa = User::role('Siswa')->where('jurusan_id', $ta->jurusan_id)->count();
            $ta->total_siswa = $totalSiswa;

            // Hitung siswa selesai
            $completedStudentIds = TugasAkhirProgressLog::where('tugas_akhir_id', $ta->id)
                ->where('status', 'completed')
                ->distinct('siswa_id')
                ->pluck('siswa_id');
            $ta->selesai_count = $completedStudentIds->count();

            $dinilaiList = $ta->nilaiTugas->whereNotNull('nilai');
            $ta->dinilai_count = $dinilaiList->count();
            $ta->rata_rata = $dinilaiList->count() > 0 ? round($dinilaiList->avg('nilai'), 1) : null;
        });

        return view('guru.nilai.index', compact('tugasAkhirs', 'guru'));
    }

    public function show(TugasAkhir $tugasAkhir)
    {
        if ($tugasAkhir->guru_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas akhir ini.');
        }

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

        return view('guru.nilai.show', [
            'tugasAkhir' => $tugasAkhir->load(['jurusan', 'guru']),
            'items' => $items,
        ]);
    }

    public function update(Request $request, NilaiTugas $nilaiTugas): JsonResponse
    {
        if ($nilaiTugas->tugasAkhir->guru_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

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
        if ($tugasAkhir->guru_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $slug = Str::slug($tugasAkhir->title, '_');
        $fileName = "Nilai_{$slug}_" . now()->format('Ymd_His') . ".xlsx";

        return Excel::download(new NilaiTugasExport($tugasAkhir), $fileName);
    }
}
