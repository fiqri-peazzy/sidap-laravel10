<?php

namespace App\Livewire\Verifikator;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prestasi;
use App\Models\Cabor;

class VerifikasiPrestasiIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filter properties
    public $search = '';
    public $statusFilter = '';
    public $tahunFilter = '';
    public $caborFilter = '';
    public $perPage = 15;

    // Listeners
    protected $listeners = ['refreshData' => '$refresh'];

    // Query string untuk maintain state saat refresh
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => '', 'as' => 'status'],
        'tahunFilter' => ['except' => '', 'as' => 'tahun'],
        'caborFilter' => ['except' => '', 'as' => 'cabor'],
    ];

    public function mount()
    {
        // Set filter status dari query string jika ada
        if (request()->has('status')) {
            $this->statusFilter = request()->get('status');
        }
    }

    // Method yang dipanggil saat property di-update
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedTahunFilter()
    {
        $this->resetPage();
    }

    public function updatedCaborFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->tahunFilter = '';
        $this->caborFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Prestasi::with(['atlit.klub', 'cabangOlahraga'])
            ->orderBy('created_at', 'desc')
            ->orderBy('tanggal_mulai', 'desc');

        // Filter status
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Filter pencarian
        if ($this->search) {
            $query->search($this->search);
        }

        // Filter tahun
        if ($this->tahunFilter) {
            $query->byTahun($this->tahunFilter);
        }

        // Filter cabang olahraga
        if ($this->caborFilter) {
            $query->byCabor($this->caborFilter);
        }

        $prestasi = $query->paginate($this->perPage);

        // Data untuk filter dropdown
        $years = Prestasi::getAvailableYears();
        $cabors = Cabor::aktif()->orderBy('nama_cabang')->get();

        // Statistik
        $statistik = [
            'total' => Prestasi::count(),
            'pending' => Prestasi::where('status', 'pending')->count(),
            'verified' => Prestasi::where('status', 'verified')->count(),
            'rejected' => Prestasi::where('status', 'rejected')->count(),
        ];

        return view('livewire.verifikator.verifikasi-prestasi-index', [
            'prestasi' => $prestasi,
            'years' => $years,
            'cabors' => $cabors,
            'statistik' => $statistik,
        ]);
    }
}