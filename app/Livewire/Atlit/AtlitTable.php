<?php

namespace App\Livewire\Atlit;

use App\Models\Atlit;
use App\Models\Klub;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class AtlitTable extends Component


{
    use WithPagination;

    public $search = '';
    public $filterKlub = '';
    public $filterCabor = '';
    public $filterKategori = '';
    public $filterStatus = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterKlub' => ['except' => ''],
        'filterCabor' => ['except' => ''],
        'filterKategori' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterKlub()
    {
        $this->resetPage();
    }

    public function updatingFilterCabor()
    {
        $this->resetPage();
        $this->filterKategori = ''; // Reset kategori ketika cabor berubah
    }

    public function updatingFilterKategori()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterKlub = '';
        $this->filterCabor = '';
        $this->filterKategori = '';
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function delete($id)
    {
        $atlit = Atlit::find($id);

        if ($atlit) {
            // Hapus foto jika ada
            if ($atlit->foto) {
                Storage::disk('public')->delete('atlit/foto/' . $atlit->foto);
            }

            // Hapus user terkait jika ada
            if ($atlit->user_id) {
                \App\Models\User::find($atlit->user_id)->delete();
            }

            $atlit->delete();
            session()->flash('success', 'Data atlit berhasil dihapus.');
        }
    }

    public function render()
    {
        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit']);

        // Apply search
        if ($this->search) {
            $query->search($this->search);
        }

        // Apply filters
        if ($this->filterKlub) {
            $query->where('klub_id', $this->filterKlub);
        }

        if ($this->filterCabor) {
            $query->where('cabang_olahraga_id', $this->filterCabor);
        }

        if ($this->filterKategori) {
            $query->where('kategori_atlit_id', $this->filterKategori);
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $atlit = $query->latest()->paginate($this->perPage);

        // Data untuk dropdown filter
        $klub = Klub::aktif()->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        $kategoriAtlit = collect();

        if ($this->filterCabor) {
            $kategoriAtlit = KategoriAtlit::where('cabang_olahraga_id', $this->filterCabor)
                ->aktif()
                ->orderBy('nama_kategori')
                ->get();
        }

        return view('livewire.atlit.atlit-table', compact('atlit', 'klub', 'cabangOlahraga', 'kategoriAtlit'));
    }
}
