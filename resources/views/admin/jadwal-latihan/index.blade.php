@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jadwal Latihan</h1>
        <a href="{{ route('jadwal-latihan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Jadwal Latihan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('jadwal-latihan.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pencarian</label>
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Cari nama kegiatan, lokasi..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cabang Olahraga</label>
                            <select name="cabang_olahraga_id" class="form-control form-control-sm">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control form-control-sm"
                                value="{{ request('tanggal') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('jadwal-latihan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Latihan</h6>
        </div>
        <div class="card-body">
            @if ($jadwalLatihan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Lokasi</th>
                                <th>Cabang Olahraga</th>
                                <th>Pelatih</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalLatihan as $index => $jadwal)
                                <tr>
                                    <td>{{ $jadwalLatihan->firstItem() + $index }}</td>
                                    <td>{{ $jadwal->nama_kegiatan }}</td>
                                    <td>{{ $jadwal->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $jadwal->jam_latihan }}</td>
                                    <td>{{ $jadwal->lokasi }}</td>
                                    <td>{{ $jadwal->cabangOlahraga->nama_cabang }}</td>
                                    <td>{{ $jadwal->pelatih->nama }}</td>
                                    <td>{!! $jadwal->status_badge !!}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('jadwal-latihan.show', $jadwal) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jadwal-latihan.edit', $jadwal) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $jadwal->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Form Delete -->
                                        <form id="delete-form-{{ $jadwal->id }}"
                                            action="{{ route('jadwal-latihan.destroy', $jadwal) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $jadwalLatihan->firstItem() }} to {{ $jadwalLatihan->lastItem() }} of
                        {{ $jadwalLatihan->total() }} results
                    </div>
                    <div>
                        {{ $jadwalLatihan->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada jadwal latihan.</p>
                    <a href="{{ route('jadwal-latihan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Jadwal Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
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
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Auto hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
