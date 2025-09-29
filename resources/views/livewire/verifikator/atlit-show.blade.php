<div>
    <div class="row">
        <!-- Left Column - Atlet Details -->
        <div class="col-lg-4">
            <!-- Atlet Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user-circle mr-2"></i>Profil Atlet
                    </h6>
                    @if ($atlit->status == 'pending')
                        <span class="badge badge-warning badge-lg">
                            <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                        </span>
                    @elseif($atlit->status == 'diverifikasi')
                        <span class="badge badge-success badge-lg">
                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                        </span>
                    @elseif($atlit->status == 'ditolak')
                        <span class="badge badge-danger badge-lg">
                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Photo -->
                    <div class="text-center mb-4 card-profile-image">
                        @if ($atlit->foto)
                            <img src="{{ asset('storage/' . $atlit->foto) }}" alt="{{ $atlit->nama_lengkap }}"
                                class="rounded-circle shadow-lg"
                                style="width: 120px; height: 120px; object-fit: cover; border: 5px solid #fff;">
                        @else
                            <div class="rounded-circle bg-gradient-secondary d-flex align-items-center justify-content-center mx-auto shadow-lg"
                                style="width: 120px; height: 120px; border: 5px solid #fff;">
                                <i class="fas fa-user text-white fa-3x"></i>
                            </div>
                        @endif
                        <h5 class="mt-3 mb-1 font-weight-bold">{{ $atlit->nama_lengkap }}</h5>
                        <p class="text-muted mb-2">{{ $atlit->email }}</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar mr-1"></i>
                            Terdaftar {{ $atlit->created_at->format('d M Y') }}
                        </small>
                    </div>

                    <!-- Basic Info -->
                    <div class="table-responsive">
                        <table class="table table-sm table-profile">
                            <tr>
                                <td class="font-weight-bold text-primary" style="width: 40%;">
                                    <i class="fas fa-id-card mr-2"></i>NIK:
                                </td>
                                <td>{{ $atlit->nik }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Tempat, Tgl Lahir:
                                </td>
                                <td>{{ $atlit->tempat_lahir }}, {{ $atlit->tanggal_lahir->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    <i class="fas fa-venus-mars mr-2"></i>Jenis Kelamin:
                                </td>
                                <td>
                                    @if ($atlit->jenis_kelamin == 'L')
                                        <span class="badge badge-info">Laki-laki</span>
                                    @else
                                        <span class="badge badge-pink">Perempuan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    <i class="fas fa-phone mr-2"></i>Telepon:
                                </td>
                                <td>{{ $atlit->telepon }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    <i class="fas fa-home mr-2"></i>Alamat:
                                </td>
                                <td>{{ $atlit->alamat }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    <i class="fas fa-building mr-2"></i>Klub:
                                </td>
                                <td>
                                    <span
                                        class="badge badge-info">{{ $atlit->klub->nama_klub ?? 'Belum ada klub' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    <i class="fas fa-running mr-2"></i>Cabor:
                                </td>
                                <td>
                                    <span
                                        class="badge badge-success">{{ $atlit->cabangOlahraga->nama_cabor ?? 'Belum ada cabor' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    <i class="fas fa-layer-group mr-2"></i>Kategori:
                                </td>
                                <td>
                                    <span
                                        class="badge badge-warning">{{ $atlit->kategoriAtlit->nama_kategori ?? 'Belum ada kategori' }}</span>
                                </td>
                            </tr>
                            @if ($atlit->prestasi)
                                <tr>
                                    <td class="font-weight-bold text-primary">
                                        <i class="fas fa-trophy mr-2"></i>Prestasi:
                                    </td>
                                    <td>{{ $atlit->prestasi }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <!-- Verification Status -->
                    @if ($atlit->verified_at)
                        <hr>
                        <div class="bg-light p-3 rounded">
                            <h6 class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-info-circle mr-2"></i>Informasi Verifikasi
                            </h6>
                            <div class="text-sm">
                                <p class="mb-1">
                                    <strong>Tanggal:</strong> {{ $atlit->verified_at->format('d/m/Y H:i') }}
                                </p>
                                @if ($atlit->verifikator)
                                    <p class="mb-1">
                                        <strong>Verifikator:</strong> {{ $atlit->verifikator->name }}
                                    </p>
                                @endif
                                @if ($atlit->alasan_ditolak)
                                    <div class="mt-2 p-2 bg-danger text-white rounded">
                                        <strong>Alasan Ditolak:</strong><br>
                                        {{ $atlit->alasan_ditolak }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Verification Actions -->
                    @if ($atlit->status == 'pending')
                        <hr>
                        <div class="text-center">
                            <h6 class="font-weight-bold text-dark mb-3">Aksi Verifikasi</h6>
                            <div class="verify-buttons">
                                <button wire:click="openVerifyAtlitModal" class="btn btn-success btn-lg mr-2">
                                    <i class="fas fa-check mr-2"></i>Verifikasi Data
                                </button>
                                <button wire:click="openRejectAtlitModal" class="btn btn-danger btn-lg">
                                    <i class="fas fa-times mr-2"></i>Tolak Data
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Documents -->
        <div class="col-lg-8">
            <!-- Document Statistics -->
            @if (!empty($documentStats))
                <div class="card shadow mb-4">
                    <div class="card-body document-stats">
                        <div class="row">
                            <div class="col-3">
                                <div class="stat-item">
                                    <div class="stat-number text-info">{{ $documentStats['total'] }}</div>
                                    <div class="stat-label">Total Dokumen</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="stat-item">
                                    <div class="stat-number text-warning">{{ $documentStats['pending'] }}</div>
                                    <div class="stat-label">Menunggu</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="stat-item">
                                    <div class="stat-number text-success">{{ $documentStats['verified'] }}</div>
                                    <div class="stat-label">Terverifikasi</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="stat-item">
                                    <div class="stat-number text-danger">{{ $documentStats['rejected'] }}</div>
                                    <div class="stat-label">Ditolak</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Documents Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-file-pdf mr-2"></i>Dokumen Atlet
                        @if ($dokumens->count() > 0)
                            <span class="badge badge-light ml-2">{{ $dokumens->count() }} dokumen</span>
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    @if ($dokumens->count() > 0)
                        <div class="row">
                            <!-- Documents List -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-dark">Daftar Dokumen:</h6>
                                </div>
                                <div style="max-height: 600px; overflow-y: auto;">
                                    @foreach ($dokumens as $index => $dokumen)
                                        <div class="document-item p-3 {{ $selectedDokumen && $selectedDokumen->id == $dokumen->id ? 'active' : '' }}"
                                            wire:click="selectDokumen({{ $dokumen->id }})">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 font-weight-bold">
                                                        <i class="fas fa-file-pdf mr-1 text-danger"></i>
                                                        {{ $dokumen->kategori_berkas }}
                                                    </h6>
                                                    <p class="mb-1 text-sm text-muted">{{ $dokumen->nama_file }}</p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ $dokumen->created_at->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                                <div class="ml-2">
                                                    @if ($dokumen->status_verifikasi == 'pending')
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-clock mr-1"></i>Pending
                                                        </span>
                                                    @elseif($dokumen->status_verifikasi == 'verified')
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle mr-1"></i>Verified
                                                        </span>
                                                    @elseif($dokumen->status_verifikasi == 'rejected')
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle mr-1"></i>Rejected
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            @if ($dokumen->status_verifikasi == 'pending')
                                                <div class="mt-3 verify-buttons">
                                                    <button wire:click="openVerifyDokumenModal({{ $dokumen->id }})"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-check mr-1"></i>Verifikasi
                                                    </button>
                                                    <button wire:click="openRejectDokumenModal({{ $dokumen->id }})"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times mr-1"></i>Tolak
                                                    </button>
                                                </div>
                                            @endif

                                            @if ($dokumen->verified_at)
                                                <div class="mt-2 p-2 bg-light rounded">
                                                    <small class="text-muted">
                                                        <strong>Diverifikasi:</strong>
                                                        {{ $dokumen->verified_at->format('d/m/Y H:i') }}<br>
                                                        @if ($dokumen->verifikator)
                                                            <strong>Oleh:</strong> {{ $dokumen->verifikator->name }}
                                                        @endif
                                                    </small>
                                                </div>
                                            @endif

                                            @if ($dokumen->alasan_ditolak)
                                                <div class="mt-2 p-2 bg-danger text-white rounded">
                                                    <small>
                                                        <strong><i class="fas fa-exclamation-triangle mr-1"></i>Alasan
                                                            Ditolak:</strong><br>
                                                        {{ $dokumen->alasan_ditolak }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- PDF Preview -->
                            <div class="col-md-8">
                                <div class="document-preview">
                                    @if ($selectedDokumen)
                                        <div class="p-3 border-bottom bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0 font-weight-bold">
                                                        {{ $selectedDokumen->kategori_berkas }}</h6>
                                                    <small
                                                        class="text-muted">{{ $selectedDokumen->nama_file }}</small>
                                                </div>
                                                <div>
                                                    <a href="{{ asset('storage/' . $selectedDokumen->file_path) }}"
                                                        target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-external-link-alt mr-1"></i>Buka di Tab Baru
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <iframe id="pdf-preview"
                                            src="{{ asset('storage/' . $selectedDokumen->file_path) }}#toolbar=0&navpanes=0&scrollbar=0"
                                            width="100%" height="500" style="border: none; background: white;">
                                            <div class="p-4 text-center">
                                                <p class="text-muted">Browser Anda tidak mendukung preview PDF.</p>
                                                <a href="{{ asset('storage/' . $selectedDokumen->file_path) }}"
                                                    target="_blank" class="btn btn-primary">
                                                    <i class="fas fa-download mr-2"></i>Download Dokumen
                                                </a>
                                            </div>
                                        </iframe>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted"
                                            style="min-height: 500px;">
                                            <div class="text-center">
                                                <i class="fas fa-file-pdf fa-5x mb-3 text-muted"></i>
                                                <h5>Pilih dokumen untuk preview</h5>
                                                <p>Klik salah satu dokumen di sebelah kiri untuk melihat preview PDF</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-5x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada dokumen</h5>
                            <p class="text-muted">Atlet belum mengupload dokumen apapun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi Atlet -->
    @if ($showVerifyModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animate-fade-in">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle mr-2"></i>
                            Konfirmasi Verifikasi
                        </h5>
                        <button type="button" class="close text-white" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-user-check fa-3x text-success mb-3"></i>
                            <h6>Verifikasi Data Atlet</h6>
                        </div>
                        <p class="text-center">Apakah Anda yakin akan memverifikasi data atlet
                            <strong>{{ $atlit->nama_lengkap }}</strong>?</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Perhatian:</strong> Data atlet yang sudah diverifikasi akan mengubah statusnya
                            menjadi "Terverifikasi" dan tidak dapat diubah kembali.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="button" class="btn btn-success" wire:click="verifyAtlit">
                            <i class="fas fa-check mr-1"></i>Ya, Verifikasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Modal Tolak Atlet -->
    @if ($showRejectModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animate-fade-in">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle mr-2"></i>
                            Konfirmasi Penolakan
                        </h5>
                        <button type="button" class="close text-white" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                            <h6>Tolak Data Atlet</h6>
                        </div>
                        <p class="text-center">Anda akan menolak data atlet
                            <strong>{{ $atlit->nama_lengkap }}</strong>.</p>

                        <div class="form-group">
                            <label for="alasanPenolakan" class="font-weight-bold">
                                Alasan Penolakan <span class="text-danger">*</span>
                            </label>
                            <textarea wire:model="alasanPenolakan" id="alasanPenolakan"
                                class="form-control @error('alasanPenolakan') is-invalid @enderror" rows="4"
                                placeholder="Masukkan alasan penolakan dengan detail..."></textarea>
                            @error('alasanPenolakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Peringatan:</strong> Data yang ditolak akan mengubah status menjadi "Ditolak" dan
                            atlet akan menerima notifikasi beserta alasan penolakan.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="rejectAtlit">
                            <i class="fas fa-times mr-1"></i>Ya, Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Modal Verifikasi Dokumen -->
    @if ($showDokumenVerifyModal && $currentDokumen)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animate-fade-in">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle mr-2"></i>
                            Konfirmasi Verifikasi Dokumen
                        </h5>
                        <button type="button" class="close text-white" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-file-check fa-3x text-success mb-3"></i>
                            <h6>Verifikasi Dokumen</h6>
                        </div>
                        <p class="text-center">Apakah Anda yakin akan memverifikasi dokumen berikut?</p>
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">{{ $currentDokumen->kategori_berkas }}</h6>
                                <p class="card-text text-muted">{{ $currentDokumen->nama_file }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Diupload: {{ $currentDokumen->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Dokumen yang sudah diverifikasi akan mengubah statusnya menjadi "Terverifikasi".
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="button" class="btn btn-success" wire:click="verifyDokumen">
                            <i class="fas fa-check mr-1"></i>Ya, Verifikasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Modal Tolak Dokumen -->
    @if ($showDokumenRejectModal && $currentDokumen)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animate-fade-in">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle mr-2"></i>
                            Konfirmasi Penolakan Dokumen
                        </h5>
                        <button type="button" class="close text-white" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-file-times fa-3x text-danger mb-3"></i>
                            <h6>Tolak Dokumen</h6>
                        </div>
                        <p class="text-center">Anda akan menolak dokumen berikut:</p>
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                <h6 class="card-title">{{ $currentDokumen->kategori_berkas }}</h6>
                                <p class="card-text text-muted">{{ $currentDokumen->nama_file }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Diupload: {{ $currentDokumen->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="alasanPenolakanDokumen" class="font-weight-bold">
                                Alasan Penolakan <span class="text-danger">*</span>
                            </label>
                            <textarea wire:model="alasanPenolakan" id="alasanPenolakanDokumen"
                                class="form-control @error('alasanPenolakan') is-invalid @enderror" rows="4"
                                placeholder="Masukkan alasan penolakan dokumen dengan detail..."></textarea>
                            @error('alasanPenolakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Peringatan:</strong> Dokumen yang ditolak akan mengubah status menjadi "Ditolak" dan
                            atlet perlu mengupload ulang dokumen yang sesuai.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="rejectDokumen">
                            <i class="fas fa-times mr-1"></i>Ya, Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading wire:target="verifyAtlit,rejectAtlit,verifyDokumen,rejectDokumen">
        <div class="position-fixed w-100 h-100 d-flex align-items-center justify-content-center"
            style="top: 0; left: 0; background: rgba(0,0,0,0.5); z-index: 9999;">
            <div class="text-center text-white">
                <div class="spinner-border mb-3" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Memproses verifikasi...</p>
            </div>
        </div>
    </div>
</div>
