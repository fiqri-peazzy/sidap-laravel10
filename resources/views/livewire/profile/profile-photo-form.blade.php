<!-- resources/views/livewire/profile/profile-photo-form.blade.php -->
<div>
    <!-- Current Profile Photo -->
    <div class="position-relative d-inline-block mb-3">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                class="rounded-circle profile-avatar">
        @else
            <div class="rounded-circle profile-avatar bg-primary d-flex align-items-center justify-content-center text-white"
                style="font-size: 3rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
        @endif

        <!-- Badge for uploaded photo indicator -->
        @if ($photo)
            <div class="position-absolute" style="top: -10px; right: -10px;">
                <span class="badge badge-success badge-pill">
                    <i class="fas fa-check"></i>
                </span>
            </div>
        @endif

        <!-- PPLP Badge Overlay -->
        <div class="position-absolute" style="bottom: -5px; left: -5px;">
            <span class="badge badge-primary badge-pill px-2" title="Atlit PPLP Gorontalo">
                <i class="fas fa-running mr-1"></i>
                PPLP
            </span>
        </div>
    </div>

    <!-- Athlete Information Display -->
    <div class="mb-3">
        <div class="text-center">
            <h5 class="font-weight-bold text-primary mb-1">{{ auth()->user()->name }}</h5>
            @if (auth()->user()->email)
                <p class="text-muted mb-1">
                    <i class="fas fa-envelope mr-1"></i>
                    {{ auth()->user()->email }}
                </p>
            @endif
            <small class="text-muted">
                <i class="fas fa-map-marker-alt mr-1"></i>
                PPLP Provinsi Gorontalo
            </small>
        </div>
    </div>

    <!-- Photo Preview (if uploading new photo) -->
    @if ($photo)
        <div class="mb-3">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Preview Foto Baru:</strong>
            </div>
            <div class="text-center">
                <div class="position-relative d-inline-block">
                    <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="rounded-circle border border-primary"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="position-absolute" style="bottom: -2px; right: -2px;">
                        <span class="badge badge-success badge-pill">
                            <i class="fas fa-camera"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Upload Form -->
    <form wire:submit="updateProfilePhoto">
        <div class="mb-3">
            <label for="photo" class="form-label font-weight-bold">
                <i class="fas fa-camera mr-1 text-primary"></i>
                Upload Foto Profil Atlit
            </label>
            <input type="file" wire:model="photo" id="photo" accept="image/*"
                class="form-control @error('photo') is-invalid @enderror" style="display: none;">
            @error('photo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                <i class="fas fa-info-circle mr-1"></i>
                Format yang didukung: JPEG, PNG, JPG, GIF | Ukuran maksimal: 2MB
                <br>
                <em>Gunakan foto terbaru untuk identifikasi yang lebih baik</em>
            </small>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            @if ($photo)
                <div class="btn-group-vertical w-100 mb-2">
                    <button type="submit" class="btn btn-success mb-2" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateProfilePhoto">
                            <i class="fas fa-upload mr-1"></i>
                            Simpan Foto Profil
                        </span>
                        <span wire:loading wire:target="updateProfilePhoto">
                            <i class="fas fa-spinner fa-spin mr-1"></i>
                            Mengupload...
                        </span>
                    </button>

                    <button type="button" wire:click="$set('photo', null)" class="btn btn-outline-secondary">
                        <i class="fas fa-times mr-1"></i>
                        Batalkan Upload
                    </button>
                </div>
            @else
                <label for="photo" class="btn btn-primary btn-block mb-2 cursor-pointer">
                    <i class="fas fa-camera mr-1"></i>
                    Pilih Foto Baru
                </label>
            @endif

            @if (auth()->user()->profile_photo_path)
                <button type="button" wire:click="deleteProfilePhoto"
                    wire:confirm="Apakah Anda yakin ingin menghapus foto profil? Foto default akan digunakan."
                    class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-trash mr-1"></i>
                    Hapus Foto Profil
                </button>
            @endif
        </div>
    </form>

    <!-- Loading Indicator -->
    <div wire:loading wire:target="photo" class="mt-3">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Memuat foto...</span>
            </div>
            <div class="mt-2">
                <small class="text-muted">
                    <i class="fas fa-cloud-upload-alt mr-1"></i>
                    Sedang memproses foto profil Anda...
                </small>
            </div>
        </div>
    </div>

    <!-- Processing Indicator -->
    <div wire:loading wire:target="updateProfilePhoto,deleteProfilePhoto" class="mt-3">
        <div class="alert alert-info text-center">
            <i class="fas fa-cog fa-spin mr-2"></i>
            <strong>Memproses...</strong>
            <span wire:target="updateProfilePhoto" wire:loading>Mengupdate foto profil</span>
            <span wire:target="deleteProfilePhoto" wire:loading>Menghapus foto profil</span>
        </div>
    </div>

    <!-- Success/Error Messages and Scripts -->
    <script>
        document.addEventListener('livewire:init', () => {
            // Photo updated successfully
            Livewire.on('profile-photo-updated', (event) => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Foto Profil Berhasil Diperbarui!',
                        html: `
                            <p>${event[0].message}</p>
                            <small class="text-muted">Foto profil atlit PPLP Gorontalo telah diperbarui</small>
                        `,
                        timer: 4000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    // Fallback if SweetAlert not available
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Berhasil!</strong> ${event[0].message}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    `;
                    document.querySelector('[wire\\:id]').appendChild(alertDiv);

                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        if (alertDiv.parentNode) {
                            alertDiv.remove();
                        }
                    }, 5000);
                }
            });

            // Photo deleted successfully
            Livewire.on('profile-photo-deleted', (event) => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Foto Profil Dihapus',
                        text: 'Foto profil telah dihapus, menggunakan inisial nama sebagai foto default.',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            });

            // Error handling
            Livewire.on('profile-photo-error', (event) => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengupload Foto',
                        text: event[0].message ||
                            'Terjadi kesalahan saat mengupload foto. Silakan coba lagi.',
                        confirmButtonColor: '#e74a3b'
                    });
                }
            });
        });

        // File input change handler for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.getElementById('photo');

            if (photoInput) {
                photoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        // Check file size (2MB = 2097152 bytes)
                        if (file.size > 2097152) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ukuran File Terlalu Besar',
                                    text: 'Ukuran file maksimal adalah 2MB. Silakan pilih foto yang lebih kecil.',
                                    confirmButtonColor: '#f6c23e'
                                });
                            }
                            this.value = ''; // Clear the input
                            return;
                        }

                        // Check file type
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                        if (!allowedTypes.includes(file.type)) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Format File Tidak Didukung',
                                    text: 'Silakan pilih file dengan format: JPEG, PNG, JPG, atau GIF.',
                                    confirmButtonColor: '#f6c23e'
                                });
                            }
                            this.value = ''; // Clear the input
                            return;
                        }
                    }
                });
            }
        });
    </script>

    <!-- Custom CSS for PPLP Profile Photo -->
    <style>
        .profile-avatar {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid #4e73df;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(78, 115, 223, 0.3);
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0.25rem 2rem 0 rgba(78, 115, 223, 0.4);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .btn-group-vertical .btn {
            border-radius: 0.375rem !important;
            margin-bottom: 0.5rem;
        }

        .badge-pill {
            font-size: 0.75rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</div>
