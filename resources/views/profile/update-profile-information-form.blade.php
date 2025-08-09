<div>
    <form wire:submit="updateProfileInformation">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">
                    <i class="fas fa-user text-primary mr-1"></i>
                    Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input type="text" wire:model="state.name" id="name"
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope text-primary mr-1"></i>
                    Alamat Email <span class="text-danger">*</span>
                </label>
                <input type="email" wire:model="state.email" id="email"
                    class="form-control @error('email') is-invalid @enderror" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                        !auth()->user()->hasVerifiedEmail())
                    <div class="alert alert-warning mt-2 d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <div>
                            <small>
                                Email Anda belum terverifikasi.
                                <button type="button" class="btn btn-link p-0 text-decoration-underline"
                                    wire:click.prevent="sendEmailVerification">
                                    Kirim ulang email verifikasi
                                </button>
                            </small>
                        </div>
                    </div>

                    @if ($this->verificationLinkSent)
                        <div class="alert alert-success mt-2">
                            <small>
                                <i class="fas fa-check-circle mr-1"></i>
                                Link verifikasi baru telah dikirim ke email Anda.
                            </small>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Additional Profile Fields (Custom for PPLP) -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">
                    <i class="fas fa-phone text-primary mr-1"></i>
                    Nomor Telepon
                </label>
                <input type="text" wire:model="state.phone" id="phone"
                    class="form-control @error('phone') is-invalid @enderror" placeholder="Contoh: 081234567890">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="position" class="form-label">
                    <i class="fas fa-id-badge text-primary mr-1"></i>
                    Jabatan/Posisi
                </label>
                <select wire:model="state.position" id="position"
                    class="form-control @error('position') is-invalid @enderror">
                    <option value="">Pilih Jabatan</option>
                    <option value="administrator">Administrator</option>
                    <option value="kepala_pplp">Kepala PPLP</option>
                    <option value="staff_admin">Staff Administrasi</option>
                    <option value="pelatih">Pelatih</option>
                    <option value="dokter">Dokter Olahraga</option>
                    <option value="fisioterapis">Fisioterapis</option>
                    <option value="gizi">Ahli Gizi</option>
                    <option value="psikolog">Psikolog Olahraga</option>
                </select>
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="bio" class="form-label">
                    <i class="fas fa-info-circle text-primary mr-1"></i>
                    Bio/Deskripsi Singkat
                </label>
                <textarea wire:model="state.bio" id="bio" rows="3" class="form-control @error('bio') is-invalid @enderror"
                    placeholder="Ceritakan sedikit tentang diri Anda..."></textarea>
                @error('bio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Maksimal 500 karakter
                </small>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                <small>
                    <i class="fas fa-clock mr-1"></i>
                    Terakhir diperbarui: {{ auth()->user()->updated_at->diffForHumans() }}
                </small>
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="updateProfileInformation">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Perubahan
                    </span>
                    <span wire:loading wire:target="updateProfileInformation">
                        <i class="fas fa-spinner fa-spin mr-1"></i>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('status') === 'profile-information-updated')
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                <strong>Berhasil!</strong> Informasi profil Anda telah diperbarui.
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </form>

    <!-- JavaScript for auto-hide success message -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('profile-updated', () => {
                setTimeout(() => {
                    const alert = document.querySelector('.alert-success');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 300);
                    }
                }, 5000);
            });
        });
    </script>
</div>
