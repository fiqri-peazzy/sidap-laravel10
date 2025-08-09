<!-- resources/views/livewire/profile/two-factor-authentication-form.blade.php -->
<div>
    <div class="alert alert-warning d-flex align-items-center mb-4">
        <i class="fas fa-shield-alt fa-2x mr-3"></i>
        <div>
            <strong>Keamanan Tingkat Tinggi untuk Atlit PPLP</strong><br>
            <small>
                Two-Factor Authentication (2FA) memberikan lapisan keamanan tambahan untuk akun atlit PPLP Gorontalo.
                Sangat direkomendasikan untuk melindungi data pribadi dan prestasi Anda.
            </small>
        </div>
    </div>

    @if (!auth()->user()->two_factor_secret)
        <!-- Enable Two Factor Authentication -->
        <div class="mb-4">
            <h5 class="font-weight-bold text-primary mb-3">
                <i class="fas fa-plus-circle mr-2"></i>
                Aktifkan Two-Factor Authentication
            </h5>

            <p class="text-muted mb-3">
                Ketika 2FA diaktifkan, Anda akan diminta untuk memasukkan token keamanan selain password saat login.
                Token dapat diperoleh dari aplikasi authenticator di ponsel Anda seperti Google Authenticator atau
                Authy.
            </p>

            <div class="card border-left-success">
                <div class="card-body">
                    <h6 class="text-success font-weight-bold">
                        <i class="fas fa-mobile-alt mr-1"></i>
                        Aplikasi yang Direkomendasikan:
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <i class="fab fa-google text-danger mr-2"></i>
                            <strong>Google Authenticator</strong> - Gratis dan mudah digunakan
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-lock text-primary mr-2"></i>
                            <strong>Authy</strong> - Mendukung backup dan sync
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-key text-success mr-2"></i>
                            <strong>Microsoft Authenticator</strong> - Terintegrasi dengan Microsoft
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                <button type="button" wire:click="enableTwoFactorAuthentication" wire:loading.attr="disabled"
                    class="btn btn-success">
                    <span wire:loading.remove wire:target="enableTwoFactorAuthentication">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Aktifkan 2FA
                    </span>
                    <span wire:loading wire:target="enableTwoFactorAuthentication">
                        <i class="fas fa-spinner fa-spin mr-1"></i>
                        Mengaktifkan...
                    </span>
                </button>
            </div>
        </div>
    @endif

    @if (auth()->user()->two_factor_secret)
        <!-- Two Factor Authentication is Enabled -->
        <div class="mb-4">
            <div class="alert alert-success d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x mr-3"></i>
                <div>
                    <strong>Two-Factor Authentication Aktif</strong><br>
                    <small>Akun atlit PPLP Anda telah dilindungi dengan keamanan 2FA.</small>
                </div>
            </div>
        </div>

        @if (session('status') === 'two-factor-authentication-enabled')
            <!-- Show QR Code and Recovery Codes -->
            <div class="row">
                <!-- QR Code Section -->
                <div class="col-md-6 mb-4">
                    <div class="card border-left-primary h-100">
                        <div class="card-header bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-qrcode mr-2"></i>
                                Langkah 1: Scan QR Code
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted mb-3">
                                Buka aplikasi authenticator dan scan QR code di bawah ini:
                            </p>

                            <div class="mb-3">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>

                            <div class="alert alert-info">
                                <small>
                                    <strong>Manual Entry:</strong><br>
                                    Jika tidak bisa scan QR code, masukkan kode ini secara manual:
                                    <br>
                                    <code class="text-primary">{{ decrypt(auth()->user()->two_factor_secret) }}</code>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recovery Codes Section -->
                <div class="col-md-6 mb-4">
                    <div class="card border-left-warning h-100">
                        <div class="card-header bg-warning text-white">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-key mr-2"></i>
                                Langkah 2: Simpan Recovery Codes
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                <strong>PENTING:</strong> Simpan recovery codes berikut di tempat yang aman.
                                Codes ini bisa digunakan jika Anda kehilangan akses ke aplikasi authenticator.
                            </p>

                            <div class="bg-light p-3 rounded mb-3">
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                    <code class="d-block mb-1 text-danger font-weight-bold">{{ $code }}</code>
                                @endforeach
                            </div>

                            <button type="button" onclick="downloadRecoveryCodes()"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download mr-1"></i>
                                Download Codes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmation Step -->
            <div class="card border-left-success mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-check-circle mr-2"></i>
                        Langkah 3: Verifikasi Setup
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Untuk memastikan 2FA berfungsi dengan baik, masukkan kode dari aplikasi authenticator Anda:
                    </p>

                    <form wire:submit="confirmTwoFactorAuthentication">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" wire:model="confirmingTwoFactor.code"
                                        class="form-control text-center @error('confirmingTwoFactor.code') is-invalid @enderror"
                                        placeholder="Masukkan 6 digit kode" maxlength="6" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="confirmTwoFactorAuthentication">
                                                <i class="fas fa-check mr-1"></i>
                                                Verifikasi
                                            </span>
                                            <span wire:loading wire:target="confirmTwoFactorAuthentication">
                                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                                Verifikasi...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                @error('confirmingTwoFactor.code')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if (session('status') === 'two-factor-authentication-confirmed')
            <!-- 2FA Successfully Configured -->
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-shield-check mr-2"></i>
                <strong>Selamat!</strong> Two-Factor Authentication berhasil dikonfigurasi untuk akun atlit PPLP Anda.
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <!-- Management Options -->
        <div class="row">
            <!-- Regenerate Recovery Codes -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-sync-alt fa-2x text-info mb-3"></i>
                        <h6 class="font-weight-bold">Regenerate Recovery Codes</h6>
                        <p class="text-muted small">
                            Buat ulang recovery codes jika codes lama sudah digunakan atau hilang.
                        </p>
                        <button type="button" wire:click="regenerateRecoveryCodes"
                            wire:confirm="Apakah Anda yakin ingin membuat recovery codes baru? Codes lama akan tidak berlaku."
                            wire:loading.attr="disabled" class="btn btn-info btn-sm">
                            <span wire:loading.remove wire:target="regenerateRecoveryCodes">
                                <i class="fas fa-sync-alt mr-1"></i>
                                Regenerate Codes
                            </span>
                            <span wire:loading wire:target="regenerateRecoveryCodes">
                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Show Recovery Codes -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-eye fa-2x text-warning mb-3"></i>
                        <h6 class="font-weight-bold">Lihat Recovery Codes</h6>
                        <p class="text-muted small">
                            Tampilkan recovery codes yang saat ini aktif untuk akun Anda.
                        </p>
                        <button type="button" wire:click="showRecoveryCodes" wire:loading.attr="disabled"
                            class="btn btn-warning btn-sm">
                            <span wire:loading.remove wire:target="showRecoveryCodes">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat Codes
                            </span>
                            <span wire:loading wire:target="showRecoveryCodes">
                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                Memuat...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show Recovery Codes Modal Content -->
        @if ($showingRecoveryCodes)
            <div class="card border-left-warning mt-4">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-key mr-2"></i>
                        Recovery Codes Aktif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian!</strong> Simpan codes ini di tempat yang aman dan jangan bagikan kepada
                        siapapun.
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                            <code class="d-block mb-1 text-danger font-weight-bold">{{ $code }}</code>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" onclick="downloadRecoveryCodes()"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download mr-1"></i>
                            Download Codes
                        </button>

                        <button type="button" wire:click="$set('showingRecoveryCodes', false)"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times mr-1"></i>
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Disable Two Factor Authentication -->
        <div class="card border-left-danger mt-4">
            <div class="card-header bg-danger text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Nonaktifkan Two-Factor Authentication
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    <strong>Peringatan:</strong> Menonaktifkan 2FA akan mengurangi keamanan akun atlit PPLP Anda.
                    Hanya lakukan jika benar-benar diperlukan.
                </p>

                <button type="button" wire:click="disableTwoFactorAuthentication"
                    wire:confirm="Apakah Anda yakin ingin menonaktifkan Two-Factor Authentication? Hal ini akan mengurangi keamanan akun Anda."
                    wire:loading.attr="disabled" class="btn btn-danger">
                    <span wire:loading.remove wire:target="disableTwoFactorAuthentication">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Nonaktifkan 2FA
                    </span>
                    <span wire:loading wire:target="disableTwoFactorAuthentication">
                        <i class="fas fa-spinner fa-spin mr-1"></i>
                        Menonaktifkan...
                    </span>
                </button>
            </div>
        </div>
    @endif

    <!-- JavaScript Functions -->
    <script>
        // Download recovery codes as text file
        function downloadRecoveryCodes() {
            const codes = [
                @if (auth()->user()->two_factor_recovery_codes)
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                        "{{ $code }}",
                    @endforeach
                @endif
            ];

            const content = `PPLP Gorontalo - Two-Factor Authentication Recovery Codes
========================================================

PENTING: Simpan codes ini dengan aman!
- Jangan bagikan kepada siapapun
- Gunakan hanya jika kehilangan akses ke aplikasi authenticator
- Setiap code hanya bisa digunakan satu kali

Recovery Codes:
${codes.map((code, index) => `${index + 1}. ${code}`).join('\n')}

Tanggal Download: ${new Date().toLocaleString('id-ID')}
Akun: ${@json(auth()->user()->name)} (${@json(auth()->user()->email)})

Untuk keamanan maksimal:
1. Print dokumen ini dan simpan di tempat aman
2. Atau simpan di password manager Anda
3. Jangan simpan di cloud storage yang tidak terenkripsi

© PPLP Provinsi Gorontalo`;

            const blob = new Blob([content], {
                type: 'text/plain'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `PPLP-Recovery-Codes-${new Date().getTime()}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            // Show success message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Recovery Codes Berhasil Didownload!',
                    text: 'Simpan file dengan aman dan jangan bagikan kepada siapapun.',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        }

        // Auto-format 2FA code input
        document.addEventListener('DOMContentLoaded', function() {
            const codeInputs = document.querySelectorAll('input[wire\\:model*="confirmingTwoFactor.code"]');

            codeInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Auto-submit when 6 digits entered
                    if (this.value.length === 6) {
                        const form = this.closest('form');
                        if (form) {
                            setTimeout(() => {
                                form.dispatchEvent(new Event('submit', {
                                    bubbles: true
                                }));
                            }, 500);
                        }
                    }
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const numbers = paste.replace(/[^0-9]/g, '').substring(0, 6);
                    this.value = numbers;

                    // Trigger input event
                    this.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                });
            });
        });

        // Livewire events for notifications
        document.addEventListener('livewire:init', () => {
            Livewire.on('two-factor-enabled', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: '2FA Berhasil Diaktifkan!',
                        text: 'Two-Factor Authentication telah diaktifkan untuk akun PPLP Anda. Ikuti langkah selanjutnya untuk menyelesaikan konfigurasi.',
                        confirmButtonColor: '#28a745'
                    });
                }
            });

            Livewire.on('two-factor-disabled', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: '2FA Telah Dinonaktifkan',
                        text: 'Two-Factor Authentication telah dinonaktifkan dari akun PPLP Anda. Akun Anda sekarang kurang aman.',
                        confirmButtonColor: '#ffc107'
                    });
                }
            });

            Livewire.on('recovery-codes-regenerated', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Recovery Codes Baru Telah Dibuat',
                        text: 'Recovery codes lama sudah tidak berlaku. Simpan codes baru dengan aman.',
                        confirmButtonColor: '#17a2b8'
                    });
                }
            });

            Livewire.on('two-factor-confirmed', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Verifikasi Berhasil!',
                        text: 'Two-Factor Authentication berhasil dikonfigurasi dan siap digunakan.',
                        timer: 4000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            });
        });
    </script>
</div>
