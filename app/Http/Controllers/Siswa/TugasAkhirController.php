<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasAkhirController extends Controller
{
    public function index()
    {
        $siswa = Auth::user();
        
        if (!$siswa->jurusan_id) {
            return redirect()->route('home')
                ->with('error', 'Anda belum memiliki jurusan yang ditetapkan. Silakan hubungi admin.');
        }

        // Siswa hanya melihat tugas akhir yang relevan dengan jurusannya
        $tugasAkhirs = TugasAkhir::where('jurusan_id', $siswa->jurusan_id)
            ->with('guru') // Load the teacher who made it
            ->latest()
            ->get();

        // Get the latest progress status for each tugas akhir for this specific student
        $tugasAkhirs->each(function ($ta) use ($siswa) {
            $latestLog = $ta->progressLogs()
                ->where('siswa_id', $siswa->id)
                ->latest()
                ->first();
                
            $ta->current_status = $latestLog ? $latestLog->status : 'pending';
            $ta->last_update = $latestLog ? $latestLog->created_at : null;
        });

        return view('siswa.tugas_akhir.index', compact('tugasAkhirs', 'siswa'));
    }

    public function show(TugasAkhir $tugasAkhir)
    {
        $siswa = Auth::user();

        // Ensure this tugas akhir belongs to the student's jurusan
        if ($tugasAkhir->jurusan_id !== $siswa->jurusan_id) {
            abort(403, 'Tugas akhir ini bukan untuk jurusan Anda.');
        }

        // Load all progress logs for this student on this tugas akhir
        $logs = $tugasAkhir->progressLogs()
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('siswa.tugas_akhir.show', compact('tugasAkhir', 'logs', 'siswa'));
    }
}
