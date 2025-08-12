@extends('layouts.app')

@section('title', 'Laporan Prestasi Atlet')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-bar"></i> Laporan Prestasi Atlet
        </h1>
        <div>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
            <a href="{{ route('prestasi.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4 no-print">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('prestasi.laporan') }}" class="row">
                <div class="col-md-4">
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
                <div class="col-md-6">
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
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Header Laporan -->
    <div class="text-center mb-4 print-header">
        <h2>LAPORAN PRESTASI ATLET</h2>
        <h3>PPLP PROVINSI GORONTALO</h3>
        <hr>
        <div class="row">
            <div class="col-md-12">
                @if (request('tahun'))
                    <p><strong>Periode:</strong> Tahun {{ request('tahun') }}</p>
                @else
                    <p><strong>Periode:</strong> Semua Tahun</p>
                @endif
                @if (request('cabor_id'))
                    <p><strong>Cabang Olahraga:</strong>
                        {{ $cabors->where('id', request('cabor_id'))->first()->nama_cabang ?? '-' }}</p>
                @else
                    <p><strong>Cabang Olahraga:</strong> Semua Cabor</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistik Umum -->
    <div class="row mb-4">
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

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Medali Emas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['emas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Medali Perak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['perak'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Medali Perunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['perunggu'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Juara 1</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['juara_1'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-crown fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Medali</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik['emas'] + $statistik['perak'] + $statistik['perunggu'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-award fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Per Cabang Olahraga -->
    @if ($statistikPerCabor->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie"></i> Prestasi Per Cabang Olahraga
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th rowspan="2" class="align-middle text-center">No</th>
                                <th rowspan="2" class="align-middle">Cabang Olahraga</th>
                                <th rowspan="2" class="align-middle text-center">Total Prestasi</th>
                                <th colspan="3" class="text-center">Medali</th>
                                <th colspan="3" class="text-center">Peringkat</th>
                            </tr>
                            <tr>
                                <th class="text-center">Emas</th>
                                <th class="text-center">Perak</th>
                                <th class="text-center">Perunggu</th>
                                <th class="text-center">Juara 1</th>
                                <th class="text-center">Juara 2</th>
                                <th class="text-center">Juara 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistikPerCabor->sortByDesc('total') as $index => $stat)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="font-weight-bold">{{ $stat['nama_cabang'] }}</td>
                                    <td class="text-center font-weight-bold">{{ $stat['total'] }}</td>
                                    <td class="text-center">{{ $stat['emas'] }}</td>
                                    <td class="text-center">{{ $stat['perak'] }}</td>
                                    <td class="text-center">{{ $stat['perunggu'] }}</td>
                                    <td class="text-center">{{ $stat['juara_1'] }}</td>
                                    <td class="text-center">{{ $stat['juara_2'] }}</td>
                                    <td class="text-center">{{ $stat['juara_3'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr class="font-weight-bold">
                                <td colspan="2" class="text-center">TOTAL</td>
                                <td class="text-center">{{ $statistikPerCabor->sum('total') }}</td>
                                <td class="text-center">{{ $statistikPerCabor->sum('emas') }}</td>
                                <td class="text-center">{{ $statistikPerCabor->sum('perak') }}</td>
                                <td class="text-center">{{ $statistikPerCabor->sum('perunggu') }}</td>
                                <td class="text-center">{{ $statistikPerCabor->sum('juara_1') }}</td>
                                <td class="text-center">{{ $statistikPerCabor->sum('juara_2') }}</td>
                                <td class="text-center">{{ $statistikPerCabor->sum('juara_3') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Detail Prestasi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> Detail Prestasi Atlet
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="3%" class="text-center">No</th>
                            <th width="12%">Nama Atlet</th>
                            <th width="10%">Cabor</th>
                            <th width="20%">Kejuaraan</th>
                            <th width="10%">Tingkat</th>
                            <th width="12%">Tempat & Tanggal</th>
                            <th width="15%">Nomor</th>
                            <th width="8%">Peringkat</th>
                            <th width="10%">Medali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasi as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $item->atlit->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $item->atlit->klub->nama_klub ?? '-' }}</small>
                                </td>
                                <td>{{ $item->cabangOlahraga->nama_cabang }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $item->nama_kejuaraan }}</div>
                                    <small class="text-muted">{{ $item->jenis_kejuaraan }}</small>
                                </td>
                                <td>{{ $item->tingkat_kejuaraan }}</td>
                                <td>
                                    <div>{{ $item->tempat_kejuaraan }}</div>
                                    <small class="text-muted">{{ $item->tanggal_kejuaraan }}</small>
                                </td>
                                <td>{{ $item->nomor_pertandingan ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($item->peringkat == '1')
                                        <span class="badge badge-warning">Juara 1</span>
                                    @elseif($item->peringkat == '2')
                                        <span class="badge badge-secondary">Juara 2</span>
                                    @elseif($item->peringkat == '3')
                                        <span class="badge badge-danger">Juara 3</span>
                                    @elseif($item->peringkat == 'partisipasi')
                                        <span class="badge badge-info">Partisipasi</span>
                                    @else
                                        <span class="badge badge-light text-dark">{{ $item->peringkat }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->medali)
                                        @if ($item->medali == 'Emas')
                                            <span class="badge badge-warning">{{ $item->medali }}</span>
                                        @elseif($item->medali == 'Perak')
                                            <span class="badge badge-secondary">{{ $item->medali }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $item->medali }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-trophy fa-2x text-gray-300 mb-2"></i>
                                    <p class="text-gray-500">Tidak ada data prestasi yang ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer Laporan -->
    <div class="row mt-5 print-footer">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-center">
            <p>Gorontalo, {{ date('d F Y') }}</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p>____________________</p>
            <p>Kepala PPLP Provinsi Gorontalo</p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .print-header {
                page-break-inside: avoid;
            }

            .print-footer {
                page-break-inside: avoid;
                margin-top: 50px;
            }

            .card {
                border: 1px solid #000 !important;
                box-shadow: none !important;
            }

            .card-header {
                background-color: #f8f9fc !important;
                border-bottom: 1px solid #000 !important;
            }

            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                border: 1px solid #000 !important;
                padding: 5px !important;
            }

            .badge {
                border: 1px solid #000 !important;
                color: #000 !important;
                background-color: #fff !important;
            }

            body {
                font-size: 12px;
            }

            h2,
            h3 {
                color: #000 !important;
            }
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }
    </style>
@endpush
