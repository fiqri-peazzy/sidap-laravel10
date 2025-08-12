@extends('layouts.app')

@section('title', 'Dashboard Prestasi')

@push('styles')
    <link href="{{ asset('template/vendor/chart.js/Chart.min.css') }}" rel="stylesheet">
    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .stats-card .card-body {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.3s ease;
        }

        .stats-card:hover::before {
            right: -30%;
        }

        .medal-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .medal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            position: relative;
            height: 400px;
        }

        .top-performer-item {
            background: linear-gradient(145deg, #f8f9fc 0%, #ffffff 100%);
            border-left: 4px solid #4e73df;
            transition: all 0.3s ease;
        }

        .top-performer-item:hover {
            border-left-color: #224abe;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .medal-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }

        .ranking-number {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-bar text-primary"></i> Dashboard Prestasi Atlet {{ $currentYear }}
            </h1>
            <div class="d-none d-lg-inline-block">
                <a href="{{ route('prestasi.index') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-table fa-sm text-white-50"></i> Lihat Data
                </a>
                <a href="{{ route('prestasi.create') }}" class="btn btn-success shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Prestasi
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Prestasi -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Prestasi</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $stats['total'] }}</div>
                                <small class="text-light">Tahun {{ $currentYear }}</small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trophy fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medal Emas -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card medal-card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Medal Emas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['emas'] }}</div>
                                <small
                                    class="text-muted">{{ $stats['total'] > 0 ? round(($stats['emas'] / $stats['total']) * 100, 1) : 0 }}%
                                    dari total</small>
                            </div>
                            <div class="col-auto">
                                <span class="medal-icon">🥇</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medal Perak -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card medal-card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Medal Perak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['perak'] }}</div>
                                <small
                                    class="text-muted">{{ $stats['total'] > 0 ? round(($stats['perak'] / $stats['total']) * 100, 1) : 0 }}%
                                    dari total</small>
                            </div>
                            <div class="col-auto">
                                <span class="medal-icon">🥈</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medal Perunggu -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card medal-card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Medal Perunggu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['perunggu'] }}</div>
                                <small
                                    class="text-muted">{{ $stats['total'] > 0 ? round(($stats['perunggu'] / $stats['total']) * 100, 1) : 0 }}%
                                    dari total</small>
                            </div>
                            <div class="col-auto">
                                <span class="medal-icon">🥉</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Level Statistics -->
        <div class="row mb-4">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tingkat Internasional
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['internasional'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-globe fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tingkat Nasional
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['nasional'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-flag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <!-- Monthly Progress Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Prestasi Per Bulan {{ $currentYear }}</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Opsi:</div>
                                <a class="dropdown-item" href="#"
                                    onclick="exportChart('monthlyChart', 'prestasi-bulanan')">Download Chart</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prestasi by Sport Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Top 5 Cabang Olahraga</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="sportChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            @foreach ($prestasiPerCabor->take(3) as $index => $prestasi)
                                <span class="mr-2">
                                    <i class="fas fa-circle"
                                        style="color: {{ ['#4e73df', '#1cc88a', '#36b9cc'][$index] ?? '#858796' }}"></i>
                                    {{ $prestasi->cabangOlahraga->nama_cabang ?? 'Unknown' }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-star text-warning"></i> Top Performers {{ $currentYear }}
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($topPerformers->count() > 0)
                            <div class="row">
                                @foreach ($topPerformers as $index => $performer)
                                    <div class="col-xl-4 col-lg-6 mb-4">
                                        <div class="top-performer-item p-4 rounded shadow-sm">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="ranking-number me-3">{{ $index + 1 }}</div>
                                                <img src="{{ $performer->atlit->foto_url ?? asset('template/img/default-avatar.png') }}"
                                                    class="rounded-circle me-3" width="50" height="50"
                                                    style="object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 font-weight-bold">
                                                        {{ $performer->atlit->nama_lengkap ?? 'N/A' }}</h6>
                                                    <small
                                                        class="text-muted">{{ $performer->atlit->cabangOlahraga->nama_cabang ?? 'N/A' }}</small>
                                                </div>
                                            </div>

                                            <div class="row text-center">
                                                <div class="col-3">
                                                    <div class="mb-1">
                                                        <span class="medal-icon">🥇</span>
                                                    </div>
                                                    <div class="h6 mb-0 font-weight-bold">{{ $performer->total_emas }}
                                                    </div>
                                                    <small class="text-muted">Emas</small>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-1">
                                                        <span class="medal-icon">🥈</span>
                                                    </div>
                                                    <div class="h6 mb-0 font-weight-bold">{{ $performer->total_perak }}
                                                    </div>
                                                    <small class="text-muted">Perak</small>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-1">
                                                        <span class="medal-icon">🥉</span>
                                                    </div>
                                                    <div class="h6 mb-0 font-weight-bold">{{ $performer->total_perunggu }}
                                                    </div>
                                                    <small class="text-muted">Perunggu</small>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-1">
                                                        <i class="fas fa-trophy text-primary"></i>
                                                    </div>
                                                    <div class="h6 mb-0 font-weight-bold text-primary">
                                                        {{ $performer->total_prestasi }}</div>
                                                    <small class="text-muted">Total</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-trophy fa-3x text-gray-300 mb-3"></i>
                                <h5 class="text-gray-500">Belum Ada Data Prestasi</h5>
                                <p class="text-muted">Mulai tambahkan data prestasi atlet untuk melihat statistik disini.
                                </p>
                                <a href="{{ route('prestasi.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Prestasi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Chart Configuration
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ],
                    datasets: [{
                        label: 'Jumlah Prestasi',
                        data: [
                            @foreach ($monthlyStats as $month => $count)
                                {{ $count }},
                            @endforeach
                        ],
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
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
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverBackgroundColor: '#4e73df'
                        }
                    }
                }
            });

            // Sport Chart Configuration (Doughnut)
            const sportCtx = document.getElementById('sportChart').getContext('2d');
            const sportChart = new Chart(sportCtx, {
                type: 'doughnut',
                data: {
                    labels: [
                        @foreach ($prestasiPerCabor->take(5) as $prestasi)
                            '{{ $prestasi->cabangOlahraga->nama_cabang ?? 'Unknown' }}',
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach ($prestasiPerCabor->take(5) as $prestasi)
                                {{ $prestasi->total }},
                            @endforeach
                        ],
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
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
                    cutout: '60%'
                }
            });

            // Export Chart Function
            window.exportChart = function(chartId, filename) {
                const chart = Chart.getChart(chartId);
                if (chart) {
                    const url = chart.toBase64Image();
                    const link = document.createElement('a');
                    link.download = filename + '.png';
                    link.href = url;
                    link.click();
                }
            };

            // Auto refresh every 5 minutes (300000 ms)
            setInterval(function() {
                location.reload();
            }, 300000);
        });
    </script>
@endpush
