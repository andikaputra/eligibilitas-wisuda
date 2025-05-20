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

});

// Superadmin Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('superadmin/users', SuperAdminController::class);
});
