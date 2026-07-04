<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Mahasiswa
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\PraktikumController as MahasiswaPraktikumController;
use App\Http\Controllers\Mahasiswa\ArsipController;
use App\Http\Controllers\Mahasiswa\ProfilController as MahasiswaProfilController;

// Dosen
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PraktikumController as DosenPraktikumController;
use App\Http\Controllers\Dosen\LaporanController;
use App\Http\Controllers\Dosen\ProfilController as DosenProfilController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Route Mahasiswa
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])
            ->name('mahasiswa.dashboard');
        Route::get('/praktikum', [MahasiswaPraktikumController::class, 'index']);
        Route::get('/praktikum/{id}', [MahasiswaPraktikumController::class, 'show']);
        Route::get('/arsip', [ArsipController::class, 'index']);
        Route::get('/profil', [MahasiswaProfilController::class, 'index']);
    });

/*
|--------------------------------------------------------------------------
| Route Dosen
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:dosen'])
    ->prefix('dosen')
    ->group(function () {
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])
            ->name('dosen.dashboard');
        Route::get('/praktikum', [DosenPraktikumController::class, 'index']);
        Route::get('/praktikum/{id}', [DosenPraktikumController::class, 'show']);
        Route::get('/laporan', [LaporanController::class, 'index']);
        Route::get('/profil', [DosenProfilController::class, 'index']);
    });

/*
|--------------------------------------------------------------------------
| Profile Breeze
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';