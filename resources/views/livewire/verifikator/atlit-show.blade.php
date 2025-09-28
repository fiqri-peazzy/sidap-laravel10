<div>
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column - Atlet Details -->
        <div class="col-lg-4">
            <!-- Atlet Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-circle mr-2"></i>Profil Atlet
                    </h6>
                    @if ($atlet->status == 'pending')
                        <span class="badge badge-warning status-badge">
                            <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                        </span>
                    @elseif($atlet->status == 'diverifikasi')
                        <span class="badge badge-success status-badge">
                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                        </span>
                    @elseif($atlet->status == 'ditolak')
                        <span class="badge badge-danger status-badge">
                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Photo -->
                    <div class="text-center mb-4">
                        @if ($atlet->foto)
                            <img src="{{ asset('storage/' . $atlet->foto) }}" alt="{{ $atlet->nama_lengkap }}"
                                class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto shadow"
                                style="width: 120px; height: 120px;">
                                <i class="fas fa-user text-white fa-3x"></i>
                            </div>
                        @endif
                        <h5 class="mt-3 mb-1 font-weight-bold">{{ $atlet->nama_lengkap }}</h5>
                        <p class="text-muted mb-0">{{ $atlet->email }}</p>
                    </div>

                    <!-- Basic Info -->
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="font-weight-bold" style="width: 40%;">NIK:</td>
                                <td>{{ $atlet->nik }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Tempat, Tgl Lahir:</td>
                                <td>{{ $atlet->tempat_lahir }}, {{ $atlet->tanggal_lahir->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Jenis Kelamin:</td>
                                <td>{{ $atlet->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Telepon:</td>
                                <td>{{ $atlet->telepon }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Alamat:</td>
                                <td>{{ $atlet->alamat }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Klub:</td>
                                <td>{{ $atlet->klub->nama_klub ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Cabor:</td>
                                <td>{{ $atlet->cabangOlahraga->nama_cabor ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Kategori:</td>
                                <td>{{ $atlet->kategoriAtlit->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Prestasi:</td>
                                <td>{{ $atlet->prestasi ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Verification Status -->
                    @if ($atlet->verified_at)
                        <hr>
                        <div class="text-sm text-muted">
                            <strong>Diverifikasi:</strong> {{ $atlet->verified_at->format('d/m/Y H:i') }}<br>
                            @if ($atlet->verifikator)
                                <strong>Oleh:</strong> {{ $atlet->verifikator->name }}
                            @endif
                            @if ($atlet->alasan_ditolak)
                                <div class="mt-2">
                                    <strong class="text-danger">Alasan Ditolak:</strong><br>
                                    <span class="text-danger">{{ $atlet->alasan_ditolak }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Verification Actions -->
                    @if ($atlet->status == 'pending')
                        <hr>
                        <div class="verify-buttons text-center">
                            <button wire:click="openVerifyAtlitModal" class="btn btn-success btn-sm">
                                <i class="fas fa-check mr-1"></i>Verifikasi
                            </button>
                            <button wire:click="openRejectAtlitModal" class="btn btn-danger btn-sm">
                                <i class="fas fa-times mr-1"></i>Tolak
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Documents -->
        <div class="col-lg-8">
            <!-- Documents Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-pdf mr-2"></i>Dokumen Atlet
                    </h6>
                </div>
                <div class="card-body">
                    @if ($dokumens->count() > 0)
                        <div class="row">
                            <!-- Documents List -->
                            <div class="col-md-4">
                                <div class="list-group">
                                    @foreach ($dokumens as $index => $dokumen)
                                        <div class="list-group-item document-item {{ $selectedDokumen && $selectedDokumen->id == $dokumen->id ? 'active' : '' }}"
                                            wire:click="selectDokumen({{ $dokumen->id }})">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 font-weight-bold">{{ $dokumen->kategori_berkas }}
                                                    </h6>
                                                    <p class="mb-1 text-sm">{{ $dokumen->nama_file }}</p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ $dokumen->created_at->format('d/m/Y') }}
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
                                                <div class="mt-2">
                                                    <button wire:click="openVerifyDokumenModal({{ $dokumen->id }})"
                                                        class="btn btn-success btn-xs">
                                                        <i class="fas fa-check mr-1"></i>Verifikasi
                                                    </button>
                                                    <button wire:click="openRejectDokumenModal({{ $dokumen->id }})"
                                                        class="btn btn-danger btn-xs">
                                                        <i class="fas fa-times mr-1"></i>Tolak
                                                    </button>
                                                </div>
                                            @endif

                                            @if ($dokumen->alasan_ditolak)
                                                <div class="mt-2 p-2 bg-light border-left border-danger">
                                                    <small class="text-danger">
                                                        <strong>Alasan Ditolak:</strong><br>
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
                                        <div class="p-3 border-bottom">
                                            <h6 class="mb-0">{{ $selectedDokumen->kategori_berkas }}</h6>
                                            <small class="text-muted">{{ $selectedDokumen->nama_file }}</small>
                                        </div>
                                        <iframe id="pdf-preview"
                                            src="{{ asset('storage/' . $selectedDokumen->file_path) }}" width="100%"
                                            height="450" style="border: none;">
                                            <p>Browser Anda tidak mendukung preview PDF.
                                                <a href="{{ asset('storage/' . $selectedDokumen->file_path) }}"
                                                    target="_blank">
                                                    Klik di sini untuk membuka dokumen
                                                </a>
                                            </p>
                                        </iframe>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                            <div class="text-center">
                                                <i class="fas fa-file-pdf fa-3x mb-3"></i>
                                                <h5>Pilih dokumen untuk preview</h5>
                                                <p>Klik salah satu dokumen di sebelah kiri untuk melihat preview</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('template/img/undraw_no_data.png') }}" alt="No documents"
                                style="max-width: 200px;" class="mb-3">
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Konfirmasi Verifikasi
                        </h5>
                        <button type="button" class="close" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin akan memverifikasi data atlet <strong>{{ $atlet->nama_lengkap }}</strong>?
                        </p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Data atlet yang sudah diverifikasi akan mengubah statusnya menjadi "Terverifikasi".
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">Batal</button>
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle text-danger mr-2"></i>
                            Konfirmasi Penolakan
                        </h5>
                        <button type="button" class="close" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan menolak data atlet <strong>{{ $atlet->nama_lengkap }}</strong>.</p>

                        <div class="form-group">
                            <label for="alasanPenolakan" class="font-weight-bold">Alasan Penolakan <span
                                    class="text-danger">*</span></label>
                            <textarea wire:model="alasanPenolakan" id="alasanPenolakan"
                                class="form-control @error('alasanPenolakan') is-invalid @enderror" rows="3"
                                placeholder="Masukkan alasan penolakan..."></textarea>
                            @error('alasanPenolakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Data yang ditolak akan mengubah status menjadi "Ditolak" dan atlet akan menerima notifikasi.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">Batal</button>
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Konfirmasi Verifikasi Dokumen
                        </h5>
                        <button type="button" class="close" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin akan memverifikasi dokumen berikut?</p>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">{{ $currentDokumen->kategori_berkas }}</h6>
                                <p class="card-text text-muted">{{ $currentDokumen->nama_file }}</p>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Dokumen yang sudah diverifikasi akan mengubah statusnya menjadi "Terverifikasi".
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">Batal</button>
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle text-danger mr-2"></i>
                            Konfirmasi Penolakan Dokumen
                        </h5>
                        <button type="button" class="close" wire:click="closeModals">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan menolak dokumen berikut:</p>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">{{ $currentDokumen->kategori_berkas }}</h6>
                                <p class="card-text text-muted">{{ $currentDokumen->nama_file }}</p>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="alasanPenolakanDokumen" class="font-weight-bold">Alasan Penolakan <span
                                    class="text-danger">*</span></label>
                            <textarea wire:model="alasanPenolakan" id="alasanPenolakanDokumen"
                                class="form-control @error('alasanPenolakan') is-invalid @enderror" rows="3"
                                placeholder="Masukkan alasan penolakan dokumen..."></textarea>
                            @error('alasanPenolakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Dokumen yang ditolak akan mengubah status menjadi "Ditolak" dan atlet perlu mengupload
                            ulang.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">Batal</button>
                        <button type="button" class="btn btn-danger" wire:click="rejectDokumen">
                            <i class="fas fa-times mr-1"></i>Ya, Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
