<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Atlit;
use App\Models\Prestasi;
use App\Models\Cabor;
use App\Models\Klub;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Laporan Atlit
    public function atlit(Request $request)
    {
        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit']);
        // Filter berdasarkan parameter
        if ($request->klub_id) {
            $query->where('klub_id', $request->klub_id);
        }
        if ($request->cabang_olahraga_id) {
            $query->where('cabang_olahraga_id', $request->cabang_olahraga_id);
        }
        if ($request->jenis_kelamin) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        $atlit = $query->orderBy('nama_lengkap')->paginate(10);
        $klub = Klub::where('status', 'Aktif')->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::where('status', 'Aktif')->orderBy('nama_cabang')->get();
        // Statistik
        $totalAtlit = Atlit::count();
        $atlitPria = Atlit::where('jenis_kelamin', 'Laki-laki')->count();
        $atlitWanita = Atlit::where('jenis_kelamin', 'Perempuan')->count();
        $atlitAktif = Atlit::where('status', 'Aktif')->count();
        return view('admin.laporan.atlit', compact(
            'atlit',
            'klub',
            'cabangOlahraga',
            'totalAtlit',
            'atlitPria',
            'atlitWanita',
            'atlitAktif'
        ));
    }
    // Laporan Prestasi
    public function prestasi(Request $request)
    {
        $query = Prestasi::with(['atlit', 'cabangOlahraga']);
        // Filter berdasarkan parameter
        if ($request->atlit_id) {
            $query->where('atlit_id', $request->atlit_id);
        }
        if ($request->cabang_olahraga_id) {
            $query->where('cabang_olahraga_id', $request->cabang_olahraga_id);
        }
        if ($request->tingkat_kejuaraan) {
            $query->where('tingkat_kejuaraan', $request->tingkat_kejuaraan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->medali) {
            $query->where('medali', $request->medali);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kejuaraan', 'like', '%' . $request->search . '%')
                    ->orWhere('tempat_kejuaraan', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_pertandingan', 'like', '%' . $request->search . '%')
                    ->orWhereHas('atlit', function ($subq) use ($request) {
                        $subq->where('nama_lengkap', 'like', '%' . $request->search . '%');
                    });
            });
        }
        $prestasi = $query->orderBy('tahun', 'desc')->orderBy('tanggal_mulai', 'desc')->paginate(10);
        $atlit = Atlit::where('status', 'Aktif')->orderBy('nama_lengkap')->get();
        $cabangOlahraga = Cabor::where('status', 'Aktif')->orderBy('nama_cabang')->get();
        // Get unique values for filters
        $tingkatKejuaraan = Prestasi::select('tingkat_kejuaraan')->distinct()->orderBy('tingkat_kejuaraan')->pluck('tingkat_kejuaraan');
        $tahunList = Prestasi::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $medaliList = Prestasi::select('medali')->distinct()->orderBy('medali')->pluck('medali');
        // Statistik
        $totalPrestasi = Prestasi::count();
        $prestasiEmas = Prestasi::where('medali', 'Emas')->count();
        $prestasiPerak = Prestasi::where('medali', 'Perak')->count();
        $prestasiPerunggu = Prestasi::where('medali', 'Perunggu')->count();
        return view('admin.laporan.prestasi', compact(
            'prestasi',
            'atlit',
            'cabangOlahraga',
            'tingkatKejuaraan',
            'tahunList',
            'medaliList',
            'totalPrestasi',
            'prestasiEmas',
            'prestasiPerak',
            'prestasiPerunggu'
        ));
    }
    // Statistik
    public function statistik(Request $request)
    {
        $tahunPilihan = $request->get('tahun', date('Y'));
        $cabangOlahragaPilihan = $request->get('cabang_olahraga_id', '');
        // Statistik Umum
        $totalAtlit = Atlit::count();
        $totalPrestasi = Prestasi::count();
        $totalKlub = Klub::where('status', 'Aktif')->count();
        $totalCabor = Cabor::where('status', 'Aktif')->count();
        // Statistik berdasarkan jenis kelamin
        $atlitPria = Atlit::where('jenis_kelamin', 'Laki-laki')->count();
        $atlitWanita = Atlit::where('jenis_kelamin', 'Perempuan')->count();
        // Statistik berdasarkan status
        $atlitAktif = Atlit::where('status', 'Aktif')->count();
        $atlitTidakAktif = Atlit::where('status', 'Tidak Aktif')->count();
        // Statistik berdasarkan umur
        $umur17Kebawah = Atlit::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 17')->count();
        $umur18_25 = Atlit::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 25')->count();
        $umur26Keatas = Atlit::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 26')->count();
        // Statistik prestasi berdasarkan medali
        $query = Prestasi::query();
        if ($tahunPilihan) {
            $query->where('tahun', $tahunPilihan);
        }
        if ($cabangOlahragaPilihan) {
            $query->where('cabang_olahraga_id', $cabangOlahragaPilihan);
        }
        $prestasiEmas = $query->clone()->where('medali', 'Emas')->count();
        $prestasiPerak = $query->clone()->where('medali', 'Perak')->count();
        $prestasiPerunggu = $query->clone()->where('medali', 'Perunggu')->count();
        // Statistik berdasarkan tingkat kejuaraan
        $prestasiInternasional = $query->clone()->where('tingkat_kejuaraan', 'Internasional')->count();
        $prestasiNasional = $query->clone()->where('tingkat_kejuaraan', 'Nasional')->count();
        $prestasiProvinsi = $query->clone()->where('tingkat_kejuaraan', 'Provinsi')->count();
        $prestasiDaerah = $query->clone()->where('tingkat_kejuaraan', 'Daerah')->count();
        // Top 5 Cabang Olahraga berdasarkan jumlah atlit
        $topCaborAtlit = Cabor::withCount('atlit')
            ->where('status', 'Aktif')
            ->orderBy('atlit_count', 'desc')
            ->take(5)
            ->get();
        // Top 5 Klub berdasarkan jumlah atlit
        $topKlubAtlit = Klub::withCount('atlit')
            ->where('status', 'Aktif')
            ->orderBy('atlit_count', 'desc')
            ->take(5)
            ->get();
        // Top 5 Atlit berdasarkan jumlah prestasi
        $topAtlitPrestasi = Atlit::withCount('prestasi')
            ->orderBy('prestasi_count', 'desc')
            ->take(5)
            ->get();
        // Data untuk chart prestasi per tahun (5 tahun terakhir)
        $tahunSekarang = date('Y');
        $prestasiPerTahun = [];
        for ($i = 4; $i >= 0; $i--) {
            $tahun = $tahunSekarang - $i;
            $jumlah = Prestasi::where('tahun', $tahun)->count();
            $prestasiPerTahun[] = [
                'tahun' => $tahun,
                'jumlah' => $jumlah
            ];
        }
        // Data untuk chart prestasi per cabang olahraga
        $prestasiPerCabor = Cabor::with(['prestasi' => function ($q) use ($tahunPilihan) {
            if ($tahunPilihan) {
                $q->where('tahun', $tahunPilihan);
            }
        }])
            ->where('status', 'Aktif')
            ->get()
            ->map(function ($cabor) {
                return [
                    'nama' => $cabor->nama_cabang,
                    'jumlah' => $cabor->prestasi->count()
                ];
            })
            ->sortByDesc('jumlah')
            ->take(10);
        // List tahun dan cabang olahraga untuk filter
        $tahunList = Prestasi::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $cabangOlahraga = Cabor::where('status', 'Aktif')->orderBy('nama_cabang')->get();
        return view('admin.laporan.statistik', compact(
            'totalAtlit',
            'totalPrestasi',
            'totalKlub',
            'totalCabor',
            'atlitPria',
            'atlitWanita',
            'atlitAktif',
            'atlitTidakAktif',
            'umur17Kebawah',
            'umur18_25',
            'umur26Keatas',
            'prestasiEmas',
            'prestasiPerak',
            'prestasiPerunggu',
            'prestasiInternasional',
            'prestasiNasional',
            'prestasiProvinsi',
            'prestasiDaerah',
            'topCaborAtlit',
            'topKlubAtlit',
            'topAtlitPrestasi',
            'prestasiPerTahun',
            'prestasiPerCabor',
            'tahunList',
            'cabangOlahraga',
            'tahunPilihan',
            'cabangOlahragaPilihan'
        ));
    }
    public function cetakAtlit(Request $request)
    {
        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit']);
        // Filter berdasarkan parameter
        if ($request->klub_id) {
            $query->where('klub_id', $request->klub_id);
        }
        if ($request->cabang_olahraga_id) {
            $query->where('cabang_olahraga_id', $request->cabang_olahraga_id);
        }
        if ($request->jenis_kelamin) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $atlit = $query->orderBy('nama_lengkap')->get();
        $data = [
            'title' => 'Laporan Data Atlit PPLP Provinsi Gorontalo',
            'atlit' => $atlit,
            'filter' => $request->all(),
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i:s')
        ];
        $pdf = Pdf::loadView('admin.laporan.atlit-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('laporan-atlit-' . date('Y-m-d') . '.pdf');
    }
    public function cetakPrestasi(Request $request)
    {
        $query = Prestasi::with(['atlit', 'cabangOlahraga']);
        // Filter berdasarkan parameter
        if ($request->atlit_id) {
            $query->where('atlit_id', $request->atlit_id);
        }
        if ($request->cabang_olahraga_id) {
            $query->where('cabang_olahraga_id', $request->cabang_olahraga_id);
        }
        if ($request->tingkat_kejuaraan) {
            $query->where('tingkat_kejuaraan', $request->tingkat_kejuaraan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->medali) {
            $query->where('medali', $request->medali);
        }
        $prestasi = $query->orderBy('tahun', 'desc')->orderBy('tanggal_mulai', 'desc')->get();
        $data = [
            'title' => 'Laporan Prestasi Atlit PPLP Provinsi Gorontalo',
            'prestasi' => $prestasi,
            'filter' => $request->all(),
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i:s')
        ];
        $pdf = Pdf::loadView('admin.laporan.prestasi-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('laporan-prestasi-' . date('Y-m-d') . '.pdf');
    }
}
