<div>
    <!-- Search and Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
            <button wire:click="create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pelatih
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Pencarian</label>
                    <input type="text" wire:model.live="search" class="form-control form-control-sm"
                        placeholder="Cari nama, email, telepon...">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Status</label>
                    <select wire:model.live="filterStatus" class="form-control form-control-sm">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non Aktif</option>
                        <option value="cuti">Cuti</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Klub</label>
                    <select wire:model.live="filterKlub" class="form-control form-control-sm">
                        <option value="">Semua Klub</option>
                        @foreach ($klub as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_klub }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Cabang Olahraga</label>
                    <select wire:model.live="filterCabor" class="form-control form-control-sm">
                        <option value="">Semua Cabor</option>
                        @foreach ($cabangOlahraga as $co)
                            <option value="{{ $co->id }}">{{ $co->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button wire:click="resetFilters" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pelatih</h6>
            <div class="d-flex align-items-center">
                <span class="mr-2">Tampilkan:</span>
                <select wire:model.live="perPage" class="form-control form-control-sm" style="width: auto;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="8%">Foto</th>
                            <th width="15%">Nama</th>
                            <th width="12%">Email</th>
                            <th width="10%">Telepon</th>
                            <th width="12%">Klub</th>
                            <th width="12%">Cabang Olahraga</th>
                            <th width="8%">Pengalaman</th>
                            <th width="8%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelatih as $index => $p)
                            <tr>
                                <td>{{ $pelatih->firstItem() + $index }}</td>
                                <td class="text-center">
                                    @if ($p->foto)
                                        <img src="{{ Storage::url($p->foto) }}" alt="{{ $p->nama }}"
                                            class="avatar-sm">
                                    @else
                                        <div
                                            class="avatar-sm bg-secondary d-flex align-items-center justify-content-center text-white rounded-circle mx-auto">
                                            {{ strtoupper(substr($p->nama, 0, 2)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $p->nama }}</div>
                                    <small
                                        class="text-muted">{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                </td>
                                <td class="text-truncate-custom">{{ $p->email }}</td>
                                <td>{{ $p->telepon }}</td>
                                <td>{{ $p->klub->nama_klub ?? '-' }}</td>
                                <td>{{ $p->cabangOlahraga->nama_cabang ?? '-' }}</td>
                                <td class="text-center">{{ $p->pengalaman_tahun }} tahun</td>
                                <td class="text-center">
                                    @switch($p->status)
                                        @case('aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @break

                                        @case('nonaktif')
                                            <span class="badge badge-secondary">Non Aktif</span>
                                        @break

                                        @case('cuti')
                                            <span class="badge badge-warning">Cuti</span>
                                        @break

                                        @default
                                            <span class="badge badge-light">Unknown</span>
                                    @endswitch
                                </td>
                                <td>
                                    <button wire:click="edit({{ $p->id }})" class="btn btn-warning btn-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $p->id }})"
                                        class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Tidak ada data pelatih yang ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <p class="text-muted mb-0">
                            Menampilkan {{ $pelatih->firstItem() ?? 0 }} sampai {{ $pelatih->lastItem() ?? 0 }}
                            dari {{ $pelatih->total() }} data
                        </p>
                    </div>
                    <div>
                        {{ $pelatih->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        @if ($showModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $editMode ? 'Edit Data Pelatih' : 'Tambah Data Pelatih' }}
                            </h5>
                            <button type="button" class="close" wire:click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form wire:submit="save">
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="nama"
                                            class="form-control @error('nama') is-invalid @enderror">
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" wire:model="email"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Telepon <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="telepon"
                                            class="form-control @error('telepon') is-invalid @enderror">
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" wire:model="tanggal_lahir"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select wire:model="jenis_kelamin"
                                            class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pengalaman (Tahun) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" wire:model="pengalaman_tahun" min="0"
                                            max="50"
                                            class="form-control @error('pengalaman_tahun') is-invalid @enderror">
                                        @error('pengalaman_tahun')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea wire:model="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Klub <span class="text-danger">*</span></label>
                                        <select wire:model="klub_id"
                                            class="form-control @error('klub_id') is-invalid @enderror">
                                            <option value="">Pilih Klub</option>
                                            @foreach ($klub as $k)
                                                <option value="{{ $k->id }}">{{ $k->nama_klub }}</option>
                                            @endforeach
                                        </select>
                                        @error('klub_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Cabang Olahraga <span
                                                class="text-danger">*</span></label>
                                        <select wire:model="cabang_olahraga_id"
                                            class="form-control @error('cabang_olahraga_id') is-invalid @enderror">
                                            <option value="">Pilih Cabang Olahraga</option>
                                            @foreach ($cabangOlahraga as $co)
                                                <option value="{{ $co->id }}">{{ $co->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                        @error('cabang_olahraga_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Lisensi</label>
                                        <input type="text" wire:model="lisensi"
                                            class="form-control @error('lisensi') is-invalid @enderror">
                                        @error('lisensi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select wire:model="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif">Non Aktif</option>
                                            <option value="cuti">Cuti</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Foto Pelatih</label>
                                    <input type="file" wire:model="foto" accept="image/*"
                                        class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if ($foto)
                                        <div class="mt-2">
                                            <img src="{{ $foto->temporaryUrl() }}" alt="Preview"
                                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    @elseif($existing_foto)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($existing_foto) }}" alt="Current Photo"
                                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ $editMode ? 'Update' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Delete Confirmation Modal -->
        @if ($showDeleteModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="close" wire:click="closeDeleteModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body overflow-auto">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <p>Apakah Anda yakin ingin menghapus data pelatih ini?</p>
                                <p class="text-muted">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="button" class="btn btn-danger" wire:click="delete">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Loading Spinner -->
        {{-- <div wire:loading.flex class="position-fixed w-100 h-100 d-flex align-items-center justify-content-center"
            style="top: 0; left: 0; background-color: rgba(255,255,255,0.8); z-index: 9999;">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> --}}
    </div>
