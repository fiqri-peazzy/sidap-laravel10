<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-3">
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                placeholder="Cari atlit...">
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterKlub" class="form-control">
                <option value="">Semua Klub</option>
                @foreach ($klub as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_klub }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterCabor" class="form-control">
                <option value="">Semua Cabor</option>
                @foreach ($cabangOlahraga as $cabor)
                    <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterKategori" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriAtlit as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterStatus" class="form-control">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
                <option value="pensiun">Pensiun</option>
            </select>
        </div>
        <div class="col-md-1">
            <button wire:click="resetFilters" class="btn btn-outline-secondary" title="Reset Filter">
                <i class="fas fa-undo"></i>
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Foto</th>
                    <th width="15%">Nama Lengkap</th>
                    <th width="10%">NIK</th>
                    <th width="8%">JK</th>
                    <th width="8%">Umur</th>
                    <th width="12%">Klub</th>
                    <th width="12%">Cabor</th>
                    <th width="10%">Kategori</th>
                    <th width="8%">Status</th>
                    <th width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($atlit as $index => $item)
                    <tr>
                        <td>{{ $atlit->firstItem() + $index }}</td>
                        <td class="text-center">
                            @if ($item->foto_url)
                                <img src="{{ $item->foto_url }}" alt="Foto {{ $item->nama_lengkap }}"
                                    class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px; border-radius: 4px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->nama_lengkap }}</strong>
                            @if ($item->email)
                                <br><small class="text-muted">{{ $item->email }}</small>
                            @endif
                        </td>
                        <td>{{ $item->nik }}</td>
                        <td>
                            <span class="badge badge-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'warning' }}">
                                {{ $item->jenis_kelamin_lengkap }}
                            </span>
                        </td>
                        <td>{{ $item->umur }} tahun</td>
                        <td>
                            <small>{{ $item->klub->nama_klub ?? '-' }}</small>
                        </td>
                        <td>
                            <small>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</small>
                        </td>
                        <td>
                            <small>{{ $item->kategoriAtlit->nama_kategori ?? '-' }}</small>
                        </td>
                        <td>{!! $item->status_badge !!}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('atlit.show', $item->id) }}" class="btn btn-info btn-sm"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('atlit.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="delete({{ $item->id }})" class="btn btn-danger btn-sm"
                                    title="Hapus" wire:confirm="Apakah Anda yakin ingin menghapus data ini?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada data atlit</h5>
                            <p class="text-muted">
                                @if ($search || $filterKlub || $filterCabor || $filterKategori || $filterStatus)
                                    Tidak ada data yang sesuai dengan filter yang dipilih.
                                @else
                                    Belum ada data atlit yang tersimpan.
                                @endif
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            <select wire:model.live="perPage" class="form-control form-control-sm" style="width: auto;">
                <option value="5">5 per halaman</option>
                <option value="10">10 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
            </select>
        </div>
        <div>
            {{ $atlit->links() }}
        </div>
    </div>
</div>
