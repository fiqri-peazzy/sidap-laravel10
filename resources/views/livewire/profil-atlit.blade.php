<div>
    <!-- Loading Indicator -->
    <div wire:loading class="text-center py-5">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Memuat data profil...</p>
    </div>

    <!-- Main Content -->
    <div wire:loading.remove>
        <!-- Header Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-gradient-primary">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="text-white mb-1">
                                    <i class="fas fa-user-circle mr-2"></i>
                                    Profil Atlit - {{ $atlit->nama_lengkap }}
                                </h5>
                                <p class="text-white-50 mb-0">
                                    <i class="fas fa-running mr-1"></i>
                                    {{ $atlit->cabangOlahraga->nama_cabang ?? '-' }} •
                                    {{ $atlit->klub->nama_klub ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('atlit.profil.id-card.preview') }}"
                                    class="btn btn-light btn-sm mr-2 shadow-sm">
                                    <i class="fas fa-eye mr-1"></i> Preview ID Card
                                </a>
                                <a href="{{ route('atlit.profil.id-card.cetak') }}"
                                    class="btn btn-warning btn-sm shadow-sm" target="_blank">
                                    <i class="fas fa-id-card mr-1"></i> Cetak ID Card
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Foto Profil & Info Singkat -->
            <div class="col-lg-4">
                <!-- Foto Profil Card -->
                <div class="card shadow mb-4 border-0">
                    <div class="card-header bg-gradient-success text-white py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-camera mr-2"></i>Foto Profil
                            </h6>
                            @if (!$editingFoto)
                                <button type="button" class="btn btn-sm btn-light" wire:click="toggleEdit('foto')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body text-center py-4">
                        <div class="position-relative mb-3">
                            @if ($atlit->foto)
                                <img src="{{ Storage::url('atlit/foto/' . $atlit->foto) }}"
                                    alt="Foto {{ $atlit->nama_lengkap }}"
                                    class="img-fluid rounded-circle shadow-lg animate__animated animate__zoomIn"
                                    style="width: 180px; height: 180px; object-fit: cover; border: 5px solid #fff;">
                            @else
                                <div class="bg-gradient-secondary rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-lg"
                                    style="width: 180px; height: 180px; border: 5px solid #fff;">
                                    <i class="fas fa-user fa-5x text-white"></i>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <span
                                class="position-absolute badge badge-{{ $atlit->status === 'aktif' ? 'success' : 'secondary' }} badge-pill shadow-sm"
                                style="top: 10px; right: 10px; font-size: 0.7rem;">
                                <i
                                    class="fas fa-{{ $atlit->status === 'aktif' ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                {{ ucfirst($atlit->status) }}
                            </span>
                        </div>

                        <h5 class="font-weight-bold text-gray-800 mb-1">{{ $atlit->nama_lengkap }}</h5>
                        <p class="text-muted mb-3">ID: {{ str_pad($atlit->id, 6, '0', STR_PAD_LEFT) }}</p>

                        @if ($editingFoto)
                            <div class="mt-3">
                                <form wire:submit.prevent="updateFoto">
                                    <div class="form-group">
                                        <label class="btn btn-outline-primary btn-block" for="fotoInput">
                                            <i class="fas fa-upload mr-2"></i>Pilih Foto Baru
                                        </label>
                                        <input type="file" wire:model="fotoTemp" class="d-none" id="fotoInput"
                                            accept="image/*">
                                        @error('fotoTemp')
                                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Preview foto baru -->
                                    @if ($fotoTemp)
                                        <div class="mb-3">
                                            <img src="{{ $fotoTemp->temporaryUrl() }}" alt="Preview"
                                                class="img-fluid rounded-circle shadow"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                            <p class="text-muted small mt-2">Preview foto baru</p>
                                        </div>
                                    @endif

                                    <div class="btn-group btn-block">
                                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                            wire:target="updateFoto">
                                            <i class="fas fa-save mr-1"></i>Simpan
                                        </button>
                                        <button type="button" class="btn btn-secondary"
                                            wire:click="toggleEdit('foto')">
                                            <i class="fas fa-times mr-1"></i>Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Singkat Card -->
                <div class="card shadow mb-4 border-0">
                    <div class="card-header bg-gradient-info text-white py-3">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Singkat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-running text-info mr-2"></i>
                                <small class="text-muted">Cabang Olahraga</small>
                            </div>
                            <p class="font-weight-bold text-gray-800 mb-0">
                                {{ $atlit->cabangOlahraga->nama_cabang ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-users text-info mr-2"></i>
                                <small class="text-muted">Klub</small>
                            </div>
                            <p class="font-weight-bold text-gray-800 mb-0">{{ $atlit->klub->nama_klub ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-tag text-info mr-2"></i>
                                <small class="text-muted">Kategori</small>
                            </div>
                            <p class="font-weight-bold text-gray-800 mb-0">
                                {{ $atlit->kategoriAtlit->nama_kategori ?? '-' }}</p>
                        </div>

                        <div class="mb-0">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-venus-mars text-info mr-2"></i>
                                <small class="text-muted">Jenis Kelamin</small>
                            </div>
                            <p class="font-weight-bold text-gray-800 mb-0">
                                {{ $atlit->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Profil Lengkap -->
            <div class="col-lg-8">
                <div class="card shadow mb-4 border-0">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-user-edit mr-2"></i>Data Profil Lengkap
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <!-- Email Warning -->
                        @if ($showEmailWarning)
                            <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Perhatian!</strong> Perubahan email akan mempengaruhi email login Anda.
                                <button type="button" class="close" wire:click="$set('showEmailWarning', false)">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Data Personal -->
                            <div class="col-md-6">
                                <h6 class="text-primary font-weight-bold mb-3">
                                    <i class="fas fa-user mr-2"></i>Data Personal
                                </h6>

                                <!-- Nama Lengkap -->
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-gray-600 small">NAMA LENGKAP</label>
                                    <div class="bg-light p-3 rounded border-left-primary">
                                        <span class="font-weight-bold">{{ $atlit->nama_lengkap }}</span>
                                        <small class="text-muted d-block">Data ini tidak dapat diubah</small>
                                    </div>
                                </div>

                                <!-- NIK -->
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-gray-600 small">NIK</label>
                                    <div class="bg-light p-3 rounded border-left-primary">
                                        <span class="font-weight-bold">{{ $atlit->nik }}</span>
                                        <small class="text-muted d-block">Data ini tidak dapat diubah</small>
                                    </div>
                                </div>

                                <!-- Tempat, Tanggal Lahir -->
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-gray-600 small">TEMPAT, TANGGAL LAHIR</label>
                                    <div class="bg-light p-3 rounded border-left-primary">
                                        <span class="font-weight-bold">{{ $atlit->tempat_lahir }},
                                            {{ $atlit->tanggal_lahir->format('d F Y') }}</span>
                                        <small class="text-muted d-block">Data ini tidak dapat diubah</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Kontak -->
                            <div class="col-md-6">
                                <h6 class="text-success font-weight-bold mb-3">
                                    <i class="fas fa-address-card mr-2"></i>Data Kontak
                                </h6>

                                <!-- Alamat -->
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-gray-600 small d-flex align-items-center">
                                        <i class="fas fa-home mr-2 text-muted"></i>ALAMAT
                                        @if (!$editingAlamat)
                                            <button type="button" class="btn btn-sm btn-outline-success ml-auto"
                                                wire:click="toggleEdit('alamat')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                    </label>
                                    @if ($editingAlamat)
                                        <form wire:submit.prevent="updateField('alamat')">
                                            <div class="input-group">
                                                <textarea wire:model="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                                    placeholder="Masukkan alamat lengkap"></textarea>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                        wire:click="toggleEdit('alamat')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('alamat')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </form>
                                    @else
                                        <div class="p-3 bg-light rounded border-left-success">
                                            <span class="text-gray-800">{{ $atlit->alamat ?: 'Belum diisi' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Telepon -->
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-gray-600 small d-flex align-items-center">
                                        <i class="fas fa-phone mr-2 text-muted"></i>TELEPON
                                        @if (!$editingTelepon)
                                            <button type="button" class="btn btn-sm btn-outline-success ml-auto"
                                                wire:click="toggleEdit('telepon')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                    </label>
                                    @if ($editingTelepon)
                                        <form wire:submit.prevent="updateField('telepon')">
                                            <div class="input-group">
                                                <input type="text" wire:model="telepon"
                                                    class="form-control @error('telepon') is-invalid @enderror"
                                                    placeholder="Nomor telepon">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                        wire:click="toggleEdit('telepon')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('telepon')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </form>
                                    @else
                                        <div class="p-3 bg-light rounded border-left-success">
                                            <span class="text-gray-800">{{ $atlit->telepon ?: 'Belum diisi' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-gray-600 small d-flex align-items-center">
                                        <i class="fas fa-envelope mr-2 text-muted"></i>EMAIL
                                        @if (!$editingEmail)
                                            <button type="button" class="btn btn-sm btn-outline-warning ml-auto"
                                                wire:click="toggleEdit('email')"
                                                title="Perubahan email akan mempengaruhi email login">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                    </label>
                                    @if ($editingEmail)
                                        <form wire:submit.prevent="updateField('email')">
                                            <div class="input-group">
                                                <input type="email" wire:model="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="Alamat email">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                        wire:click="toggleEdit('email')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('email')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </form>
                                    @else
                                        <div class="p-3 bg-light rounded border-left-warning">
                                            <span class="text-gray-800">{{ $atlit->email ?: 'Belum diisi' }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Prestasi Section -->
                        <hr class="my-4">

                        <!-- Daftar Prestasi Card -->
                        <div class="card shadow mb-4 border-0">
                            <div
                                class="card-header bg-gradient-info text-white py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-trophy mr-2"></i>Daftar Prestasi Saya
                                </h6>
                                <span class="badge badge-light badge-pill">{{ $prestasi->count() }} Prestasi</span>
                            </div>
                            <div class="card-body">
                                <!-- Filter Status -->
                                <div class="btn-group mb-3 btn-group-sm" role="group">
                                    <button type="button"
                                        class="btn {{ $filterStatus === 'all' ? 'btn-primary' : 'btn-outline-primary' }}"
                                        wire:click="setFilterStatus('all')">
                                        <i class="fas fa-list mr-1"></i> Semua ({{ $statistikPrestasi['total'] }})
                                    </button>
                                    <button type="button"
                                        class="btn {{ $filterStatus === 'verified' ? 'btn-success' : 'btn-outline-success' }}"
                                        wire:click="setFilterStatus('verified')">
                                        <i class="fas fa-check mr-1"></i> Terverifikasi
                                        ({{ $statistikPrestasi['verified'] }})
                                    </button>
                                    <button type="button"
                                        class="btn {{ $filterStatus === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}"
                                        wire:click="setFilterStatus('pending')">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                        ({{ $statistikPrestasi['pending'] }})
                                    </button>
                                    <button type="button"
                                        class="btn {{ $filterStatus === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}"
                                        wire:click="setFilterStatus('rejected')">
                                        <i class="fas fa-times mr-1"></i> Ditolak
                                        ({{ $statistikPrestasi['rejected'] }})
                                    </button>
                                </div>

                                <!-- Loading Indicator -->
                                <div wire:loading wire:target="setFilterStatus" class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                                <!-- Daftar Prestasi -->
                                <div wire:loading.remove wire:target="setFilterStatus">
                                    @forelse($prestasi as $item)
                                        <div class="card mb-3 border-0 shadow-sm hover-shadow">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="d-flex align-items-start">
                                                            <div class="mr-3">
                                                                @if ($item->peringkat == '1')
                                                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                                                        style="width: 50px; height: 50px;">
                                                                        <i class="fas fa-trophy fa-2x text-white"></i>
                                                                    </div>
                                                                @elseif($item->peringkat == '2')
                                                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                                        style="width: 50px; height: 50px;">
                                                                        <i class="fas fa-medal fa-2x text-white"></i>
                                                                    </div>
                                                                @elseif($item->peringkat == '3')
                                                                    <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center"
                                                                        style="width: 50px; height: 50px;">
                                                                        <i class="fas fa-medal fa-2x text-white"></i>
                                                                    </div>
                                                                @else
                                                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center"
                                                                        style="width: 50px; height: 50px;">
                                                                        <i class="fas fa-award fa-2x text-white"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="font-weight-bold text-gray-800 mb-1">
                                                                    {{ $item->nama_kejuaraan }}
                                                                </h6>
                                                                <div class="mb-2">
                                                                    <span class="badge badge-primary badge-sm mr-1">
                                                                        <i class="fas fa-layer-group"></i>
                                                                        {{ $item->tingkat_kejuaraan }}
                                                                    </span>
                                                                    <span class="badge badge-info badge-sm mr-1">
                                                                        <i class="fas fa-running"></i>
                                                                        {{ $item->cabangOlahraga->nama_cabang ?? '-' }}
                                                                    </span>
                                                                    @if ($item->medali)
                                                                        {!! $item->medali_badge !!}
                                                                    @endif
                                                                </div>
                                                                <p class="text-muted small mb-2">
                                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                                    {{ $item->tempat_kejuaraan }}
                                                                </p>
                                                                <p class="text-muted small mb-0">
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    {{ $item->tanggal_kejuaraan }}
                                                                </p>
                                                                @if ($item->nomor_pertandingan)
                                                                    <p class="text-muted small mb-0">
                                                                        <i class="fas fa-list-ol mr-1"></i> Nomor:
                                                                        {{ $item->nomor_pertandingan }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <div class="mb-2">
                                                            {!! $item->peringkat_badge !!}
                                                        </div>
                                                        <div class="mb-2">
                                                            {!! $item->status_badge !!}
                                                        </div>
                                                        @if ($item->sertifikat)
                                                            <a href="{{ $item->sertifikat_url }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-file-pdf mr-1"></i> Lihat Sertifikat
                                                            </a>
                                                        @endif
                                                        @if ($item->status === 'rejected' && $item->keterangan)
                                                            <div class="alert alert-danger alert-sm mt-2 p-2">
                                                                <small><strong>Alasan
                                                                        Penolakan:</strong><br>{{ $item->keterangan }}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-5">
                                            <i class="fas fa-trophy fa-4x text-gray-300 mb-3"></i>
                                            <h5 class="text-gray-500">
                                                @if ($filterStatus === 'all')
                                                    Belum Ada Prestasi
                                                @else
                                                    Tidak Ada Prestasi dengan Status {{ ucfirst($filterStatus) }}
                                                @endif
                                            </h5>
                                            <p class="text-muted">
                                                Prestasi Anda akan muncul di sini setelah diinputkan dan diverifikasi
                                                oleh admin.
                                            </p>
                                        </div>
                                    @endforelse
                                </div>

                                @if ($prestasi->count() > 0)
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Menampilkan {{ $prestasi->count() }} prestasi
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @push('styles')
                            <style>
                                .hover-shadow {
                                    transition: all 0.3s ease;
                                }

                                .hover-shadow:hover {
                                    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
                                    transform: translateY(-2px);
                                }

                                .bg-gradient-warning {
                                    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
                                }
                            </style>
                        @endpush
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0 bg-gradient-light">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="text-gray-800 mb-1">
                                    <i class="fas fa-rocket mr-2"></i>Aksi Cepat
                                </h6>
                                <small class="text-muted">Kelola profil dan ID card Anda dengan mudah</small>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('atlit.profil.id-card.preview') }}"
                                    class="btn btn-info btn-sm mr-2 shadow-sm">
                                    <i class="fas fa-search mr-1"></i> Lihat ID Card
                                </a>
                                <a href="{{ route('atlit.profil.id-card.cetak') }}"
                                    class="btn btn-primary btn-sm shadow-sm" target="_blank">
                                    <i class="fas fa-download mr-1"></i> Unduh PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }

        .border-left-info {
            border-left: 4px solid #36b9cc !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-secondary {
            background: linear-gradient(135deg, #868e96 0%, #596164 100%);
        }

        .bg-gradient-light {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
        }

        .card {
            transition: all 0.3s ease;
            border: 0 !important;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            border-color: #4e73df;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .prestasi-content {
            line-height: 1.6;
            color: #495057;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1rem !important;
            }

            .btn-group.btn-block {
                display: flex !important;
            }

            .btn-group.btn-block .btn {
                flex: 1;
            }
        }
    </style>
@endpush
