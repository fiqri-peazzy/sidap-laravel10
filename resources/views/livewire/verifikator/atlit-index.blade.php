<div>
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle mr-2"></i>
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle mr-2"></i>
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Atlit -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Atlit
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 card-stats" style="cursor: pointer;"
                wire:click="quickFilter('{{ \App\Models\Atlit::STATUS_VERIFIKASI_PENDING }}')">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Verifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['pending']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terverifikasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 card-stats" style="cursor: pointer;"
                wire:click="quickFilter('{{ \App\Models\Atlit::STATUS_VERIFIKASI_VERIFIED }}')">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Terverifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['verified']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 card-stats" style="cursor: pointer;"
                wire:click="quickFilter('{{ \App\Models\Atlit::STATUS_VERIFIKASI_REJECTED }}')">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['rejected']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i>Daftar Atlit
                </h6>
                <button wire:click="resetFilters" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-sync mr-1"></i> Reset Filter
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Filters Row -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label text-sm font-weight-bold">Pencarian</label>
                    <input wire:model.debounce.300ms="search" type="text" class="form-control form-control-sm"
                        placeholder="Cari nama, NIK, email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label text-sm font-weight-bold">Status Verifikasi</label>
                    <select wire:model="statusFilter" class="form-control form-control-sm">
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-sm font-weight-bold">Cabang Olahraga</label>
                    <select wire:model="caborFilter" class="form-control form-control-sm">
                        <option value="">Semua Cabor</option>
                        @foreach ($cabors as $cabor)
                            <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-sm font-weight-bold">Kategori</label>
                    <select wire:model="kategoriFilter" class="form-control form-control-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-sm font-weight-bold">Per Halaman</label>
                    <select wire:model="perPage" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <!-- Loading Indicator -->
            <div wire:loading.delay class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="text-muted mt-2">Memuat data atlit...</p>
            </div>

            <!-- Table -->
            <div class="table-responsive" wire:loading.remove>
                @if ($atlets->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Cabang Olahraga</th>
                                <th>Kategori</th>
                                <th>Status Verifikasi</th>
                                <th>Dokumen</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($atlets as $index => $atlet)
                                <tr>
                                    <td class="text-center">
                                        {{ ($atlets->currentPage() - 1) * $atlets->perPage() + $index + 1 }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($atlet->foto)
                                                <img src="{{ asset('storage/atlit/foto/' . $atlet->foto) }}"
                                                    alt="{{ $atlet->nama_lengkap }}" class="rounded-circle mr-2"
                                                    style="width: 35px; height: 35px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mr-2"
                                                    style="width: 35px; height: 35px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-weight-bold">{{ $atlet->nama_lengkap }}</div>
                                                <small class="text-muted">{{ $atlet->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $atlet->nik }}</td>
                                    <td>{{ $atlet->cabangOlahraga->nama_cabang ?? '-' }}</td>
                                    <td>{{ $atlet->kategoriAtlit->nama_kategori ?? '-' }}</td>
                                    <td>
                                        @if ($atlet->status_verifikasi == \App\Models\Atlit::STATUS_VERIFIKASI_PENDING)
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>Menunggu
                                            </span>
                                        @elseif($atlet->status_verifikasi == \App\Models\Atlit::STATUS_VERIFIKASI_VERIFIED)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                            </span>
                                        @elseif($atlet->status_verifikasi == \App\Models\Atlit::STATUS_VERIFIKASI_REJECTED)
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                                            </span>
                                        @else
                                            <span
                                                class="badge badge-secondary">{{ $atlet->status_verifikasi_indonesia }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $totalDokumen = $atlet->dokumen->count();
                                            $verifiedDokumen = $atlet->dokumen
                                                ->where('status_verifikasi', 'verified')
                                                ->count();
                                            $pendingDokumen = $atlet->dokumen
                                                ->where('status_verifikasi', 'pending')
                                                ->count();
                                            $rejectedDokumen = $atlet->dokumen
                                                ->where('status_verifikasi', 'rejected')
                                                ->count();
                                        @endphp
                                        <div class="text-sm">
                                            <span class="badge badge-info" title="Total Dokumen">
                                                <i class="fas fa-file mr-1"></i>{{ $totalDokumen }}
                                            </span>
                                            @if ($verifiedDokumen > 0)
                                                <span class="badge badge-success" title="Dokumen Terverifikasi">
                                                    <i class="fas fa-check mr-1"></i>{{ $verifiedDokumen }}
                                                </span>
                                            @endif
                                            @if ($pendingDokumen > 0)
                                                <span class="badge badge-warning" title="Dokumen Pending">
                                                    <i class="fas fa-clock mr-1"></i>{{ $pendingDokumen }}
                                                </span>
                                            @endif
                                            @if ($rejectedDokumen > 0)
                                                <span class="badge badge-danger" title="Dokumen Ditolak">
                                                    <i class="fas fa-times mr-1"></i>{{ $rejectedDokumen }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('verifikator.atlit.show', $atlet) }}"
                                            class="btn btn-primary btn-sm" title="Lihat Detail & Verifikasi">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-5">
                        <img src="{{ asset('template/img/undraw_empty.png') }}" alt="No data"
                            style="max-width: 200px;" class="mb-3">
                        <h5 class="text-muted">Tidak ada data atlit</h5>
                        <p class="text-muted">Belum ada data atlit yang sesuai dengan filter yang dipilih.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if ($atlets->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $atlets->firstItem() }} - {{ $atlets->lastItem() }} dari
                        {{ $atlets->total() }} data
                    </div>
                    <div>
                        {{ $atlets->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
