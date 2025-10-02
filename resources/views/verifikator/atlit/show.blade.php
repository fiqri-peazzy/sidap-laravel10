@extends('layouts.app')

@section('title', 'Detail Atlit - ' . $atlit->nama_lengkap)

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-user-check text-warning mr-2"></i>
                    Detail Atlit untuk Verifikasi
                </h1>
                <p class="mb-0 text-muted">Kelola verifikasi data dan dokumen atlet</p>
            </div>
            <div class="btn-group" role="group">
                <a href="{{ route('verifikator.atlit.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <button type="button" class="btn btn-info" onclick="window.print()">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('verifikator.dashboard') }}" class="text-primary">
                        <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('verifikator.atlit.index') }}" class="text-primary">
                        <i class="fas fa-user-friends mr-1"></i>Data Atlit
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-user mr-1"></i>{{ $atlit->nama_lengkap }}
                </li>
            </ol>
        </nav>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg mr-3 text-success"></i>
                    <div>
                        <strong>Berhasil!</strong>
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-lg mr-3 text-danger"></i>
                    <div>
                        <strong>Error!</strong>
                        <div>{{ session('error') }}</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-lg mr-3 text-warning"></i>
                    <div>
                        <strong>Peringatan!</strong>
                        <div>{{ session('warning') }}</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-lg mr-3 text-info"></i>
                    <div>
                        <strong>Informasi!</strong>
                        <div>{{ session('info') }}</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Quick Info Bar -->
        <div class="card mb-4 border-left-primary">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <div class="d-flex align-items-center">
                            @if ($atlit->foto)
                                <img src="{{ asset('storage/atlit/foto/' . $atlit->foto) }}"
                                    alt="{{ $atlit->nama_lengkap }}" class="rounded-circle mr-3"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0 font-weight-bold">{{ $atlit->nama_lengkap }}</h5>
                                <div class="text-muted">
                                    <small>
                                        <i class="fas fa-id-card mr-1"></i>{{ $atlit->nik }} |
                                        <i
                                            class="fas fa-running mr-1"></i>{{ $atlit->cabangOlahraga->nama_cabang ?? 'Belum ada cabor' }}
                                        |
                                        <i class="fas fa-calendar mr-1"></i>{{ $atlit->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <!-- Status Badge -->
                        @if ($atlit->status == 'aktif')
                            <span class="badge badge-success badge-lg px-3 py-2">
                                <i class="fas fa-clock mr-2"></i>{{ ucfirst($atlit->status) }}
                            </span>
                        @else
                            <span class="badge badge-danger badge-lg px-3 py-2">
                                <i class="fas fa-question-circle mr-2"></i>{{ ucfirst($atlit->status) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Statistics Overview -->
        @if (!empty($documentStats) && $documentStats['total'] > 0)
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Dokumen
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $documentStats['total'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
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
                                        Menunggu Verifikasi
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $documentStats['pending'] }}
                                    </div>
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
                                        Terverifikasi
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $documentStats['verified'] }}
                                    </div>
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
                                        Ditolak
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $documentStats['rejected'] }}
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
        @endif

        <!-- Main Content - Livewire Component -->
        @livewire('verifikator.atlit-show', [
            'atlit' => $atlit,
            'documentStats' => $documentStats,
        ])

        <!-- Additional Info Card -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informasi Tambahan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-dark mb-3">Timeline Verifikasi:</h6>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <i class="fas fa-user-plus bg-primary"></i>
                                        <div class="timeline-content">
                                            <h6>Data Didaftarkan</h6>
                                            <p class="text-muted mb-0">{{ $atlit->created_at->format('d M Y, H:i') }}</p>
                                            <small class="text-muted">Oleh: {{ $atlit->user->name ?? 'Sistem' }}</small>
                                        </div>
                                    </div>

                                    @if ($atlit->verified_at)
                                        <div class="timeline-item">
                                            @if ($atlit->status == 'diverifikasi')
                                                <i class="fas fa-check bg-success"></i>
                                            @else
                                                <i class="fas fa-times bg-danger"></i>
                                            @endif
                                            <div class="timeline-content">
                                                <h6>
                                                    @if ($atlit->status == 'diverifikasi')
                                                        Data Diverifikasi
                                                    @else
                                                        Data Ditolak
                                                    @endif
                                                </h6>
                                                <p class="text-muted mb-0">{{ $atlit->verified_at->format('d M Y, H:i') }}
                                                </p>
                                                @if ($atlit->verifikator)
                                                    <small class="text-muted">Oleh:
                                                        {{ $atlit->verifikator->name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-dark mb-3">Ringkasan:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>ID Atlet:</strong></td>
                                            <td>{{ $atlit->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $atlit->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Telepon:</strong></td>
                                            <td>{{ $atlit->telepon }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Klub:</strong></td>
                                            <td>{{ $atlit->klub->nama_klub ?? 'Belum ada klub' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kategori:</strong></td>
                                            <td>{{ $atlit->kategoriAtlit->nama_kategori ?? 'Belum ada kategori' }}</td>
                                        </tr>
                                    </table>
                                </div>

                                @if ($atlit->alasan_ditolak)
                                    <div class="alert alert-danger mt-3">
                                        <h6><i class="fas fa-exclamation-triangle mr-2"></i>Alasan Penolakan:</h6>
                                        <p class="mb-0">{{ $atlit->alasan_ditolak }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .badge-lg {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .timeline {
            position: relative;
            padding: 0;
            list-style: none;
        }

        .timeline-item {
            position: relative;
            padding-left: 3rem;
            padding-bottom: 1.5rem;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 2rem;
            bottom: -1.5rem;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item:last-child:before {
            display: none;
        }

        .timeline-item i {
            position: absolute;
            left: 0.5rem;
            top: 0.25rem;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            text-align: center;
            line-height: 2rem;
            color: white;
            font-size: 0.75rem;
            z-index: 1;
        }

        .timeline-content h6 {
            margin-bottom: 0.25rem;
            color: #495057;
        }

        @media print {

            .btn-group,
            .breadcrumb,
            .alert {
                display: none !important;
            }

            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }
        }

        .card:hover {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }

        .updating {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert && alert.parentNode) {
                        alert.style.transition = 'opacity 0.5s ease';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 500);
                    }
                }, 5000);
            });
        });

        // Reload page on Livewire navigation
        window.addEventListener('beforeunload', function() {
            // Optional: save any unsaved changes
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Alt + B = Back to index
            if (e.altKey && e.key === 'b') {
                e.preventDefault();
                window.location.href = "{{ route('verifikator.atlit.index') }}";
            }

            // Alt + P = Print
            if (e.altKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });

        // Smooth scroll for anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endpush
