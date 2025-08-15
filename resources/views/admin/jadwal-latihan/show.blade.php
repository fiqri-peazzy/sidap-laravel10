@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Jadwal Latihan</h1>
        <div>
            <a href="{{ route('jadwal-latihan.edit', $jadwalLatihan) }}"
                class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Jadwal
            </a>
            <a href="{{ route('jadwal-latihan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Jadwal Latihan</h6>
            <div class="d-flex align-items-center">
                {!! $jadwalLatihan->status_badge !!}
                @if ($jadwalLatihan->isExpired())
                    <span class="badge badge-warning ml-2">
                        <i class="fas fa-clock"></i> Sudah Lewat
                    </span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="font-weight-bold text-gray-800">Nama Kegiatan:</td>
                            <td>{{ $jadwalLatihan->nama_kegiatan }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Tanggal:</td>
                            <td>
                                <i class="fas fa-calendar-day text-primary"></i>
                                {{ $jadwalLatihan->tanggal->format('d F Y') }}
                                <small class="text-muted">({{ $jadwalLatihan->tanggal->format('l') }})</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Waktu:</td>
                            <td>
                                <i class="fas fa-clock text-success"></i>
                                {{ $jadwalLatihan->jam_latihan }}
                                <small class="text-muted">({{ $jadwalLatihan->durasi }})</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Lokasi:</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                {{ $jadwalLatihan->lokasi }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Status:</td>
                            <td>{!! $jadwalLatihan->status_badge !!}</td>
                        </tr>
                    </table>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="font-weight-bold text-gray-800">Cabang Olahraga:</td>
                            <td>
                                <span class="badge badge-info">{{ $jadwalLatihan->cabangOlahraga->nama_cabang }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Pelatih:</td>
                            <td>
                                <i class="fas fa-user-tie text-info"></i>
                                {{ $jadwalLatihan->pelatih->nama }}
                                @if ($jadwalLatihan->pelatih->no_telepon)
                                    <br><small class="text-muted">
                                        <i class="fas fa-phone"></i> {{ $jadwalLatihan->pelatih->no_telepon }}
                                    </small>
                                @endif
                            </td>
                        </tr>
                        @if ($jadwalLatihan->klub)
                            <tr>
                                <td class="font-weight-bold text-gray-800">Klub:</td>
                                <td>
                                    <i class="fas fa-users text-warning"></i>
                                    {{ $jadwalLatihan->klub->nama_klub }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="font-weight-bold text-gray-800">Dibuat:</td>
                            <td>
                                <small class="text-muted">
                                    {{ $jadwalLatihan->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-gray-800">Terakhir Update:</td>
                            <td>
                                <small class="text-muted">
                                    {{ $jadwalLatihan->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Catatan -->
            @if ($jadwalLatihan->catatan)
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6 class="font-weight-bold text-gray-800 mb-3">
                            <i class="fas fa-sticky-note text-warning"></i> Catatan:
                        </h6>
                        <div class="alert alert-info">
                            {{ $jadwalLatihan->catatan }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('jadwal-latihan.edit', $jadwalLatihan) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Jadwal
                        </a>

                        @if ($jadwalLatihan->status == 'aktif')
                            <button type="button" class="btn btn-success btn-sm" onclick="updateStatus('selesai')">
                                <i class="fas fa-check"></i> Tandai Selesai
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="updateStatus('dibatalkan')">
                                <i class="fas fa-times"></i> Batalkan
                            </button>
                        @elseif($jadwalLatihan->status == 'dibatalkan')
                            <button type="button" class="btn btn-primary btn-sm" onclick="updateStatus('aktif')">
                                <i class="fas fa-undo"></i> Aktifkan Kembali
                            </button>
                        @endif

                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
                            <i class="fas fa-trash"></i> Hapus Jadwal
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right">
                        <a href="{{ route('jadwal-latihan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Hidden Forms -->
            <form id="status-form" action="{{ route('jadwal-latihan.update-status', $jadwalLatihan) }}" method="POST"
                style="display: none;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="status-input">
            </form>

            <form id="delete-form" action="{{ route('jadwal-latihan.destroy', $jadwalLatihan) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .badge {
            font-size: 0.9em;
        }

        .table td {
            padding: 0.5rem 0.75rem;
            vertical-align: top;
        }

        .gap-2>* {
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateStatus(status) {
            let title, text, confirmText, icon;

            switch (status) {
                case 'selesai':
                    title = 'Tandai Selesai?';
                    text = 'Jadwal latihan ini akan ditandai sebagai selesai.';
                    confirmText = 'Ya, Selesai!';
                    icon = 'success';
                    break;
                case 'dibatalkan':
                    title = 'Batalkan Jadwal?';
                    text = 'Jadwal latihan ini akan dibatalkan.';
                    confirmText = 'Ya, Batalkan!';
                    icon = 'warning';
                    break;
                case 'aktif':
                    title = 'Aktifkan Kembali?';
                    text = 'Jadwal latihan ini akan diaktifkan kembali.';
                    confirmText = 'Ya, Aktifkan!';
                    icon = 'info';
                    break;
            }

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('status-input').value = status;
                    document.getElementById('status-form').submit();
                }
            });
        }

        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Jadwal latihan ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        }

        // Auto hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
