<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\TugasAkhir;
use App\Support\UploadedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasAkhirController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        
        // Guru hanya melihat tugas akhir yang mereka buat
        $tugasAkhirs = TugasAkhir::where('guru_id', $guru->id)
            ->withCount('progressLogs')
            ->latest()
            ->get();
            
        return view('guru.tugas_akhir.index', compact('tugasAkhirs', 'guru'));
    }

    public function create()
    {
        $guru = Auth::user();
        
        if (!$guru->jurusan_id) {
            return redirect()->route('guru.tugas-akhir.index')
                ->with('error', 'Anda belum di-assign ke jurusan manapun. Hubungi Admin.');
        }
        
        return view('guru.tugas_akhir.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $guru = Auth::user();
        
        if (!$guru->jurusan_id) {
            return back()->with('error', 'Anda tidak memiliki jurusan.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|' . UploadedDocument::rule(),
        ]);

        $fileData = [];
        if ($request->hasFile('file')) {
            $fileData = UploadedDocument::store($request->file('file'), 'tugas_akhir_files');
        }

        TugasAkhir::create([
            'guru_id' => $guru->id,
            'jurusan_id' => $guru->jurusan_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $fileData['path'] ?? null,
            'file_original_name' => $fileData['original_name'] ?? null,
            'file_size' => $fileData['size'] ?? null,
            'file_mime' => $fileData['mime'] ?? null,
        ]);

        return redirect()->route('guru.tugas-akhir.index')
            ->with('success', 'Tugas Akhir berhasil ditambahkan.');
    }

    public function show(TugasAkhir $tugasAkhir)
    {
        // Pastikan tugas akhir ini milik guru yang login
        if ($tugasAkhir->guru_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load progress logs related to this tugas akhir, with their students
        $tugasAkhir->load(['progressLogs.siswa' => function ($query) {
            // Get the latest log first
            $query->orderBy('created_at', 'desc');
        }]);
        
        // Group logs by siswa to easily see latest status per student, or just list all chronologically
        // A simple chronological log view might be easiest, but usually we want to see grouped by student
        $logs = $tugasAkhir->progressLogs()->with(['siswa', 'files'])->latest()->get();

        return view('guru.tugas_akhir.show', compact('tugasAkhir', 'logs'));
    }

    public function edit(TugasAkhir $tugasAkhir)
    {
        if ($tugasAkhir->guru_id !== Auth::id()) {
            abort(403);
        }
        
        return view('guru.tugas_akhir.edit', compact('tugasAkhir'));
    }

    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        if ($tugasAkhir->guru_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|' . UploadedDocument::rule(),
            'remove_file' => 'nullable|boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($tugasAkhir->file_path) {
                Storage::disk('public')->delete($tugasAkhir->file_path);
            }
            $fileData = UploadedDocument::store($request->file('file'), 'tugas_akhir_files');
            $validated['file_path'] = $fileData['path'];
            $validated['file_original_name'] = $fileData['original_name'];
            $validated['file_size'] = $fileData['size'];
            $validated['file_mime'] = $fileData['mime'];
        } elseif ($request->boolean('remove_file') && $tugasAkhir->file_path) {
            Storage::disk('public')->delete($tugasAkhir->file_path);
            $validated['file_path'] = null;
            $validated['file_original_name'] = null;
            $validated['file_size'] = null;
            $validated['file_mime'] = null;
        }

        unset($validated['remove_file']);

        $tugasAkhir->update($validated);

        return redirect()->route('guru.tugas-akhir.index')
            ->with('success', 'Tugas Akhir berhasil diperbarui.');
    }

    public function destroy(TugasAkhir $tugasAkhir)
    {
        if ($tugasAkhir->guru_id !== Auth::id()) {
            abort(403);
        }

        if ($tugasAkhir->file_path) {
            Storage::disk('public')->delete($tugasAkhir->file_path);
        }

        $tugasAkhir->delete();

        return redirect()->route('guru.tugas-akhir.index')
            ->with('success', 'Tugas Akhir berhasil dihapus.');
    }
}
