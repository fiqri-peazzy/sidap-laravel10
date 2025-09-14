<div>
    <!-- Loading Indicator -->
    <div wire:loading class="text-center">
        <div class="spinner-border text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Main Content -->
    <div wire:loading.remove>
        <div class="row">
            <!-- Foto Profil Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-success">Foto Profil</h6>
                        <div class="dropdown no-arrow">
                            <button type="button" class="btn btn-sm btn-outline-success" wire:click="toggleEdit('foto')">
                                <i class="fas fa-pencil-alt fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if($atlit->foto)
                                <img src="{{ Storage::url('atlit/foto/' . $atlit->foto) }}" 
                                     alt="Foto {{ $atlit->nama_lengkap }}" 
                                     class="img-fluid rounded-circle" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-gray-300 rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x text-gray-600"></i>
                                </div>
                            @endif
                        </div>

                        @if($editingFoto)
                            <div class="mt-3">
                                <form wire:submit.prevent="updateFoto">
                                    <div class="form-group">
                                        <input type="file" wire:model="fotoTemp" class="form-control-file" accept="image/*">
                                        @error('fotoTemp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                    <!-- Preview foto baru -->
                                    @if($fotoTemp)
                                        <div class="mb-2">
                                            <img src="{{ $fotoTemp->temporaryUrl() }}" 
                                                 alt="Preview" 
                                                 class="img-fluid rounded-circle" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                    @endif

                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-success btn-sm" 
                                                wire:loading.attr="disabled" 
                                                wire:target="updateFoto">
                                            <i class="fas fa-save fa-sm mr-1"></i>Simpan
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" 
                                                wire:click="toggleEdit('foto')">
                                            <i class="fas fa-times fa-sm mr-1"></i>Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Data Profil Card -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Data Profil</h6>
                    </div>
                    <div class="card-body">
                        <!-- Email Warning -->
                        @if($showEmailWarning)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle fa-fw mr-2"></i>
                                <strong>Perhatian!</strong> Perubahan email akan mempengaruhi email login Anda.
                                <button type="button" class="close" wire:click="$set('showEmailWarning', false)">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <!-- Data yang TIDAK bisa diubah -->
                                    <tr>
                                        <td class="font-weight-bold" style="width: 200px;">Nama Lengkap</td>
                                        <td>{{ $atlit->nama_lengkap }}</td>
                                        <td width="50"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">NIK</td>
                                        <td>{{ $atlit->nik }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tempat Lahir</td>
                                        <td>{{ $atlit->tempat_lahir }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tanggal Lahir</td>
                                        <td>{{ $atlit->tanggal_lahir->format('d F Y') }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Jenis Kelamin</td>
                                        <td>{{ $atlit->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Klub</td>
                                        <td>{{ $atlit->klub->nama_klub ?? '-' }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Cabang Olahraga</td>
                                        <td>{{ $atlit->cabangOlahraga->nama_cabang ?? '-' }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Kategori Atlit</td>
                                        <td>{{ $atlit->kategoriAtlit->nama_kategori ?? '-' }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Status</td>
                                        <td>
                                            <span class="badge badge-{{ $atlit->status === 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($atlit->status) }}
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <!-- Data yang BISA diubah -->
                                    
                                    <!-- Alamat -->
                                    <tr>
                                        <td class="font-weight-bold">Alamat</td>
                                        <td>
                                            @if($editingAlamat)
                                                <form wire:submit.prevent="updateField('alamat')">
                                                    <div class="input-group">
                                                        <textarea wire:model="alamat" 
                                                                class="form-control @error('alamat') is-invalid @enderror" 
                                                                rows="3" 
                                                                placeholder="Masukkan alamat lengkap"></textarea>
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fas fa-save"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-secondary btn-sm" 
                                                                    wire:click="toggleEdit('alamat')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @error('alamat')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </form>
                                            @else
                                                {{ $atlit->alamat ?: '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$editingAlamat)
                                                <button type="button" class="btn btn-sm btn-outline-success" 
                                                        wire:click="toggleEdit('alamat')">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Telepon -->
                                    <tr>
                                        <td class="font-weight-bold">Telepon</td>
                                        <td>
                                            @if($editingTelepon)
                                                <form wire:submit.prevent="updateField('telepon')">
                                                    <div class="input-group">
                                                        <input type="text" 
                                                               wire:model="telepon" 
                                                               class="form-control @error('telepon') is-invalid @enderror" 
                                                               placeholder="Nomor telepon">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fas fa-save"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-secondary btn-sm" 
                                                                    wire:click="toggleEdit('telepon')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @error('telepon')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </form>
                                            @else
                                                {{ $atlit->telepon ?: '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$editingTelepon)
                                                <button type="button" class="btn btn-sm btn-outline-success" 
                                                        wire:click="toggleEdit('telepon')">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Email -->
                                    <tr>
                                        <td class="font-weight-bold">Email</td>
                                        <td>
                                            @if($editingEmail)
                                                <form wire:submit.prevent="updateField('email')">
                                                    <div class="input-group">
                                                        <input type="email" 
                                                               wire:model="email" 
                                                               class="form-control @error('email') is-invalid @enderror" 
                                                               placeholder="Alamat email">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fas fa-save"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-secondary btn-sm" 
                                                                    wire:click="toggleEdit('email')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </form>
                                            @else
                                                {{ $atlit->email ?: '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$editingEmail)
                                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                                        wire:click="toggleEdit('email')" 
                                                        title="Perubahan email akan mempengaruhi email login">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>