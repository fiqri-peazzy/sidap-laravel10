<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Klub Olahraga</h1>
        <button wire:click="create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Klub
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
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Klub Olahraga</h6>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model.live="search" class="form-control form-control-sm"
                            placeholder="Cari nama klub, kota, provinsi...">
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
                            <th>Logo</th>
                            <th>Nama Klub</th>
                            <th>Alamat</th>
                            <th>Ketua Klub</th>
                            <th>Cabang Olahraga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($klub as $index => $k)
                            <tr>
                                <td>{{ $klub->firstItem() + $index }}</td>
                                <td>
                                    <img src="{{ $k->logo_url }}" alt="{{ $k->nama_klub }}" class="rounded-circle"
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $k->nama_klub }}</div>
                                    @if ($k->tahun_berdiri)
                                        <small class="text-muted">Berdiri {{ $k->tahun_berdiri }} ({{ $k->umur_klub }}
                                            tahun)</small>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $k->kota }}, {{ $k->provinsi }}</div>
                                    @if ($k->telepon)
                                        <small class="text-muted"><i class="fas fa-phone"></i>
                                            {{ $k->telepon }}</small>
                                    @endif
                                </td>
                                <td>{{ $k->ketua_klub ?? '-' }}</td>
                                <td>
                                    @foreach ($k->cabangOlahraga->take(2) as $cabang)
                                        <span class="badge badge-info badge-sm">{{ $cabang->nama_cabang }}</span>
                                    @endforeach
                                    @if ($k->cabangOlahraga->count() > 2)
                                        <span class="badge badge-light badge-sm">+{{ $k->cabangOlahraga->count() - 2 }}
                                            lainnya</span>
                                    @endif
                                </td>
                                <td>{!! $k->status_badge !!}</td>
                                <td>
                                    <button wire:click="detail({{ $k->id }})" class="btn btn-sm btn-info"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="edit({{ $k->id }})" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $k->id }})"
                                        class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data klub</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Menampilkan {{ $klub->firstItem() ?? 0 }} hingga {{ $klub->lastItem() ?? 0 }}
                    dari {{ $klub->total() }} data
                </div>
                <div>
                    {{ $klub->links() }}
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
                            {{ $editingId ? 'Edit Klub' : 'Tambah Klub' }}
                        </h5>
                        <button type="button" wire:click="closeModal" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab == 'info' ? 'active' : '' }}"
                                    wire:click="setActiveTab('info')" href="#">Informasi Dasar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab == 'kontak' ? 'active' : '' }}"
                                    wire:click="setActiveTab('kontak')" href="#">Kontak & Pengurus</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab == 'cabang' ? 'active' : '' }}"
                                    wire:click="setActiveTab('cabang')" href="#">Cabang Olahraga</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- Tab Informasi Dasar -->
                            <div class="tab-pane fade {{ $activeTab == 'info' ? 'show active' : '' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_klub">Nama Klub <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="nama_klub"
                                                class="form-control @error('nama_klub') is-invalid @enderror"
                                                placeholder="Masukkan nama klub">
                                            @error('nama_klub')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahun_berdiri">Tahun Berdiri</label>
                                            <input type="number" wire:model="tahun_berdiri"
                                                class="form-control @error('tahun_berdiri') is-invalid @enderror"
                                                min="1900" max="{{ date('Y') }}" placeholder="Contoh: 2010">
                                            @error('tahun_berdiri')
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
                                                placeholder="Contoh: 95111">
                                            @error('kode_pos')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo">Logo Klub</label>
                                            <input type="file" wire:model="logo"
                                                class="form-control-file @error('logo') is-invalid @enderror"
                                                accept="image/*">
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if ($existing_logo)
                                                <small class="text-muted">Logo saat ini: {{ $existing_logo }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select wire:model="status"
                                                class="form-control @error('status') is-invalid @enderror">
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
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea wire:model="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                        placeholder="Deskripsi tentang klub"></textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tab Kontak & Pengurus -->
                            <div class="tab-pane fade {{ $activeTab == 'kontak' ? 'show active' : '' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telepon">Telepon</label>
                                            <input type="text" wire:model="telepon"
                                                class="form-control @error('telepon') is-invalid @enderror"
                                                placeholder="Contoh: 0431-123456">
                                            @error('telepon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" wire:model="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Contoh: info@klub.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="url" wire:model="website"
                                        class="form-control @error('website') is-invalid @enderror"
                                        placeholder="Contoh: https://www.klub.com">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>
                                <h6 class="text-primary">Pengurus Klub</h6>

                                <div class="form-group">
                                    <label for="ketua_klub">Ketua Klub</label>
                                    <input type="text" wire:model="ketua_klub"
                                        class="form-control @error('ketua_klub') is-invalid @enderror"
                                        placeholder="Nama ketua klub">
                                    @error('ketua_klub')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sekretaris">Sekretaris</label>
                                            <input type="text" wire:model="sekretaris"
                                                class="form-control @error('sekretaris') is-invalid @enderror"
                                                placeholder="Nama sekretaris">
                                            @error('sekretaris')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bendahara">Bendahara</label>
                                            <input type="text" wire:model="bendahara"
                                                class="form-control @error('bendahara') is-invalid @enderror"
                                                placeholder="Nama bendahara">
                                            @error('bendahara')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Cabang Olahraga -->
                            <div class="tab-pane fade {{ $activeTab == 'cabang' ? 'show active' : '' }}">
                                <div class="form-group">
                                    <label>Cabang Olahraga yang Dikelola</label>
                                    <div class="row">
                                        @foreach ($cabangOlahraga as $cabang)
                                            <div class="col-md-4 mb-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="cabang_{{ $cabang->id }}"
                                                        wire:model="cabang_olahraga_ids" value="{{ $cabang->id }}">
                                                    <label class="custom-control-label"
                                                        for="cabang_{{ $cabang->id }}">
                                                        {{ $cabang->nama_cabang }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if (empty($cabangOlahraga->toArray()))
                                        <p class="text-muted">Belum ada cabang olahraga tersedia. Silakan tambahkan
                                            terlebih dahulu di menu Cabang Olahraga.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
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
    @if ($showDetailModal && $detailKlub)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Klub: {{ $detailKlub->nama_klub }}</h5>
                        <button type="button" wire:click="closeDetailModal" class="close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img src="{{ $detailKlub->logo_url }}" alt="{{ $detailKlub->nama_klub }}"
                                    class="img-fluid rounded mb-3" style="max-height: 150px;">
                                {!! $detailKlub->status_badge !!}
                            </div>
                            <div class="col-md-9">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Nama Klub</strong></td>
                                        <td>{{ $detailKlub->nama_klub }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tahun Berdiri</strong></td>
                                        <td>
                                            @if ($detailKlub->tahun_berdiri)
                                                {{ $detailKlub->tahun_berdiri }} ({{ $detailKlub->umur_klub }} tahun)
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat</strong></td>
                                        <td>{{ $detailKlub->alamat_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Telepon</strong></td>
                                        <td>{{ $detailKlub->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>
                                            @if ($detailKlub->email)
                                                <a
                                                    href="mailto:{{ $detailKlub->email }}">{{ $detailKlub->email }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Website</strong></td>
                                        <td>
                                            @if ($detailKlub->website)
                                                <a href="{{ $detailKlub->website }}"
                                                    target="_blank">{{ $detailKlub->website }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary">Pengurus Klub</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Ketua:</strong><br>
                                {{ $detailKlub->ketua_klub ?? '-' }}
                            </div>
                            <div class="col-md-4">
                                <strong>Sekretaris:</strong><br>
                                {{ $detailKlub->sekretaris ?? '-' }}
                            </div>
                            <div class="col-md-4">
                                <strong>Bendahara:</strong><br>
                                {{ $detailKlub->bendahara ?? '-' }}
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary">Cabang Olahraga</h6>
                        <div class="row">
                            @forelse($detailKlub->cabangOlahraga as $cabang)
                                <div class="col-md-4 mb-2">
                                    <span class="badge badge-info">{{ $cabang->nama_cabang }}</span>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted">Belum ada cabang olahraga yang terdaftar.</p>
                                </div>
                            @endforelse
                        </div>

                        @if ($detailKlub->deskripsi)
                            <hr>
                            <h6 class="text-primary">Deskripsi</h6>
                            <p>{{ $detailKlub->deskripsi }}</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeDetailModal" class="btn btn-secondary">Tutup</button>
                        <button type="button" wire:click="edit({{ $detailKlub->id }}); closeDetailModal()"
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
                        Apakah Anda yakin ingin menghapus data klub ini? Data yang sudah dihapus tidak dapat
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
