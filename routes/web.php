<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\JurusanDetailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────────────────────
// SHARED DATA HELPER
// ──────────────────────────────────────────────────────────────
$getStats = function () {
    return [
        'totalJurusan' => \Illuminate\Support\Facades\Schema::hasTable('jurusans')
            ? \App\Models\Jurusan::count() : 0,
        'totalTugasAkhir' => \Illuminate\Support\Facades\Schema::hasTable('tugas_akhirs')
            ? \App\Models\TugasAkhir::count() : 0,
        'totalSiswa' => \Illuminate\Support\Facades\Schema::hasTable('roles')
            ? \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Siswa'))->count() : 0,
        'totalGuru' => \Illuminate\Support\Facades\Schema::hasTable('roles')
            ? \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Guru'))->count() : 0,
    ];
};

// ──────────────────────────────────────────────────────────────
// BERANDA (Home)
// ──────────────────────────────────────────────────────────────
$renderBeranda = function () use ($getStats) {
    $stats = $getStats();

    // Recent Tugas Akhir for "Karya Unggulan" section
    $recentTugasAkhirs = \Illuminate\Support\Facades\Schema::hasTable('tugas_akhirs')
        ? \App\Models\TugasAkhir::with(['jurusan', 'guru', 'progressLogs.siswa'])
            ->latest()
            ->limit(4)
            ->get()
        : collect();

    $jurusans = \Illuminate\Support\Facades\Schema::hasTable('jurusans')
        ? \App\Models\Jurusan::all()
        : collect();

    $theme = session('talog_theme', 'education');
    $view  = $theme === 'futuristic' ? 'experience.futuristic-beranda' : 'experience.beranda';

    return view($view, array_merge($stats, compact('recentTugasAkhirs', 'jurusans')));
};

Route::get('/', $renderBeranda)->name('home');
Route::get('/beranda', $renderBeranda)->name('beranda');

// ──────────────────────────────────────────────────────────────
// JURUSAN INDEX (daftar semua jurusan)
// ──────────────────────────────────────────────────────────────
Route::get('/jurusan', function () {
    $jurusans = \App\Models\Jurusan::withCount('tugasAkhirs')->get();
    $theme    = session('talog_theme', 'education');
    $view     = $theme === 'futuristic'
        ? 'experience.futuristic-jurusan-index'
        : 'experience.jurusan-index';
    return view($view, compact('jurusans'));
})->name('jurusan.index');

// Legacy redirect — old URL from 3D book
Route::get('/jurusan-smkn20', fn() => redirect()->route('jurusan.index', [], 301))
    ->name('experience.majors');

// JURUSAN DETAIL (per slug)
Route::get('/jurusan/{slug}', [JurusanDetailController::class, 'show'])->name('jurusan.detail');

// ──────────────────────────────────────────────────────────────
// TENTANG
// ──────────────────────────────────────────────────────────────
Route::get('/tentang', function () use ($getStats) {
    $stats = $getStats();
    $theme = session('talog_theme', 'education');
    $view  = $theme === 'futuristic'
        ? 'experience.futuristic-tentang'
        : 'experience.tentang';
    return view($view, $stats);
})->name('tentang');

// ──────────────────────────────────────────────────────────────
// THEME SWITCHER & TRANSITIONS
// ──────────────────────────────────────────────────────────────
Route::get('/theme/switch/{theme}', function (string $theme) {
    if (!in_array($theme, ['education', 'futuristic'])) {
        $theme = 'education';
    }
    session(['talog_theme' => $theme]);
    return redirect()->route('home');
})->name('theme.switch');

Route::get('/education/beranda', function () {
    session(['talog_theme' => 'education']);
    return redirect()->route('home');
})->name('education.beranda');

Route::get('/futuristic/beranda', function () {
    session(['talog_theme' => 'futuristic']);
    return redirect()->route('home');
})->name('futuristic.beranda');

// ──────────────────────────────────────────────────────────────
// 3D EXPERIENCES
// ──────────────────────────────────────────────────────────────
Route::get('/loading', fn() => view('experience.loading'))->name('experience.loading');

Route::get('/3d-experience', function () {
    $jurusans = \App\Models\Jurusan::all();
    return view('experience.3d', compact('jurusans'));
})->name('experience.3d');

Route::get('/futuristic/3d', function () {
    $jurusans = \App\Models\Jurusan::withCount('tugasAkhirs')->get();
    return view('experience.futuristic-3d', compact('jurusans'));
})->name('experience.futuristic-3d');

// ──────────────────────────────────────────────────────────────
// AUTHENTICATED ROUTES
// ──────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('Admin'))  return redirect()->route('admin.dashboard');
        if ($user->hasRole('Guru'))   return redirect()->route('guru.tugas-akhir.index');
        if ($user->hasRole('Siswa'))  return redirect()->route('siswa.tugas-akhir.index');
        return redirect()->route('home');
    })->name('dashboard');

    // Admin area
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::resource('jurusan', JurusanController::class);
        Route::resource('users', UserController::class);
    });

    // Guru
    Route::middleware(['role:Guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::resource('tugas-akhir', \App\Http\Controllers\Guru\TugasAkhirController::class);
    });

    // Siswa
    Route::middleware(['role:Siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/tugas-akhir', [\App\Http\Controllers\Siswa\TugasAkhirController::class, 'index'])->name('tugas-akhir.index');
        Route::get('/tugas-akhir/{tugasAkhir}', [\App\Http\Controllers\Siswa\TugasAkhirController::class, 'show'])->name('tugas-akhir.show');
        Route::post('/progress/{tugasAkhir}', [\App\Http\Controllers\Siswa\ProgressLogController::class, 'store'])->name('progress.store');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
