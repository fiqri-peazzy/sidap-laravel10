<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prestasi;
use App\Models\Atlit;
use App\Models\Cabor;

class LaporanPrestasi extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $atlit_id = '';
    public $cabang_olahraga_id = '';
    public $tingkat_kejuaraan = '';
    public $tahun = '';
    public $medali = '';
    public $search = '';

    protected $updatesQueryString = ['atlit_id', 'cabang_olahraga_id', 'tingkat_kejuaraan', 'tahun', 'medali', 'search'];

    public function mount()
    {
        $this->atlit_id = request('atlit_id', '');
        $this->cabang_olahraga_id = request('cabang_olahraga_id', '');
        $this->tingkat_kejuaraan = request('tingkat_kejuaraan', '');
        $this->tahun = request('tahun', '');
        $this->medali = request('medali', '');
        $this->search = request('search', '');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAtlitId()
    {
        $this->resetPage();
    }

    public function updatingCabangOlahragaId()
    {
        $this->resetPage();
    }

    public function updatingTingkatKejuaraan()
    {
        $this->resetPage();
    }

    public function updatingTahun()
    {
        $this->resetPage();
    }

    public function updatingMedali()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->atlit_id = '';
        $this->cabang_olahraga_id = '';
        $this->tingkat_kejuaraan = '';
        $this->tahun = '';
        $this->medali = '';
        $this->search = '';
        $this->resetPage();
    }

    public function cetakLaporan()
    {
        $params = [
            'atlit_id' => $this->atlit_id,
            'cabang_olahraga_id' => $this->cabang_olahraga_id,
            'tingkat_kejuaraan' => $this->tingkat_kejuaraan,
            'tahun' => $this->tahun,
            'medali' => $this->medali
        ];

        // Filter parameter kosong
        $params = array_filter($params);

        $url = route('admin.laporan.prestasi.cetak', $params);
        return redirect()->to($url);
    }

    public function render()
    {
        $query = Prestasi::with(['atlit', 'cabangOlahraga']);

        // Filter berdasarkan pencarian
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_kejuaraan', 'like', '%' . $this->search . '%')
                    ->orWhere('tempat_kejuaraan', 'like', '%' . $this->search . '%')
                    ->orWhere('nomor_pertandingan', 'like', '%' . $this->search . '%')
                    ->orWhereHas('atlit', function ($subq) {
                        $subq->where('nama_lengkap', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter berdasarkan atlit
        if ($this->atlit_id) {
            $query->where('atlit_id', $this->atlit_id);
        }

        // Filter berdasarkan cabang olahraga
        if ($this->cabang_olahraga_id) {
            $query->where('cabang_olahraga_id', $this->cabang_olahraga_id);
        }

        // Filter berdasarkan tingkat kejuaraan
        if ($this->tingkat_kejuaraan) {
            $query->where('tingkat_kejuaraan', $this->tingkat_kejuaraan);
        }

        // Filter berdasarkan tahun
        if ($this->tahun) {
            $query->where('tahun', $this->tahun);
        }

        // Filter berdasarkan medali
        if ($this->medali) {
            $query->where('medali', $this->medali);
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

        return view('livewire.laporan-prestasi', [
            'prestasi' => $prestasi,
            'atlit' => $atlit,
            'cabangOlahraga' => $cabangOlahraga,
            'tingkatKejuaraan' => $tingkatKejuaraan,
            'tahunList' => $tahunList,
            'medaliList' => $medaliList,
            'totalPrestasi' => $totalPrestasi,
            'prestasiEmas' => $prestasiEmas,
            'prestasiPerak' => $prestasiPerak,
            'prestasiPerunggu' => $prestasiPerunggu
        ]);
    }
}
