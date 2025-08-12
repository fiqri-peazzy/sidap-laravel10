@extends('layouts.app')

@section('title', 'Data Prestasi Atlet')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-trophy"></i> Data Prestasi Atlet
        </h1>
        <div>
            <a href="{{ route('prestasi.laporan') }}" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar"></i> Laporan
            </a>
            <a href="{{ route('prestasi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Prestasi
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Prestasi Card -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Prestasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Juara 1 Card -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Juara 1</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_1'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Juara 2 Card -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Juara 2</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_2'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Juara 3 Card -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Juara 3</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_3'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medali Emas Card -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Medali Emas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['emas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medali Perak Card -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Medali Perak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['perak'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('prestasi.index') }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Pencarian</label>
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="Cari nama kejuaraan, atlet..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Semua Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cabor_id">Cabang Olahraga</label>
                        <select name="cabor_id" id="cabor_id" class="form-control">
                            <option value="">Semua Cabor</option>
                            @foreach ($cabors as $cabor)
                                <option value="{{ $cabor->id }}"
                                    {{ request('cabor_id') == $cabor->id ? 'selected' : '' }}>
                                    {{ $cabor->nama_cabang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="peringkat">Peringkat</label>
                        <select name="peringkat" id="peringkat" class="form-control">
                            <option value="">Semua Peringkat</option>
                            <option value="1" {{ request('peringkat') == '1' ? 'selected' : '' }}>Juara 1</option>
                            <option value="2" {{ request('peringkat') == '2' ? 'selected' : '' }}>Juara 2</option>
                            <option value="3" {{ request('peringkat') == '3' ? 'selected' : '' }}>Juara 3</option>
                            <option value="partisipasi" {{ request('peringkat') == 'partisipasi' ? 'selected' : '' }}>
                                Partisipasi</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('prestasi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Prestasi</h6>
            <div class="text-muted small">
                Menampilkan {{ $prestasi->firstItem() ?? 0 }} - {{ $prestasi->lastItem() ?? 0 }}
                dari {{ $prestasi->total() }} data
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Atlet</th>
                            <th>Cabor</th>
                            <th>Kejuaraan</th>
                            <th>Tingkat</th>
                            <th>Tanggal</th>
                            <th>Peringkat</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasi as $index => $item)
                            <tr>
                                <td>{{ $prestasi->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $item->atlit->nama_lengkap }}</div>
                                    <div class="small text-muted">{{ $item->atlit->klub->nama_klub ?? '-' }}</div>
                                </td>
                                <td>{{ $item->cabangOlahraga->nama_cabang }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $item->nama_kejuaraan }}</div>
                                    <div class="small text-muted">{{ $item->tempat_kejuaraan }}</div>
                                    @if ($item->nomor_pertandingan)
                                        <div class="small text-info">{{ $item->nomor_pertandingan }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $item->tingkat_kejuaraan }}</div>
                                    <div class="small text-muted">{{ $item->jenis_kejuaraan }}</div>
                                </td>
                                <td>
                                    <div>{{ $item->tanggal_kejuaraan }}</div>
                                    <div class="small text-muted">{{ $item->tahun }}</div>
                                </td>
                                <td>
                                    {!! $item->peringkat_badge !!}
                                    @if ($item->medali)
                                        <br>{!! $item->medali_badge !!}
                                    @endif
                                </td>
                                <td>{!! $item->status_badge !!}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('prestasi.show', $item->id) }}">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a class="dropdown-item" href="{{ route('prestasi.edit', $item->id) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            @if ($item->status == 'pending')
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('prestasi.verify', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item text-success"
                                                        onclick="return confirm('Apakah Anda yakin ingin memverifikasi prestasi ini?')">
                                                        <i class="fas fa-check"></i> Verifikasi
                                                    </button>
                                                </form>
                                                <form action="{{ route('prestasi.reject', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item text-warning"
                                                        onclick="return confirm('Apakah Anda yakin ingin menolak prestasi ini?')">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($item->sertifikat)
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                    href="{{ route('prestasi.download-sertifikat', $item->id) }}"
                                                    target="_blank">
                                                    <i class="fas fa-download"></i> Download Sertifikat
                                                </a>
                                            @endif

                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('prestasi.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="py-4">
                                        <i class="fas fa-trophy fa-3x text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">Tidak ada data prestasi yang ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($prestasi->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $prestasi->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .badge {
            font-size: 0.75em;
        }

        .dropdown-menu {
            font-size: 0.875rem;
        }
    </style>
@endpush
