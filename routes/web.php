<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaWisudaController;
use App\Http\Controllers\MahasiswaYudisiumController;
use App\Http\Controllers\BendaharaWisudaController;
use App\Http\Controllers\AdminPerpusWisudaController;
use App\Http\Controllers\SuperAdminController;
use App\Models\User;
use App\Http\Controllers\MahasiswaIjazahController;
use App\Http\Controllers\SuperAdminIjazahController;


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// Registrasi Mahasiswa
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Wisuda Mahasiswa
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mahasiswa/wisuda',
        [MahasiswaWisudaController::class, 'index']
    )->name('mahasiswa.wisuda.index');

    Route::post(
        '/mahasiswa/wisuda',
        [MahasiswaWisudaController::class, 'store']
    )->name('mahasiswa.wisuda.store');


    /*
    |--------------------------------------------------------------------------
    | Dokumen Mahasiswa
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mahasiswa/dokumen',
        function () {
            return view('mahasiswa.dokumen');
        }
    )->name('mahasiswa.dokumen.index');

    Route::post(
    '/mahasiswa/dokumen',
    function (\Illuminate\Http\Request $request) {

        $request->validate([
            'link_skpi' => 'required|url',
        ]);

        $user = Auth::user();

        User::where('username', $user->username)
            ->update([
                'link_skpi' => $request->link_skpi,
            ]);

        return redirect()
            ->route('mahasiswa.dokumen.index')
            ->with('success', 'Link Google Drive SKPI berhasil disimpan.');

    }
)->name('mahasiswa.dokumen.store');

    /*
    |--------------------------------------------------------------------------
    | Yudisium Mahasiswa
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mahasiswa/yudisium',
        [MahasiswaYudisiumController::class, 'index']
    )->name('mahasiswa.yudisium.index');

    Route::post(
        '/mahasiswa/yudisium',
        [MahasiswaYudisiumController::class, 'store']
    )->name('mahasiswa.yudisium.store');


    /*
    |--------------------------------------------------------------------------
    | Kartu Peserta Yudisium & Wisuda
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mahasiswa/yudisium/kartu',
        [MahasiswaYudisiumController::class, 'kartu']
    )->name('mahasiswa.yudisium.kartu');

    /*
    |--------------------------------------------------------------------------
    | Kartu Peserta Yudisium
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mahasiswa/yudisium/kartu-yudisium',
        [MahasiswaYudisiumController::class, 'kartuYudisium']
    )->name('mahasiswa.yudisium.kartuYudisium');

    /*
    |--------------------------------------------------------------------------
    | IJAZAH MAHASISWA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mahasiswa/ijazah',
        [MahasiswaIjazahController::class, 'index']
    )->name('mahasiswa.ijazah.index');

    Route::post(
        '/mahasiswa/ijazah',
        [MahasiswaIjazahController::class, 'store']
    )->name('mahasiswa.ijazah.store');

});


/*
|--------------------------------------------------------------------------
| BENDAHARA WISUDA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/bendahara/wisuda',
        [BendaharaWisudaController::class, 'index']
    )->name('bendahara.wisuda.index');

    Route::post(
        '/bendahara/wisuda/{id}/validasi',
        [BendaharaWisudaController::class, 'validasi']
    )->name('bendahara.wisuda.validasi');

});


/*
|--------------------------------------------------------------------------
| ADMIN PERPUSTAKAAN WISUDA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/adminperpus/wisuda',
        [AdminPerpusWisudaController::class, 'index']
    )->name('adminperpus.wisuda.index');


    /*
    |--------------------------------------------------------------------------
    | Validasi
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/adminperpus/wisuda/{id}/validasi/repo',
        [AdminPerpusWisudaController::class, 'validasirepo']
    )->name('adminperpus.wisuda.validasirepo');

    Route::post(
        '/adminperpus/wisuda/{id}/validasi/jurnal',
        [AdminPerpusWisudaController::class, 'validasijurnal']
    )->name('adminperpus.wisuda.validasijurnal');

    Route::post(
        '/adminperpus/wisuda/{id}/validasi/skripsi',
        [AdminPerpusWisudaController::class, 'validasiskripsi']
    )->name('adminperpus.wisuda.validasiskripsi');

    Route::post(
        '/adminperpus/wisuda/{id}/validasi/perpus',
        [AdminPerpusWisudaController::class, 'validasiperpus']
    )->name('adminperpus.wisuda.validasiperpus');


    /*
    |--------------------------------------------------------------------------
    | Reject
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/adminperpus/wisuda/{id}/reject/repo',
        [AdminPerpusWisudaController::class, 'rejectrepo']
    )->name('adminperpus.wisuda.rejectrepo');

    Route::post(
        '/adminperpus/wisuda/{id}/reject/jurnal',
        [AdminPerpusWisudaController::class, 'rejectjurnal']
    )->name('adminperpus.wisuda.rejectjurnal');

    Route::post(
        '/adminperpus/wisuda/{id}/reject/skripsi',
        [AdminPerpusWisudaController::class, 'rejectskripsi']
    )->name('adminperpus.wisuda.rejectskripsi');

    Route::post(
        '/adminperpus/wisuda/{id}/reject/perpus',
        [AdminPerpusWisudaController::class, 'rejectperpus']
    )->name('adminperpus.wisuda.rejectperpus');

});


/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Manajemen User
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'superadmin/users',
        SuperAdminController::class
    );

    Route::post(
        'superadmin/users/{user}/reset-password',
        [SuperAdminController::class, 'resetPassword']
    )->name('users.resetPassword');

    /*
    |--------------------------------------------------------------------------
    | Validasi Wisuda
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/superadmin/validasi',
        [SuperAdminController::class, 'dashboard']
    )->name('superadmin.validasi.index');


    /*
    |--------------------------------------------------------------------------
    | Input Nomor Urut Wisuda
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/superadmin/validasi/{id}/no-urut',
        [SuperAdminController::class, 'noUrut']
    )->name('superadmin.validasi.noUrut');


    /*
    |--------------------------------------------------------------------------
    | VALIDASI YUDISIUM - KEUANGAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/superadmin/yudisium/keuangan',
        [SuperAdminController::class, 'yudisiumKeuangan']
    )->name('superadmin.yudisium.keuangan');


    Route::post(
        '/superadmin/yudisium/{id}/keuangan/{jenis}',
        [SuperAdminController::class, 'validasiYudisiumKeuangan']
    )->name('superadmin.yudisium.keuangan.validasi');

    /*
    |--------------------------------------------------------------------------
    | VALIDASI WISUDA - KEUANGAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/superadmin/wisuda/keuangan',
        [SuperAdminController::class, 'wisudaKeuangan']
    )->name('superadmin.wisuda.keuangan');


    Route::post(
        '/superadmin/wisuda/{id}/keuangan',
        [SuperAdminController::class, 'validasiWisudaKeuangan']
    )->name('superadmin.wisuda.keuangan.validasi');


    /*
    |--------------------------------------------------------------------------
    | VALIDASI YUDISIUM - PERPUSTAKAAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/superadmin/yudisium/perpustakaan',
        [SuperAdminController::class, 'yudisiumPerpustakaan']
    )->name('superadmin.yudisium.perpustakaan');


    Route::post(
        '/superadmin/yudisium/{id}/perpustakaan',
        [SuperAdminController::class, 'validasiYudisiumPerpustakaan']
    )->name('superadmin.yudisium.perpustakaan.validasi');

    Route::post(
    '/superadmin/yudisium/{id}/perpustakaan',
    [SuperAdminController::class, 'validasiYudisiumPerpustakaan']
)->name('superadmin.yudisium.perpustakaan.validasi');


/*
|--------------------------------------------------------------------------
| SIAP YUDISIUM
|--------------------------------------------------------------------------
*/

