<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/loading', function () {
        return view('experience.loading');
    })->name('experience.loading');

    Route::get('/3d-experience', function () {
        return view('experience.3d');
    })->name('experience.3d');

    Route::get('/beranda', function () {
        return view('experience.beranda');
    })->name('home');

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
