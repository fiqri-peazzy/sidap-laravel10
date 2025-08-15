@extends('layouts.app')

@section('title', 'Jadwal Event')

@push('styles')
    <style>
        .card-header .btn {
            margin-left: 10px;
        }

        .table th {
            background-color: #f8f9fc;
            border-top: none;
        }

        .badge {
            font-size: 0.75rem;
        }

        .filter-section {
            background: #f8f9fc;
            border-radius: 0.35rem;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Event</h1>
            <div>
                <a href="{{ route('jadwal-event.create') }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Event
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('jadwal-event.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Nama event, lokasi, penyelenggara..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cabang_olahraga_id">Cabang Olahraga</label>
                            <select name="cabang_olahraga_id" id="cabang_olahraga_id" class="form-control">
                                <option value="">Semua Cabang</option>
                                @foreach ($cabangOlahraga as $cabor)
                                    <option value="{{ $cabor->id }}"
                                        {{ request('cabang_olahraga_id') == $cabor->id ? 'selected' : '' }}>
                                        {{ $cabor->nama_cabang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="jenis_event">Jenis Event</label>
                            <select name="jenis_event" id="jenis_event" class="form-control">
                                <option value="">Semua Jenis</option>
                                <option value="pertandingan"
                                    {{ request('jenis_event') == 'pertandingan' ? 'selected' : '' }}>Pertandingan</option>
                                <option value="seleksi" {{ request('jenis_event') == 'seleksi' ? 'selected' : '' }}>Seleksi
                                </option>
                                <option value="uji_coba" {{ request('jenis_event') == 'uji_coba' ? 'selected' : '' }}>Uji
                                    Coba</option>
                                <option value="kejuaraan" {{ request('jenis_event') == 'kejuaraan' ? 'selected' : '' }}>
                                    Kejuaraan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('jadwal-event.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Event</h6>
                <div class="dropdown no-arrow">
                    <span class="text-muted small">Total: {{ $jadwalEvent->total() }} event</span>
                </div>
            </div>
            <div class="card-body">
                @if ($jadwalEvent->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Event</th>
                                    <th width="12%">Jenis</th>
                                    <th width="15%">Cabang Olahraga</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="15%">Lokasi</th>
                                    <th width="8%">Status</th>
                                    <th width="5%">Atlet</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalEvent as $index => $event)
                                    <tr>
                                        <td>{{ $jadwalEvent->firstItem() + $index }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $event->nama_event }}</div>
                                            <small class="text-muted">{{ $event->penyelenggara }}</small>
                                        </td>
                                        <td>{!! $event->jenis_event_badge !!}</td>
                                        <td>
                                            <span class="badge badge-outline-primary">
                                                {{ $event->cabangOlahraga->nama_cabang ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <i class="fas fa-calendar-alt text-primary"></i>
                                                {{ $event->tanggal_mulai->format('d/m/Y') }}
                                                @if ($event->tanggal_mulai != $event->tanggal_selesai)
                                                    <br>s/d {{ $event->tanggal_selesai->format('d/m/Y') }}
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $event->durasi_event }}</small>
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-danger"></i>
                                            {{ Str::limit($event->lokasi, 25) }}
                                        </td>
                                        <td>{!! $event->status_badge !!}</td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $event->jumlah_atlet }}</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                    type="button" id="dropdownMenuButton{{ $event->id }}"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $event->id }}">
                                                    <a class="dropdown-item"
                                                        href="{{ route('jadwal-event.show', $event) }}">
                                                        <i class="fas fa-eye text-info"></i> Detail
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('jadwal-event.edit', $event) }}">
                                                        <i class="fas fa-edit text-warning"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('jadwal-event.manage-atlit', $event) }}">
                                                        <i class="fas fa-users text-primary"></i> Kelola Atlet
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    @if ($event->status !== 'selesai')
                                                        <button class="dropdown-item"
                                                            onclick="updateStatus('{{ $event->id }}', 'selesai')">
                                                            <i class="fas fa-check text-success"></i> Selesaikan
                                                        </button>
                                                    @endif
                                                    @if ($event->status !== 'dibatalkan')
                                                        <button class="dropdown-item"
                                                            onclick="updateStatus('{{ $event->id }}', 'dibatalkan')">
                                                            <i class="fas fa-times text-danger"></i> Batalkan
                                                        </button>
                                                    @endif
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item text-danger"
                                                        onclick="confirmDelete('{{ $event->id }}', '{{ $event->nama_event }}')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted">
                                Menampilkan {{ $jadwalEvent->firstItem() }} - {{ $jadwalEvent->lastItem() }}
                                dari {{ $jadwalEvent->total() }} data
                            </p>
                        </div>
                        <div class="col-md-6">
                            {{ $jadwalEvent->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-5x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada jadwal event</h5>
                        <p class="text-muted">Belum ada jadwal event yang dibuat.</p>
                        <a href="{{ route('jadwal-event.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Event Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Form untuk update status -->
    <form id="statusForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" id="statusInput">
    </form>

    <!-- Form untuk delete -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        function updateStatus(eventId, status) {
            if (confirm('Apakah Anda yakin ingin mengubah status event ini?')) {
                const form = document.getElementById('statusForm');
                form.action = `/jadwal-event/${eventId}/status`;
                document.getElementById('statusInput').value = status;
                form.submit();
            }
        }

        function confirmDelete(eventId, eventName) {
            if (confirm(
                `Apakah Anda yakin ingin menghapus event "${eventName}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
                const form = document.getElementById('deleteForm');
                form.action = `/jadwal-event/${eventId}`;
                form.submit();
            }
        }

        // Auto submit form on filter change
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelects = document.querySelectorAll('#cabang_olahraga_id, #jenis_event, #status');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        });
    </script>
@endpush
