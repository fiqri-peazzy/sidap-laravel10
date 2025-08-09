<!-- resources/views/livewire/profile/update-password-form.blade.php -->
<div>
    <form wire:submit="updatePassword">
        <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="fas fa-info-circle fa-2x mr-3"></i>
            <div>
                <strong>Keamanan Password</strong><br>
                <small>
                    Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.
                    Gunakan kombinasi huruf besar, kecil, angka, dan simbol.
                </small>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="current_password" class="form-label">
                    <i class="fas fa-lock text-warning mr-1"></i>
                    Password Saat Ini <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <input type="password" wire:model="state.current_password" id="current_password"
                        class="form-control @error('current_password') is-invalid @enderror" required
                        autocomplete="current-password">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('current_password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-key text-success mr-1"></i>
                    Password Baru <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <input type="password" wire:model="state.password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required
                        autocomplete="new-password">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Strength Indicator -->
                <div class="mt-2" wire:ignore>
                    <div id="password-strength" style="display: none;">
                        <div class="progress" style="height: 5px;">
                            <div id="strength-bar" class="progress-bar" style="width: 0%"></div>
                        </div>
                        <small id="strength-text" class="text-muted"></small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-check-double text-success mr-1"></i>
                    Konfirmasi Password Baru <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <input type="password" wire:model="state.password_confirmation" id="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror" required
                        autocomplete="new-password">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Password Requirements -->
        <div class="card bg-light border-0 mb-3">
            <div class="card-body py-2">
                <small class="text-muted">
                    <strong>Syarat Password:</strong>
                </small>
                <ul class="small text-muted mb-0 mt-1">
                    <li>Minimal 8 karakter</li>
                    <li>Mengandung huruf besar dan kecil</li>
                    <li>Mengandung minimal 1 angka</li>
                    <li>Mengandung minimal 1 simbol (!@#$%^&*)</li>
                </ul>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                <small>
                    <i class="fas fa-history mr-1"></i>
                    Password terakhir diubah:
                    {{ auth()->user()->updated_at->diffForHumans() }}
                </small>
            </div>

            <div>
                <button type="button" class="btn btn-secondary mr-2"
                    onclick="this.closest('form').reset(); window.livewire.find('{{ $this->getId() }}').call('$refresh')">
                    <i class="fas fa-undo mr-1"></i>
                    Reset
                </button>

                <button type="submit" class="btn btn-warning" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="updatePassword">
                        <i class="fas fa-key mr-1"></i>
                        Ubah Password
                    </span>
                    <span wire:loading wire:target="updatePassword">
                        <i class="fas fa-spinner fa-spin mr-1"></i>
                        Memperbarui...
                    </span>
                </button>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-shield-alt mr-2"></i>
                <strong>Berhasil!</strong> Password Anda telah berhasil diperbarui.
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </form>

    <!-- JavaScript for password functionality -->
    <script>
        function togglePassword(inputId) {
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

        // Password strength checker
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const strengthDiv = document.getElementById('password-strength');
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');

            passwordInput.addEventListener('input', function() {
                const password = this.value;

                if (password.length === 0) {
                    strengthDiv.style.display = 'none';
                    return;
                }

                strengthDiv.style.display = 'block';

                let strength = 0;
                let feedback = '';

                // Length check
                if (password.length >= 8) strength += 25;

                // Uppercase letter
                if (/[A-Z]/.test(password)) strength += 25;

                // Lowercase letter  
                if (/[a-z]/.test(password)) strength += 25;

                // Numbers
                if (/\d/.test(password)) strength += 15;

                // Special characters
                if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 10;

                // Set progress bar
                strengthBar.style.width = strength + '%';

                // Set color and text based on strength
                if (strength < 30) {
                    strengthBar.className = 'progress-bar bg-danger';
                    feedback = 'Lemah - Tambahkan karakter lagi';
                } else if (strength < 60) {
                    strengthBar.className = 'progress-bar bg-warning';
                    feedback = 'Sedang - Bisa ditingkatkan';
                } else if (strength < 80) {
                    strengthBar.className = 'progress-bar bg-info';
                    feedback = 'Baik - Hampir sempurna';
                } else {
                    strengthBar.className = 'progress-bar bg-success';
                    feedback = 'Sangat Kuat - Password aman';
                }

                strengthText.textContent = feedback;
            });
        });

        // Livewire events for PPLP notifications
        document.addEventListener('livewire:init', () => {
            Livewire.on('password-updated', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Berhasil Diubah!',
                        text: 'Password akun PPLP Anda telah berhasil diperbarui.',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            });
        });
    </script>
</div>
