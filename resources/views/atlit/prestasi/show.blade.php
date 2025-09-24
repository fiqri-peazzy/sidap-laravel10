@extends('layouts.app')

@section('title', 'Detail Prestasi')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-trophy fa-fw mr-2 text-warning"></i>Detail Prestasi
            </h1>
            <a href="{{ route('atlit.prestasi.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle fa-fw mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle fa-fw mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Prestasi Detail Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-success">Informasi Prestasi</h6>
                        <div>
                            {!! $prestasi->status_badge !!}
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Achievement Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                @if ($prestasi->medali)
                                    <i class="fas fa-medal fa-4x medal-{{ strtolower($prestasi->medali) }}"></i>
                                @elseif(in_array($prestasi->peringkat, ['1', '2', '3']))
                                    <i
                                        class="fas fa-medal fa-4x medal-{{ ['1' => 'gold', '2' => 'silver', '3' => 'bronze'][$prestasi->peringkat] }}"></i>
                                @else
                                    <i class="fas fa-trophy fa-4x text-muted"></i>
                                @endif
                            </div>
                            <h3 class="text-dark font-weight-bold">{{ $prestasi->nama_kejuaraan }}</h3>
                            <div class="mb-2">
                                <span
                                    class="badge badge-primary badge-lg mr-2">{{ $prestasi->cabangOlahraga->nama_cabang ?? 'N/A' }}</span>
                                <span class="badge badge-info badge-lg mr-2">{{ $prestasi->tingkat_kejuaraan }}</span>
                                <span class="badge badge-warning badge-lg">{{ $prestasi->tahun }}</span>
                            </div>
                            <div>
                                {!! $prestasi->peringkat_badge !!}
                                @if ($prestasi->medali)
                                    {!! $prestasi->medali_badge !!}
                                @endif
                            </div>
                        </div>

                        <!-- Detail Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-group mb-3">
                                    <label class="font-weight-bold text-gray-600">Jenis Kejuaraan</label>
                                    <p class="mb-0">{{ $prestasi->jenis_kejuaraan }}</p>
                                </div>
                                <div class="detail-group mb-3">
                                    <label class="font-weight-bold text-gray-600">Tempat Kejuaraan</label>
                                    <p class="mb-0">
                                        <i class="fas fa-map-marker-alt mr-1 text-danger"></i>
                                        {{ $prestasi->tempat_kejuaraan }}
                                    </p>
                                </div>
                                <div class="detail-group mb-3">
                                    <label class="font-weight-bold text-gray-600">Tanggal Kejuaraan</label>
                                    <p class="mb-0">
                                        <i class="fas fa-calendar mr-1 text-primary"></i>
                                        {{ $prestasi->tanggal_kejuaraan }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if ($prestasi->nomor_pertandingan)
                                    <div class="detail-group mb-3">
                                        <label class="font-weight-bold text-gray-600">Nomor Pertandingan</label>
                                        <p class="mb-0">
                                            <i class="fas fa-hashtag mr-1 text-info"></i>
                                            {{ $prestasi->nomor_pertandingan }}
                                        </p>
                                    </div>
                                @endif
                                <div class="detail-group mb-3">
                                    <label class="font-weight-bold text-gray-600">Cabang Olahraga</label>
                                    <p class="mb-0">{{ $prestasi->cabangOlahraga->nama_cabang ?? '-' }}</p>
                                </div>
                                <div class="detail-group mb-3">
                                    <label class="font-weight-bold text-gray-600">Tingkat Kejuaraan</label>
                                    <p class="mb-0">{{ $prestasi->tingkat_kejuaraan }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($prestasi->keterangan)
                            <hr>
                            <div class="detail-group">
                                <label class="font-weight-bold text-gray-600">Keterangan</label>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $prestasi->keterangan }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Atlit Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Informasi Atlit</h6>
                    </div>
                    <div class="card-body text-center">
                        @if ($atlit->foto)
                            <img src="{{ Storage::url('atlit/' . $atlit->foto) }}" alt="Foto {{ $atlit->nama_lengkap }}"
                                class="img-fluid rounded-circle mb-3"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-gray-300 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px;">
                                <i class="fas fa-user fa-2x text-gray-600"></i>
                            </div>
                        @endif

                        <h5 class="font-weight-bold">{{ $atlit->nama_lengkap }}</h5>
                        <p class="text-muted mb-2">{{ $atlit->klub->nama ?? 'Tidak ada klub' }}</p>
                        <p class="text-muted small">{{ $atlit->cabangOlahraga->nama_cabang ?? 'Tidak ada cabor' }}</p>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Aksi</h6>
                    </div>
                    <div class="card-body">
                        @if ($prestasi->sertifikat)
                            <a href="{{ route('atlit.prestasi.download-sertifikat-atlit', $prestasi->id) }}"
                                class="btn btn-success btn-block mb-2">
                                <i class="fas fa-download mr-2"></i>Download Sertifikat
                            </a>
                        @else
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Info:</strong> Sertifikat belum tersedia untuk prestasi ini.
                            </div>
                        @endif

                        <a href="{{ route('atlit.prestasi.index') }}" class="btn btn-outline-primary btn-block">
                            <i class="fas fa-list mr-2"></i>Lihat Semua Prestasi
                        </a>
                    </div>
                </div>

                <!-- Achievement Stats -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Statistik Prestasi</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $totalPrestasi = $atlit->prestasi()->verified()->count();
                            $juara1 = $atlit->prestasi()->verified()->where('peringkat', '1')->count();
                            $juara2 = $atlit->prestasi()->verified()->where('peringkat', '2')->count();
                            $juara3 = $atlit->prestasi()->verified()->where('peringkat', '3')->count();
                            $medaliEmas = $atlit->prestasi()->verified()->where('medali', 'Emas')->count();
                            $medaliPerak = $atlit->prestasi()->verified()->where('medali', 'Perak')->count();
                            $medaliPerunggu = $atlit->prestasi()->verified()->where('medali', 'Perunggu')->count();
                        @endphp

                        <div class="mb-2 d-flex justify-content-between">
                            <span>Total Prestasi:</span>
                            <span class="font-weight-bold">{{ $totalPrestasi }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span><i class="fas fa-medal text-warning mr-1"></i>Juara 1:</span>
                            <span class="font-weight-bold">{{ $juara1 }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span><i class="fas fa-medal text-secondary mr-1"></i>Juara 2:</span>
                            <span class="font-weight-bold">{{ $juara2 }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span><i class="fas fa-medal text-bronze mr-1"></i>Juara 3:</span>
                            <span class="font-weight-bold">{{ $juara3 }}</span>
                        </div>
                        @if ($medaliEmas > 0 || $medaliPerak > 0 || $medaliPerunggu > 0)
                            <hr class="my-2">
                            @if ($medaliEmas > 0)
                                <div class="mb-1 d-flex justify-content-between">
                                    <span><i class="fas fa-medal medal-gold mr-1"></i>Medali Emas:</span>
                                    <span class="font-weight-bold">{{ $medaliEmas }}</span>
                                </div>
                            @endif
                            @if ($medaliPerak > 0)
                                <div class="mb-1 d-flex justify-content-between">
                                    <span><i class="fas fa-medal medal-silver mr-1"></i>Medali Perak:</span>
                                    <span class="font-weight-bold">{{ $medaliPerak }}</span>
                                </div>
                            @endif
                            @if ($medaliPerunggu > 0)
                                <div class="mb-1 d-flex justify-content-between">
                                    <span><i class="fas fa-medal medal-bronze mr-1"></i>Medali Perunggu:</span>
                                    <span class="font-weight-bold">{{ $medaliPerunggu }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .medal-gold {
            color: #ffd700;
        }

        .medal-silver {
            color: #c0c0c0;
        }

        .medal-bronze {
            color: #cd7f32;
        }

        .text-bronze {
            color: #cd7f32;
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .detail-group label {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            display: block;
        }

        .detail-group p {
            font-size: 0.95rem;
            color: #333;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto hide flash messages after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
