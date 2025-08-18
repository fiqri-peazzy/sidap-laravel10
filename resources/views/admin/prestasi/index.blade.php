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

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Prestasi Card -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Prestasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['total'] ?? 0 }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_1'] ?? 0 }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_2'] ?? 0 }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_3'] ?? 0 }}</div>
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
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Medali Emas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['emas'] ?? 0 }}</div>
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
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Medali Perak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['perak'] ?? 0 }}</div>
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
                                    <div class="font-weight-bold">{{ $item->atlit->nama_lengkap ?? '-' }}</div>
                                    <div class="small text-muted">{{ $item->atlit->klub->nama_klub ?? '-' }}</div>
                                </td>
                                <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
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
                                    <div>{{ $item->tanggal_kejuaraan ?? '-' }}</div>
                                    <div class="small text-muted">{{ $item->tahun ?? '-' }}</div>
                                </td>
                                <td>
                                    @if (method_exists($item, 'peringkat_badge'))
                                        {!! $item->peringkat_badge !!}
                                    @else
                                        @php
                                            $badgeClass = '';
                                            $icon = '';
                                            switch ($item->peringkat) {
                                                case '1':
                                                    $badgeClass = 'badge-warning';
                                                    $icon = '<i class="fas fa-trophy"></i>';
                                                    break;
                                                case '2':
                                                    $badgeClass = 'badge-secondary';
                                                    $icon = '<i class="fas fa-medal"></i>';
                                                    break;
                                                case '3':
                                                    $badgeClass = 'badge-danger';
                                                    $icon = '<i class="fas fa-medal"></i>';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge-info';
                                                    $icon = '<i class="fas fa-certificate"></i>';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {!! $icon !!}
                                            @if ($item->peringkat == 'partisipasi')
                                                Partisipasi
                                            @else
                                                Juara {{ $item->peringkat }}
                                            @endif
                                        </span>
                                    @endif

                                    @if ($item->medali)
                                        <br>
                                        @if (method_exists($item, 'medali_badge'))
                                            {!! $item->medali_badge !!}
                                        @else
                                            @php
                                                $medaliBadge = '';
                                                $medaliIcon = '';
                                                switch ($item->medali) {
                                                    case 'Emas':
                                                        $medaliBadge = 'badge-warning';
                                                        $medaliIcon = '<i class="fas fa-medal text-yellow"></i>';
                                                        break;
                                                    case 'Perak':
                                                        $medaliBadge = 'badge-secondary';
                                                        $medaliIcon = '<i class="fas fa-medal text-secondary"></i>';
                                                        break;
                                                    case 'Perunggu':
                                                        $medaliBadge = 'badge-danger';
                                                        $medaliIcon = '<i class="fas fa-medal text-danger"></i>';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $medaliBadge }}">
                                                {{ $item->medali }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (method_exists($item, 'status_badge'))
                                        {!! $item->status_badge !!}
                                    @else
                                        @php
                                            $statusBadge = '';
                                            switch ($item->status) {
                                                case 'verified':
                                                    $statusBadge = 'badge-success';
                                                    $statusText = 'Terverifikasi';
                                                    break;
                                                case 'pending':
                                                    $statusBadge = 'badge-warning';
                                                    $statusText = 'Pending';
                                                    break;
                                                case 'rejected':
                                                    $statusBadge = 'badge-danger';
                                                    $statusText = 'Ditolak';
                                                    break;
                                                default:
                                                    $statusBadge = 'badge-secondary';
                                                    $statusText = $item->status;
                                            }
                                        @endphp
                                        <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                                    @endif
                                </td>
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
                                                    class="d-inline verify-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="fas fa-check"></i> Verifikasi
                                                    </button>
                                                </form>
                                                <form action="{{ route('prestasi.reject', $item->id) }}" method="POST"
                                                    class="d-inline reject-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item text-warning">
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
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
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
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm">
                            {{-- Previous Page Link --}}
                            @if ($prestasi->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">« Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $prestasi->previousPageUrl() }}" rel="prev">«
                                        Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($prestasi->getUrlRange(1, $prestasi->lastPage()) as $page => $url)
                                @if ($page == $prestasi->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($prestasi->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $prestasi->nextPageUrl() }}" rel="next">Next »</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next »</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
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

        .alert {
            margin-bottom: 1rem;
        }

        /* Pagination Styling */
        .pagination-sm .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .pagination-sm .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .pagination-sm .page-link:hover {
            background-color: #f8f9fc;
            border-color: #dee2e6;
        }

        /* Custom colors for text in badges */
        .text-yellow {
            color: #ffc107 !important;
        }

        /* Badge spacing for icons */
        .badge i {
            margin-right: 3px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle delete confirmation with SweetAlert2
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data prestasi ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Handle verify confirmation
            $('.verify-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Verifikasi Prestasi?',
                    text: "Prestasi ini akan diverifikasi dan berstatus aktif.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Verifikasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Handle reject confirmation
            $('.reject-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Tolak Prestasi?',
                    text: "Prestasi ini akan ditolak dan tidak akan ditampilkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Auto hide alerts after 5 seconds
            $('.alert').delay(5000).fadeOut('slow');
        });
    </script>
@endpush
