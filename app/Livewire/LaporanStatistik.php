<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Atlit;
use App\Models\Prestasi;
use App\Models\Cabor;
use App\Models\Klub;
use Carbon\Carbon;

class LaporanStatistik extends Component
{
    public $tahunPilihan = '';
    public $cabangOlahragaPilihan = '';

    public function mount()
    {
        // Tidak set tahun default agar menampilkan semua data
        $this->tahunPilihan = '';
        $this->cabangOlahragaPilihan = '';
    }

    public function render()
    {
        // Statistik Umum (tidak terpengaruh filter)
        $totalAtlit = Atlit::count();
        $totalPrestasi = Prestasi::count();
        $totalKlub = Klub::where('status', 'Aktif')->count();
        $totalCabor = Cabor::where('status', 'Aktif')->count();

        // Statistik berdasarkan jenis kelamin (tidak terpengaruh filter)
        $atlitPria = Atlit::where('jenis_kelamin', 'L')->count();
        $atlitWanita = Atlit::where('jenis_kelamin', 'P')->count();

        // Statistik berdasarkan status (tidak terpengaruh filter)
        $atlitAktif = Atlit::where('status', 'aktif')->count();
        $atlitTidakAktif = Atlit::where('status', 'nonaktif')->count();

        // Statistik berdasarkan umur (tidak terpengaruh filter)
        $umur17Kebawah = Atlit::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 17')->count();
        $umur18_25 = Atlit::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 25')->count();
        $umur26Keatas = Atlit::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 26')->count();

        // Prestasi berdasarkan medali (terpengaruh filter)
        $queryMedali = $this->getFilteredPrestasiQuery();
        $prestasiEmas = (clone $queryMedali)->where('medali', 'Emas')->count();
        $prestasiPerak = (clone $queryMedali)->where('medali', 'Perak')->count();
        $prestasiPerunggu = (clone $queryMedali)->where('medali', 'Perunggu')->count();

        // Prestasi berdasarkan tingkat kejuaraan (terpengaruh filter)
        $queryKejuaraan = $this->getFilteredPrestasiQuery();
        $prestasiInternasional = (clone $queryKejuaraan)->where('jenis_kejuaraan', 'Internasional')->count();
        $prestasiNasional = (clone $queryKejuaraan)->where('jenis_kejuaraan', 'Nasional')->count();
        $prestasiProvinsi = (clone $queryKejuaraan)->where('jenis_kejuaraan', 'Provinsi')->count();
        $prestasiRegional = (clone $queryKejuaraan)->where('jenis_kejuaraan', 'Regional')->count();
        $prestasiDaerah = (clone $queryKejuaraan)->where('jenis_kejuaraan', 'Kabupaten/Kota')->count();

        // Top 5 Cabang Olahraga berdasarkan jumlah atlit
        $topCaborAtlit = Cabor::withCount('atlit')
            ->where('status', 'Aktif')
            ->orderBy('atlit_count', 'desc')
            ->take(5)
            ->get();

        // Top 5 Klub berdasarkan jumlah atlit
        $topKlubAtlit = Klub::withCount('atlit')
            ->where('status', 'Aktif')
            ->orderBy('atlit_count', 'desc')
            ->take(5)
            ->get();

        // Top 5 Atlit berdasarkan jumlah prestasi
        $topAtlitPrestasi = Atlit::with('cabangOlahraga')
            ->withCount('prestasi')
            ->orderBy('prestasi_count', 'desc')
            ->take(5)
            ->get();

        // Data untuk chart prestasi per tahun (5 tahun terakhir)
        $tahunSekarang = date('Y');
        $prestasiPerTahun = [];
        for ($i = 4; $i >= 0; $i--) {
            $tahun = $tahunSekarang - $i;
            $jumlah = Prestasi::where('tahun', $tahun)->count();
            $prestasiPerTahun[] = [
                'tahun' => $tahun,
                'jumlah' => $jumlah
            ];
        }

        // Data untuk chart prestasi per cabang olahraga (terpengaruh filter)
        $prestasiPerCabor = $this->getPrestasiPerCabor();

        // List tahun dan cabang olahraga untuk filter
        $tahunList = Prestasi::select('tahun')
            ->distinct()
            ->whereNotNull('tahun')
            ->where('tahun', '>', 0)
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $cabangOlahraga = Cabor::where('status', 'Aktif')->orderBy('nama_cabang')->get();

        return view('livewire.laporan-statistik', compact(
            'totalAtlit',
            'totalPrestasi',
            'totalKlub',
            'totalCabor',
            'atlitPria',
            'atlitWanita',
            'atlitAktif',
            'atlitTidakAktif',
            'umur17Kebawah',
            'umur18_25',
            'umur26Keatas',
            'prestasiEmas',
            'prestasiPerak',
            'prestasiPerunggu',
            'prestasiInternasional',
            'prestasiNasional',
            'prestasiProvinsi',
            'prestasiRegional',
            'prestasiDaerah',
            'topCaborAtlit',
            'topKlubAtlit',
            'topAtlitPrestasi',
            'prestasiPerTahun',
            'prestasiPerCabor',
            'tahunList',
            'cabangOlahraga'
        ));
    }

    private function getFilteredPrestasiQuery()
    {
        $query = Prestasi::query();

        if (!empty($this->tahunPilihan)) {
            $query->where('tahun', $this->tahunPilihan);
        }

        if (!empty($this->cabangOlahragaPilihan)) {
            $query->where('cabang_olahraga_id', $this->cabangOlahragaPilihan);
        }

        return $query;
    }

    private function getPrestasiPerCabor()
    {
        if (!empty($this->cabangOlahragaPilihan)) {
            // Jika cabang olahraga dipilih, tampilkan hanya cabang tersebut
            $cabor = Cabor::find($this->cabangOlahragaPilihan);
            if ($cabor) {
                $queryPrestasi = $this->getFilteredPrestasiQuery();
                $jumlahPrestasi = $queryPrestasi->count();

                if ($jumlahPrestasi > 0) {
                    return collect([[
                        'nama' => $cabor->nama_cabang,
                        'jumlah' => $jumlahPrestasi
                    ]]);
                }
            }
            return collect([]);
        } else {
            // Jika tidak ada cabang yang dipilih, tampilkan semua cabang dengan prestasi
            $cabangOlahraga = Cabor::where('status', 'Aktif')
                ->orderBy('nama_cabang')
                ->get();

            $prestasiData = [];
            foreach ($cabangOlahraga as $cabor) {
                $queryPrestasi = Prestasi::where('cabang_olahraga_id', $cabor->id);

                if (!empty($this->tahunPilihan)) {
                    $queryPrestasi->where('tahun', $this->tahunPilihan);
                }

                $jumlahPrestasi = $queryPrestasi->count();
                if ($jumlahPrestasi > 0) {
                    $prestasiData[] = [
                        'nama' => $cabor->nama_cabang,
                        'jumlah' => $jumlahPrestasi
                    ];
                }
            }

            return collect($prestasiData)
                ->sortByDesc('jumlah')
                ->take(10)
                ->values();
        }
    }

    // Method untuk update chart ketika filter berubah
    public function updatedTahunPilihan()
    {
        $this->dispatch('chartUpdated');
    }

    public function updatedCabangOlahragaPilihan()
    {
        $this->dispatch('chartUpdated');
    }

    // Method untuk reset filter
    public function resetFilter()
    {
        $this->tahunPilihan = '';
        $this->cabangOlahragaPilihan = '';
        $this->dispatch('chartUpdated');
    }
}
