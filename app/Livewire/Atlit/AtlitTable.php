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

    // Fix: Gunakan updatedPropertyName untuk reactive updates
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterKlub()
    {
        $this->resetPage();
    }

    public function updatedFilterCabor()
    {
        $this->resetPage();
        $this->filterKategori = ''; // Reset kategori ketika cabor berubah
    }

    public function updatedFilterKategori()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    // Fix: Tambahkan method untuk perPage
    public function updatedPerPage()
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
        try {
            $atlit = Atlit::find($id);

            if ($atlit) {
                // Hapus foto jika ada
                if ($atlit->foto) {
                    Storage::disk('public')->delete('atlit/foto/' . $atlit->foto);
                }

                // Hapus user terkait jika ada
                if ($atlit->user_id) {
                    $user = \App\Models\User::find($atlit->user_id);
                    if ($user) {
                        $user->delete();
                    }
                }

                $atlit->delete();
                session()->flash('success', 'Data atlit berhasil dihapus.');
            } else {
                session()->flash('error', 'Data atlit tidak ditemukan.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit']);

        // Apply search - pastikan method search() ada di Model Atlit
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('nik', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            });
        }

        // Apply filters dengan pengecekan yang lebih robust
        if (!empty($this->filterKlub)) {
            $query->where('klub_id', $this->filterKlub);
        }

        if (!empty($this->filterCabor)) {
            $query->where('cabang_olahraga_id', $this->filterCabor);
        }

        if (!empty($this->filterKategori)) {
            $query->where('kategori_atlit_id', $this->filterKategori);
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        $atlit = $query->latest()->paginate($this->perPage);

        // Data untuk dropdown filter
        $klub = Klub::aktif()->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        $kategoriAtlit = collect();

        if (!empty($this->filterCabor)) {
            $kategoriAtlit = KategoriAtlit::where('cabang_olahraga_id', $this->filterCabor)
                ->aktif()
                ->orderBy('nama_kategori')
                ->get();
        }

        return view('livewire.atlit.atlit-table', compact('atlit', 'klub', 'cabangOlahraga', 'kategoriAtlit'));
    }
}
