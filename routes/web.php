<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaWisudaController;
use App\Http\Controllers\BendaharaWisudaController;
use App\Http\Controllers\AdminPerpusWisudaController;
use App\Http\Controllers\SuperAdminController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    //return view('auth.login');php
    return redirect()->route('login');
});


// Mahasiswa Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa/wisuda', [MahasiswaWisudaController::class, 'index'])->name('mahasiswa.wisuda.index');
    Route::post('/mahasiswa/wisuda', [MahasiswaWisudaController::class, 'store'])->name('mahasiswa.wisuda.store');
});

// Bendahara Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/bendahara/wisuda', [BendaharaWisudaController::class, 'index'])->name('bendahara.wisuda.index');
    Route::post('/bendahara/wisuda/{id}/validasi', [BendaharaWisudaController::class, 'validasi'])->name('bendahara.wisuda.validasi');
});

// Admin Perpus Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/adminperpus/wisuda', [AdminPerpusWisudaController::class, 'index'])->name('adminperpus.wisuda.index');
    Route::post('/adminperpus/wisuda/{id}/validasi/repo', [AdminPerpusWisudaController::class, 'validasirepo'])->name('adminperpus.wisuda.validasirepo');
    Route::post('/adminperpus/wisuda/{id}/validasi/jurnal', [AdminPerpusWisudaController::class, 'validasijurnal'])->name('adminperpus.wisuda.validasijurnal');
    Route::post('/adminperpus/wisuda/{id}/validasi/skripsi', [AdminPerpusWisudaController::class, 'validasiskripsi'])->name('adminperpus.wisuda.validasiskripsi');
    Route::post('/adminperpus/wisuda/{id}/validasi/perpus', [AdminPerpusWisudaController::class, 'validasiperpus'])->name('adminperpus.wisuda.validasiperpus');


    Route::post('/adminperpus/wisuda/{id}/reject/repo', [AdminPerpusWisudaController::class, 'rejectrepo'])->name('adminperpus.wisuda.rejectrepo');
    Route::post('/adminperpus/wisuda/{id}/reject/jurnal', [AdminPerpusWisudaController::class, 'rejectjurnal'])->name('adminperpus.wisuda.rejectjurnal');
    Route::post('/adminperpus/wisuda/{id}/reject/skripsi', [AdminPerpusWisudaController::class, 'rejectskripsi'])->name('adminperpus.wisuda.rejectskripsi');
    Route::post('/adminperpus/wisuda/{id}/reject/perpus', [AdminPerpusWisudaController::class, 'rejectperpus'])->name('adminperpus.wisuda.rejectperpus');

    Route::get('/wisuda/export-pdf', [SuperAdminController::class, 'exportPdf'])->name('wisuda.exportPdf');
});

// Superadmin Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('superadmin/users', SuperAdminController::class);
    Route::get('/superadmin/validasi', [SuperAdminController::class, 'dashboard'])->name('superadmin.validasi.index');
});



Route::get('/run-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrasi berhasil dijalankan.';
});

Route::get('/run-seed', function () {
    Artisan::call('db:seed UserSeeder', ['--force' => true]);
    return 'Seeder berhasil dijalankan!';
});
