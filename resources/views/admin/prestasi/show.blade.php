@extends('layouts.app')

@section('title', 'Detail Prestasi - ' . $prestasi->atlit->nama_lengkap)

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-trophy"></i> Detail Prestasi Atlet
        </h1>
        <div>
            <a href="{{ route('prestasi.edit', $prestasi->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('prestasi.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Atlet -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Informasi Atlet
                    </h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $prestasi->atlit->foto_url }}" alt="Foto {{ $prestasi->atlit->nama_lengkap }}"
                        class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">

                    <h5 class="font-weight-bold">{{ $prestasi->atlit->nama_lengkap }}</h5>
                    <p class="text-muted mb-1">{{ $prestasi->cabangOlahraga->nama_cabang }}</p>
                    <p class="text-muted mb-3">{{ $prestasi->atlit->klub->nama_klub ?? '-' }}</p>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <h6 class="font-weight-bold text-primary">{{ $prestasi->atlit->umur ?? '-' }}</h6>
                                <small class="text-muted">Tahun</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="font-weight-bold text-primary">{{ $prestasi->atlit->jenis_kelamin_lengkap }}</h6>
                            <small class="text-muted">Jenis Kelamin</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs"></i> Status & Aksi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="font-weight-bold">Status Prestasi:</label><br>
                        {!! $prestasi->status_badge !!}
                    </div>

                    @if ($prestasi->status == 'pending')
                        <div class="mb-3">
                            <form action="{{ route('prestasi.verify', $prestasi->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm btn-block mb-2"
                                    onclick="return confirm('Apakah Anda yakin ingin memverifikasi prestasi ini?')">
                                    <i class="fas fa-check"></i> Verifikasi Prestasi
                                </button>
                            </form>

                            <form action="{{ route('prestasi.reject', $prestasi->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning btn-sm btn-block"
                                    onclick="return confirm('Apakah Anda yakin ingin menolak prestasi ini?')">
                                    <i class="fas fa-times"></i> Tolak Prestasi
                                </button>
                            </form>
                        </div>
                    @endif

                    @if ($prestasi->sertifikat)
                        <div class="mb-3">
                            <a href="{{ route('prestasi.download-sertifikat', $prestasi->id) }}"
                                class="btn btn-info btn-sm btn-block" target="_blank">
                                <i class="fas fa-download"></i> Download Sertifikat
                            </a>
                        </div>
                    @endif

                    <hr>

                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-clock"></i>
                            Dibuat: {{ $prestasi->created_at->format('d M Y, H:i') }}<br>
                            Diperbarui: {{ $prestasi->updated_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Prestasi -->
        <div class="col-lg-8">
            <!-- Informasi Kejuaraan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-trophy"></i> Detail Prestasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4 text-center">
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h2 class="font-weight-bold mb-0">
                                        @if ($prestasi->peringkat == '1')
                                            <i class="fas fa-medal"></i> 1
                                        @elseif($prestasi->peringkat == '2')
                                            <i class="fas fa-medal"></i> 2
                                        @elseif($prestasi->peringkat == '3')
                                            <i class="fas fa-medal"></i> 3
                                        @elseif($prestasi->peringkat == 'partisipasi')
                                            <i class="fas fa-users"></i>
                                        @else
                                            {{ $prestasi->peringkat }}
                                        @endif
                                    </h2>
                                    <small>
                                        @if ($prestasi->peringkat == 'partisipasi')
                                            Partisipasi
                                        @else
                                            Peringkat {{ $prestasi->peringkat }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if ($prestasi->medali)
                                <div
                                    class="card @if ($prestasi->medali == 'Emas') bg-warning @elseif($prestasi->medali == 'Perak') bg-secondary @else bg-danger @endif text-white">
                                    <div class="card-body">
                                        <h2 class="font-weight-bold mb-0">
                                            <i class="fas fa-medal"></i>
                                        </h2>
                                        <small>{{ $prestasi->medali }}</small>
                                    </div>
                                </div>
                            @else
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h2 class="font-weight-bold mb-0 text-muted">
                                            <i class="fas fa-minus"></i>
                                        </h2>
                                        <small class="text-muted">Tanpa Medali</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h2 class="font-weight-bold mb-0">{{ $prestasi->tahun }}</h2>
                                    <small>Tahun Prestasi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <td class="font-weight-bold" width="25%">Nama Kejuaraan</td>
                            <td width="5%">:</td>
                            <td>{{ $prestasi->nama_kejuaraan }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Jenis Kejuaraan</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-primary">{{ $prestasi->jenis_kejuaraan }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tingkat Kejuaraan</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-info">{{ $prestasi->tingkat_kejuaraan }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tempat Kejuaraan</td>
                            <td>:</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-danger"></i> {{ $prestasi->tempat_kejuaraan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Kejuaraan</td>
                            <td>:</td>
                            <td>
                                <i class="fas fa-calendar text-primary"></i> {{ $prestasi->tanggal_kejuaraan }}
                            </td>
                        </tr>
                        @if ($prestasi->nomor_pertandingan)
                            <tr>
                                <td class="font-weight-bold">Nomor Pertandingan</td>
                                <td>:</td>
                                <td>
                                    <span class="badge badge-secondary">{{ $prestasi->nomor_pertandingan }}</span>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="font-weight-bold">Cabang Olahraga</td>
                            <td>:</td>
                            <td>{{ $prestasi->cabangOlahraga->nama_cabang }}</td>
                        </tr>
                    </table>

                    @if ($prestasi->keterangan)
                        <hr>
                        <div>
                            <h6 class="font-weight-bold">Keterangan:</h6>
                            <p class="text-muted">{{ $prestasi->keterangan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sertifikat Preview -->
            @if ($prestasi->sertifikat)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-certificate"></i> Sertifikat
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $extension = pathinfo($prestasi->sertifikat, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ $prestasi->sertifikat_url }}" alt="Sertifikat {{ $prestasi->nama_kejuaraan }}"
                                class="img-fluid rounded shadow" style="max-height: 400px;">
                        @else
                            <div class="py-4">
                                <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                <h5>File PDF</h5>
                                <p class="text-muted">{{ $prestasi->sertifikat }}</p>
                            </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('prestasi.download-sertifikat', $prestasi->id) }}" class="btn btn-primary"
                                target="_blank">
                                <i class="fas fa-download"></i> Download Sertifikat
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Riwayat Prestasi Atlet Lainnya -->
            @php
                $prestasiLain = $prestasi->atlit
                    ->prestasi()
                    ->where('id', '!=', $prestasi->id)
                    ->verified()
                    ->orderBy('tahun', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if ($prestasiLain->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-history"></i> Prestasi Lainnya
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach ($prestasiLain as $item)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $item->nama_kejuaraan }}</h6>
                                        <small class="text-muted">{{ $item->tahun }}</small>
                                    </div>
                                    <p class="mb-1 text-muted">{{ $item->tingkat_kejuaraan }} -
                                        {{ $item->tempat_kejuaraan }}</p>
                                    <div>
                                        {!! $item->peringkat_badge !!}
                                        @if ($item->medali)
                                            {!! $item->medali_badge !!}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('prestasi.index', ['search' => $prestasi->atlit->nama_lengkap]) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-list"></i> Lihat Semua Prestasi Atlet
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card .card-body h2 {
            font-size: 2rem;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
        }

        .list-group-item:first-child {
            border-top: none;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .badge {
            font-size: 0.75em;
        }
    </style>
@endpush
