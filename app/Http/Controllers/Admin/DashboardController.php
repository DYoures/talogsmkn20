<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'jurusan'     => Jurusan::count(),
            'users'       => User::count(),
            'guru'        => User::role('Guru')->count(),
            'siswa'       => User::role('Siswa')->count(),
            'tugas_akhir' => TugasAkhir::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
