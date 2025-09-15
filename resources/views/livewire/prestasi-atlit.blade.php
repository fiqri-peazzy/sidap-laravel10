<div>
    <!-- Loading Indicator -->
    <div wire:loading class="text-center">
        <div class="spinner-border text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Main Content -->
    <div wire:loading.remove>
        <!-- Statistik Achievement Dashboard -->
        <div class="row mb-4">
            <!-- Total Prestasi -->
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Prestasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trophy fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Juara 1 -->
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-warning shadow h-100 py-2" style="border-left-color: #ffd700 !important;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #b8860b;">Juara
                                    1</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_1'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-medal fa-2x" style="color: #ffd700;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Juara 2 -->
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Juara 2</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_2'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-medal fa-2x" style="color: #c0c0c0;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Juara 3 -->
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-danger shadow h-100 py-2" style="border-left-color: #cd7f32 !important;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #8b4513;">Juara
                                    3</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_3'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-medal fa-2x" style="color: #cd7f32;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terverifikasi -->
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terverifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['verified'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['pending'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-filter mr-2"></i>Filter & Pencarian
                        </h6>
                    </div>
                    <div class="col-auto">
                        <!-- View Mode Switch -->
                        <div class="btn-group" role="group">
                            <button type="button"
                                class="btn btn-sm {{ $viewMode === 'cards' ? 'btn-success' : 'btn-outline-success' }}"
                                wire:click="switchViewMode('cards')">
                                <i class="fas fa-th-large"></i> Cards
                            </button>
                            <button type="button"
                                class="btn btn-sm {{ $viewMode === 'timeline' ? 'btn-success' : 'btn-outline-success' }}"
                                wire:click="switchViewMode('timeline')">
                                <i class="fas fa-timeline"></i> Timeline
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Search -->
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold">Pencarian</label>
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="searchTerm" placeholder="Cari kejuaraan, tempat...">
                    </div>

                    <!-- Filter Tahun -->
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Tahun</label>
                        <select wire:model.live="filterTahun" class="form-control form-control-sm">
                            <option value="">Semua Tahun</option>
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Cabor -->
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Cabang Olahraga</label>
                        <select wire:model.live="filterCabor" class="form-control form-control-sm">
                            <option value="">Semua Cabor</option>
                            @foreach ($availableCabors as $cabor)
                                <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Status</label>
                        <select wire:model.live="filterStatus" class="form-control form-control-sm">
                            <option value="">Semua Status</option>
                            <option value="verified">Terverifikasi</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <!-- Filter Tingkat -->
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Tingkat</label>
                        <select wire:model.live="filterTingkat" class="form-control form-control-sm">
                            <option value="">Semua Tingkat</option>
                            @foreach ($availableTingkat as $tingkat)
                                <option value="{{ $tingkat }}">{{ $tingkat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                            wire:click="resetFilters" title="Reset Filter">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi Content -->
        @if ($prestasiList->isEmpty())
            <!-- Empty State -->
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-trophy fa-4x text-gray-300"></i>
                    </div>
                    <h5 class="text-gray-600 mb-2">Belum Ada Prestasi</h5>
                    <p class="text-gray-500">
                        @if ($searchTerm || $filterTahun || $filterCabor || $filterStatus || $filterTingkat)
                            Tidak ada prestasi yang sesuai dengan filter yang dipilih.
                        @else
                            Prestasi Anda belum tercatat dalam sistem. Hubungi admin untuk menambahkan prestasi.
                        @endif
                    </p>
                    @if ($searchTerm || $filterTahun || $filterCabor || $filterStatus || $filterTingkat)
                        <button type="button" class="btn btn-outline-primary" wire:click="resetFilters">
                            <i class="fas fa-undo mr-1"></i>Reset Filter
                        </button>
                    @endif
                </div>
            </div>
        @else
            @if ($viewMode === 'cards')
                <!-- Cards View -->
                <div class="row">
                    @foreach ($prestasiList as $prestasi)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div
                                class="card achievement-card {{ $prestasi->medali ? strtolower($prestasi->medali) : $prestasi->status }} shadow h-100">
                                <!-- Card Header -->
                                <div class="card-header d-flex justify-content-between align-items-center py-2">
                                    <div>
                                        <span
                                            class="badge badge-primary">{{ $prestasi->cabangOlahraga->nama_cabang ?? 'N/A' }}</span>
                                        <span class="badge badge-info ml-1">{{ $prestasi->tahun }}</span>
                                    </div>
                                    <div>
                                        {!! $prestasi->status_badge !!}
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        @if ($prestasi->medali)
                                            <i
                                                class="fas fa-medal medal-icon medal-{{ strtolower($prestasi->medali) }}"></i>
                                        @elseif(in_array($prestasi->peringkat, ['1', '2', '3']))
                                            <i
                                                class="fas fa-medal medal-icon medal-{{ ['1' => 'gold', '2' => 'silver', '3' => 'bronze'][$prestasi->peringkat] }}"></i>
                                        @else
                                            <i class="fas fa-trophy medal-icon text-muted"></i>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="font-weight-bold mb-1 text-truncate"
                                                title="{{ $prestasi->nama_kejuaraan }}">
                                                {{ Str::limit($prestasi->nama_kejuaraan, 40) }}
                                            </h6>
                                            <small class="text-muted">{{ $prestasi->tingkat_kejuaraan }}</small>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <small class="text-muted d-block">
                                            <i
                                                class="fas fa-map-marker-alt mr-1"></i>{{ $prestasi->tempat_kejuaraan }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar mr-1"></i>{{ $prestasi->tanggal_kejuaraan }}
                                        </small>
                                        @if ($prestasi->nomor_pertandingan)
                                            <small class="text-muted d-block">
                                                <i class="fas fa-hashtag mr-1"></i>{{ $prestasi->nomor_pertandingan }}
                                            </small>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        {!! $prestasi->peringkat_badge !!}
                                        @if ($prestasi->medali)
                                            {!! $prestasi->medali_badge !!}
                                        @endif
                                    </div>

                                    @if ($prestasi->keterangan)
                                        <p class="small text-muted mb-3">{{ Str::limit($prestasi->keterangan, 100) }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer bg-transparent">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('atlit.prestasi.show', $prestasi->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                        @if ($prestasi->sertifikat)
                                            <a href="{{ route('atlit.prestasi.download-sertifikat-atlit', $prestasi->id) }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-download mr-1"></i>Sertifikat
                                            </a>
                                        @else
                                            <span class="btn btn-outline-secondary btn-sm disabled">
                                                <i class="fas fa-download mr-1"></i>Tidak Ada
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Timeline View -->
                <div class="card shadow">
                    <div class="card-body">
                        @foreach ($prestasiGrouped as $tahun => $prestasiTahun)
                            <div class="mb-4">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-calendar-alt mr-2"></i>{{ $tahun }}
                                    <span class="badge badge-primary ml-2">{{ $prestasiTahun->count() }}
                                        prestasi</span>
                                </h4>

                                @foreach ($prestasiTahun as $prestasi)
                                    <div class="timeline-item">
                                        <div
                                            class="timeline-dot bg-{{ $prestasi->status === 'verified' ? 'success' : ($prestasi->status === 'pending' ? 'warning' : 'danger') }}">
                                        </div>
                                        <div class="card border-0 shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="d-flex align-items-start mb-2">
                                                            @if ($prestasi->medali)
                                                                <i
                                                                    class="fas fa-medal medal-icon medal-{{ strtolower($prestasi->medali) }}"></i>
                                                            @elseif(in_array($prestasi->peringkat, ['1', '2', '3']))
                                                                <i
                                                                    class="fas fa-medal medal-icon medal-{{ ['1' => 'gold', '2' => 'silver', '3' => 'bronze'][$prestasi->peringkat] }}"></i>
                                                            @else
                                                                <i class="fas fa-trophy medal-icon text-muted"></i>
                                                            @endif
                                                            <div class="flex-grow-1">
                                                                <h6 class="font-weight-bold mb-1">
                                                                    {{ $prestasi->nama_kejuaraan }}</h6>
                                                                <div class="mb-2">
                                                                    <span
                                                                        class="badge badge-primary mr-1">{{ $prestasi->cabangOlahraga->nama_cabang ?? 'N/A' }}</span>
                                                                    <span
                                                                        class="badge badge-info mr-1">{{ $prestasi->tingkat_kejuaraan }}</span>
                                                                    {!! $prestasi->status_badge !!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row text-muted small">
                                                            <div class="col-sm-6">
                                                                <i
                                                                    class="fas fa-map-marker-alt mr-1"></i>{{ $prestasi->tempat_kejuaraan }}
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <i
                                                                    class="fas fa-calendar mr-1"></i>{{ $prestasi->tanggal_kejuaraan }}
                                                            </div>
                                                        </div>

                                                        @if ($prestasi->nomor_pertandingan)
                                                            <div class="text-muted small">
                                                                <i
                                                                    class="fas fa-hashtag mr-1"></i>{{ $prestasi->nomor_pertandingan }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="text-right">
                                                            <div class="mb-2">
                                                                {!! $prestasi->peringkat_badge !!}
                                                            </div>
                                                            @if ($prestasi->medali)
                                                                <div class="mb-2">
                                                                    {!! $prestasi->medali_badge !!}
                                                                </div>
                                                            @endif
                                                            <div class="btn-group">
                                                                <a href="{{ route('atlit.prestasi.show', $prestasi->id) }}"
                                                                    class="btn btn-outline-primary btn-sm">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </a>
                                                                @if ($prestasi->sertifikat)
                                                                    <a href="{{ route('atlit.prestasi.download-sertifikat-atlit', $prestasi->id) }}"
                                                                        class="btn btn-outline-success btn-sm">
                                                                        <i class="fas fa-download mr-1"></i>Sertifikat
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($prestasi->keterangan)
                                                    <div class="mt-2 pt-2 border-top">
                                                        <small class="text-muted">{{ $prestasi->keterangan }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <!-- Achievement Summary (if has data) -->
        @if ($prestasiList->isNotEmpty())
            <div class="row mt-4">
                <!-- Medali Emas -->
                <div class="col-md-4">
                    <div class="card bg-gradient-warning text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Medali Emas</div>
                                    <div class="h3 mb-0">{{ $statistik['emas'] ?? 0 }}</div>
                                </div>
                                <div>
                                    <i class="fas fa-medal fa-3x" style="color: rgba(255,255,255,0.3);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medali Perak -->
                <div class="col-md-4">
                    <div class="card bg-gradient-secondary text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Medali Perak</div>
                                    <div class="h3 mb-0">{{ $statistik['perak'] ?? 0 }}</div>
                                </div>
                                <div>
                                    <i class="fas fa-medal fa-3x" style="color: rgba(255,255,255,0.3);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medali Perunggu -->
                <div class="col-md-4">
                    <div class="card text-white shadow" style="background: linear-gradient(45deg, #cd7f32, #8b4513);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Medali Perunggu</div>
                                    <div class="h3 mb-0">{{ $statistik['perunggu'] ?? 0 }}</div>
                                </div>
                                <div>
                                    <i class="fas fa-medal fa-3x" style="color: rgba(255,255,255,0.3);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Pagination -->
        @if ($prestasiList->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $prestasiList->links() }}
            </div>
        @endif
    </div>
</div>
