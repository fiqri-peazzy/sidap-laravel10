@extends('layouts.app')
@section('pageTitle', 'Dashboard')

@push('styles')
    <style>
        .icon-circle {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .widget-stats {
            transition: transform 0.2s;
        }

        .widget-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Sistem Data Atlit</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row - Statistik Utama -->
    <div class="row">
        <!-- Total Atlit Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 widget-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Atlit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_atlit'] }}</div>
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
            <div class="card border-left-success shadow h-100 py-2 widget-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Cabang Olahraga</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_cabor'] }}</div>
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
            <div class="card border-left-info shadow h-100 py-2 widget-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Klub</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_klub'] }}</div>
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
            <div class="card border-left-warning shadow h-100 py-2 widget-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Prestasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_prestasi'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Status Verifikasi -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Verifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $verifikasiStats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Terverifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $verifikasiStats['verified'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $verifikasiStats['rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Medali Emas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prestasiStats['emas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Charts -->
    <div class="row">
        <!-- Pertumbuhan Atlit -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pertumbuhan Atlit (6 Bulan Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartAtlit"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Cabang Olahraga -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Cabang Olahraga</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartCabor"></canvas>
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
                            <a class="dropdown-item" href="{{ route('admin.klub.index') }}">Lihat Semua Klub</a>
                            <a class="dropdown-item" href="{{ route('admin.cabang-olahraga.index') }}">Lihat Cabang
                                Olahraga</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                                                        <div class="text-xs text-gray-500">Sejak
                                                            {{ $klub->tahun_berdiri }}</div>
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

    <!-- Content Row - Atlit Berprestasi & Pending Verifikasi -->
    <div class="row">
        <!-- Atlit Berprestasi -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Atlit Berprestasi</h6>
                </div>
                <div class="card-body">
                    @forelse($atletBerprestasi as $atlet)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="mr-3">
                                <img src="{{ $atlet->foto ? asset('storage/atlit/foto/' . $atlet->foto) : asset('template/img/undraw_profile.svg') }}"
                                    alt="{{ $atlet->nama_lengkap }}" class="rounded-circle"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">{{ $atlet->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $atlet->cabangOlahraga->nama_cabang ?? '-' }} |
                                    {{ $atlet->klub->nama_klub ?? '-' }}
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-success badge-pill">
                                    <i class="fas fa-trophy"></i> {{ $atlet->prestasi_count }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500">
                            <i class="fas fa-trophy fa-2x mb-2"></i>
                            <p>Belum ada data atlit berprestasi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Atlit Pending Verifikasi -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Atlit Pending Verifikasi</h6>
                </div>
                <div class="card-body">
                    @forelse($atlitPendingVerifikasi as $atlet)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="mr-3">
                                <img src="{{ $atlet->foto ? asset('storage/atlit/foto/' . $atlet->foto) : asset('template/img/undraw_profile.svg') }}"
                                    alt="{{ $atlet->nama_lengkap }}" class="rounded-circle"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">{{ $atlet->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $atlet->cabangOlahraga->nama_cabang ?? '-' }} |
                                    {{ $atlet->klub->nama_klub ?? '-' }}
                                </div>
                                <div class="text-xs text-muted">
                                    <i class="fas fa-clock"></i> {{ $atlet->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div>
                                {!! $atlet->status_verifikasi_badge !!}
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <p>Tidak ada atlit yang menunggu verifikasi</p>
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
                            <a href="{{ route('admin.cabang-olahraga.index') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-running mr-2"></i>
                                Kelola Cabang Olahraga
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.klub.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-users mr-2"></i>
                                Kelola Klub
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.atlit.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-user-friends mr-2"></i>
                                Kelola Atlit
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('prestasi.index') }}" class="btn btn-warning btn-block">
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
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-left-primary p-3">
                                <div class="text-primary font-weight-bold">Klub Aktif</div>
                                <div class="h5 mb-0">{{ $klubStats['aktif'] }}</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-success p-3">
                                <div class="text-success font-weight-bold">Cabang Tersedia</div>
                                <div class="h5 mb-0">{{ $klubStats['cabang_aktif'] }}</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-info p-3">
                                <div class="text-info font-weight-bold">Klub Nonaktif</div>
                                <div class="h5 mb-0">{{ $klubStats['nonaktif'] }}</div>
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
                    @if ($klubStats['aktif'] > 0)
                        <hr>
                        <h6 class="text-primary mb-3">Distribusi Klub per Kota</h6>
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

    <!-- Chart Prestasi -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Prestasi per Tingkat Kejuaraan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartPrestasi"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari Controller
        const dataAtlit = @json($chartAtlit);
        const dataCabor = @json($chartCabor);
        const dataPrestasi = @json($chartPrestasi);

        // Chart Pertumbuhan Atlit
        const ctxAtlit = document.getElementById('chartAtlit').getContext('2d');
        new Chart(ctxAtlit, {
            type: 'line',
            data: {
                labels: dataAtlit.map(item => item.bulan),
                datasets: [{
                    label: 'Jumlah Atlit',
                    data: dataAtlit.map(item => item.total),
                    borderColor: 'rgb(78, 115, 223)',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                // maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Chart Distribusi Cabang Olahraga
        const ctxCabor = document.getElementById('chartCabor').getContext('2d');
        new Chart(ctxCabor, {
            type: 'doughnut',
            data: {
                labels: dataCabor.map(item => item.nama),
                datasets: [{
                    data: dataCabor.map(item => item.total),
                    backgroundColor: [
                        'rgb(78, 115, 223)',
                        'rgb(28, 200, 138)',
                        'rgb(54, 185, 204)',
                        'rgb(246, 194, 62)',
                        'rgb(231, 74, 59)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Chart Prestasi per Tingkat
        const ctxPrestasi = document.getElementById('chartPrestasi').getContext('2d');
        new Chart(ctxPrestasi, {
            type: 'bar',
            data: {
                labels: dataPrestasi.map(item => item.tingkat),
                datasets: [{
                    label: 'Jumlah Prestasi',
                    data: dataPrestasi.map(item => item.total),
                    backgroundColor: 'rgb(246, 194, 62)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
