@extends('layouts.app')
@section('pageTitle', 'Dashboard Verifikator')

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

        .list-group-item:hover {
            background-color: #f8f9fc;
        }

        .badge-xl {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Verifikator</h1>
            <span class="badge badge-warning badge-xl">
                <i class="fas fa-user-shield"></i> {{ auth()->user()->name }}
            </span>
        </div>

        <!-- Content Row - Statistik Atlit -->
        <div class="row">
            <div class="col-12 mb-2">
                <h6 class="text-primary font-weight-bold">
                    <i class="fas fa-user-friends"></i> STATISTIK ATLIT
                </h6>
            </div>

            <!-- Atlit Menunggu Verifikasi Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Atlit Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $atlitStats['pending'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Atlit Terverifikasi Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Atlit Terverifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $atlitStats['verified'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Atlit Ditolak Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Atlit Ditolak
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $atlitStats['rejected'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Atlit Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Atlit
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $atlitStats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row - Statistik Prestasi -->
        <div class="row">
            <div class="col-12 mb-2">
                <h6 class="text-primary font-weight-bold">
                    <i class="fas fa-trophy"></i> STATISTIK PRESTASI
                </h6>
            </div>

            <!-- Prestasi Pending -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Prestasi Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prestasiStats['pending'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prestasi Terverifikasi -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Prestasi Terverifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prestasiStats['verified'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prestasi Ditolak -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Prestasi Ditolak
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prestasiStats['rejected'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Prestasi -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 widget-stats">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Prestasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prestasiStats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-medal fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row - Performa Verifikator -->
        <div class="row">
            <div class="col-12 mb-2">
                <h6 class="text-primary font-weight-bold">
                    <i class="fas fa-chart-line"></i> PERFORMA VERIFIKASI ANDA
                </h6>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Hari Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $performaStats['hari_ini'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Minggu Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $performaStats['minggu_ini'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Bulan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $performaStats['bulan_ini'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Verifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $performaStats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-double fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row - Charts -->
        <div class="row">
            <!-- Chart Verifikasi per Minggu -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aktivitas Verifikasi (4 Minggu Terakhir)</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartVerifikasi"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Status Atlit -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Distribusi Status Atlit</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartStatusAtlit"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Atlit Pending Verifikasi -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-user-friends"></i> Atlit Menunggu Verifikasi
                        </h6>
                        <a href="{{ route('verifikator.atlit.index') }}" class="btn btn-sm btn-warning">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nama Atlit</th>
                                        <th>Cabang Olahraga</th>
                                        <th>Klub</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($atlitPending as $atlet)
                                        <tr>
                                            <td>
                                                <img src="{{ $atlet->foto ? asset('storage/atlit/foto/' . $atlet->foto) : asset('template/img/undraw_profile.svg') }}"
                                                    alt="{{ $atlet->nama_lengkap }}" class="rounded-circle"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            </td>
                                            <td class="font-weight-bold">{{ $atlet->nama_lengkap }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $atlet->cabangOlahraga->nama_cabang ?? '-' }}
                                                </span>
                                            </td>
                                            <td>{{ $atlet->klub->nama_klub ?? '-' }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> {{ $atlet->created_at->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-gray-500 py-4">
                                                <i class="fas fa-check-circle fa-3x mb-2"></i>
                                                <p>Tidak ada atlit yang menunggu verifikasi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Prestasi Pending Verifikasi -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-trophy"></i> Prestasi Menunggu Verifikasi
                        </h6>
                        <a href="{{ route('verifikator.prestasi.index', ['status' => 'menunggu']) }}"
                            class="btn btn-sm btn-warning">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Atlit</th>
                                        <th>Kejuaraan</th>
                                        <th>Peringkat</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($prestasiPending as $prestasi)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $prestasi->atlit->foto ? asset('storage/atlit/foto/' . $prestasi->atlit->foto) : asset('template/img/undraw_profile.svg') }}"
                                                        alt="{{ $prestasi->atlit->nama_lengkap }}"
                                                        class="rounded-circle mr-2"
                                                        style="width: 35px; height: 35px; object-fit: cover;">
                                                    <div>
                                                        <div class="font-weight-bold">{{ $prestasi->atlit->nama_lengkap }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $prestasi->cabangOlahraga->nama_cabang ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ Str::limit($prestasi->nama_kejuaraan, 30) }}</div>
                                                <small class="text-muted">{{ $prestasi->tingkat_kejuaraan }}</small>
                                            </td>
                                            <td>{!! $prestasi->peringkat_badge !!}</td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    {{ $prestasi->created_at->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 py-4">
                                                <i class="fas fa-check-circle fa-3x mb-2"></i>
                                                <p>Tidak ada prestasi yang menunggu verifikasi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-5">
                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-bolt"></i> Menu Verifikator
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('verifikator.atlit.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-users text-info"></i> Semua Data Atlit
                                </div>
                                <span class="badge badge-info badge-pill">{{ $atlitStats['total'] }}</span>
                            </a>
                            <a href="{{ route('verifikator.prestasi.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-trophy text-warning"></i> Semua Prestasi
                                </div>
                                <span class="badge badge-warning badge-pill">{{ $prestasiStats['total'] }}</span>
                            </a>
                            <a href="{{ route('verifikator.prestasi.index', ['status' => 'menunggu']) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-clock text-warning"></i> Menunggu Verifikasi
                                </div>
                                <span
                                    class="badge badge-warning badge-pill">{{ $atlitStats['pending'] + $prestasiStats['pending'] }}</span>
                            </a>
                            <a href="{{ route('verifikator.prestasi.index', ['status' => 'diverifikasi']) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-check text-success"></i> Terverifikasi
                                </div>
                                <span
                                    class="badge badge-success badge-pill">{{ $atlitStats['verified'] + $prestasiStats['verified'] }}</span>
                            </a>
                            <a href="{{ route('verifikator.prestasi.index', ['status' => 'ditolak']) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-times text-danger"></i> Ditolak
                                </div>
                                <span
                                    class="badge badge-danger badge-pill">{{ $atlitStats['rejected'] + $prestasiStats['rejected'] }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- History Verifikasi Terbaru -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-history"></i> History Verifikasi
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($historyVerifikasi as $history)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="mr-3">
                                    @if ($history->status_verifikasi == 'diverifikasi')
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-check text-white"></i>
                                        </div>
                                    @else
                                        <div class="icon-circle bg-danger">
                                            <i class="fas fa-times text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">{{ $history->nama_lengkap }}</div>
                                    <div class="text-xs text-muted">
                                        {{ $history->cabangOlahraga->nama_cabang ?? '-' }} |
                                        {{ $history->klub->nama_klub ?? '-' }}
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        <i class="fas fa-clock"></i> {{ $history->verified_at->diffForHumans() }}
                                    </div>
                                    @if ($history->status_verifikasi == 'diverifikasi')
                                        <span class="badge badge-success badge-sm mt-1">Diverifikasi</span>
                                    @else
                                        <span class="badge badge-danger badge-sm mt-1">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500">
                                <i class="fas fa-history fa-2x mb-2"></i>
                                <p>Belum ada history verifikasi</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Cabang Olahraga dengan Atlit Pending Terbanyak -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-running"></i> Cabor dengan Pending Terbanyak
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($caborPendingTerbanyak as $cabor)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="font-weight-bold">{{ $cabor['nama'] }}</div>
                                </div>
                                <div>
                                    <span class="badge badge-warning badge-pill">{{ $cabor['total'] }} atlit</span>
                                </div>
                            </div>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: {{ ($cabor['total'] / $atlitStats['pending']) * 100 }}%"
                                    aria-valuenow="{{ $cabor['total'] }}" aria-valuemin="0"
                                    aria-valuemax="{{ $atlitStats['pending'] }}">
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500">
                                <i class="fas fa-running fa-2x mb-2"></i>
                                <p>Tidak ada data</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Status Prestasi -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Distribusi Status Prestasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartStatusPrestasi"></canvas>
                        </div>
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
        const dataVerifikasi = @json($chartVerifikasi);
        const dataStatusAtlit = @json($chartStatusAtlit);
        const dataStatusPrestasi = @json($chartStatusPrestasi);

        // Chart Verifikasi per Minggu
        const ctxVerifikasi = document.getElementById('chartVerifikasi').getContext('2d');
        new Chart(ctxVerifikasi, {
            type: 'line',
            data: {
                labels: dataVerifikasi.map(item => item.minggu),
                datasets: [{
                        label: 'Diverifikasi',
                        data: dataVerifikasi.map(item => item.verified),
                        borderColor: 'rgb(28, 200, 138)',
                        backgroundColor: 'rgba(28, 200, 138, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Ditolak',
                        data: dataVerifikasi.map(item => item.rejected),
                        borderColor: 'rgb(231, 74, 59)',
                        backgroundColor: 'rgba(231, 74, 59, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
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

        // Chart Status Atlit
        const ctxStatusAtlit = document.getElementById('chartStatusAtlit').getContext('2d');
        new Chart(ctxStatusAtlit, {
            type: 'doughnut',
            data: {
                labels: dataStatusAtlit.map(item => item.status),
                datasets: [{
                    data: dataStatusAtlit.map(item => item.total),
                    backgroundColor: [
                        'rgb(246, 194, 62)',
                        'rgb(28, 200, 138)',
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

        // Chart Status Prestasi
        const ctxStatusPrestasi = document.getElementById('chartStatusPrestasi').getContext('2d');
        new Chart(ctxStatusPrestasi, {
            type: 'bar',
            data: {
                labels: dataStatusPrestasi.map(item => item.status),
                datasets: [{
                    label: 'Jumlah Prestasi',
                    data: dataStatusPrestasi.map(item => item.total),
                    backgroundColor: [
                        'rgb(246, 194, 62)',
                        'rgb(28, 200, 138)',
                        'rgb(231, 74, 59)'
                    ]
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
