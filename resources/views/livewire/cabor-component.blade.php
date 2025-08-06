<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Cabang Olahraga</h1>
        <button wire:click="create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Cabang Olahraga
        </button>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Cabang Olahraga</h6>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model.live="search" class="form-control form-control-sm"
                            placeholder="Cari cabang olahraga...">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Cabang</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Jumlah Atlit</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cabangOlahraga as $index => $cabang)
                            <tr>
                                <td>{{ $cabangOlahraga->firstItem() + $index }}</td>
                                <td>{{ $cabang->nama_cabang }}</td>
                                <td>{{ Str::limit($cabang->deskripsi ?? '-', 50) }}</td>
                                <td>{!! $cabang->status_badge !!}</td>
                                <td>
                                    <span class="badge badge-info">{{ $cabang->jumlah_atlit ?? 0 }} atlit</span>
                                </td>
                                <td>{{ $cabang->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <button wire:click="edit({{ $cabang->id }})" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $cabang->id }})"
                                        class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data cabang olahraga</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Menampilkan {{ $cabangOlahraga->firstItem() ?? 0 }} hingga
                    {{ $cabangOlahraga->lastItem() ?? 0 }}
                    dari {{ $cabangOlahraga->total() }} data
                </div>
                <div>
                    {{ $cabangOlahraga->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    @if ($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $editingId ? 'Edit Cabang Olahraga' : 'Tambah Cabang Olahraga' }}
                        </h5>
                        <button type="button" wire:click="closeModal" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="form-group">
                                <label for="nama_cabang">Nama Cabang Olahraga <span class="text-danger">*</span></label>
                                <input type="text" wire:model="nama_cabang"
                                    class="form-control @error('nama_cabang') is-invalid @enderror" id="nama_cabang"
                                    placeholder="Masukkan nama cabang olahraga">
                                @error('nama_cabang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea wire:model="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                    rows="3" placeholder="Masukkan deskripsi cabang olahraga"></textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select wire:model="status" class="form-control @error('status') is-invalid @enderror"
                                    id="status">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModal" class="btn btn-secondary">Batal</button>
                        <button type="button" wire:click="save" class="btn btn-primary">
                            {{ $editingId ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    @if ($deleteId)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" wire:click="$set('deleteId', null)" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data cabang olahraga ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="$set('deleteId', null)"
                            class="btn btn-secondary">Batal</button>
                        <button type="button" wire:click="delete" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

</div>
