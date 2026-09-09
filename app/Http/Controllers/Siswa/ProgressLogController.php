<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TugasAkhir;
use App\Models\TugasAkhirProgressLog;
use App\Support\UploadedDocument;
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
            'notes' => 'nullable|string|max:2000',
            'status' => 'required|in:pending,in_progress,completed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB, legacy single-photo field
            'files' => 'nullable|array|max:10',
            'files.*' => UploadedDocument::rule(),
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file->isValid()) {
                $photoPath = $file->store('progress_photos', 'public');
            } else {
                return back()->withErrors(['photo' => 'Gagal mengunggah foto: ' . $file->getErrorMessage()])->withInput();
            }
        }

        $log = TugasAkhirProgressLog::create([
            'tugas_akhir_id' => $tugasAkhir->id,
            'siswa_id' => $siswa->id,
            'notes' => $validated['notes'] ?? null,
            'status' => $validated['status'],
            'photo_path' => $photoPath,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $fileData = UploadedDocument::store($uploadedFile, 'progress_log_files');
                $log->files()->create($fileData);
            }
        }

        return redirect()->route('siswa.tugas-akhir.show', $tugasAkhir)
            ->with('success', 'Progress berhasil diupdate!');
    }
}
