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

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">Daftar Kategori Atlit</h5>
        <button wire:click="openForm" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>

    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                placeholder="Cari kategori...">
        </div>
        <div class="col-md-3">
            <select wire:model.live="filterCabor" class="form-control">
                <option value="">Semua Cabang Olahraga</option>
                @foreach ($cabangOlahraga as $cabor)
                    <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model.live="filterStatus" class="form-control">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
        <div class="col-md-2">
            <button wire:click="resetFilters" class="btn btn-outline-secondary">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
    </div>

    <!-- Form Modal -->
    @if ($showForm)
        <div class="card border-primary mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="fas fa-{{ $editMode ? 'edit' : 'plus' }}"></i>
                    {{ $editMode ? 'Edit' : 'Tambah' }} Kategori Atlit
                </h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cabang_olahraga_id">Cabang Olahraga <span
                                        class="text-danger">*</span></label>
                                <select wire:model="cabang_olahraga_id"
                                    class="form-control @error('cabang_olahraga_id') is-invalid @enderror" required>
                                    <option value="">Pilih Cabang Olahraga</option>
                                    @foreach ($cabangOlahraga as $cabor)
                                        <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                                    @endforeach
                                </select>
                                @error('cabang_olahraga_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select wire:model="status" class="form-control @error('status') is-invalid @enderror"
                                    required>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                        <input wire:model="nama_kategori" type="text"
                            class="form-control @error('nama_kategori') is-invalid @enderror"
                            placeholder="Contoh: Kyorugi, Poomsae, dll" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea wire:model="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                            placeholder="Deskripsi kategori (opsional)"></textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ $editMode ? 'Update' : 'Simpan' }}
                        </button>
                        <button type="button" wire:click="closeForm" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Cabang Olahraga</th>
                    <th width="20%">Nama Kategori</th>
                    <th width="25%">Deskripsi</th>
                    <th width="10%">Jumlah Atlit</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoriAtlit as $index => $item)
                    <tr>
                        <td>{{ $kategoriAtlit->firstItem() + $index }}</td>
                        <td>{{ $item->cabangOlahraga->nama_cabang }}</td>
                        <td><strong>{{ $item->nama_kategori }}</strong></td>
                        <td>{{ $item->deskripsi ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ $item->atlit_count }}</span>
                        </td>
                        <td>{!! $item->status_badge !!}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button wire:click="edit({{ $item->id }})" class="btn btn-warning btn-sm"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $item->id }})" class="btn btn-danger btn-sm"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada data kategori atlit</h5>
                            <p class="text-muted">Belum ada kategori atlit yang tersimpan.</p>
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
            {{ $kategoriAtlit->links() }}
        </div>
    </div>
</div>

<!-- SweetAlert2 Scripts -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            // Listen for confirm delete event
            Livewire.on('confirmDelete', (data) => {
                Swal.fire({
                    title: data.title,
                    text: data.text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: data.confirmButtonText,
                    cancelButtonText: data.cancelButtonText,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, proceed with deletion
                        @this.call('delete', data.id);
                    }
                    // If cancelled, nothing happens (this fixes the bug where delete still executed)
                });
            });

            Livewire.on('showAlert', (data) => {
                Swal.fire({
                    title: data.title,
                    text: data.message,
                    icon: data.type,
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .swal2-popup {
            font-size: 0.875rem;
        }

        .swal2-toast {
            font-size: 0.875rem;
        }
    </style>
@endpush
