<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Atlit;
use App\Models\Prestasi;
use App\Models\Cabor;
use Illuminate\Support\Facades\Auth;

class PrestasiAtlit extends Component
{
    public $atlit;
    public $prestasiList = [];
    public $prestasiGrouped = [];

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
        $this->loadPrestasi();
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

    public function loadPrestasi()
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

        $this->prestasiList = $query->orderBy('tanggal_mulai', 'desc')->paginate(3);

        // Group by year for timeline view
        $this->prestasiGrouped = $this->prestasiList->getCollection()->groupBy('tahun');
    }

    public function updatedFilterTahun()
    {
        $this->loadPrestasi();
    }

    public function updatedFilterCabor()
    {
        $this->loadPrestasi();
    }

    public function updatedFilterStatus()
    {
        $this->loadPrestasi();
    }

    public function updatedFilterTingkat()
    {
        $this->loadPrestasi();
    }

    public function updatedSearchTerm()
    {
        $this->loadPrestasi();
    }

    public function resetFilters()
    {
        $this->filterTahun = '';
        $this->filterCabor = '';
        $this->filterStatus = '';
        $this->filterTingkat = '';
        $this->searchTerm = '';
        $this->loadPrestasi();
    }

    public function switchViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function getStatistikPrestasi()
    {
        $filtered = $this->prestasiList;

        return [
            'total' => $filtered->count(),
            'verified' => $filtered->where('status', 'verified')->count(),
            'pending' => $filtered->where('status', 'pending')->count(),
            'juara_1' => $filtered->where('peringkat', '1')->count(),
            'juara_2' => $filtered->where('peringkat', '2')->count(),
            'juara_3' => $filtered->where('peringkat', '3')->count(),
            'emas' => $filtered->where('medali', 'Emas')->count(),
            'perak' => $filtered->where('medali', 'Perak')->count(),
            'perunggu' => $filtered->where('medali', 'Perunggu')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.prestasi-atlit', [
            'statistik' => $this->getStatistikPrestasi(),
        ]);
    }
}
