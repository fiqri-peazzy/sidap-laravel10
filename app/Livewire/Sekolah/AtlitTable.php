<?php

namespace App\Livewire\Sekolah;

use App\Models\Atlit;
use App\Models\Klub;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AtlitTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCabor = '';
    public $filterKategori = '';
    public $filterStatus = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCabor' => ['except' => ''],
        'filterKategori' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterCabor()
    {
        $this->resetPage();
        $this->filterKategori = '';
    }

    public function updatedFilterKategori()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterCabor = '';
        $this->filterKategori = '';
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function delete($id)
    {
        $atlit = Atlit::where('sekolah_id', Auth::user()->sekolah_id)->find($id);

        if (!$atlit) {
            session()->flash('error', 'Data atlet tidak ditemukan atau bukan milik sekolah Anda.');
            return;
        }

        if ($atlit->foto) {
            Storage::disk('public')->delete('atlit/foto/' . $atlit->foto);
        }

        if ($atlit->user_id) {
            $atlit->user()->delete();
        }

        $atlit->delete();
        session()->flash('success', 'Data atlet berhasil dihapus.');
    }

    public function render()
    {
        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit'])
            ->where('sekolah_id', Auth::user()->sekolah_id);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('nik', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterCabor)) {
            $query->where('cabang_olahraga_id', $this->filterCabor);
        }

        if (!empty($this->filterKategori)) {
            $query->where('kategori_atlit_id', $this->filterKategori);
        }

        if (!empty($this->filterStatus)) {
            $query->where('status_verifikasi', $this->filterStatus);
        }

        $atlit = $query->latest()->paginate($this->perPage);

        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        $kategoriAtlit = collect();

        if (!empty($this->filterCabor)) {
            $kategoriAtlit = KategoriAtlit::where('cabang_olahraga_id', $this->filterCabor)
                ->aktif()
                ->orderBy('nama_kategori')
                ->get();
        }

        return view('livewire.sekolah.atlit-table', compact('atlit', 'cabangOlahraga', 'kategoriAtlit'));
    }
}
