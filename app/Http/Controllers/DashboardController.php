<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Atlit;
use App\Models\JadwalLatihan;
use App\Models\JadwalEvent;
use Illuminate\Support\Facades\DB;
use App\Models\Cabor;
use App\Models\Klub;
use App\Models\Prestasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Redirect user to appropriate dashboard based on role
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('atlit.dashboard');
            case 'verifikator':
                return redirect()->route('verifikator.dashboard');
            default:
                return view('admin.dashboard');
        }
    }

    /**
     * Dashboard untuk Atlet dengan data lengkap
     */
    public function atletDashboard()
    {
        $user = Auth::user();

        // Ambil data atlet dengan relasi
        $atlet = Atlit::with([
            'cabangOlahraga',
            'klub',
            'kategoriAtlit',
            'prestasi' => function ($query) {
                $query->orderBy('tanggal_selesai', 'desc');
            },
            'dokumen'
        ])->where('user_id', $user->id)->first();



        // Jika atlet tidak ditemukan
        if (!$atlet) {
            return view('atlit.dashboard', [
                'error' => 'Data atlet tidak ditemukan. Silakan hubungi administrator.',
                'atlet' => null,
                'statistikPrestasi' => [],
                'prestasiTerbaru' => collect(),
                'dokumenStats' => ['total' => 0, 'verified' => 0, 'pending' => 0, 'rejected' => 0],
                'persentaseDokumen' => 0,
                'jadwalHariIni' => collect(),
                'jadwalMingguIni' => collect(),
                'eventMendatang' => collect(),
                'jumlahEventMendatang' => 0,
                'notifikasi' => [],
                'prestasiPerTahun' => []
            ]);
        }

        // ========================================
        // STATISTIK PRESTASI
        // ========================================
        $statistikPrestasi = $atlet->getStatistikPrestasi();

        // Prestasi Terbaru (3 terakhir yang sudah diverifikasi)
        $prestasiTerbaru = $atlet->prestasi()
            ->whereIn('status', ['verified', 'pending', 'rejected'])
            ->orderBy('tanggal_selesai', 'desc')
            ->take(3)
            ->get();

        // ========================================
        // STATISTIK DOKUMEN
        // ========================================
        $dokumenStats = $atlet->getDocumentStats();
        $persentaseDokumen = $atlet->getDocumentVerificationPercentage();

        // ========================================
        // JADWAL LATIHAN
        // ========================================
        // Jadwal Latihan Hari Ini
        $jadwalHariIni = JadwalLatihan::where('cabang_olahraga_id', $atlet->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->whereDate('tanggal', now())
            ->with(['pelatih', 'lokasi'])
            ->orderBy('jam_mulai')
            ->get();

        // Jadwal Latihan Minggu Ini
        $jadwalMingguIni = JadwalLatihan::where('cabang_olahraga_id', $atlet->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->whereBetween('tanggal', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->with(['pelatih'])
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->take(5)
            ->get();

        // ========================================
        // EVENT MENDATANG
        // ========================================
        // Event yang akan datang (3 terdekat)
        $eventMendatang = JadwalEvent::where('cabang_olahraga_id', $atlet->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai')
            ->take(3)
            ->get();

        // Hitung jumlah event mendatang
        $jumlahEventMendatang = JadwalEvent::where('cabang_olahraga_id', $atlet->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '>=', now())
            ->count();

        // ========================================
        // NOTIFIKASI / PENGUMUMAN
        // ========================================
        $notifikasi = [];

        // Notifikasi: Dokumen perlu dilengkapi
        if ($dokumenStats['total'] == 0) {
            $notifikasi[] = [
                'type' => 'warning',
                'icon' => 'fa-exclamation-triangle',
                'title' => 'Dokumen Belum Dilengkapi',
                'message' => 'Anda belum mengunggah dokumen pendukung. Silakan lengkapi dokumen Anda.',
                'link' => route('atlit.dokumen.index'),
                'link_text' => 'Upload Dokumen'
            ];
        }

        // Notifikasi: Dokumen ditolak
        if ($dokumenStats['rejected'] > 0) {
            $notifikasi[] = [
                'type' => 'danger',
                'icon' => 'fa-times-circle',
                'title' => 'Dokumen Ditolak',
                'message' => "Anda memiliki {$dokumenStats['rejected']} dokumen yang ditolak. Silakan perbaiki dan unggah ulang.",
                'link' => route('atlit.dokumen.index'),
                'link_text' => 'Lihat Dokumen'
            ];
        }

        // Notifikasi: Status verifikasi atlet
        if ($atlet->status_verifikasi == 'pending') {
            $notifikasi[] = [
                'type' => 'info',
                'icon' => 'fa-clock',
                'title' => 'Menunggu Verifikasi',
                'message' => 'Profil Anda sedang dalam proses verifikasi oleh admin.',
                'link' => null,
                'link_text' => null
            ];
        }

        if ($atlet->status_verifikasi == 'ditolak') {
            $notifikasi[] = [
                'type' => 'danger',
                'icon' => 'fa-ban',
                'title' => 'Verifikasi Ditolak',
                'message' => 'Profil Anda ditolak. Alasan: ' . ($atlet->catatan_verifikasi ?? 'Tidak ada keterangan'),
                'link' => route('atlit.profil'),
                'link_text' => 'Update Profil'
            ];
        }

        // Notifikasi: Jadwal latihan hari ini
        if ($jadwalHariIni->count() > 0) {
            $notifikasi[] = [
                'type' => 'success',
                'icon' => 'fa-calendar-check',
                'title' => 'Jadwal Latihan Hari Ini',
                'message' => "Anda memiliki {$jadwalHariIni->count()} jadwal latihan hari ini.",
                'link' => route('atlit.jadwal-latihan.index'),
                'link_text' => 'Lihat Jadwal'
            ];
        }

        // Notifikasi: Event mendatang dalam 7 hari
        $eventSegera = JadwalEvent::where('cabang_olahraga_id', $atlet->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->whereBetween('tanggal_mulai', [now(), now()->addDays(7)])
            ->get();

        if ($eventSegera->count() > 0) {
            $notifikasi[] = [
                'type' => 'warning',
                'icon' => 'fa-bullhorn',
                'title' => 'Event Segera Dimulai',
                'message' => "Ada {$eventSegera->count()} event dalam 7 hari ke depan.",
                'link' => route('atlit.jadwal-event.index'),
                'link_text' => 'Lihat Event'
            ];
        }

        // ========================================
        // DATA UNTUK CHART
        // ========================================
        // Data prestasi per tahun (5 tahun terakhir)
        $tahunSekarang = now()->year;
        $prestasiPerTahun = [];

        for ($i = 4; $i >= 0; $i--) {
            $tahun = $tahunSekarang - $i;
            $jumlah = $atlet->prestasi()
                ->whereYear('tahun', $tahun)
                ->where('status', 'verified')
                ->count();

            $prestasiPerTahun[] = [
                'tahun' => $tahun,
                'jumlah' => $jumlah
            ];
        }

        // ========================================
        // RETURN VIEW
        // ========================================
        return view('atlit.dashboard', compact(
            'atlet',
            'statistikPrestasi',
            'prestasiTerbaru',
            'dokumenStats',
            'persentaseDokumen',
            'jadwalHariIni',
            'jadwalMingguIni',
            'eventMendatang',
            'jumlahEventMendatang',
            'notifikasi',
            'prestasiPerTahun'
        ));
    }

    public function adminDashboard()
    {
        // Statistik Utama
        $stats = [
            'total_atlit' => Atlit::count(),
            'total_cabor' => Cabor::count(),
            'total_klub' => Klub::count(),
            'total_prestasi' => Prestasi::count(),
        ];

        // Klub Terbaru (5 terbaru)
        $klubTerbaru = Klub::with('cabangOlahraga')
            ->latest()
            ->take(5)
            ->get();

        // Aktivitas Terbaru
        $aktivitasCabang = Cabor::latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'type' => 'cabang',
                    'title' => 'Cabang ' . $item->nama_cabang . ' ditambahkan',
                    'created_at' => $item->created_at,
                    'icon' => 'fas fa-running',
                    'color' => 'primary',
                ];
            });

        $aktivitasKlub = Klub::latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'type' => 'klub',
                    'title' => 'Klub ' . $item->nama_klub . ' terdaftar',
                    'created_at' => $item->created_at,
                    'icon' => 'fas fa-users',
                    'color' => 'info',
                ];
            });

        $aktivitas = $aktivitasCabang->concat($aktivitasKlub)
            ->sortByDesc('created_at')
            ->take(5);

        // Statistik Klub
        $klubStats = [
            'aktif' => Klub::aktif()->count(),
            'nonaktif' => Klub::nonaktif()->count(),
            'cabang_aktif' => Cabor::aktif()->count(),
        ];

        // Provinsi dengan klub terbanyak
        $klubPerProvinsi = Klub::selectRaw('provinsi, COUNT(*) as total')
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->first();

        // Top 3 Kota dengan klub terbanyak
        $klubPerKota = Klub::selectRaw('kota, COUNT(*) as total')
            ->where('status', 'aktif')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->take(3)
            ->get();

        // Data untuk Chart - Pertumbuhan Atlit per Bulan (6 bulan terakhir)
        $chartAtlit = Atlit::selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get()
            ->map(function ($item) {
                return [
                    'bulan' => Carbon::create()->month($item->bulan)->locale('id')->format('M Y'),
                    'total' => $item->total
                ];
            });

        // Data untuk Chart - Distribusi Atlit per Cabang Olahraga (Top 5)
        $chartCabor = Atlit::select('cabang_olahraga_id', DB::raw('COUNT(*) as total'))
            ->with('cabangOlahraga:id,nama_cabang')
            ->groupBy('cabang_olahraga_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->cabangOlahraga->nama_cabang ?? 'Tidak ada',
                    'total' => $item->total
                ];
            });

        // Data untuk Chart - Prestasi per Tingkat Kejuaraan
        $chartPrestasi = Prestasi::selectRaw('tingkat_kejuaraan, COUNT(*) as total')
            ->where('status', 'verified')
            ->groupBy('tingkat_kejuaraan')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return [
                    'tingkat' => $item->tingkat_kejuaraan,
                    'total' => $item->total
                ];
            });

        // Statistik Prestasi
        $prestasiStats = Prestasi::getStatistikPrestasi();

        // Atlit Berprestasi (Top 5 berdasarkan jumlah prestasi)
        $atletBerprestasi = Atlit::withCount(['prestasi' => function ($query) {
            $query->where('status', 'verified');
        }])
            ->with('cabangOlahraga:id,nama_cabang', 'klub:id,nama_klub')
            ->having('prestasi_count', '>', 0)
            ->orderByDesc('prestasi_count')
            ->take(5)
            ->get();

        // Status Verifikasi Atlit
        $verifikasiStats = [
            'pending' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
            'verified' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
            'rejected' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),
        ];

        // Atlit Terbaru yang Perlu Diverifikasi
        $atlitPendingVerifikasi = Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)
            ->with('cabangOlahraga:id,nama_cabang', 'klub:id,nama_klub')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'klubTerbaru',
            'aktivitas',
            'klubStats',
            'klubPerProvinsi',
            'klubPerKota',
            'chartAtlit',
            'chartCabor',
            'chartPrestasi',
            'prestasiStats',
            'atletBerprestasi',
            'verifikasiStats',
            'atlitPendingVerifikasi'
        ));
    }

    /**
     * Export data dashboard ke Excel
     */
    public function exportDashboard()
    {
        // Method untuk export data yang akan kita buat nanti
        // Menunggu arahan Anda apakah menggunakan Laravel Excel atau cara lain
    }


    /**
     * Dashboard untuk Verifikator dengan data lengkap
     */
    public function verifikatorDashboard()
    {
        $verifikatorId = Auth::id();

        // Statistik Atlit
        $atlitStats = [
            'pending' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
            'verified' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
            'rejected' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),
            'total' => Atlit::count(),
        ];

        // Statistik Prestasi
        $prestasiStats = [
            'pending' => Prestasi::where('status', 'pending')->count(),
            'verified' => Prestasi::where('status', 'verified')->count(),
            'rejected' => Prestasi::where('status', 'rejected')->count(),
            'total' => Prestasi::count(),
        ];

        // Atlit Pending Verifikasi (10 terbaru)
        $atlitPending = Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)
            ->with(['cabangOlahraga:id,nama_cabang', 'klub:id,nama_klub'])
            ->latest()
            ->take(10)
            ->get();

        // Prestasi Pending Verifikasi (10 terbaru)
        $prestasiPending = Prestasi::where('status', 'pending')
            ->with(['atlit:id,nama_lengkap', 'cabangOlahraga:id,nama_cabang'])
            ->latest()
            ->take(10)
            ->get();

        // Aktivitas Verifikasi Hari Ini (yang dilakukan oleh verifikator ini)
        $aktivitasHariIni = [
            'atlit_verified' => Atlit::where('verified_by', $verifikatorId)
                ->whereDate('verified_at', Carbon::today())
                ->count(),
            'atlit_rejected' => Atlit::where('verified_by', $verifikatorId)
                ->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)
                ->whereDate('verified_at', Carbon::today())
                ->count(),
        ];

        // History Verifikasi Terbaru (10 terakhir yang dilakukan verifikator ini)
        $historyVerifikasi = Atlit::where('verified_by', $verifikatorId)
            ->whereNotNull('verified_at')
            ->with(['cabangOlahraga:id,nama_cabang', 'klub:id,nama_klub'])
            ->latest('verified_at')
            ->take(10)
            ->get();

        // Chart - Verifikasi per Minggu (4 minggu terakhir)
        $chartVerifikasi = [];
        for ($i = 3; $i >= 0; $i--) {
            $startWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endWeek = Carbon::now()->subWeeks($i)->endOfWeek();

            $verified = Atlit::where('verified_by', $verifikatorId)
                ->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)
                ->whereBetween('verified_at', [$startWeek, $endWeek])
                ->count();

            $rejected = Atlit::where('verified_by', $verifikatorId)
                ->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)
                ->whereBetween('verified_at', [$startWeek, $endWeek])
                ->count();

            $chartVerifikasi[] = [
                'minggu' => $startWeek->format('d M') . ' - ' . $endWeek->format('d M'),
                'verified' => $verified,
                'rejected' => $rejected,
            ];
        }

        // Chart - Distribusi Status Atlit
        $chartStatusAtlit = [
            ['status' => 'Pending', 'total' => $atlitStats['pending']],
            ['status' => 'Terverifikasi', 'total' => $atlitStats['verified']],
            ['status' => 'Ditolak', 'total' => $atlitStats['rejected']],
        ];

        // Chart - Distribusi Status Prestasi
        $chartStatusPrestasi = [
            ['status' => 'Pending', 'total' => $prestasiStats['pending']],
            ['status' => 'Terverifikasi', 'total' => $prestasiStats['verified']],
            ['status' => 'Ditolak', 'total' => $prestasiStats['rejected']],
        ];

        // Total Verifikasi oleh Verifikator Ini
        $totalVerifikasiSaya = Atlit::where('verified_by', $verifikatorId)
            ->whereNotNull('verified_at')
            ->count();

        // Statistik Performa Verifikator
        $performaStats = [
            'hari_ini' => $aktivitasHariIni['atlit_verified'] + $aktivitasHariIni['atlit_rejected'],
            'minggu_ini' => Atlit::where('verified_by', $verifikatorId)
                ->whereBetween('verified_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
            'bulan_ini' => Atlit::where('verified_by', $verifikatorId)
                ->whereMonth('verified_at', Carbon::now()->month)
                ->whereYear('verified_at', Carbon::now()->year)
                ->count(),
            'total' => $totalVerifikasiSaya,
        ];

        // Cabang Olahraga dengan Atlit Pending Terbanyak
        $caborPendingTerbanyak = Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)
            ->select('cabang_olahraga_id', DB::raw('COUNT(*) as total'))
            ->with('cabangOlahraga:id,nama_cabang')
            ->groupBy('cabang_olahraga_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->cabangOlahraga->nama_cabang ?? 'Tidak ada',
                    'total' => $item->total
                ];
            });

        return view('verifikator.dashboard', compact(
            'atlitStats',
            'prestasiStats',
            'atlitPending',
            'prestasiPending',
            'aktivitasHariIni',
            'historyVerifikasi',
            'chartVerifikasi',
            'chartStatusAtlit',
            'chartStatusPrestasi',
            'performaStats',
            'caborPendingTerbanyak'
        ));
    }
}
