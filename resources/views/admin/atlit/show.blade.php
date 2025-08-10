@extends('layouts.app')

@section('title', 'Detail Atlit')

@push('styles')
    <style>
        .badge-pink {
            background-color: #e83e8c;
            color: white;
        }

        .img-avatar {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .img-avatar-lg {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }

        .table th {
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .status-lisensi {
            font-size: 0.8rem;
        }

        .card-atlit-profile {
            border-left: 4px solid #4e73df;
        }

        .info-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-box h4 {
            color: white;
            margin-bottom: 10px;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Responsive table improvements */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.8rem;
            }

            .btn-group .btn {
                padding: 0.25rem 0.4rem;
                font-size: 0.75rem;
            }

            .img-avatar {
                width: 40px;
                height: 40px;
            }
        }

        /* Form styling improvements */
        .form-section {
            border-left: 4px solid #4e73df;
            padding-left: 15px;
            margin-bottom: 25px;
        }

        .form-section h5 {
            color: #4e73df;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .required-field::after {
            content: " *";
            color: #e74a3b;
        }

        /* Loading states */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Atlit</h1>
            <div>
                <a href="{{ route('atlit.edit', $atlit->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('atlit.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Foto dan Info Dasar -->
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <img src="{{ $atlit->foto_url }}" alt="Foto {{ $atlit->nama_lengkap }}"
                            class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <h5 class="card-title">{{ $atlit->nama_lengkap }}</h5>
                        <p class="text-muted">{{ $atlit->klub->nama_klub }}</p>
                        <div class="mb-2">{!! $atlit->status_badge !!}</div>
                        @if ($atlit->nomor_lisensi)
                            <div class="mb-2">{!! $atlit->status_lisensi !!}</div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Detail Info -->
            <div class="col-md-8">
                <!-- Data Pribadi -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Pribadi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>NIK</strong></td>
                                        <td>: {{ $atlit->nik }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tempat, Tanggal Lahir</strong></td>
                                        <td>: {{ $atlit->tempat_lahir }}, {{ $atlit->tanggal_lahir->format('d M Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Umur</strong></td>
                                        <td>: {{ $atlit->umur }} tahun</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Kelamin</strong></td>
                                        <td>: {{ $atlit->jenis_kelamin_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat</strong></td>
                                        <td>: {{ $atlit->alamat_lengkap }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Telepon</strong></td>
                                        <td>: {{ $atlit->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: {{ $atlit->email ?? '-' }}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Olahraga -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Olahraga</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Klub</strong></td>
                                        <td>: {{ $atlit->klub->nama_klub }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Cabang Olahraga</strong></td>
                                        <td>: {{ $atlit->cabangOlahraga->nama_cabang }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kategori</strong></td>
                                        <td>: {{ $atlit->kategoriAtlit->nama_kategori }}</td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">

                                    <tr>
                                        <td><strong>Akun User</strong></td>
                                        <td>: {{ $atlit->user ? 'Tersedia' : 'Tidak Ada' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prestasi -->
                @if ($atlit->prestasi)
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Prestasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-justify">
                                {!! nl2br(e($atlit->prestasi)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
