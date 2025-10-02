<div>
    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Prestasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
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
                                Menunggu Verifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['pending'] }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['verified'] }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data Prestasi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Pencarian</label>
                    <input type="text" class="form-control" wire:model.debounce.500ms="search"
                        placeholder="Cari nama atlet, kejuaraan...">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control" wire:model.live="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Verifikasi</option>
                        <option value="verified">Terverifikasi</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Tahun</label>
                    <select class="form-control" wire:model.live="tahunFilter">
                        <option value="">Semua Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Cabang Olahraga</label>
                    <select class="form-control" wire:model.live="caborFilter">
                        <option value="">Semua Cabor</option>
                        @foreach ($cabors as $cabor)
                            <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button class="btn btn-secondary btn-block" wire:click="resetFilters" title="Reset Filter">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Prestasi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Prestasi</h6>
            <div class="text-muted small">
                Menampilkan {{ $prestasi->count() }} dari {{ $prestasi->total() }} data
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Atlet</th>
                            <th width="15%">Cabor</th>
                            <th width="20%">Kejuaraan</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%">Peringkat</th>
                            <th width="10%">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prestasi as $index => $item)
                            <tr>
                                <td>{{ $prestasi->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $item->atlit->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $item->atlit->klub->nama_klub ?? '-' }}</small>
                                </td>
                                <td>{{ $item->cabangOlahraga->nama_cabang }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $item->nama_kejuaraan }}</div>
                                    <small class="text-muted">
                                        {{ $item->tingkat_kejuaraan }} • {{ $item->tempat_kejuaraan }}
                                    </small>
                                </td>
                                <td>
                                    <small>{{ $item->tanggal_kejuaraan }}</small>
                                </td>
                                <td>{!! $item->peringkat_badge !!}</td>
                                <td>
                                    @if ($item->status === 'pending')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @elseif ($item->status === 'verified')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('verifikator.prestasi.show', $item->id) }}"
                                        class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($item->sertifikat)
                                        <a href="{{ route('verifikator.prestasi.show', $item->id) }}#sertifikat"
                                            class="btn btn-sm btn-secondary" title="Lihat Sertifikat">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">Tidak ada data prestasi yang ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $prestasi->firstItem() ?? 0 }} - {{ $prestasi->lastItem() ?? 0 }}
                    dari {{ $prestasi->total() }} data
                </div>
                <div>
                    {{ $prestasi->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
