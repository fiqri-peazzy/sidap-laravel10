<?php

namespace App\Http\Controllers\Sekolah;

use App\Exports\AtlitSekolahExport;
use App\Http\Controllers\Controller;
use App\Models\Atlit;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $sekolahId = Auth::user()->sekolah_id;

        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit'])
            ->where('sekolah_id', $sekolahId);

        $this->applyFilters($query, $request);

        $atlit = $query->orderBy('nama_lengkap')->paginate(15)->withQueryString();

        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        $kategoriAtlit = $request->cabang_olahraga_id
            ? KategoriAtlit::where('cabang_olahraga_id', $request->cabang_olahraga_id)->aktif()->orderBy('nama_kategori')->get()
            : collect();

        return view('sekolah.laporan.index', compact('atlit', 'cabangOlahraga', 'kategoriAtlit'));
    }

    public function cetakPdf(Request $request)
    {
        $sekolah = Auth::user()->sekolah;

        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit'])
            ->where('sekolah_id', $sekolah->id);

        $this->applyFilters($query, $request);

        $atlit = $query->orderBy('nama_lengkap')->get();

        $data = [
            'sekolah' => $sekolah,
            'atlit' => $atlit,
            'tanggal_cetak' => Carbon::now()->format('d F Y'),
            'user_cetak' => Auth::user()->name,
        ];

        $pdf = Pdf::loadView('sekolah.laporan.atlit-pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-atlet-' . str_replace(' ', '-', strtolower($sekolah->nama_sekolah)) . '-' . date('Y-m-d') . '.pdf');
    }

    public function cetakExcel(Request $request)
    {
        $sekolahId = Auth::user()->sekolah_id;

        $filters = $request->only(['cabang_olahraga_id', 'kategori_atlit_id', 'status_verifikasi']);

        return Excel::download(new AtlitSekolahExport($sekolahId, $filters), 'laporan-atlet-' . date('Y-m-d') . '.xlsx');
    }

    private function applyFilters($query, Request $request)
    {
        if ($request->cabang_olahraga_id) {
            $query->where('cabang_olahraga_id', $request->cabang_olahraga_id);
        }
        if ($request->kategori_atlit_id) {
            $query->where('kategori_atlit_id', $request->kategori_atlit_id);
        }
        if ($request->status_verifikasi) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }
    }
}
