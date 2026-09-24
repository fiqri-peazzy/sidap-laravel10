<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Sekolah</h1>
        <button wire:click="create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Sekolah
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

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Sekolah</h6>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model.live="search" class="form-control form-control-sm"
                            placeholder="Cari nama sekolah, NPSN, kota...">
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
                            <th>Nama Sekolah</th>
                            <th>Jenjang</th>
                            <th>Alamat</th>
                            <th>Jumlah Atlet</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sekolah as $index => $s)
                            <tr>
                                <td>{{ $sekolah->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $s->nama_sekolah }}</div>
                                    @if ($s->npsn)
                                        <small class="text-muted">NPSN: {{ $s->npsn }}</small>
                                    @endif
                                </td>
                                <td><span class="badge badge-secondary">{{ $s->jenjang }}</span></td>
                                <td>{{ $s->kota }}, {{ $s->provinsi }}</td>
                                <td>{{ $s->atlit_count }}</td>
                                <td>{!! $s->status_badge !!}</td>
                                <td>
                                    <button wire:click="detail({{ $s->id }})" class="btn btn-sm btn-info"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="edit({{ $s->id }})" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $s->id }})"
                                        class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data sekolah</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Menampilkan {{ $sekolah->firstItem() ?? 0 }} hingga {{ $sekolah->lastItem() ?? 0 }}
                    dari {{ $sekolah->total() }} data
                </div>
                <div>
                    {{ $sekolah->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    @if ($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $editingId ? 'Edit Sekolah' : 'Tambah Sekolah' }}
                        </h5>
                        <button type="button" wire:click="closeModal" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_sekolah">Nama Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="nama_sekolah"
                                        class="form-control @error('nama_sekolah') is-invalid @enderror"
                                        placeholder="Masukkan nama sekolah">
                                    @error('nama_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenjang">Jenjang <span class="text-danger">*</span></label>
                                    <select wire:model="jenjang"
                                        class="form-control @error('jenjang') is-invalid @enderror">
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SMK">SMK</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    @error('jenjang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="npsn">NPSN</label>
                                    <input type="text" wire:model="npsn"
                                        class="form-control @error('npsn') is-invalid @enderror"
                                        placeholder="Nomor Pokok Sekolah Nasional">
                                    @error('npsn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kepala_sekolah">Kepala Sekolah</label>
                                    <input type="text" wire:model="kepala_sekolah"
                                        class="form-control @error('kepala_sekolah') is-invalid @enderror"
                                        placeholder="Nama kepala sekolah">
                                    @error('kepala_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea wire:model="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2"
                                placeholder="Masukkan alamat lengkap"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kota">Kota <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="kota"
                                        class="form-control @error('kota') is-invalid @enderror"
                                        placeholder="Masukkan kota">
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="provinsi"
                                        class="form-control @error('provinsi') is-invalid @enderror"
                                        placeholder="Masukkan provinsi">
                                    @error('provinsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kode_pos">Kode Pos</label>
                                    <input type="text" wire:model="kode_pos"
                                        class="form-control @error('kode_pos') is-invalid @enderror"
                                        placeholder="Contoh: 96115">
                                    @error('kode_pos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input type="text" wire:model="telepon"
                                        class="form-control @error('telepon') is-invalid @enderror"
                                        placeholder="Contoh: 0435-123456">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Sekolah</label>
                                    <input type="email" wire:model="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Contoh: info@sekolah.sch.id">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select wire:model="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h6 class="text-primary">Akun Operator Sekolah</h6>
                        @if ($hasOperator)
                            <p class="text-muted small">
                                <i class="fas fa-check-circle text-success"></i>
                                Sekolah ini sudah punya akun operator: <strong>{{ $currentOperatorEmail }}</strong>
                            </p>
                        @else
                            <p class="text-muted small">Isi untuk membuatkan akun login bagi operator sekolah ini agar
                                bisa menginput data atlet sendiri.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="operator_email">Email Operator</label>
                                        <input type="email" wire:model="operator_email"
                                            class="form-control @error('operator_email') is-invalid @enderror"
                                            placeholder="Contoh: operator@sekolah.sch.id">
                                        @error('operator_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="operator_password">Password Operator</label>
                                        <input type="password" wire:model="operator_password"
                                            class="form-control @error('operator_password') is-invalid @enderror"
                                            placeholder="Minimal 6 karakter">
                                        @error('operator_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
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

    <!-- Detail Modal -->
    @if ($showDetailModal && $detailSekolah)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Sekolah: {{ $detailSekolah->nama_sekolah }}</h5>
                        <button type="button" wire:click="closeDetailModal" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>NPSN</strong></td>
                                <td>{{ $detailSekolah->npsn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenjang</strong></td>
                                <td>{{ $detailSekolah->jenjang }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>{{ $detailSekolah->alamat_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kepala Sekolah</strong></td>
                                <td>{{ $detailSekolah->kepala_sekolah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon</strong></td>
                                <td>{{ $detailSekolah->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $detailSekolah->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>{!! $detailSekolah->status_badge !!}</td>
                            </tr>
                            <tr>
                                <td><strong>Akun Operator</strong></td>
                                <td>
                                    @if ($detailSekolah->operator)
                                        {{ $detailSekolah->operator->email }}
                                    @else
                                        <span class="text-muted">Belum ada akun operator</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeDetailModal" class="btn btn-secondary">Tutup</button>
                        <button type="button" wire:click="edit({{ $detailSekolah->id }}); closeDetailModal()"
                            class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    @if ($deleteId)
        <!-- Delete Confirmation Modal -->
        <div class="modal fade show" style="display: block;" id="deleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data sekolah ini? Data yang sudah dihapus tidak dapat
                        dikembalikan.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" wire:click="delete" class="btn btn-danger"
                            data-dismiss="modal">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
