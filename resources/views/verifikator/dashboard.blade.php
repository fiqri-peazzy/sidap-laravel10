@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Verifikator</h1>
            <span class="badge badge-warning badge-lg">{{ auth()->user()->name }}</span>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Menunggu Verifikasi Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Verifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="pendingCount">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terverifikasi Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terverifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="verifiedCount">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ditolak Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="rejectedCount">0</div>
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
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Atlit</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalAtlit">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Prestasi Pending -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Prestasi Menunggu Verifikasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Atlit</th>
                                        <th>Event</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="pendingPrestasiTable">
                                    <!-- Data akan dimuat via AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('verifikator.prestasi.index', ['status' => 'menunggu']) }}"
                            class="btn btn-warning">Lihat Semua</a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Menu Verifikator</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="{{ route('verifikator.prestasi.index') }}"
                                class="list-group-item list-group-item-action">
                                <i class="fas fa-trophy text-warning"></i> Semua Prestasi
                            </a>
                            <a href="{{ route('verifikator.prestasi.index', ['status' => 'menunggu']) }}"
                                class="list-group-item list-group-item-action">
                                <i class="fas fa-clock text-warning"></i> Menunggu Verifikasi
                            </a>
                            <a href="{{ route('verifikator.prestasi.index', ['status' => 'diverifikasi']) }}"
                                class="list-group-item list-group-item-action">
                                <i class="fas fa-check text-success"></i> Terverifikasi
                            </a>
                            <a href="{{ route('verifikator.atlit.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-users text-info"></i> Data Atlit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load dashboard data
        $(document).ready(function() {
            loadDashboardData();
        });

        function loadDashboardData() {
            // Load statistics
            $.get('{{ route('verifikator.prestasi.index') }}', function(data) {
                // Update counts based on response
                // This would need to be implemented in your controller
            });
        }
    </script>
@endsection
