<div>
    <!-- Loading Indicator -->
    <div wire:loading class="text-center">
        <div class="spinner-border text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Main Content -->
    <div wire:loading.remove>
        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Dokumen</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terverifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['verified'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['pending'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistik['rejected'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen List Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Daftar Dokumen</h6>
                <button type="button" class="btn btn-success btn-sm" wire:click="openUploadModal">
                    <i class="fas fa-plus fa-sm mr-1"></i>Upload Dokumen
                </button>
            </div>
            <div class="card-body">
                @if($dokumenList->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-file-pdf fa-4x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-600">Belum ada dokumen yang diupload</h5>
                        <p class="text-gray-500">Klik tombol "Upload Dokumen" untuk menambah dokumen pertama Anda.</p>
                        <button type="button" class="btn btn-success" wire:click="openUploadModal">
                            <i class="fas fa-plus fa-sm mr-1"></i>Upload Dokumen Pertama
                        </button>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Kategori Berkas</th>
                                    <th>Nama File</th>
                                    <th>Status Verifikasi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Verifikator</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dokumenList as $dokumen)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary">{{ $dokumen->kategori_berkas }}</span>
                                        </td>
                                        <td>
                                            <i class="fas fa-file-pdf text-danger mr-2"></i>
                                            {{ Str::limit($dokumen->nama_file, 30) }}
                                            @if($dokumen->keterangan)
                                                <br><small class="text-muted">{{ $dokumen->keterangan }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $dokumen->status_badge_class }}">
                                                {{ $dokumen->status_verifikasi_indonesia }}
                                            </span>
                                            @if($dokumen->isRejected() && $dokumen->alasan_ditolak)
                                                <br><small class="text-danger">
                                                    <i class="fas fa-info-circle"></i> {{ $dokumen->alasan_ditolak }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>{{ $dokumen->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($dokumen->verifikator)
                                                {{ $dokumen->verifikator->name }}
                                                @if($dokumen->verified_at)
                                                    <br><small class="text-muted">{{ $dokumen->verified_at->format('d/m/Y H:i') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Download Button -->
                                                <a href="{{ route('atlit.dokumen.download', $dokumen->id) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                
                                                <!-- Delete Button -->
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="confirmDelete({{ $dokumen->id }}, '{{ $dokumen->nama_file }}')"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    @if($showUploadModal)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-upload mr-2"></i>Upload Dokumen Baru
                        </h5>
                        <button type="button" class="close" wire:click="closeUploadModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="uploadDokumen">
                        <div class="modal-body">
                            <!-- Kategori Berkas -->
                            <div class="form-group">
                                <label for="kategori_berkas">Kategori Berkas <span class="text-danger">*</span></label>
                                <select wire:model="kategori_berkas" 
                                        class="form-control @error('kategori_berkas') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoriBerkas as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_berkas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="form-group">
                                <label for="file_upload">File PDF <span class="text-danger">*</span></label>
                                <input type="file" 
                                       wire:model="file_upload" 
                                       class="form-control-file @error('file_upload') is-invalid @enderror"
                                       accept=".pdf">
                                <small class="form-text text-muted">
                                    Format: PDF, Maksimal: 5MB
                                </small>
                                @error('file_upload')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <!-- Loading saat upload -->
                                <div wire:loading wire:target="file_upload" class="mt-2">
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                             role="progressbar" 
                                             style="width: 100%">
                                            Mengupload file...
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea wire:model="keterangan" 
                                          class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Keterangan tambahan (opsional)"></textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info -->
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Catatan:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Untuk kategori <strong>Ijazah</strong>, <strong>Akta Kelahiran</strong>, dan <strong>Kartu Pelajar</strong>, hanya boleh upload satu dokumen per kategori.</li>
                                    <li>Untuk kategori <strong>Dokumen Pendukung</strong>, Anda bisa upload beberapa dokumen terpisah.</li>
                                    <li>Dokumen yang sudah diupload akan menunggu verifikasi dari admin/verifikator.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeUploadModal">
                                <i class="fas fa-times mr-1"></i>Batal
                            </button>
                            <button type="submit" 
                                    class="btn btn-success" 
                                    wire:loading.attr="disabled" 
                                    wire:target="uploadDokumen">
                                <span wire:loading.remove wire:target="uploadDokumen">
                                    <i class="fas fa-upload mr-1"></i>Upload Dokumen
                                </span>
                                <span wire:loading wire:target="uploadDokumen">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Mengupload...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function confirmDelete(dokumenId, fileName) {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen "' + fileName + '"?\n\nData yang sudah dihapus tidak dapat dikembalikan.')) {
            @this.call('deleteDokumen', dokumenId);
        }
    }
</script>
@endpush