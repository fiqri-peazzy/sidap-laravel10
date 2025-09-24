<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Atlit;
use App\Models\Prestasi;
use App\Models\Cabor;
use Livewire\WithPagination;

class PrestasiAtlit extends Component
{
    use WithPagination;

    public $atlit;

    // Filter properties
    public $filterTahun = '';
    public $filterCabor = '';
    public $filterStatus = '';
    public $filterTingkat = '';
    public $searchTerm = '';

    // View mode
    public $viewMode = 'cards'; // cards, timeline

    // Available options for filters
    public $availableYears = [];
    public $availableCabors = [];
    public $availableTingkat = [
        'Internasional',
        'Nasional',
        'Regional',
        'Provinsi',
        'Kabupaten/Kota',
        'Lokal'
    ];

    protected $paginationTheme = 'bootstrap';

    public function mount(Atlit $atlit)
    {
        $this->atlit = $atlit;
        $this->loadFilterOptions();
    }

    public function updating($field)
    {
        if (in_array($field, [
            'filterTahun',
            'filterCabor',
            'filterStatus',
            'filterTingkat',
            'searchTerm'
        ])) {
            $this->resetPage();
        }
    }

    public function loadFilterOptions()
    {
        // Load available years dari prestasi atlit
        $this->availableYears = Prestasi::where('atlit_id', $this->atlit->id)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        // Load available cabors
        $this->availableCabors = Cabor::whereHas('prestasi', function ($query) {
            $query->where('atlit_id', $this->atlit->id);
        })
            ->orderBy('nama_cabang')
            ->get();
    }

    private function buildQuery()
    {
        $query = Prestasi::with(['cabangOlahraga'])
            ->where('atlit_id', $this->atlit->id);

        // Apply filters
        if ($this->filterTahun) {
            $query->where('tahun', $this->filterTahun);
        }
        if ($this->filterCabor) {
            $query->where('cabang_olahraga_id', $this->filterCabor);
        }
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterTingkat) {
            $query->where('tingkat_kejuaraan', 'like', '%' . $this->filterTingkat . '%');
        }
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('nama_kejuaraan', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('tempat_kejuaraan', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nomor_pertandingan', 'like', '%' . $this->searchTerm . '%');
            });
        }

        return $query;
    }

    public function resetFilters()
    {
        $this->filterTahun = '';
        $this->filterCabor = '';
        $this->filterStatus = '';
        $this->filterTingkat = '';
        $this->searchTerm = '';
        $this->resetPage();
    }

    public function switchViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    private function getStatistikPrestasi($prestasi)
    {
        return [
            'total'     => $prestasi->count(),
            'verified'  => $prestasi->where('status', 'verified')->count(),
            'pending'   => $prestasi->where('status', 'pending')->count(),
            'juara_1'   => $prestasi->where('peringkat', '1')->count(),
            'juara_2'   => $prestasi->where('peringkat', '2')->count(),
            'juara_3'   => $prestasi->where('peringkat', '3')->count(),
            'emas'      => $prestasi->where('medali', 'Emas')->count(),
            'perak'     => $prestasi->where('medali', 'Perak')->count(),
            'perunggu'  => $prestasi->where('medali', 'Perunggu')->count(),
        ];
    }

    public function render()
    {
        $query = $this->buildQuery();

        $prestasiList = $query->orderBy('tanggal_mulai', 'desc')->paginate(3);
        $prestasiGrouped = $prestasiList->getCollection()->groupBy('tahun');

        return view('livewire.prestasi-atlit', [
            'prestasiList'    => $prestasiList,
            'prestasiGrouped' => $prestasiGrouped,
            'statistik'       => $this->getStatistikPrestasi($prestasiList->getCollection()),
        ]);
    }
}