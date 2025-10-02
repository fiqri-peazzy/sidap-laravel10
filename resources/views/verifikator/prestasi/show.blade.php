@extends('layouts.app')

@section('title', 'Detail Prestasi')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-trophy text-primary"></i> Detail Prestasi
        </h1>
        <a href="{{ route('verifikator.prestasi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
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

    <div class="row">
        <!-- Kolom Kiri: Detail Prestasi -->
        <div class="col-lg-8">
            <!-- Card Status Verifikasi -->
            <div
                class="card shadow mb-4 border-left-{{ $prestasi->status === 'verified' ? 'success' : ($prestasi->status === 'pending' ? 'warning' : 'danger') }}">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Status Verifikasi</h6>
                    @if ($prestasi->status === 'pending')
                        <span class="badge badge-warning badge-lg">
                            <i class="fas fa-clock"></i> Menunggu Verifikasi
                        </span>
                    @elseif ($prestasi->status === 'verified')
                        <span class="badge badge-success badge-lg">
                            <i class="fas fa-check-circle"></i> Terverifikasi
                        </span>
                    @else
                        <span class="badge badge-danger badge-lg">
                            <i class="fas fa-times-circle"></i> Ditolak
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    @if ($prestasi->catatan_verifikator)
                        <div class="alert alert-info">
                            <strong><i class="fas fa-sticky-note"></i> Catatan Verifikator:</strong>
                            <p class="mb-0 mt-2">{{ $prestasi->catatan_verifikator }}</p>
                        </div>
                    @endif

                    @if ($prestasi->status === 'pending')
                        <p class="text-muted mb-3">
                            <i class="fas fa-info-circle"></i>
                            Prestasi ini menunggu untuk diverifikasi. Silakan periksa detail di bawah ini.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Card Info Atlet -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Informasi Atlet
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Nama Lengkap</label>
                            <p class="text-gray-800">{{ $prestasi->atlit->nama_lengkap }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Klub</label>
                            <p class="text-gray-800">{{ $prestasi->atlit->klub->nama_klub ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Cabang Olahraga</label>
                            <p class="text-gray-800">{{ $prestasi->atlit->cabangOlahraga->nama_cabang ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Tempat, Tanggal Lahir</label>
                            <p class="text-gray-800">
                                {{ $prestasi->atlit->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($prestasi->atlit->tanggal_lahir)->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail Prestasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-trophy"></i> Detail Prestasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold text-gray-700">Nama Kejuaraan</label>
                            <p class="text-gray-800 h5">{{ $prestasi->nama_kejuaraan }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Jenis Kejuaraan</label>
                            <p class="text-gray-800">{{ $prestasi->jenis_kejuaraan }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Tingkat Kejuaraan</label>
                            <p class="text-gray-800">
                                <span class="badge badge-primary">{{ $prestasi->tingkat_kejuaraan }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Tempat Kejuaraan</label>
                            <p class="text-gray-800">
                                <i class="fas fa-map-marker-alt text-danger"></i> {{ $prestasi->tempat_kejuaraan }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Tanggal Kejuaraan</label>
                            <p class="text-gray-800">{{ $prestasi->tanggal_kejuaraan }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Tahun</label>
                            <p class="text-gray-800">{{ $prestasi->tahun }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Cabang Olahraga</label>
                            <p class="text-gray-800">{{ $prestasi->cabangOlahraga->nama_cabang }}</p>
                        </div>
                        @if ($prestasi->nomor_pertandingan)
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold text-gray-700">Nomor Pertandingan</label>
                                <p class="text-gray-800">{{ $prestasi->nomor_pertandingan }}</p>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Peringkat</label>
                            <p>{!! $prestasi->peringkat_badge !!}</p>
                        </div>
                        @if ($prestasi->medali)
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-gray-700">Medali</label>
                                <p>{!! $prestasi->medali_badge !!}</p>
                            </div>
                        @endif
                    </div>

                    @if ($prestasi->keterangan)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="font-weight-bold text-gray-700">Keterangan</label>
                                <p class="text-gray-800">{{ $prestasi->keterangan }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Sertifikat -->
            @if ($prestasi->sertifikat)
                <div class="card shadow mb-4" id="sertifikat">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-file-alt"></i> Sertifikat Prestasi
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $extension = pathinfo($prestasi->sertifikat, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ $prestasi->sertifikat_url }}" alt="Sertifikat"
                                class="img-fluid rounded shadow-sm mb-3" style="max-height: 500px;">
                        @elseif (strtolower($extension) === 'pdf')
                            <div class="embed-responsive embed-responsive-16by9 mb-3">
                                <iframe class="embed-responsive-item" src="{{ $prestasi->sertifikat_url }}"
                                    allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-file"></i> File sertifikat tersedia untuk diunduh
                            </div>
                        @endif

                        <a href="{{ $prestasi->sertifikat_url }}" target="_blank" class="btn btn-primary" download>
                            <i class="fas fa-download"></i> Download Sertifikat
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Kolom Kanan: Panel Verifikasi -->
        <div class="col-lg-4">
            <!-- Card Aksi Verifikasi -->
            @if ($prestasi->status === 'pending')
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-warning text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-tasks"></i> Aksi Verifikasi
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Form Verifikasi (Approve) -->
                        <form action="{{ route('verifikator.prestasi.verify', $prestasi->id) }}" method="POST"
                            id="formVerify">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">Catatan Verifikasi (Opsional)</label>
                                <textarea name="catatan_verifikator" class="form-control" rows="3"
                                    placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success btn-block"
                                onclick="return confirm('Apakah Anda yakin ingin memverifikasi prestasi ini?')">
                                <i class="fas fa-check-circle"></i> Verifikasi
                            </button>
                        </form>

                        <hr>

                        <!-- Form Tolak (Reject) -->
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                            data-target="#modalReject">
                            <i class="fas fa-times-circle"></i> Tolak
                        </button>
                    </div>
                </div>
            @elseif ($prestasi->status === 'verified' || $prestasi->status === 'rejected')
                <!-- Form Update Catatan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-edit"></i> Edit Catatan
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('verifikator.prestasi.catatan', $prestasi->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">Catatan Verifikasi</label>
                                <textarea name="catatan_verifikator" class="form-control @error('catatan_verifikator') is-invalid @enderror"
                                    rows="4" placeholder="Tambahkan atau perbarui catatan...">{{ old('catatan_verifikator', $prestasi->catatan_verifikator) }}</textarea>
                                @error('catatan_verifikator')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Simpan Catatan
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Card Info Timestamp -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clock"></i> Informasi Waktu
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="font-weight-bold text-gray-700 small">Dibuat</label>
                        <p class="text-gray-800 small mb-0">
                            {{ $prestasi->created_at->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                    <div>
                        <label class="font-weight-bold text-gray-700 small">Terakhir Diperbarui</label>
                        <p class="text-gray-800 small mb-0">
                            {{ $prestasi->updated_at->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tolak Prestasi -->
    <div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('verifikator.prestasi.reject', $prestasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalRejectLabel">
                            <i class="fas fa-exclamation-triangle"></i> Tolak Prestasi
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i>
                            <strong>Perhatian!</strong> Anda akan menolak prestasi ini. Pastikan Anda memberikan alasan yang
                            jelas.
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="catatan_verifikator" class="form-control @error('catatan_verifikator') is-invalid @enderror"
                                rows="4" placeholder="Jelaskan alasan penolakan..." required></textarea>
                            @error('catatan_verifikator')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Catatan ini akan dilihat oleh atlet.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times-circle"></i> Tolak Prestasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .badge-lg {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .card-body label {
            font-size: 0.875rem;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Modal error handling
        @if ($errors->has('catatan_verifikator'))
            $('#modalReject').modal('show');
        @endif
    </script>
@endpush
