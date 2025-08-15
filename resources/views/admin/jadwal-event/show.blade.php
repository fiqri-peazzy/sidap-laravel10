@extends('layouts.app')
@section('title', 'Detail Jadwal Event')

@push('styles')
    <style>
        .info-box {
            background: #f8f9fc;
            border-left: 4px solid #4e73df;
            padding: 15px;
            border-radius: 0.35rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0.75rem;
            padding: 20px;
            margin-bottom: 20px;
        }

        .atlet-card {
            transition: transform 0.2s;
        }

        .atlet-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Detail Jadwal Event</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('jadwal-event.index') }}">Jadwal Event</a></li>
                        <li class="breadcrumb-item active">{{ $jadwalEvent->nama_event }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('jadwal-event.edit', $jadwalEvent) }}" class="btn btn-sm btn-warning mr-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('jadwal-event.manage-atlit', $jadwalEvent) }}" class="btn btn-sm btn-primary mr-2">
                    <i class="fas fa-users"></i> Kelola Atlet
                </a>
                <a href="{{ route('jadwal-event.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Informasi Event -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Event</h6>
                        <div>
                            {!! $jadwalEvent->status_badge !!}
                            {!! $jadwalEvent->jenis_event_badge !!}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h4 class="font-weight-bold text-primary">{{ $jadwalEvent->nama_event }}</h4>
                                <p class="text-muted mb-3">{{ $jadwalEvent->penyelenggara }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="fas fa-calendar-alt text-primary"></i> Jadwal
                                    </h6>
                                    <p class="mb-1">
                                        <strong>Mulai:</strong> {{ $jadwalEvent->tanggal_mulai->format('d F Y') }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Selesai:</strong> {{ $jadwalEvent->tanggal_selesai->format('d F Y') }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Durasi:</strong> {{ $jadwalEvent->durasi_event }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="fas fa-map-marker-alt text-danger"></i> Lokasi
                                    </h6>
                                    <p class="mb-0">{{ $jadwalEvent->lokasi }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="fas fa-running text-success"></i> Cabang Olahraga
                                    </h6>
                                    <p class="mb-0">{{ $jadwalEvent->cabangOlahraga->nama_cabang ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box mb-3">
                                    <h6 class="font-weight-bold">
                                        <i class="fas fa-trophy text-warning"></i> Status Event
                                    </h6>
                                    <p class="mb-0">
                                        @php
                                            $statusEvent = $jadwalEvent->status_event;
                                            $statusClass =
                                                [
                                                    'mendatang' => 'text-primary',
                                                    'berlangsung' => 'text-success',
                                                    'selesai' => 'text-muted',
                                                ][$statusEvent] ?? 'text-secondary';
                                            $statusIcon =
                                                [
                                                    'mendatang' => 'fas fa-clock',
                                                    'berlangsung' => 'fas fa-play',
                                                    'selesai' => 'fas fa-check',
                                                ][$statusEvent] ?? 'fas fa-question';
                                        @endphp
                                        <i class="{{ $statusIcon }} {{ $statusClass }}"></i>
                                        <span
                                            class="{{ $statusClass }} font-weight-bold">{{ ucfirst($statusEvent) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($jadwalEvent->deskripsi)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="info-box">
                                        <h6 class="font-weight-bold">
                                            <i class="fas fa-info-circle text-info"></i> Deskripsi
                                        </h6>
                                        <p class="mb-0">{{ $jadwalEvent->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Daftar Atlet -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Atlet Peserta</h6>
                        <div>
                            <span class="badge badge-info">{{ $jadwalEvent->jumlah_atlet }} Atlet</span>
                            <a href="{{ route('jadwal-event.manage-atlit', $jadwalEvent) }}"
                                class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-edit"></i> Kelola
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($jadwalEvent->atlit->count() > 0)
                            <div class="row">
                                @foreach ($jadwalEvent->atlit as $atlit)
                                    <div class="col-md-6 mb-3">
                                        <div class="card atlet-card border-left-primary">
                                            <div class="card-body py-3">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="font-weight-bold text-primary">
                                                            {{ $atlit->nama_lengkap }}
                                                        </div>
                                                        <div class="text-xs text-muted">
                                                            <i class="fas fa-id-card"></i> {{ $atlit->nomor_induk ?? '-' }}
                                                        </div>
                                                        @if ($atlit->jenis_kelamin)
                                                            <div class="text-xs text-muted">
                                                                <i
                                                                    class="fas fa-{{ $atlit->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
                                                                {{ $atlit->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-user-athlete fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Atlet Terdaftar</h5>
                                <p class="text-muted">Belum ada atlet yang terdaftar untuk mengikuti event ini.</p>
                                <a href="{{ route('jadwal-event.manage-atlit', $jadwalEvent) }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Atlet
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <!-- Quick Stats -->
                <div class="stat-card">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">
                                Total Atlet
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">
                                {{ $jadwalEvent->jumlah_atlet }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white-25"></i>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('jadwal-event.edit', $jadwalEvent) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit"></i> Edit Event
                            </a>
                            <a href="{{ route('jadwal-event.manage-atlit', $jadwalEvent) }}"
                                class="btn btn-primary btn-block">
                                <i class="fas fa-users"></i> Kelola Atlet
                            </a>

                            @if ($jadwalEvent->status !== 'selesai')
                                <button class="btn btn-success btn-block" onclick="updateStatus('selesai')">
                                    <i class="fas fa-check"></i> Tandai Selesai
                                </button>
                            @endif

                            @if ($jadwalEvent->status !== 'dibatalkan')
                                <button class="btn btn-danger btn-block" onclick="updateStatus('dibatalkan')">
                                    <i class="fas fa-times"></i> Batalkan Event
                                </button>
                            @endif

                            <div class="dropdown-divider"></div>
                            <button class="btn btn-outline-danger btn-block" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i> Hapus Event
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Tambahan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center mb-3">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Dibuat
                                </div>
                                <div class="small text-gray-900">{{ $jadwalEvent->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Diupdate
                                </div>
                                <div class="small text-gray-900">{{ $jadwalEvent->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-edit fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form untuk update status -->
    <form id="statusForm" method="POST" action="{{ route('jadwal-event.update-status', $jadwalEvent) }}"
        style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" id="statusInput">
    </form>

    <!-- Form untuk delete -->
    <form id="deleteForm" method="POST" action="{{ route('jadwal-event.destroy', $jadwalEvent) }}"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateStatus(status) {
            const statusText = {
                'selesai': 'menyelesaikan',
                'dibatalkan': 'membatalkan'
            };

            const statusIcon = {
                'selesai': 'success',
                'dibatalkan': 'warning'
            };

            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin ${statusText[status]} event "{{ $jadwalEvent->nama_event }}"?`,
                icon: statusIcon[status],
                showCancelButton: true,
                confirmButtonColor: status === 'selesai' ? '#28a745' : '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, ' + statusText[status] + '!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('statusInput').value = status;
                    document.getElementById('statusForm').submit();
                }
            });
        }

        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Anda akan menghapus event:<br><strong>"{{ $jadwalEvent->nama_event }}"</strong><br><br>Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    document.getElementById('deleteForm').submit();
                }
            });
        }

        // Show success message if there's a flash message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Show error message if there's a flash message
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
