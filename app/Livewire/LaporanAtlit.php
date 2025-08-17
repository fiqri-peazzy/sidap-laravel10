<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Atlit;
use App\Models\Klub;
use App\Models\Cabor;

class LaporanAtlit extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $klub_id = '';
    public $cabang_olahraga_id = '';
    public $jenis_kelamin = '';
    public $status = '';
    public $search = '';

    protected $updatesQueryString = ['klub_id', 'cabang_olahraga_id', 'jenis_kelamin', 'status', 'search'];

    public function mount()
    {
        $this->klub_id = request('klub_id', '');
        $this->cabang_olahraga_id = request('cabang_olahraga_id', '');
        $this->jenis_kelamin = request('jenis_kelamin', '');
        $this->status = request('status', '');
        $this->search = request('search', '');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKlubId()
    {
        $this->resetPage();
    }

    public function updatingCabangOlahragaId()
    {
        $this->resetPage();
    }

    public function updatingJenisKelamin()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->klub_id = '';
        $this->cabang_olahraga_id = '';
        $this->jenis_kelamin = '';
        $this->status = '';
        $this->search = '';
        $this->resetPage();
    }

    public function cetakLaporan()
    {
        $params = [
            'klub_id' => $this->klub_id,
            'cabang_olahraga_id' => $this->cabang_olahraga_id,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status' => $this->status
        ];

        // Filter parameter kosong
        $params = array_filter($params);

        $url = route('laporan.atlit.cetak', $params);
        return redirect()->to($url);
    }

    public function render()
    {
        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit']);

        // Filter berdasarkan pencarian
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Filter berdasarkan klub
        if ($this->klub_id) {
            $query->where('klub_id', $this->klub_id);
        }

        // Filter berdasarkan cabang olahraga
        if ($this->cabang_olahraga_id) {
            $query->where('cabang_olahraga_id', $this->cabang_olahraga_id);
        }

        // Filter berdasarkan jenis kelamin
        if ($this->jenis_kelamin) {
            $query->where('jenis_kelamin', $this->jenis_kelamin);
        }

        // Filter berdasarkan status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        $atlit = $query->orderBy('nama_lengkap')->paginate(10);
        $klub = Klub::where('status', 'Aktif')->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::where('status', 'Aktif')->orderBy('nama_cabang')->get();

        // Statistik
        $totalAtlit = Atlit::count();
        $atlitPria = Atlit::where('jenis_kelamin', 'L')->count();
        $atlitWanita = Atlit::where('jenis_kelamin', 'P')->count();
        $atlitAktif = Atlit::where('status', 'Aktif')->count();

        return view('livewire.laporan-atlit', [
            'atlit' => $atlit,
            'klub' => $klub,
            'cabangOlahraga' => $cabangOlahraga,
            'totalAtlit' => $totalAtlit,
            'atlitPria' => $atlitPria,
            'atlitWanita' => $atlitWanita,
            'atlitAktif' => $atlitAktif
        ]);
    }
}
