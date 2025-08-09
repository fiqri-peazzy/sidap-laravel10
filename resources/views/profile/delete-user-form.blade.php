<!-- resources/views/livewire/profile/delete-user-form.blade.php -->
<div>
    <div class="alert alert-danger d-flex align-items-center mb-4">
        <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
        <div>
            <strong>Peringatan: Zona Berbahaya</strong><br>
            <small>
                Menghapus akun atlit PPLP adalah tindakan permanen yang tidak dapat dibatalkan.
                Semua data prestasi, riwayat latihan, dan informasi pribadi akan hilang secara permanen.
            </small>
        </div>
    </div>

    <!-- Account Deletion Information -->
    <div class="mb-4">
        <h6 class="font-weight-bold text-danger mb-3">
            <i class="fas fa-user-times mr-2"></i>
            Hapus Akun Atlit PPLP Secara Permanen
        </h6>

        <p class="text-muted mb-3">
            Sebelum menghapus akun, pertimbangkan dampak dari tindakan ini. Setelah akun dihapus,
            Anda tidak akan dapat mengakses data apapun yang terkait dengan akun atlit PPLP Anda.
        </p>

        <!-- What will be deleted -->
        <div class="card border-left-warning mb-4">
            <div class="card-body">
                <h6 class="font-weight-bold text-warning">
                    <i class="fas fa-database mr-2"></i>
                    Data yang Akan Dihapus:
                </h6>
                <ul class="mb-0 text-muted">
                    <li>Informasi profil dan foto atlit</li>
                    <li>Riwayat prestasi dan pencapaian</li>
                    <li>Data latihan dan program pelatihan</li>
                    <li>Sertifikat dan penghargaan digital</li>
                    <li>Riwayat komunikasi dengan pelatih</li>
                    <li>Semua preferensi dan pengaturan akun</li>
                </ul>
            </div>
        </div>

        <!-- Alternative Actions -->
        <div class="card border-left-info mb-4">
            <div class="card-body">
                <h6 class="font-weight-bold text-info">
                    <i class="fas fa-lightbulb mr-2"></i>
                    Alternatif Sebelum Menghapus Akun:
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="mb-0 text-muted small">
                            <li class="mb-2">
                                <strong>Nonaktifkan sementara:</strong><br>
                                Hubungi administrator untuk menonaktifkan akun tanpa menghapus data
                            </li>
                            <li class="mb-2">
                                <strong>Backup data:</strong><br>
                                Download sertifikat dan foto penting sebelum menghapus
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="mb-0 text-muted small">
                            <li class="mb-2">
                                <strong>Transfer data:</strong><br>
                                Konsultasi dengan pelatih untuk transfer data prestasi
                            </li>
                            <li class="mb-2">
                                <strong>Ubah password:</strong><br>
                                Jika masalah keamanan, coba ubah password terlebih dahulu
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="card border-left-primary mb-4">
        <div class="card-body">
            <h6 class="font-weight-bold text-primary">
                <i class="fas fa-phone mr-2"></i>
                Butuh Bantuan?
            </h6>
            <p class="mb-2 text-muted">
                Jika Anda mengalami masalah dengan akun, hubungi tim dukungan PPLP sebelum menghapus akun:
            </p>
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">
                        <i class="fas fa-envelope mr-1"></i>
                        <strong>Email:</strong> support@pplpgorontalo.id
                    </small>
                </div>
                <div class="col-md-6">
                    <small class="text-muted">
                        <i class="fas fa-phone mr-1"></i>
                        <strong>Telepon:</strong> (0435) 123-4567
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Button -->
    <div class="text-center">
        <button type="button" onclick="confirmDeleteAccount()" class="btn btn-danger">
            <i class="fas fa-user-times mr-1"></i>
            Hapus Akun Secara Permanen
        </button>
    </div>

    <!-- Password Confirmation Modal -->
    @if ($confirmingUserDeletion)
        <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.7);">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Konfirmasi Penghapusan Akun PPLP
                        </h5>
                    </div>
                    <form wire:submit="deleteUser">
                        <div class="modal-body">
                            <!-- Final Warning -->
                            <div class="alert alert-danger">
                                <i class="fas fa-skull-crossbones mr-2"></i>
                                <strong>PERINGATAN TERAKHIR!</strong><br>
                                <small>
                                    Tindakan ini akan menghapus akun atlit PPLP Anda secara permanen dan tidak dapat
                                    dibatalkan.
                                    Semua data akan hilang selamanya.
                                </small>
                            </div>

                            <!-- Account Information -->
                            <div class="card bg-light mb-3">
                                <div class="card-body py-2">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <small class="text-muted">Nama Atlit</small>
                                            <div class="font-weight-bold">{{ auth()->user()->name }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Email</small>
                                            <div class="font-weight-bold">{{ auth()->user()->email }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Bergabung</small>
                                            <div class="font-weight-bold">
                                                {{ auth()->user()->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirmation Checklist -->
                            <div class="mb-3">
                                <label class="font-weight-bold text-danger mb-2">
                                    Konfirmasi dengan mencentang semua kotak berikut:
                                </label>
                                <div class="pl-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" wire:model="confirmations.understand_permanent"
                                            class="form-check-input" id="understand_permanent">
                                        <label class="form-check-label" for="understand_permanent">
                                            <small>Saya memahami bahwa penghapusan ini bersifat permanen dan tidak dapat
                                                dibatalkan</small>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" wire:model="confirmations.backup_data"
                                            class="form-check-input" id="backup_data">
                                        <label class="form-check-label" for="backup_data">
                                            <small>Saya telah membackup semua data penting yang diperlukan</small>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" wire:model="confirmations.informed_coach"
                                            class="form-check-input" id="informed_coach">
                                        <label class="form-check-label" for="informed_coach">
                                            <small>Saya telah menginformasikan pelatih tentang rencana penghapusan akun
                                                ini</small>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" wire:model="confirmations.final_decision"
                                            class="form-check-input" id="final_decision">
                                        <label class="form-check-label" for="final_decision">
                                            <small><strong>Saya yakin 100% ingin menghapus akun atlit PPLP
                                                    ini</strong></small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Type confirmation text -->
                            <div class="form-group">
                                <label for="confirmation_text" class="font-weight-bold text-danger">
                                    Ketik "<strong class="text-uppercase">HAPUS AKUN SAYA</strong>" untuk konfirmasi
                                    final:
                                </label>
                                <input type="text" wire:model="confirmationText" id="confirmation_text"
                                    class="form-control text-center font-weight-bold @error('confirmationText') is-invalid @enderror"
                                    placeholder="Ketik: HAPUS AKUN SAYA" required autocomplete="off">
                                @error('confirmationText')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password confirmation -->
                            <div class="form-group">
                                <label for="password" class="font-weight-bold text-danger">
                                    <i class="fas fa-lock mr-1"></i>
                                    Password Saat Ini <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" wire:model="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password untuk konfirmasi" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePasswordDelete('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Final notice -->
                            <div class="bg-dark text-white p-3 rounded text-center">
                                <i class="fas fa-hourglass-end fa-2x mb-2"></i>
                                <div class="font-weight-bold">Akun akan dihapus dalam 24 jam</div>
                                <small>Setelah konfirmasi, Anda memiliki 24 jam untuk membatalkan penghapusan dengan
                                    menghubungi administrator.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="$set('confirmingUserDeletion', false)"
                                class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>
                                Batalkan
                            </button>
                            <button type="submit" class="btn btn-danger" wire:loading.attr="disabled"
                                :disabled="!$wire.canDelete">
                                <span wire:loading.remove wire:target="deleteUser">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus Akun Sekarang
                                </span>
                                <span wire:loading wire:target="deleteUser">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>
                                    Menghapus...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- JavaScript Functions -->
    <script>
        function confirmDeleteAccount() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    html: `
                        <div class="text-left">
                            <p class="text-muted mb-3">
                                Menghapus akun atlit PPLP akan menghilangkan secara permanen:
                            </p>
                            <ul class="text-muted text-left small">
                                <li>Semua data profil dan prestasi</li>
                                <li>Riwayat latihan dan program</li>
                                <li>Sertifikat dan penghargaan</li>
                                <li>Komunikasi dengan pelatih</li>
                            </ul>
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Tindakan ini tidak dapat dibatalkan!</strong>
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Lanjutkan',
                    cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal-wide'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('confirmUserDeletion');
                    }
                });
            } else {
                // Fallback if SweetAlert not available
                if (confirm(
                        'Apakah Anda yakin ingin menghapus akun PPLP secara permanen? Tindakan ini tidak dapat dibatalkan.'
                    )) {
                    @this.call('confirmUserDeletion');
                }
            }
        }

        function togglePasswordDelete(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.target.closest('button').querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Real-time validation for confirmation text
        document.addEventListener('livewire:init', () => {
            Livewire.on('user-deletion-confirmed', () => {
                setTimeout(() => {
                    const confirmationInput = document.getElementById('confirmation_text');
                    const passwordInput = document.getElementById('password');

                    if (confirmationInput) {
                        confirmationInput.focus();
                    }
                }, 100);
            });

            Livewire.on('user-deleted', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Akun Berhasil Dihapus',
                        text: 'Akun atlit PPLP Anda telah dijadwalkan untuk dihapus. Terima kasih telah menjadi bagian dari PPLP Gorontalo.',
                        confirmButtonText: 'Mengerti',
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.href = '/';
                    });
                } else {
                    alert('Akun berhasil dijadwalkan untuk dihapus. Anda akan diarahkan ke halaman utama.');
                    window.location.href = '/';
                }
            });

            Livewire.on('deletion-error', (event) => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menghapus Akun',
                        text: event[0].message ||
                            'Terjadi kesalahan saat menghapus akun. Silakan hubungi administrator.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        // Auto-format confirmation text
        document.addEventListener('DOMContentLoaded', function() {
            const confirmationInput = document.getElementById('confirmation_text');
            if (confirmationInput) {
                confirmationInput.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            }
        });

        // Handle modal backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
                if (confirm('Apakah Anda yakin ingin membatalkan proses penghapusan akun?')) {
                    @this.call('$set', 'confirmingUserDeletion', false);
                }
            }
        });

        // Handle escape key with confirmation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.querySelector('.modal.show')) {
                if (confirm('Apakah Anda yakin ingin membatalkan proses penghapusan akun?')) {
                    @this.call('$set', 'confirmingUserDeletion', false);
                }
            }
        });
    </script>

    <!-- Custom CSS -->
    <style>
        .modal.show {
            display: block !important;
        }

        .swal-wide {
            width: 600px !important;
        }

        .form-check-input:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .border-danger {
            border-color: #dc3545 !important;
        }

        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .swal-wide {
                width: 95% !important;
            }
        }

        /* Animation for danger elements */
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        .alert-danger {
            animation: pulse-danger 2s infinite;
        }

        @keyframes pulse-danger {
            0% {
                border-color: #dc3545;
            }

            50% {
                border-color: #ff6b7a;
            }

            100% {
                border-color: #dc3545;
            }
        }
    </style>
</div>