Route::get(
    '/superadmin/yudisium/siap',
    [SuperAdminController::class, 'siapYudisium']
)->name('superadmin.yudisium.siap');

Route::post(
    '/superadmin/yudisium/{id}/no-urut',
    [SuperAdminController::class, 'noUrutYudisium']
)->name('superadmin.yudisium.noUrut');

Route::get(
    '/superadmin/yudisium/cetak-semua',
    [SuperAdminController::class, 'cetakSemuaKartuYudisium']
)->name('superadmin.yudisium.cetakSemua');


/*
|--------------------------------------------------------------------------
| SIAP WISUDA
|--------------------------------------------------------------------------
*/
Route::get(
    '/superadmin/wisuda/siap',
    [SuperAdminController::class, 'siapWisuda']
)->name('superadmin.wisuda.siap');

Route::post(
    '/superadmin/wisuda/{id}/no-urut',
    [SuperAdminController::class, 'noUrutWisuda']
)->name('superadmin.wisuda.no-urut');

/*
|--------------------------------------------------------------------------
| CETAK KARTU WISUDA
|--------------------------------------------------------------------------
*/

// Cetak semua kartu Wisuda
Route::get(
    '/superadmin/wisuda/cetak-semua',
    [SuperAdminController::class, 'cetakSemuaKartuWisuda']
)->name('superadmin.wisuda.cetakSemua');

