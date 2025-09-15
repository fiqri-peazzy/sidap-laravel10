@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Atlit</h1>
            <span class="badge badge-success badge-lg">{{ auth()->user()->name }}</span>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Profil Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Profil Saya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Lengkap</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
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
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Prestasi Saya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ auth()->user()->atlit ? auth()->user()->atlit->prestasi->count() : 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trophy fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal Latihan Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jadwal Latihan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Aktif</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal Event Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Event Mendatang</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Quick Actions -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="{{ route('atlit.profil') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-user text-success"></i> Update Profil
                            </a>
                            {{-- <a href="{{ route('atlit.prestasi.create') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-plus text-warning"></i> Upload Prestasi Baru
                            </a> --}}
                            <a href="{{ route('atlit.jadwal-latihan.index') }}"
                                class="list-group-item list-group-item-action">
                                <i class="fas fa-clock text-info"></i> Lihat Jadwal Latihan
                            </a>
                            <a href="{{ route('atlit.kalender') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-calendar text-primary"></i> Kalender Kegiatan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prestasi Terbaru -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Prestasi Terbaru</h6>
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->atlit && auth()->user()->atlit->prestasi->count() > 0)
                            @foreach (auth()->user()->atlit->prestasi->take(3) as $prestasi)
                                <div class="mb-3 p-2 border rounded">
                                    <h6 class="text-warning">{{ $prestasi->nama_event }}</h6>
                                    <p class="mb-1">{{ $prestasi->nama_kejuaraan }}</p>
                                    <small class="text-muted">{{ $prestasi->tanggal_event }}</small>
                                    <span
                                        class="badge badge-{{ $prestasi->status == 'diverifikasi' ? 'success' : ($prestasi->status == 'menunggu' ? 'warning' : 'danger') }} float-right">
                                        {{ ucfirst($prestasi->status) }}
                                    </span>
                                </div>
                            @endforeach
                            <a href="{{ route('atlit.prestasi.index') }}" class="btn btn-warning btn-sm">Lihat Semua</a>
                        @else
                            <p class="text-muted">Belum ada prestasi.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
