<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TugasAkhir;
use App\Models\TugasAkhirProgressLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressLogController extends Controller
{
    public function store(Request $request, TugasAkhir $tugasAkhir)
    {
        $siswa = Auth::user();

        if ($tugasAkhir->jurusan_id !== $siswa->jurusan_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('progress_photos', 'public');
        }

        TugasAkhirProgressLog::create([
            'tugas_akhir_id' => $tugasAkhir->id,
            'siswa_id' => $siswa->id,
            'notes' => $validated['notes'],
            'status' => $validated['status'],
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('siswa.tugas-akhir.show', $tugasAkhir)
            ->with('success', 'Progress berhasil diupdate!');
    }
}
