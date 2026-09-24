<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Atlit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sekolahId = Auth::user()->sekolah_id;
        $sekolah = Auth::user()->sekolah;

        $stats = [
            'total' => Atlit::where('sekolah_id', $sekolahId)->count(),
            'pending' => Atlit::where('sekolah_id', $sekolahId)->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
            'verified' => Atlit::where('sekolah_id', $sekolahId)->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
            'rejected' => Atlit::where('sekolah_id', $sekolahId)->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),
        ];

        $atlitTerbaru = Atlit::where('sekolah_id', $sekolahId)
            ->with(['klub', 'cabangOlahraga'])
            ->latest()
            ->take(5)
            ->get();

        // ========================================
        // CHART: Distribusi Atlet per Cabang Olahraga
        // ========================================
        $chartCabor = Atlit::where('sekolah_id', $sekolahId)
            ->select('cabang_olahraga_id', DB::raw('COUNT(*) as total'))
            ->with('cabangOlahraga:id,nama_cabang')
            ->groupBy('cabang_olahraga_id')
            ->get()
            ->map(fn ($item) => [
                'nama' => $item->cabangOlahraga->nama_cabang ?? 'Tidak diketahui',
                'total' => $item->total,
            ]);

        // ========================================
        // CHART: Distribusi Status Verifikasi
        // ========================================
        $chartStatusVerifikasi = [
            ['status' => 'Menunggu', 'total' => $stats['pending']],
            ['status' => 'Terverifikasi', 'total' => $stats['verified']],
            ['status' => 'Ditolak', 'total' => $stats['rejected']],
        ];

        // ========================================
        // CHART: Tren Pendaftaran Atlet 6 Bulan Terakhir
        // ========================================
        $chartTren = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $jumlah = Atlit::where('sekolah_id', $sekolahId)
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->count();

            $chartTren[] = [
                'label' => $bulan->translatedFormat('M Y'),
                'total' => $jumlah,
            ];
        }

        // ========================================
        // RIWAYAT AKTIVITAS
        // ========================================
        $aktivitasBaru = Atlit::where('sekolah_id', $sekolahId)
            ->latest('created_at')
            ->take(15)
            ->get()
            ->map(fn ($a) => [
                'type' => 'ditambahkan',
                'nama' => $a->nama_lengkap,
                'timestamp' => $a->created_at,
                'keterangan' => null,
            ]);

        $aktivitasVerifikasi = Atlit::where('sekolah_id', $sekolahId)
            ->whereNotNull('verified_at')
            ->with('verifikator:id,name')
            ->latest('verified_at')
            ->take(15)
            ->get()
            ->map(fn ($a) => [
                'type' => $a->status_verifikasi,
                'nama' => $a->nama_lengkap,
                'timestamp' => $a->verified_at,
                'keterangan' => $a->status_verifikasi === Atlit::STATUS_VERIFIKASI_REJECTED
                    ? $a->catatan_verifikasi
                    : ($a->verifikator->name ?? null),
            ]);

        $riwayatAktivitas = $aktivitasBaru
            ->concat($aktivitasVerifikasi)
            ->sortByDesc('timestamp')
            ->take(15)
            ->values();

        return view('sekolah.dashboard', compact(
            'sekolah',
            'stats',
            'atlitTerbaru',
            'chartCabor',
            'chartStatusVerifikasi',
            'chartTren',
            'riwayatAktivitas'
        ));
    }
}
