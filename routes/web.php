<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtlitController;
use App\Http\Controllers\KategoriAtlitController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\JadwalLatihanController;
use App\Http\Controllers\JadwalEventController;
use App\Http\Controllers\KalenderKegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\LaporanAtlit;
use App\Http\Livewire\LaporanPrestasi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Redirect after login based on role
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard redirect route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ADMIN ROUTES
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Data Master Routes - Hanya Admin
        Route::get('/cabang-olahraga', function () {
            return view('admin.cabor');
        })->name('cabang-olahraga.index');

        Route::get('/klub', function () {
            return view('admin.klub');
        })->name('klub.index');

        Route::get('/pelatih', function () {
            return view('admin.pelatih');
        })->name('pelatih.index');

        // Routes untuk Atlit - Admin dapat CRUD semua
        Route::resource('atlit', AtlitController::class);
        Route::get('/atlit/kategori/data', [AtlitController::class, 'kategori'])->name('atlit.kategori');

        // Routes untuk Kategori Atlit
        Route::resource('kategori-atlit', KategoriAtlitController::class);

        // Routes untuk Jadwal Latihan - Admin dapat mengelola semua
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

        // Routes untuk Jadwal Event - Admin dapat mengelola semua
        Route::prefix('jadwal-event')->name('jadwal-event.')->group(function () {
            Route::get('/', [JadwalEventController::class, 'index'])->name('index');
            Route::get('/create', [JadwalEventController::class, 'create'])->name('create');
            Route::post('/', [JadwalEventController::class, 'store'])->name('store');
            Route::get('/{jadwalEvent}', [JadwalEventController::class, 'show'])->name('show');
            Route::get('/{jadwalEvent}/edit', [JadwalEventController::class, 'edit'])->name('edit');
            Route::put('/{jadwalEvent}', [JadwalEventController::class, 'update'])->name('update');
            Route::delete('/{jadwalEvent}', [JadwalEventController::class, 'destroy'])->name('destroy');
            Route::patch('/{jadwalEvent}/status', [JadwalEventController::class, 'updateStatus'])->name('update-status');
            Route::get('/{jadwalEvent}/atlit', [JadwalEventController::class, 'manageAtlit'])->name('manage-atlit');
            Route::patch('/{jadwalEvent}/atlit', [JadwalEventController::class, 'updateAtlit'])->name('update-atlit');
        });

        // Laporan - Hanya Admin
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/atlit', [LaporanController::class, 'atlit'])->name('atlit');
            Route::get('/atlit/cetak', [LaporanController::class, 'cetakAtlit'])->name('atlit.cetak');
            Route::get('/prestasi', [LaporanController::class, 'prestasi'])->name('prestasi');
            Route::get('/prestasi/cetak', [LaporanController::class, 'cetakPrestasi'])->name('prestasi.cetak');
            Route::get('/statistik', [LaporanController::class, 'statistik'])->name('statistik');
        });
    });

    // ATLIT ROUTES
    Route::middleware('role:user')->prefix('atlit')->name('atlit.')->group(function () {
        // Atlit Dashboard
        Route::get('/dashboard', function () {
            return view('atlit.dashboard');
        })->name('dashboard');

        // Atlit dapat melihat profil sendiri dan mengupdate
        Route::get('/profil', [AtlitController::class, 'profil'])->name('profil');
        Route::put('/profil', [AtlitController::class, 'updateProfil'])->name('profil.update');
        Route::get('/profil/id-card/preview', [AtlitController::class, 'previewIdCard'])->name('profil.id-card.preview');
        Route::get('/profil/id-card/cetak', [AtlitController::class, 'cetakIdCard'])->name('profil.id-card.cetak');
        Route::get('/verify/{id}', [AtlitController::class, 'verifyIdCard'])->name('verify');

        // Atlit dapat mengelola dokumen pribadi
        Route::prefix('dokumen')->name('dokumen.')->group(function () {
            Route::get('/', [AtlitController::class, 'dokumenIndex'])->name('index');
            Route::get('/create', [AtlitController::class, 'dokumenCreate'])->name('create');
            Route::post('/', [AtlitController::class, 'dokumenStore'])->name('store');
            Route::get('/{dokumen}/download', [AtlitController::class, 'dokumenDownload'])->name('download');
            Route::delete('/{dokumen}', [AtlitController::class, 'dokumenDestroy'])->name('destroy');
        });

        // Atlit dapat melihat prestasi sendiri (read-only)
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [PrestasiController::class, 'indexAtlit'])->name('index');
            Route::get('/{prestasi}', [PrestasiController::class, 'showAtlit'])->name('show');
            Route::get('/{prestasi}/download-sertifikat-atlit', [PrestasiController::class, 'downloadSertifikatAtlit'])->name('download-sertifikat-atlit');
        });

        // Atlit dapat melihat jadwal latihan dan event
        Route::get('/jadwal-latihan', [JadwalLatihanController::class, 'indexAtlit'])->name('jadwal-latihan.index');
        Route::get('/jadwal-event', [JadwalEventController::class, 'indexAtlit'])->name('jadwal-event.index');

        // Kalender kegiatan untuk atlit
        Route::get('/kalender', [KalenderKegiatanController::class, 'indexAtlit'])->name('kalender');
        Route::get('/kalender/events', [KalenderKegiatanController::class, 'getAllEventsAtlit'])->name('kalender.events');
        Route::get('/kalender/event-detail', [KalenderKegiatanController::class, 'getEventDetailAtlit'])->name('kalender.event-detail');
        Route::get('/kalender/events-by-month', [KalenderKegiatanController::class, 'getEventsByMonth'])->name('kalender.events-by-month');
    });

    // VERIFIKATOR ROUTES
    Route::middleware('role:verifikator')->prefix('verifikator')->name('verifikator.')->group(function () {
        // Verifikator Dashboard
        Route::get('/dashboard', function () {
            return view('verifikator.dashboard');
        })->name('dashboard');

        // Verifikator dapat memverifikasi prestasi
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [PrestasiController::class, 'indexVerifikator'])->name('index');
            Route::get('/{prestasi}', [PrestasiController::class, 'showVerifikator'])->name('show');
            Route::put('/{prestasi}/verify', [PrestasiController::class, 'verify'])->name('verify');
            Route::put('/{prestasi}/reject', [PrestasiController::class, 'reject'])->name('reject');
            Route::post('/{prestasi}/catatan', [PrestasiController::class, 'addCatatan'])->name('catatan');
        });

        // Verifikator dapat melihat data atlit untuk verifikasi
        Route::prefix('atlit')->name('atlit.')->group(function () {
            Route::get('/', [App\Http\Controllers\Verifikator\AtlitVerifikasiController::class, 'index'])->name('index');
            Route::get('/{atlit}', [App\Http\Controllers\Verifikator\AtlitVerifikasiController::class, 'show'])->name('show');
            Route::put('/{atlit}/verify', [App\Http\Controllers\Verifikator\AtlitVerifikasiController::class, 'verifyAtlit'])->name('verify');
            Route::put('/{atlit}/reject', [App\Http\Controllers\Verifikator\AtlitVerifikasiController::class, 'rejectAtlit'])->name('reject');
            Route::put('/{atlit}/dokumen/{dokumen}/verify', [App\Http\Controllers\Verifikator\AtlitVerifikasiController::class, 'verifyDokumen'])->name('dokumen.verify');
            Route::put('/{atlit}/dokumen/{dokumen}/reject', [App\Http\Controllers\Verifikator\AtlitVerifikasiController::class, 'rejectDokumen'])->name('dokumen.reject');
        });

        Route::get('/dokumen_atlit/{file_name}', function ($file_name) {
            $path = storage_path('app/private/dokumen_atlit/' . $file_name);
            if (!file_exists($path)) {
                abort(404);
            }
            return response()->file($path);
        })->name('dokumen-atlit.preview');
    });

    // SHARED ROUTES (dapat diakses berdasarkan role dengan middleware)
    Route::middleware('role:admin,verifikator')->group(function () {
        // Prestasi management untuk admin dan verifikator
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [PrestasiController::class, 'index'])->name('index');
            Route::get('/create', [PrestasiController::class, 'create'])->name('create')->middleware('role:admin');
            Route::post('/', [PrestasiController::class, 'store'])->name('store')->middleware('role:admin');
            Route::get('/{prestasi}', [PrestasiController::class, 'show'])->name('show');
            Route::get('/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('edit')->middleware('role:admin');
            Route::put('/{prestasi}', [PrestasiController::class, 'update'])->name('update')->middleware('role:admin');
            Route::delete('/{prestasi}', [PrestasiController::class, 'destroy'])->name('destroy')->middleware('role:admin');
            Route::put('/{prestasi}/verify', [PrestasiController::class, 'verify'])->name('verify');
            Route::put('/{prestasi}/reject', [PrestasiController::class, 'reject'])->name('reject');
            Route::get('/{prestasi}/download-sertifikat', [PrestasiController::class, 'downloadSertifikat'])->name('download-sertifikat');
            Route::get('/api/atlit-by-cabor', [PrestasiController::class, 'getAtlitByCabor'])->name('api.atlit-by-cabor');
            Route::get('/laporan/index', [PrestasiController::class, 'laporan'])->name('laporan')->middleware('role:admin');
        });
    });

    // Kalender Kegiatan - dapat diakses semua role
    Route::get('/kalender-kegiatan', [KalenderKegiatanController::class, 'index'])->name('kalender-kegiatan');
    Route::get('/kalender-kegiatan/export', [KalenderKegiatanController::class, 'exportCalendar'])->name('kalender-kegiatan.export');
    Route::get('/kalender-kegiatan/filter', [KalenderKegiatanController::class, 'filterEvents'])->name('kalender-kegiatan.filter');
    Route::get('/kalender-kegiatan/detail', [KalenderKegiatanController::class, 'getEventDetail'])->name('kalender-kegiatan.detail');

    // API Routes
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/kategori-atlit/{cabangOlahragaId}', [AtlitController::class, 'getKategori'])->name('kategori-atlit');
        Route::get('/kalender/events', [KalenderKegiatanController::class, 'getAllEvents'])->name('kalender.events');
        Route::get('/kalender/events/filter', [KalenderKegiatanController::class, 'filterEvents'])->name('kalender.events.filter');
        Route::get('/kalender/event-detail', [KalenderKegiatanController::class, 'getEventDetail'])->name('kalender.event-detail');
        Route::get('/jadwal-latihan/calendar', [JadwalLatihanController::class, 'getJadwalForCalendar'])->name('jadwal-latihan.calendar');
        Route::get('/jadwal-event/calendar', [JadwalEventController::class, 'getEventForCalendar'])->name('jadwal-event.calendar');
        Route::get('/pelatih/by-cabor/{caborId}', [JadwalLatihanController::class, 'getPelatihByCabor'])->name('pelatih.by-cabor');
        Route::get('/atlit/by-cabor/{caborId}', [JadwalEventController::class, 'getAtlitByCabor'])->name('atlit.by-cabor');
    });
});

// Route binding untuk model
Route::bind('jadwalLatihan', function ($value) {
    return App\Models\JadwalLatihan::findOrFail($value);
});

Route::bind('jadwalEvent', function ($value) {
    return App\Models\JadwalEvent::findOrFail($value);
});