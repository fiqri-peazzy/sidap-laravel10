<?php

namespace App\Livewire\Verifikator;

use App\Models\Atlit;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use Livewire\Component;
use Livewire\WithPagination;

class AtlitIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Stats from controller
    public $initialStats = [];

    // Filter properties
    public $search = '';
    public $statusFilter = '';
    public $caborFilter = '';
    public $kategoriFilter = '';
    public $perPage = 10;

    // Status options
    public $statusOptions = [
        '' => 'Semua Status',
        'pending' => 'Menunggu Verifikasi',
        'diverifikasi' => 'Terverifikasi',
        'ditolak' => 'Ditolak'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'caborFilter' => ['except' => ''],
        'kategoriFilter' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $listeners = [
        'refreshStats' => 'refreshStats',
        'refreshAtletsList' => '$refresh'
    ];

    public function mount($initialStats = [])
    {
        $this->initialStats = $initialStats;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCaborFilter()
    {
        $this->resetPage();
    }

    public function updatingKategoriFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'caborFilter', 'kategoriFilter']);
        $this->resetPage();
        // $this->emit('showAlert', 'info', 'Filter berhasil direset');
    }

    public function refreshStats()
    {
        // Refresh stats in real-time
        $this->initialStats = [
            'total' => Atlit::count(),
            'pending' => Atlit::where('status_verifikasi', 'pending')->count(),
            'verified' => Atlit::where('status_verifikasi', 'diverifikasi')->count(),
            'rejected' => Atlit::where('status_verifikasi', 'ditolak')->count(),
        ];
    }

    public function quickFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
        $this->emit('showAlert', 'info', 'Filter diterapkan: ' . ($this->statusOptions[$status] ?? 'Semua Status'));
    }

    public function exportData()
    {
        // Method untuk export data (bisa dikembangkan kemudian)
        $this->emit('showAlert', 'info', 'Fitur export akan segera tersedia!');
    }

    public function render()
    {
        $atlets = Atlit::query()
            ->with(['cabangOlahraga', 'kategoriAtlit', 'klub', 'user'])
            ->withCount([
                'dokumen',
                'dokumen as verified_documents_count' => function ($query) {
                    $query->where('status_verifikasi', 'verified');
                },
                'dokumen as pending_documents_count' => function ($query) {
                    $query->where('status_verifikasi', 'pending');
                },
                'dokumen as rejected_documents_count' => function ($query) {
                    $query->where('status_verifikasi', 'rejected');
                }
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status_verifikasi', $this->statusFilter);
            })
            ->when($this->caborFilter, function ($query) {
                $query->where('cabang_olahraga_id', $this->caborFilter);
            })
            ->when($this->kategoriFilter, function ($query) {
                $query->where('kategori_atlit_id', $this->kategoriFilter);
            })
            ->latest('created_at')
            ->paginate($this->perPage);

        $cabors = Cabor::orderBy('nama_cabang')->get();
        $kategoris = KategoriAtlit::orderBy('nama_kategori')->get();

        // Use current stats or initial stats
        $stats = !empty($this->initialStats) ? $this->initialStats : [
            'total' => Atlit::count(),
            'pending' => Atlit::where('status_verifikasi', 'pending')->count(),
            'verified' => Atlit::where('status_verifikasi', 'diverifikasi')->count(),
            'rejected' => Atlit::where('status_verifikasi', 'ditolak')->count(),
        ];

        return view('livewire.verifikator.atlit-index', compact('atlets', 'cabors', 'kategoris', 'stats'));
    }
}
