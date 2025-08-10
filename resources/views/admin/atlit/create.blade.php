@extends('layouts.app')

@section('title', 'Tambah Atlit')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Atlit</h1>
            <a href="{{ route('atlit.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Atlit</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('atlit.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Data Pribadi -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Data Pribadi</h5>

                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                            required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nik">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" value="{{ old('nik') }}" maxlength="20"
                                            required>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tempat_lahir">Tempat Lahir <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                    id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                                    required>
                                                @error('tempat_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal_lahir">Tanggal Lahir <span
                                                        class="text-danger">*</span></label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                    id="tanggal_lahir" name="tanggal_lahir"
                                                    value="{{ old('tanggal_lahir') }}" required>
                                                @error('tanggal_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                            id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                            required>{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telepon">Telepon</label>
                                                <input type="text"
                                                    class="form-control @error('telepon') is-invalid @enderror"
                                                    id="telepon" name="telepon" value="{{ old('telepon') }}">
                                                @error('telepon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Jika diisi, akan otomatis dibuatkan akun
                                                    user
                                                    untuk login</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto">Foto Atlit</label>
                                        <input type="file" class="form-control-file @error('foto') is-invalid @enderror"
                                            id="foto" name="foto" accept="image/*">
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Data Olahraga</h5>

                                    <div class="form-group">
                                        <label for="klub_id">Klub <span class="text-danger">*</span></label>
                                        <select class="form-control @error('klub_id') is-invalid @enderror" id="klub_id"
                                            name="klub_id" required>
                                            <option value="">Pilih Klub</option>
                                            @foreach ($klub as $k)
                                                <option value="{{ $k->id }}"
                                                    {{ old('klub_id') == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_klub }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('klub_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cabang_olahraga_id">Cabang Olahraga <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('cabang_olahraga_id') is-invalid @enderror"
                                            id="cabang_olahraga_id" name="cabang_olahraga_id" required>
                                            <option value="">Pilih Cabang Olahraga</option>
                                            @foreach ($cabangOlahraga as $cabor)
                                                <option value="{{ $cabor->id }}"
                                                    {{ old('cabang_olahraga_id') == $cabor->id ? 'selected' : '' }}>
                                                    {{ $cabor->nama_cabang }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cabang_olahraga_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kategori_atlit_id">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control @error('kategori_atlit_id') is-invalid @enderror"
                                            id="kategori_atlit_id" name="kategori_atlit_id" required disabled>
                                            <option value="">Pilih cabang olahraga terlebih dahulu</option>
                                        </select>
                                        @error('kategori_atlit_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="prestasi">Prestasi</label>
                                        <textarea class="form-control @error('prestasi') is-invalid @enderror" id="prestasi" name="prestasi"
                                            rows="4">{{ old('prestasi') }}</textarea>
                                        @error('prestasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="aktif"
                                                {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                                Nonaktif</option>
                                            <option value="pensiun" {{ old('status') == 'pensiun' ? 'selected' : '' }}>
                                                Pensiun</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('atlit.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#cabang_olahraga_id').change(function() {
                    var cabangOlahragaId = $(this).val();
                    var kategoriSelect = $('#kategori_atlit_id');
                    console.log('test');
                    kategoriSelect.html('<option value="">Loading...</option>').prop('disabled', true);

                    if (cabangOlahragaId) {
                        $.get('/api/kategori-atlit/' + cabangOlahragaId, function(data) {
                            kategoriSelect.html('<option value="">Pilih Kategori</option>');

                            $.each(data, function(index, kategori) {
                                kategoriSelect.append('<option value="' + kategori.id + '">' +
                                    kategori.nama_kategori + '</option>');
                            });

                            kategoriSelect.prop('disabled', false);

                            @if (old('kategori_atlit_id'))
                                kategoriSelect.val('{{ old('kategori_atlit_id') }}');
                            @endif
                        });
                    } else {
                        kategoriSelect.html('<option value="">Pilih cabang olahraga terlebih dahulu</option>');
                    }
                });

                // Trigger change jika ada old value
                @if (old('cabang_olahraga_id'))
                    $('#cabang_olahraga_id').trigger('change');
                @endif
            });
        </script>
    @endpush
@endsection
