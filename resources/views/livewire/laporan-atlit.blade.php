<div>
    @section('title', 'Laporan Data Atlit')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-bar"></i> Laporan Data Atlit
            </h1>
        </div>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Atlit
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalAtlit) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                    Atlit Pria
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($atlitPria) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-male fa-2x text-gray-300"></i>
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
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Atlit Wanita
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($atlitWanita) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-female fa-2x text-gray-300"></i>
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
                                    Atlit Aktif
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($atlitAktif) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-filter"></i> Filter Laporan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Klub</label>
                            <select wire:model="klub_id" class="form-control">
                                <option value="">Semua Klub</option>
                                @foreach ($klub as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_klub }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cabang Olahraga</label>
                            <select wire:model="cabang_olahraga_id" class="form-control">
                                <option value="">Semua Cabang Olahraga</option>
                                @foreach ($cabangOlahraga as $cabor)
                                    <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select wire:model="jenis_kelamin" class="form-control">
                                <option value="">Semua</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Pencarian</label>
                            <input wire:model.debounce.300ms="search" type="text" class="form-control"
                                placeholder="Nama, NIK, Email...">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button wire:click="resetFilter" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reset Filter
                        </button>
                        <button wire:click="cetakLaporan" class="btn btn-danger ml-2">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table"></i> Data Atlit
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Klub</th>
                                <th>Cabang Olahraga</th>
                                <th>Status</th>
                                <th>Umur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($atlit as $index => $item)
                                <tr>
                                    <td>{{ ($atlit->currentPage() - 1) * $atlit->perPage() + $index + 1 }}</td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>
                                        @if ($item->jenis_kelamin == 'L')
                                            <i class="fas fa-male text-primary"></i> {{ $item->jenis_kelamin }}
                                        @else
                                            <i class="fas fa-female text-danger"></i> {{ $item->jenis_kelamin }}
                                        @endif
                                    </td>
                                    <td>{{ $item->klub->nama_klub ?? '-' }}</td>
                                    <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                                    <td>
                                        @if ($item->status == 'aktif')
                                            <span class="badge badge-success">{{ $item->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} tahun</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data yang ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan {{ $atlit->firstItem() ?? 0 }} sampai {{ $atlit->lastItem() ?? 0 }}
                        dari {{ $atlit->total() }} data
                    </div>
                    <div>
                        {{ $atlit->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
