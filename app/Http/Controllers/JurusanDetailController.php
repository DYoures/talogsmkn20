<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;

class JurusanDetailController extends Controller
{
    public function show(string $slug)
    {
        $jurusan = Jurusan::where('slug', $slug)
            ->withCount('tugasAkhirs')
            ->firstOrFail();

        // Other jurusans for the sidebar / navigation
        $otherJurusans = Jurusan::where('id', '!=', $jurusan->id)
            ->select('id', 'name', 'kode', 'slug')
            ->get();

        $theme = session('talog_theme', 'education');

        if ($theme === 'futuristic') {
            return view('experience.jurusan-detail-futuristic', compact('jurusan', 'otherJurusans'));
        }

        return view('experience.jurusan-detail', compact('jurusan', 'otherJurusans'));
    }
}
