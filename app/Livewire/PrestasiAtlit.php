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
    protected $paginationTheme = 'bootstrap';

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

    public function mount(Atlit $atlit)
    {
        $this->atlit = $atlit;
        $this->loadFilterOptions();
    }

    public function updating($property)
    {
        if (in_array($property, [
            'filterTahun',
            'filterCabor',
            'filterStatus',
            'filterTingkat',
            'searchTerm',
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

    private function queryPrestasi()
    {
        return Prestasi::with(['cabangOlahraga'])
            ->where('atlit_id', $this->atlit->id)
            ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
            ->when($this->filterCabor, fn($q) => $q->where('cabang_olahraga_id', $this->filterCabor))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterTingkat, fn($q) => $q->where('tingkat_kejuaraan', 'like', '%' . $this->filterTingkat . '%'))
            ->when($this->searchTerm, function ($q) {
                $q->where('nama_kejuaraan', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('tempat_kejuaraan', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nomor_pertandingan', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('tanggal_mulai', 'desc');
    }

    public function getStatistikPrestasi($prestasiList)
    {
        $filtered = $prestasiList->getCollection(); // ambil collection dari paginator

        return [
            'total'     => $prestasiList->total(),
            'verified'  => $filtered->where('status', 'verified')->count(),
            'pending'   => $filtered->where('status', 'pending')->count(),
            'juara_1'   => $filtered->where('peringkat', '1')->count(),
            'juara_2'   => $filtered->where('peringkat', '2')->count(),
            'juara_3'   => $filtered->where('peringkat', '3')->count(),
            'emas'      => $filtered->where('medali', 'Emas')->count(),
            'perak'     => $filtered->where('medali', 'Perak')->count(),
            'perunggu'  => $filtered->where('medali', 'Perunggu')->count(),
        ];
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

    public function render()
    {
        $prestasiList = $this->queryPrestasi()->paginate(9);

        return view('livewire.prestasi-atlit', [
            'prestasiList'    => $prestasiList,
            'prestasiGrouped' => $prestasiList->getCollection()->groupBy('tahun'),
            'statistik'       => $this->getStatistikPrestasi($prestasiList),
        ]);
    }
}