// Cetak kartu Wisuda per mahasiswa
Route::get(
    '/superadmin/wisuda/{id}/cetak-kartu',
    [SuperAdminController::class, 'cetakKartuWisuda']
)->name('superadmin.wisuda.cetakKartu');


/*
|--------------------------------------------------------------------------
| VALIDASI WISUDA - KEUANGAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/superadmin/wisuda/keuangan',
    [SuperAdminController::class, 'wisudaKeuangan']
)->name('superadmin.wisuda.keuangan');

Route::post(
    '/superadmin/wisuda/{id}/keuangan',
    [SuperAdminController::class, 'validasiWisudaKeuangan']
)->name('superadmin.wisuda.keuangan.validasi');

/*
|--------------------------------------------------------------------------
| VALIDASI WISUDA - PERPUSTAKAAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/superadmin/wisuda/perpustakaan',
    [SuperAdminController::class, 'wisudaPerpustakaan']
)->name('superadmin.wisuda.perpustakaan');

Route::post(
    '/superadmin/wisuda/{id}/perpustakaan/{jenis}',
    [SuperAdminController::class, 'validasiWisudaPerpustakaan']
)->name('superadmin.wisuda.perpustakaan.validasi');

/*
|--------------------------------------------------------------------------
| CETAK KARTU YUDISIUM
|--------------------------------------------------------------------------
*/

Route::get(
    '/superadmin/yudisium/{id}/cetak-kartu',
    [SuperAdminController::class, 'cetakKartuYudisium']
)->name('superadmin.yudisium.cetakKartu');

});



/*
|--------------------------------------------------------------------------
| EXPORT PDF WISUDA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/wisuda/export-pdf',
        [SuperAdminController::class, 'exportPdf']
    )->name('wisuda.exportPdf');

});


/*
|--------------------------------------------------------------------------
| ROUTE MIGRASI
|--------------------------------------------------------------------------
*/

Route::get('/run-migrate', function () {

    Artisan::call('migrate', [
        '--force' => true
    ]);

    return 'Migrasi berhasil dijalankan.';

});


/*
|--------------------------------------------------------------------------
| ROUTE SEED
|--------------------------------------------------------------------------
*/

Route::get('/run-seed', function () {

    Artisan::call('db:seed', [
        '--class' => 'UserSeeder',
        '--force' => true
    ]);

    return 'Seeder berhasil dijalankan!';



});

/*
|--------------------------------------------------------------------------
| SKPI
|--------------------------------------------------------------------------
*/

Route::get(
    '/superadmin/skpi',
    function () {

        $users = \App\Models\User::where('role', 'mahasiswa')
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'superadmin.skpi',
            compact('users')
        );

    }
)->name('superadmin.skpi.index');


/*
|--------------------------------------------------------------------------
| IJAZAH
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get(
        '/superadmin/ijazah',
        [SuperAdminIjazahController::class, 'index']
    )->name('superadmin.ijazah.index');

    Route::get(
        '/superadmin/ijazah/export-pdf',
        [SuperAdminIjazahController::class, 'exportPdf']
    )->name('superadmin.ijazah.export-pdf');

    Route::post(
        '/superadmin/ijazah/{ijazah}/validasi',
        [SuperAdminIjazahController::class, 'validasi']
    )->name('superadmin.ijazah.validasi');
});
