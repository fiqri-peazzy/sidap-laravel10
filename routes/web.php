<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtlitController;
use App\Http\Controllers\KategoriAtlitController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\JadwalLatihanController;
use App\Http\Controllers\JadwalEventController;
use App\Http\Controllers\KalenderKegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Livewire\LaporanAtlit;
use App\Http\Livewire\LaporanPrestasi;
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

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Data Master Routes
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

    // Routes untuk Prestasi
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

    // Routes untuk Jadwal Latihan
    Route::prefix('jadwal-latihan')->name('jadwal-latihan.')->group(function () {
        Route::get('/', [JadwalLatihanController::class, 'index'])->name('index');
        Route::get('/create', [JadwalLatihanController::class, 'create'])->name('create');
        Route::post('/', [JadwalLatihanController::class, 'store'])->name('store');
        Route::get('/{jadwalLatihan}', [JadwalLatihanController::class, 'show'])->name('show');
        Route::get('/{jadwalLatihan}/edit', [JadwalLatihanController::class, 'edit'])->name('edit');
        Route::put('/{jadwalLatihan}', [JadwalLatihanController::class, 'update'])->name('update');
        Route::delete('/{jadwalLatihan}', [JadwalLatihanController::class, 'destroy'])->name('destroy');
        Route::patch('/{jadwalLatihan}/status', [JadwalLatihanController::class, 'updateStatus'])->name('update-status');
    });

    // Routes untuk Jadwal Event
    Route::prefix('jadwal-event')->name('jadwal-event.')->group(function () {
        Route::get('/', [JadwalEventController::class, 'index'])->name('index');
        Route::get('/create', [JadwalEventController::class, 'create'])->name('create');
        Route::post('/', [JadwalEventController::class, 'store'])->name('store');
        Route::get('/{jadwalEvent}', [JadwalEventController::class, 'show'])->name('show');
        Route::get('/{jadwalEvent}/edit', [JadwalEventController::class, 'edit'])->name('edit');
        Route::put('/{jadwalEvent}', [JadwalEventController::class, 'update'])->name('update');
        Route::delete('/{jadwalEvent}', [JadwalEventController::class, 'destroy'])->name('destroy');
        Route::patch('/{jadwalEvent}/status', [JadwalEventController::class, 'updateStatus'])->name('update-status');

        // Routes untuk mengelola atlet dalam event
        Route::get('/{jadwalEvent}/atlit', [JadwalEventController::class, 'manageAtlit'])->name('manage-atlit');
        Route::patch('/{jadwalEvent}/atlit', [JadwalEventController::class, 'updateAtlit'])->name('update-atlit');
    });

    // Routes untuk Kalender Kegiatan
    Route::get('/kalender-kegiatan', [KalenderKegiatanController::class, 'index'])->name('kalender-kegiatan');
    Route::get('/kalender-kegiatan/export', [KalenderKegiatanController::class, 'exportCalendar'])->name('kalender-kegiatan.export');
    Route::get('/kalender-kegiatan/filter', [KalenderKegiatanController::class, 'filterEvents'])->name('kalender-kegiatan.filter');
    Route::get('/kalender-kegiatan/detail', [KalenderKegiatanController::class, 'getEventDetail'])->name('kalender-kegiatan.detail');
    // API Routes untuk AJAX calls
    Route::prefix('api')->name('api.')->group(function () {

        // API untuk mendapatkan data kalender
        Route::get('/kalender/events', [KalenderKegiatanController::class, 'getAllEvents'])->name('kalender.events');
        Route::get('/kalender/events/filter', [KalenderKegiatanController::class, 'filterEvents'])->name('kalender.events.filter');
        Route::get('/kalender/event-detail', [KalenderKegiatanController::class, 'getEventDetail'])->name('kalender.event-detail');

        // API untuk mendapatkan data jadwal latihan
        Route::get('/jadwal-latihan/calendar', [JadwalLatihanController::class, 'getJadwalForCalendar'])->name('jadwal-latihan.calendar');

        // API untuk mendapatkan data jadwal event
        Route::get('/jadwal-event/calendar', [JadwalEventController::class, 'getEventForCalendar'])->name('jadwal-event.calendar');

        // API untuk mendapatkan pelatih berdasarkan cabang olahraga
        Route::get('/pelatih/by-cabor/{caborId}', [JadwalLatihanController::class, 'getPelatihByCabor'])->name('pelatih.by-cabor');

        // API untuk mendapatkan atlet berdasarkan cabang olahraga
        Route::get('/atlit/by-cabor/{caborId}', [JadwalEventController::class, 'getAtlitByCabor'])->name('atlit.by-cabor');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        // Laporan Atlit
        Route::get('/atlit', [App\Http\Controllers\LaporanController::class, 'atlit'])->name('atlit');
        Route::get('/atlit/cetak', [App\Http\Controllers\LaporanController::class, 'cetakAtlit'])->name('atlit.cetak');
        // Laporan Prestasi
        Route::get('/prestasi', [App\Http\Controllers\LaporanController::class, 'prestasi'])->name('prestasi');
        Route::get('/prestasi/cetak', [App\Http\Controllers\LaporanController::class, 'cetakPrestasi'])->name('prestasi.cetak');
        // Statistik
        Route::get('/statistik', [App\Http\Controllers\LaporanController::class, 'statistik'])->name('statistik');
    });
});

// Route binding untuk model
Route::bind('jadwalLatihan', function ($value) {
    return App\Models\JadwalLatihan::findOrFail($value);
});

Route::bind('jadwalEvent', function ($value) {
    return App\Models\JadwalEvent::findOrFail($value);
});
