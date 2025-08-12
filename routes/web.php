<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtlitController;
use App\Http\Controllers\KategoriAtlitController;
use App\Http\Controllers\PrestasiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/cabang-olahraga', function () {
        return view('admin.cabor');
    })->name('cabang-olahraga.index');

    Route::get('/klub', function () {
        return view('admin.klub');
    })->name('klub.index');

    Route::get('/pelatih', function () {
        return view('admin.pelatih');
    })->name('pelatih.index');

    // Routes untuk Atlit
    Route::resource('atlit', AtlitController::class);
    Route::get('/atlit/kategori/data', [AtlitController::class, 'kategori'])->name('atlit.kategori');
    Route::get('/api/kategori-atlit/{cabangOlahragaId}', [AtlitController::class, 'getKategori'])->name('api.kategori-atlit');

    // Routes untuk Kategori Atlit
    Route::resource('kategori-atlit', KategoriAtlitController::class);

    Route::prefix('prestasi')->name('prestasi.')->group(function () {
        Route::get('/', [PrestasiController::class, 'index'])->name('index');
        Route::get('/create', [PrestasiController::class, 'create'])->name('create');
        Route::post('/', [PrestasiController::class, 'store'])->name('store');
        Route::get('/{prestasi}', [PrestasiController::class, 'show'])->name('show');
        Route::get('/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('edit');
        Route::put('/{prestasi}', [PrestasiController::class, 'update'])->name('update');
        Route::delete('/{prestasi}', [PrestasiController::class, 'destroy'])->name('destroy');

        // Action routes
        Route::put('/{prestasi}/verify', [PrestasiController::class, 'verify'])->name('verify');
        Route::put('/{prestasi}/reject', [PrestasiController::class, 'reject'])->name('reject');
        Route::get('/{prestasi}/download-sertifikat', [PrestasiController::class, 'downloadSertifikat'])->name('download-sertifikat');

        // API routes
        Route::get('/api/atlit-by-cabor', [PrestasiController::class, 'getAtlitByCabor'])->name('api.atlit-by-cabor');

        // Laporan
        Route::get('/laporan/index', [PrestasiController::class, 'laporan'])->name('laporan');
    });
});
