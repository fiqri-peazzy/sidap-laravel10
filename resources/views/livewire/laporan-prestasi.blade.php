<div>
    @section('title', 'Laporan Prestasi Atlit')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-trophy"></i> Laporan Prestasi Atlit
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
                                    Total Prestasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPrestasi) }}
                                </div>
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
                                    Medali Emas
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($prestasiEmas) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-medal fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Medali Perak
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($prestasiPerak) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-medal fa-2x text-secondary"></i>
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
                                    Medali Perunggu
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($prestasiPerunggu) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-medal fa-2x text-info"></i>
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
                            <label>Atlit</label>
                            <select wire:model="atlit_id" class="form-control">
                                <option value="">Semua Atlit</option>
                                @foreach ($atlit as $a)
                                    <option value="{{ $a->id }}">{{ $a->nama_lengkap }}</option>
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
                            <label>Tingkat Kejuaraan</label>
                            <select wire:model="tingkat_kejuaraan" class="form-control">
                                <option value="">Semua Tingkat</option>
                                @foreach ($tingkatKejuaraan as $tingkat)
                                    <option value="{{ $tingkat }}">{{ $tingkat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select wire:model="tahun" class="form-control">
                                <option value="">Semua Tahun</option>
                                @foreach ($tahunList as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Medali</label>
                            <select wire:model="medali" class="form-control">
                                <option value="">Semua Medali</option>
                                @foreach ($medaliList as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pencarian</label>
                            <input wire:model.debounce.300ms="search" type="text" class="form-control"
                                placeholder="Nama kejuaraan, tempat, nomor pertandingan...">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-group">
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
        </div>

        <!-- Data Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table"></i> Data Prestasi
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="3%">No</th>
                                <th>Nama Atlit</th>
                                <th>Nama Kejuaraan</th>
                                <th>Cabang Olahraga</th>
                                <th>Tingkat</th>
                                <th>Tahun</th>
                                <th>Tempat</th>
                                <th>Peringkat</th>
                                <th>Medali</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prestasi as $index => $item)
                                <tr>
                                    <td>{{ ($prestasi->currentPage() - 1) * $prestasi->perPage() + $index + 1 }}</td>
                                    <td>{{ $item->atlit->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $item->nama_kejuaraan }}</td>
                                    <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = '';
                                            switch ($item->tingkat_kejuaraan) {
                                                case 'Internasional':
                                                    $badgeClass = 'badge-danger';
                                                    break;
                                                case 'Nasional':
                                                    $badgeClass = 'badge-warning';
                                                    break;
                                                case 'Provinsi':
                                                    $badgeClass = 'badge-info';
                                                    break;
                                                case 'Daerah':
                                                    $badgeClass = 'badge-secondary';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge-light';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $item->tingkat_kejuaraan }}</span>
                                    </td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->tempat_kejuaraan }}</td>
                                    <td>{{ $item->peringkat }}</td>
                                    <td>
                                        @if ($item->medali)
                                            @php
                                                $medalClass = '';
                                                $medalIcon = 'fa-medal';
                                                switch ($item->medali) {
                                                    case 'Emas':
                                                        $medalClass = 'text-warning';
                                                        break;
                                                    case 'Perak':
                                                        $medalClass = 'text-secondary';
                                                        break;
                                                    case 'Perunggu':
                                                        $medalClass = 'text-info';
                                                        break;
                                                }
                                            @endphp
                                            <i class="fas {{ $medalIcon }} {{ $medalClass }}"></i>
                                            {{ $item->medali }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data yang ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan {{ $prestasi->firstItem() ?? 0 }} sampai {{ $prestasi->lastItem() ?? 0 }}
                        dari {{ $prestasi->total() }} data
                    </div>
                    <div>
                        {{ $prestasi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
