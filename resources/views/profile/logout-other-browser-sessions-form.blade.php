<!-- resources/views/livewire/profile/logout-other-browser-sessions-form.blade.php -->
<div>
    <div class="alert alert-info d-flex align-items-center mb-4">
        <i class="fas fa-laptop fa-2x mr-3"></i>
        <div>
            <strong>Kelola Sesi Login Akun PPLP</strong><br>
            <small>
                Pantau dan kelola semua perangkat yang sedang login ke akun atlit PPLP Anda.
                Logout dari perangkat yang tidak dikenal untuk menjaga keamanan akun.
            </small>
        </div>
    </div>

    <!-- Current Browser Sessions -->
    <div class="mb-4">
        <h6 class="font-weight-bold text-primary mb-3">
            <i class="fas fa-desktop mr-2"></i>
            Sesi Browser Aktif
        </h6>

        <p class="text-muted mb-3">
            Jika diperlukan, Anda dapat logout dari semua sesi browser lain di seluruh perangkat.
            Berikut adalah beberapa sesi terbaru, namun mungkin ada sesi lain yang tidak tercantum.
        </p>

        @if (count($this->sessions) > 0)
            <div class="row">
                @foreach ($this->sessions as $session)
                    <div class="col-md-6 mb-3">
                        <div
                            class="card {{ $session->is_current_device ? 'border-left-success' : 'border-left-info' }} h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="flex-grow-1">
                                        <!-- Device Icon and Info -->
                                        <div class="d-flex align-items-center mb-2">
                                            @if ($session->agent->isDesktop())
                                                <i class="fas fa-desktop text-primary fa-lg mr-2"></i>
                                            @elseif ($session->agent->isTablet())
                                                <i class="fas fa-tablet-alt text-info fa-lg mr-2"></i>
                                            @else
                                                <i class="fas fa-mobile-alt text-success fa-lg mr-2"></i>
                                            @endif

                                            <div>
                                                <h6 class="mb-0 font-weight-bold">
                                                    {{ $session->agent->platform() ?: 'Unknown Platform' }}
                                                    @if ($session->is_current_device)
                                                        <span class="badge badge-success badge-pill ml-1">
                                                            <i class="fas fa-check-circle"></i>
                                                            Perangkat Ini
                                                        </span>
                                                    @endif
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $session->agent->browser() ?: 'Unknown Browser' }}
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Location and IP -->
                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                <strong>IP Address:</strong> {{ $session->ip_address }}
                                            </small>
                                            @if ($session->location)
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-globe mr-1"></i>
                                                    <strong>Lokasi:</strong> {{ $session->location }}
                                                </small>
                                            @endif
                                        </div>

                                        <!-- Last Activity -->
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock mr-1"></i>
                                            <small>
                                                @if ($session->is_current_device)
                                                    <span class="text-success font-weight-bold">Sedang Aktif
                                                        Sekarang</span>
                                                @else
                                                    <strong>Terakhir Aktif:</strong>
                                                    {{ $session->last_active }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Device Type Badge -->
                                    <div class="ml-2">
                                        @if ($session->agent->isDesktop())
                                            <span class="badge badge-primary">Desktop</span>
                                        @elseif ($session->agent->isTablet())
                                            <span class="badge badge-info">Tablet</span>
                                        @else
                                            <span class="badge badge-success">Mobile</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Security Status -->
                                <div class="mt-3 pt-2 border-top">
                                    @if ($session->is_current_device)
                                        <small class="text-success">
                                            <i class="fas fa-shield-alt mr-1"></i>
                                            Sesi ini sedang aktif dan aman
                                        </small>
                                    @else
                                        <small class="text-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Periksa apakah ini perangkat Anda
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-laptop-slash fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Tidak Ada Sesi Lain yang Terdeteksi</h6>
                    <small class="text-muted">
                        Saat ini hanya ada sesi dari perangkat ini yang aktif.
                    </small>
                </div>
            </div>
        @endif
    </div>

    <!-- Security Recommendations -->
    <div class="card border-left-warning mb-4">
        <div class="card-body">
            <h6 class="font-weight-bold text-warning">
                <i class="fas fa-lightbulb mr-2"></i>
                Tips Keamanan untuk Atlit PPLP
            </h6>
            <ul class="mb-0 small text-muted">
                <li class="mb-1">Selalu logout dari perangkat umum atau yang bukan milik Anda</li>
                <li class="mb-1">Periksa sesi login secara rutin, terutama setelah menggunakan komputer umum</li>
                <li class="mb-1">Jika melihat aktivitas mencurigakan, segera ubah password dan aktifkan 2FA</li>
                <li class="mb-1">Gunakan jaringan WiFi yang aman saat login ke akun PPLP</li>
                <li>Laporkan aktivitas mencurigakan kepada administrator PPLP</li>
            </ul>
        </div>
    </div>

    <!-- Logout Other Sessions Actions -->
    <div class="card border-left-danger">
        <div class="card-header bg-danger text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Logout dari Perangkat Lain
            </h6>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">
                <strong>Peringatan:</strong> Tindakan ini akan mengeluarkan Anda dari semua perangkat lain yang sedang
                login.
                Anda perlu login ulang di perangkat tersebut dengan username dan password.
            </p>

            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <small>
                    <strong>Catatan:</strong> Setelah logout dari semua perangkat, Anda akan diminta untuk
                    memasukkan password saat ini sebagai konfirmasi keamanan.
                </small>
            </div>

            <button type="button" onclick="confirmLogoutOtherSessions()" class="btn btn-danger">
                <i class="fas fa-sign-out-alt mr-1"></i>
                Logout dari Semua Perangkat Lain
            </button>
        </div>
    </div>

    <!-- Password Confirmation Modal -->
    @if ($confirmingLogout)
        <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Konfirmasi Keamanan
                        </h5>
                    </div>
                    <form wire:submit="logoutOtherBrowserSessions">
                        <div class="modal-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Konfirmasi Logout</strong><br>
                                <small>
                                    Untuk keamanan, masukkan password akun PPLP Anda untuk mengkonfirmasi
                                    logout dari semua perangkat lain.
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="password" class="font-weight-bold">
                                    <i class="fas fa-lock mr-1"></i>
                                    Password Saat Ini <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" wire:model="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password Anda" required autofocus>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePasswordModal('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Session Info -->
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    <strong>Perangkat ini akan tetap login.</strong><br>
                                    Hanya sesi dari perangkat lain yang akan dikeluarkan.
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="$set('confirmingLogout', false)"
                                class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn btn-danger" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="logoutOtherBrowserSessions">
                                    <i class="fas fa-sign-out-alt mr-1"></i>
                                    Logout Sekarang
                                </span>
                                <span wire:loading wire:target="logoutOtherBrowserSessions">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Success Message -->
    @if (session('status') === 'other-browser-sessions-logged-out')
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <strong>Berhasil!</strong> Semua sesi dari perangkat lain telah dikeluarkan.
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- JavaScript Functions -->
    <script>
        function confirmLogoutOtherSessions() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Logout dari Semua Perangkat Lain?',
                    html: `
                        <p class="text-muted mb-3">
                            Tindakan ini akan mengeluarkan akun PPLP Anda dari semua perangkat lain 
                            yang sedang login (komputer, tablet, ponsel lain).
                        </p>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Perhatian:</strong> Anda perlu login ulang di perangkat tersebut.
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-sign-out-alt mr-1"></i> Ya, Logout',
                    cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('confirmLogout');
                    }
                });
            } else {
                // Fallback if SweetAlert not available
                if (confirm(
                        'Apakah Anda yakin ingin logout dari semua perangkat lain? Anda perlu login ulang di perangkat tersebut.'
                        )) {
                    @this.call('confirmLogout');
                }
            }
        }

        function togglePasswordModal(inputId) {
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

        // Auto-focus password input when modal opens
        document.addEventListener('livewire:init', () => {
            Livewire.on('logout-confirmed', () => {
                setTimeout(() => {
                    const passwordInput = document.getElementById('password');
                    if (passwordInput) {
                        passwordInput.focus();
                    }
                }, 100);
            });

            Livewire.on('other-browser-sessions-logged-out', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Logout Berhasil!',
                        html: `
                            <p>Semua sesi dari perangkat lain telah dikeluarkan.</p>
                            <small class="text-muted">Akun PPLP Anda sekarang lebih aman.</small>
                        `,
                        timer: 4000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            });

            Livewire.on('logout-error', (event) => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Logout',
                        text: event[0].message ||
                            'Terjadi kesalahan saat logout dari perangkat lain.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        // Handle modal backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
                @this.call('$set', 'confirmingLogout', false);
            }
        });

        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.querySelector('.modal.show')) {
                @this.call('$set', 'confirmingLogout', false);
            }
        });

        // Real-time session monitoring (optional enhancement)
        function startSessionMonitoring() {
            // Check for new sessions every 5 minutes
            setInterval(() => {
                @this.call('refreshSessions');
            }, 300000);
        }

        // Initialize session monitoring when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Uncomment the line below if you want real-time session monitoring
            // startSessionMonitoring();
        });
    </script>

    <!-- Custom CSS for Sessions -->
    <style>
        .modal.show {
            display: block !important;
        }

        .card:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
            box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.2);
        }

        .border-left-success {
            border-left: 0.25rem solid #28a745 !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #17a2b8 !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #ffc107 !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #dc3545 !important;
        }

        @media (max-width: 768px) {
            .modal-dialog {
                margin: 1rem;
            }

            .card-body {
                padding: 1rem;
            }
        }
    </style>
</div>
