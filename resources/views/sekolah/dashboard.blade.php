@extends('layouts.app')

@section('title', 'Dashboard Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard {{ $sekolah->nama_sekolah ?? 'Sekolah' }}</h1>
            <div>
                <a href="{{ route('sekolah.laporan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm">
                    <i class="fas fa-chart-bar fa-sm"></i> Laporan
                </a>
                <a href="{{ route('sekolah.atlit.import.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm">
                    <i class="fas fa-file-excel fa-sm"></i> Import Excel
                </a>
                <a href="{{ route('sekolah.atlit.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Atlet
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Atlet</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu
                                    Verifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terverifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['verified'] }}</div>
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
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Distribusi Cabang Olahraga</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartCabor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Verifikasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartStatusVerifikasi"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tren Pendaftaran (6 Bulan Terakhir)</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartTren"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Atlet Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Klub</th>
                                        <th>Cabor</th>
                                        <th>Status Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($atlitTerbaru as $item)
                                        <tr>
                                            <td>{{ $item->nama_lengkap }}</td>
                                            <td>{{ $item->klub->nama_klub ?? '-' }}</td>
                                            <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                                            <td>{!! $item->status_verifikasi_badge !!}</td>
                                            <td>
                                                <a href="{{ route('sekolah.atlit.show', $item->id) }}"
                                                    class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data atlet. Silakan
                                                tambahkan data atlet binaan sekolah Anda.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('sekolah.atlit.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua
                            Data Atlet</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Aktivitas</h6>
                    </div>
                    <div class="card-body" style="max-height: 420px; overflow-y: auto;">
                        <div class="timeline">
                            @forelse ($riwayatAktivitas as $aktivitas)
                                <div class="timeline-item">
                                    @if ($aktivitas['type'] === 'ditambahkan')
                                        <i class="fas fa-user-plus bg-primary"></i>
                                    @elseif($aktivitas['type'] === 'verified')
                                        <i class="fas fa-check bg-success"></i>
                                    @else
                                        <i class="fas fa-times bg-danger"></i>
                                    @endif
                                    <div class="timeline-content">
                                        <h6 class="mb-0">
                                            {{ $aktivitas['nama'] }}
                                            @if ($aktivitas['type'] === 'ditambahkan')
                                                ditambahkan
                                            @elseif($aktivitas['type'] === 'verified')
                                                diverifikasi
                                            @else
                                                ditolak
                                            @endif
                                        </h6>
                                        <p class="text-muted mb-0 small">
                                            {{ $aktivitas['timestamp']->format('d M Y, H:i') }}
                                        </p>
                                        @if ($aktivitas['keterangan'])
                                            <small class="text-muted">{{ $aktivitas['keterangan'] }}</small>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center mb-0">Belum ada aktivitas.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .chart-container {
                position: relative;
                height: 300px;
            }

            .timeline {
                position: relative;
                padding: 0;
                list-style: none;
            }

            .timeline-item {
                position: relative;
                padding-left: 3rem;
                padding-bottom: 1.5rem;
            }

            .timeline-item:before {
                content: '';
                position: absolute;
                left: 1rem;
                top: 2rem;
                bottom: -1.5rem;
                width: 2px;
                background: #dee2e6;
            }

            .timeline-item:last-child:before {
                display: none;
            }

            .timeline-item i {
                position: absolute;
                left: 0.5rem;
                top: 0.25rem;
                width: 2rem;
                height: 2rem;
                border-radius: 50%;
                text-align: center;
                line-height: 2rem;
                color: white;
                font-size: 0.75rem;
                z-index: 1;
            }

            .timeline-content h6 {
                margin-bottom: 0.25rem;
                color: #495057;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const dataCaborSekolah = @json($chartCabor);
            const dataStatusVerifikasi = @json($chartStatusVerifikasi);
            const dataTrenSekolah = @json($chartTren);

            new Chart(document.getElementById('chartCabor').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: dataCaborSekolah.map(item => item.nama),
                    datasets: [{
                        data: dataCaborSekolah.map(item => item.total),
                        backgroundColor: ['rgb(78, 115, 223)', 'rgb(28, 200, 138)', 'rgb(54, 185, 204)',
                            'rgb(246, 194, 62)', 'rgb(231, 74, 59)', 'rgb(133, 135, 150)'
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

            new Chart(document.getElementById('chartStatusVerifikasi').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: dataStatusVerifikasi.map(item => item.status),
                    datasets: [{
                        data: dataStatusVerifikasi.map(item => item.total),
                        backgroundColor: ['rgb(246, 194, 62)', 'rgb(28, 200, 138)', 'rgb(231, 74, 59)']
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

            new Chart(document.getElementById('chartTren').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dataTrenSekolah.map(item => item.label),
                    datasets: [{
                        label: 'Atlet Baru',
                        data: dataTrenSekolah.map(item => item.total),
                        backgroundColor: 'rgb(78, 115, 223)'
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
@endsection
