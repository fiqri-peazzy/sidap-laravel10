@extends('layouts.app')

@section('pageTitle', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Sistem Data Atlit</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Atlit Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Atlit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Atlit::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cabang Olahraga Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Cabang Olahraga</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Cabor::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-running fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Klub Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Klub</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Klub::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Prestasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Klub Terbaru -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Klub Terdaftar</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Aksi:</div>
                            <a class="dropdown-item" href="{{ route('klub.index') }}">Lihat Semua Klub</a>
                            <a class="dropdown-item" href="{{ route('cabang-olahraga.index') }}">Lihat Cabang Olahraga</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $klubTerbaru = \App\Models\Klub::with('cabangOlahraga')->latest()->take(5)->get();
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr class="text-xs text-uppercase text-gray-500">
                                    <th>Klub</th>
                                    <th>Lokasi</th>
                                    <th>Cabang Olahraga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($klubTerbaru as $klub)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $klub->logo_url }}" alt="{{ $klub->nama_klub }}"
                                                    class="rounded-circle mr-2"
                                                    style="width: 30px; height: 30px; object-fit: cover;">
                                                <div>
                                                    <div class="font-weight-bold text-sm">{{ $klub->nama_klub }}</div>
                                                    @if ($klub->tahun_berdiri)
                                                        <div class="text-xs text-gray-500">Sejak {{ $klub->tahun_berdiri }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-sm">{{ $klub->kota }}, {{ $klub->provinsi }}</td>
                                        <td>
                                            @foreach ($klub->cabangOlahraga->take(2) as $cabang)
                                                <span class="badge badge-info badge-sm">{{ $cabang->nama_cabang }}</span>
                                            @endforeach
                                            @if ($klub->cabangOlahraga->count() > 2)
                                                <span
                                                    class="text-xs text-gray-500">+{{ $klub->cabangOlahraga->count() - 2 }}</span>
                                            @endif
                                        </td>
                                        <td>{!! $klub->status_badge !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500">
                                            Belum ada klub terdaftar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    @php
                        $aktivitasCabang = \App\Models\Cabor::latest()
                            ->take(3)
                            ->get()
                            ->map(function ($item) {
                                return (object) [
                                    'type' => 'cabang',
                                    'title' => 'Cabang ' . $item->nama_cabang . ' ditambahkan',
                                    'created_at' => $item->created_at,
                                    'icon' => 'fas fa-running',
                                    'color' => 'primary',
                                ];
                            });

                        $aktivitasKlub = \App\Models\Klub::latest()
                            ->take(3)
                            ->get()
                            ->map(function ($item) {
                                return (object) [
                                    'type' => 'klub',
                                    'title' => 'Klub ' . $item->nama_klub . ' terdaftar',
                                    'created_at' => $item->created_at,
                                    'icon' => 'fas fa-users',
                                    'color' => 'info',
                                ];
                            });

                        $aktivitas = $aktivitasCabang->concat($aktivitasKlub)->sortByDesc('created_at')->take(5);
                    @endphp

                    @forelse($aktivitas as $activity)
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <div class="icon-circle bg-{{ $activity->color }}">
                                    <i class="{{ $activity->icon }} text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                                <span class="font-weight-bold">{{ $activity->title }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p>Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('cabang-olahraga.index') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-running mr-2"></i>
                                Kelola Cabang Olahraga
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('klub.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-users mr-2"></i>
                                Kelola Klub
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="" class="btn btn-success btn-block">
                                <i class="fas fa-user-friends mr-2"></i>
                                Kelola Atlit
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="" class="btn btn-warning btn-block">
                                <i class="fas fa-trophy mr-2"></i>
                                Kelola Prestasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Klub -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Klub</h6>
                </div>
                <div class="card-body">
                    @php
                        $klubAktif = \App\Models\Klub::aktif()->count();
                        $klubNonaktif = \App\Models\Klub::nonaktif()->count();
                        $cabangAktif = \App\Models\Cabor::aktif()->count();
                        $klubPerProvinsi = \App\Models\Klub::selectRaw('provinsi, COUNT(*) as total')
                            ->groupBy('provinsi')
                            ->orderByDesc('total')
                            ->first();
                    @endphp

                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-left-primary p-3">
                                <div class="text-primary font-weight-bold">Klub Aktif</div>
                                <div class="h5 mb-0">{{ $klubAktif }}</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-success p-3">
                                <div class="text-success font-weight-bold">Cabang Tersedia</div>
                                <div class="h5 mb-0">{{ $cabangAktif }}</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-info p-3">
                                <div class="text-info font-weight-bold">Klub Nonaktif</div>
                                <div class="h5 mb-0">{{ $klubNonaktif }}</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-warning p-3">
                                <div class="text-warning font-weight-bold">Provinsi Terbanyak</div>
                                <div class="small mb-0">
                                    @if ($klubPerProvinsi)
                                        {{ Str::limit($klubPerProvinsi->provinsi, 15) }}<br>
                                        <span class="h6">{{ $klubPerProvinsi->total }} klub</span>
                                    @else
                                        <span class="h6">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($klubAktif > 0)
                        <hr>
                        <h6 class="text-primary mb-3">Distribusi Klub per Kota</h6>
                        @php
                            $klubPerKota = \App\Models\Klub::selectRaw('kota, COUNT(*) as total')
                                ->where('status', 'aktif')
                                ->groupBy('kota')
                                ->orderByDesc('total')
                                ->take(3)
                                ->get();
                        @endphp

                        @foreach ($klubPerKota as $kota)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>{{ $kota->kota }}</div>
                                <div>
                                    <span class="badge badge-primary">{{ $kota->total }} klub</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
