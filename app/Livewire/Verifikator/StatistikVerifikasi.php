<?php

namespace App\Livewire\Verifikator;

use Livewire\Component;
use App\Models\Atlit;
use App\Models\Prestasi;
use App\Models\DokumenAtlit;
use App\Models\Cabor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikVerifikasi extends Component
{
    public $statistikAtlit;
    public $statistikPrestasi;
    public $statistikDokumen;
    public $trendVerifikasi;
    public $statistikPerCabor;
    public $chartDataReady = false;
    public $isLoading = false;

    public function mount()
    {
        $this->loadStatistik();
    }

    public function loadStatistik()
    {
        $this->isLoading = true;

        $this->statistikAtlit = $this->getStatistikAtlit();
        $this->statistikPrestasi = $this->getStatistikPrestasi();
        $this->statistikDokumen = $this->getStatistikDokumen();
        $this->trendVerifikasi = $this->getTrendVerifikasi();
        $this->statistikPerCabor = $this->getStatistikPerCabor();

        $this->chartDataReady = true;
        $this->isLoading = false;
    }

    public function getStatistikAtlit()
    {
        $pending = Atlit::pending()->count();
        $verified = Atlit::verified()->count();
        $rejected = Atlit::rejected()->count();
        $total = Atlit::count();

        return [
            'pending' => $pending,
            'verified' => $verified,
            'rejected' => $rejected,
            'total' => $total,
            'persentase_verified' => $total > 0
                ? round(($verified / $total) * 100, 2)
                : 0,
        ];
    }

    public function getStatistikPrestasi()
    {
        $pending = Prestasi::pending()->count();
        $verified = Prestasi::verified()->count();
        $rejected = Prestasi::rejected()->count();
        $total = Prestasi::count();

        return [
            'pending' => $pending,
            'verified' => $verified,
            'rejected' => $rejected,
            'total' => $total,
            'persentase_verified' => $total > 0
                ? round(($verified / $total) * 100, 2)
                : 0,
        ];
    }

    public function getStatistikDokumen()
    {
        $pending = DokumenAtlit::where('status_verifikasi', 'pending')->count();
        $verified = DokumenAtlit::where('status_verifikasi', 'verified')->count();
        $rejected = DokumenAtlit::where('status_verifikasi', 'rejected')->count();
        $total = DokumenAtlit::count();

        return [
            'pending' => $pending,
            'verified' => $verified,
            'rejected' => $rejected,
            'total' => $total,
            'persentase_verified' => $total > 0
                ? round(($verified / $total) * 100, 2)
                : 0,
        ];
    }

    public function getTrendVerifikasi()
    {
        $months = [];
        $atlitData = [];
        $prestasiData = [];
        $dokumenData = [];

        // Ambil data 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->locale('id')->format('M Y');

            $months[] = $monthName;

            // Hitung atlit yang diverifikasi di bulan tersebut
            $atlitData[] = Atlit::whereYear('verified_at', $date->year)
                ->whereMonth('verified_at', $date->month)
                ->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)
                ->count();

            // Hitung prestasi yang diverifikasi di bulan tersebut
            $prestasiData[] = Prestasi::whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->where('status', 'verified')
                ->count();

            // Hitung dokumen yang diverifikasi di bulan tersebut
            $dokumenData[] = DokumenAtlit::whereYear('verified_at', $date->year)
                ->whereMonth('verified_at', $date->month)
                ->where('status_verifikasi', 'verified')
                ->count();
        }

        return [
            'categories' => $months,
            'atlit' => $atlitData,
            'prestasi' => $prestasiData,
            'dokumen' => $dokumenData,
        ];
    }

    public function getStatistikPerCabor()
    {
        $cabors = Cabor::withCount([
            'atlit as atlit_verified' => function ($query) {
                $query->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED);
            },
            'atlit as atlit_pending' => function ($query) {
                $query->where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING);
            },
            'prestasi as prestasi_verified' => function ($query) {
                $query->where('status', 'verified');
            },
            'prestasi as prestasi_pending' => function ($query) {
                $query->where('status', 'pending');
            }
        ])
            ->having('atlit_verified', '>', 0)
            ->orHaving('prestasi_verified', '>', 0)
            ->orderBy('atlit_verified', 'desc')
            ->limit(10)
            ->get();

        return [
            'nama_cabor' => $cabors->pluck('nama_cabang')->toArray(),
            'atlit_verified' => $cabors->pluck('atlit_verified')->toArray(),
            'prestasi_verified' => $cabors->pluck('prestasi_verified')->toArray(),
        ];
    }

    public function refresh()
    {
        $this->loadStatistik();
        $this->emit('chartRefreshed');
        session()->flash('success', 'Statistik berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.verifikator.statistik-verifikasi');
    }
}
