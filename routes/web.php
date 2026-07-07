<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Mahasiswa
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\PraktikumController as MahasiswaPraktikumController;
use App\Http\Controllers\Mahasiswa\ArsipController;
use App\Http\Controllers\Mahasiswa\ProfilController as MahasiswaProfilController;
use App\Http\Controllers\Mahasiswa\LengkapiDataController as MahasiswaLengkapiDataController;

// Dosen
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PraktikumController as DosenPraktikumController;
use App\Http\Controllers\Dosen\LaporanController;
use App\Http\Controllers\Dosen\ProfilController as DosenProfilController;
use App\Http\Controllers\Dosen\LengkapiDataController as DosenLengkapiDataController;

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->role === 'dosen') {
        return redirect()->route('dosen.dashboard');
    }

    return redirect()->route('mahasiswa.dashboard');
});

// MAHASISWA
Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->group(function () {
        // dashboard
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('mahasiswa.dashboard');
        // praktikum
        Route::get('/praktikum', [MahasiswaPraktikumController::class, 'index'])->name('mahasiswa.praktikum.index');
        Route::get('/praktikum/{praktikum}', [MahasiswaPraktikumController::class, 'show'])->name('mahasiswa.praktikum.show');
        Route::post('/praktikum/{praktikum}/pertemuan/{pertemuan}/laporan', [MahasiswaPraktikumController::class, 'uploadLaporan'])->name('mahasiswa.praktikum.laporan.store');
        // arsip
        Route::get('/arsip', [ArsipController::class, 'index'])->name('mahasiswa.arsip.index');
        // Route::get('/profil', [MahasiswaProfilController::class, 'index']);
        Route::get('/profil', [MahasiswaProfilController::class, 'index'])->name('mahasiswa.profil');
        Route::put('/profil', [MahasiswaProfilController::class, 'update'])->name('mahasiswa.profil.update');
        // lengkapi data
        Route::get('/lengkapi-data', [MahasiswaLengkapiDataController::class, 'create'])->name('mahasiswa.lengkapi-data');
        Route::post('/lengkapi-data', [MahasiswaLengkapiDataController::class, 'store'])->name('mahasiswa.lengkapi-data.store');
    });

// DOSEN
Route::middleware(['auth', 'role:dosen'])
    ->prefix('dosen')
    ->group(function () {
        // dashboard
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
        // praktikum
        Route::get('/praktikum', [DosenPraktikumController::class, 'index'])->name('dosen.praktikum.index');
        Route::post('/praktikum',[DosenPraktikumController::class,'store'])->name('dosen.praktikum.store');
        Route::get('/praktikum/{praktikum}', [DosenPraktikumController::class, 'show'])->name('dosen.praktikum.show');
        Route::put('/praktikum/{praktikum}', [DosenPraktikumController::class, 'update'])->name('dosen.praktikum.update');
        Route::post('/praktikum/{praktikum}/pertemuan/', [DosenPraktikumController::class, 'createPertemuan'])->name('dosen.pertemuan.store');
        Route::get('/praktikum/{praktikum}/pertemuan/{pertemuan}', [DosenPraktikumController::class, 'showDetail'])->name('dosen.pertemuan.show');
        Route::put('/praktikum/{praktikum}/pertemuan/{pertemuan}', [DosenPraktikumController::class, 'updatePertemuan'])->name('dosen.pertemuan.update');
        // laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('dosen.laporan.index');
        Route::patch('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])->name('dosen.laporan.status');
        // profil
        Route::get('/profil', [DosenProfilController::class, 'index'])->name('dosen.profil');
        Route::put('/profil', [DosenProfilController::class, 'update'])->name('dosen.profil.update');
        // lengkapi data
        Route::get('/lengkapi-data', [DosenLengkapiDataController::class, 'create'])->name('dosen.lengkapi-data');
        Route::post('/lengkapi-data', [DosenLengkapiDataController::class, 'store'])->name('dosen.lengkapi-data.store');
    });

// BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
