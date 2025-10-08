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

    // Status options - KOREKSI: Gunakan konstanta dari Model
    public $statusOptions = [];

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

        // KOREKSI: Inisialisasi status options dari konstanta Model
        $this->statusOptions = [
            '' => 'Semua Status',
            Atlit::STATUS_VERIFIKASI_PENDING => 'Menunggu Verifikasi',
            Atlit::STATUS_VERIFIKASI_VERIFIED => 'Terverifikasi',
            Atlit::STATUS_VERIFIKASI_REJECTED => 'Ditolak'
        ];

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

        // PERBAIKAN: Gunakan session flash untuk notifikasi
        session()->flash('message', 'Filter berhasil direset');
    }

    public function refreshStats()
    {
        // KOREKSI: Gunakan konstanta dari Model
        $this->initialStats = [
            'total' => Atlit::count(),
            'pending' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
            'verified' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
            'rejected' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),
        ];
    }

    public function quickFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();

        // PERBAIKAN: Gunakan session flash untuk notifikasi
        session()->flash('message', 'Filter diterapkan: ' . ($this->statusOptions[$status] ?? 'Semua Status'));
    }

    public function exportData()
    {
        // PERBAIKAN: Gunakan session flash untuk notifikasi
        session()->flash('info', 'Fitur export akan segera tersedia!');
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
                $query->search($this->search); // KOREKSI: Gunakan scope search dari Model
            })
            ->when($this->statusFilter, function ($query) {
                $query->byStatusVerifikasi($this->statusFilter); // KOREKSI: Gunakan scope dari Model
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

        // KOREKSI: Gunakan konstanta dari Model untuk stats
        $stats = !empty($this->initialStats) ? $this->initialStats : [
            'total' => Atlit::count(),
            'pending' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
            'verified' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
            'rejected' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),
        ];

        return view('livewire.verifikator.atlit-index', compact('atlets', 'cabors', 'kategoris', 'stats'));
    }
}
