@extends('layouts.app')
@section('title', 'Jadwal Latihan')
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

        /* Fix pagination styling */
        .pagination {
            margin-bottom: 0;
            justify-content: flex-end;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .dataTables_info {
            color: #858796;
            font-size: 0.875rem;
            padding-top: 0.5rem;
        }

        .dataTables_paginate {
            float: right;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Latihan</h1>
            <a href="{{ route('admin.jadwal-latihan.create') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
            </a>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.jadwal-latihan.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Cari nama kegiatan, lokasi..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cabang_olahraga_id">Cabang Olahraga</label>
                            <select name="cabang_olahraga_id" id="cabang_olahraga_id" class="form-control">
                                <option value="">Semua Cabang Olahraga</option>
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
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                value="{{ request('tanggal') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.jadwal-latihan.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Latihan</h6>
                <div class="dropdown no-arrow">
                    <span class="text-muted small">Total: {{ $jadwalLatihan->total() }} jadwal</span>
                </div>
            </div>
            <div class="card-body">
                @if ($jadwalLatihan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Kegiatan</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="10%">Jam</th>
                                    <th width="15%">Lokasi</th>
                                    <th width="15%">Cabang Olahraga</th>
                                    <th width="10%">Pelatih</th>
                                    <th width="8%">Status</th>
                                    <th width="7%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalLatihan as $index => $jadwal)
                                    <tr>
                                        <td>{{ $jadwalLatihan->firstItem() + $index }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $jadwal->nama_kegiatan }}</div>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                            {{ $jadwal->tanggal->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <i class="fas fa-clock text-info"></i>
                                            {{ $jadwal->jam_latihan }}
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-danger"></i>
                                            {{ Str::limit($jadwal->lokasi, 20) }}
                                        </td>
                                        <td>
                                            <span class="badge badge-outline-primary">
                                                {{ $jadwal->cabangOlahraga->nama_cabang }}
                                            </span>
                                        </td>
                                        <td>{{ $jadwal->pelatih->nama }}</td>
                                        <td>{!! $jadwal->status_badge !!}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                    type="button" id="dropdownMenuButton{{ $jadwal->id }}"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $jadwal->id }}">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.jadwal-latihan.show', $jadwal) }}">
                                                        <i class="fas fa-eye text-info"></i> Detail
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.jadwal-latihan.edit', $jadwal) }}">
                                                        <i class="fas fa-edit text-warning"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item text-danger"
                                                        onclick="confirmDelete('{{ $jadwal->id }}', '{{ $jadwal->nama_kegiatan }}')">
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
                    <div class="row align-items-center mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info">
                                Menampilkan {{ $jadwalLatihan->firstItem() }} sampai {{ $jadwalLatihan->lastItem() }}
                                dari {{ $jadwalLatihan->total() }} entri
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers">
                                {{ $jadwalLatihan->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-5x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada jadwal latihan</h5>
                        <p class="text-muted">Belum ada jadwal latihan yang dibuat.</p>
                        <a href="{{ route('admin.jadwal-latihan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Jadwal Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Form untuk delete -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        function confirmDelete(jadwalId, namaKegiatan) {
            Swal.fire({
                title: 'Hapus Jadwal Latihan?',
                html: `Apakah Anda yakin ingin menghapus jadwal<br><strong>"${namaKegiatan}"</strong>?<br><br><small class="text-muted">Tindakan ini tidak dapat dibatalkan!</small>`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = `/jadwal-latihan/${jadwalId}`;
                    form.submit();
                }
            });
        }

        // Auto submit form on filter change
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelects = document.querySelectorAll('#cabang_olahraga_id, #status, #tanggal');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        });

        // Auto hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
