<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

$renderBeranda = function () {
    $jurusans = \Illuminate\Support\Facades\Schema::hasTable('jurusans')
        ? \App\Models\Jurusan::withCount('tugasAkhirs')->get()
        : collect();
    $totalTugasAkhir = \Illuminate\Support\Facades\Schema::hasTable('tugas_akhirs')
        ? \App\Models\TugasAkhir::count()
        : 0;
    $totalSiswa = \Illuminate\Support\Facades\Schema::hasTable('roles')
        ? \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Siswa'))->count()
        : 0;
    $totalGuru = \Illuminate\Support\Facades\Schema::hasTable('roles')
        ? \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Guru'))->count()
        : 0;
    $theme = session('talog_theme', 'education');
    $view = $theme === 'futuristic' ? 'experience.futuristic-beranda' : 'experience.beranda';
    return view($view, compact('jurusans', 'totalTugasAkhir', 'totalSiswa', 'totalGuru'));
};

Route::get('/', $renderBeranda)->name('home');
Route::get('/beranda', $renderBeranda);

// Theme Switcher & Visual Transitions
Route::get('/theme/switch/{theme}', function (string $theme) {
    if (!in_array($theme, ['education', 'futuristic'])) {
        $theme = 'education';
    }
    session(['talog_theme' => $theme]);
    return redirect()->route('theme.loading', ['target' => $theme]);
})->name('theme.switch');

Route::get('/theme/loading/{target}', function (string $target) {
    if (!in_array($target, ['education', 'futuristic'])) {
        $target = 'education';
    }
    return view('experience.theme-loading', compact('target'));
})->name('theme.loading');

Route::get('/education/beranda', function () {
    session(['talog_theme' => 'education']);
    return redirect()->route('home');
})->name('education.beranda');

Route::get('/futuristic/beranda', function () {
    session(['talog_theme' => 'futuristic']);
    return redirect()->route('home');
})->name('futuristic.beranda');

Route::get('/jurusan-smkn20', function () {
    $jurusans = \App\Models\Jurusan::withCount('tugasAkhirs')->get();
    return view('experience.majors', compact('jurusans'));
})->name('experience.majors');

Route::get('/loading', function () {
    return view('experience.loading');
})->name('experience.loading');

Route::get('/3d-experience', function () {
    $jurusans = \App\Models\Jurusan::all();
    return view('experience.3d', compact('jurusans'));
})->name('experience.3d');

Route::get('/futuristic/3d', function () {
    $jurusans = \App\Models\Jurusan::all();
    return view('experience.futuristic-3d', compact('jurusans'));
})->name('experience.futuristic-3d');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('Guru')) {
            return redirect()->route('guru.tugas-akhir.index');
        }
        if ($user->hasRole('Siswa')) {
            return redirect()->route('siswa.tugas-akhir.index');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Admin area — Full access (Jurusan, Users, Settings)
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::resource('jurusan', JurusanController::class);
        Route::resource('users', UserController::class);
    });

    // Guru Routes
    Route::middleware(['role:Guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::resource('tugas-akhir', \App\Http\Controllers\Guru\TugasAkhirController::class);
    });

    // Siswa Routes
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
