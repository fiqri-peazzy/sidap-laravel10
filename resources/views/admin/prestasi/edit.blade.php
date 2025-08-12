@extends('layouts.app')

@section('title', 'Edit Prestasi - ' . $prestasi->atlit->nama_lengkap)

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Prestasi Atlet
        </h1>
        <div>
            <a href="{{ route('prestasi.show', $prestasi->id) }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Detail
            </a>
            <a href="{{ route('prestasi.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Prestasi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data"
                id="prestasiForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Data Atlet -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cabang_olahraga_id">Cabang Olahraga <span class="text-danger">*</span></label>
                            <select name="cabang_olahraga_id" id="cabang_olahraga_id"
                                class="form-control @error('cabang_olahraga_id') is-invalid @enderror" required>
                                <option value="">Pilih Cabang Olahraga</option>
                                @foreach ($cabors as $cabor)
                                    <option value="{{ $cabor->id }}"
                                        {{ old('cabang_olahraga_id', $prestasi->cabang_olahraga_id) == $cabor->id ? 'selected' : '' }}>
                                        {{ $cabor->nama_cabang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cabang_olahraga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="atlit_id">Nama Atlet <span class="text-danger">*</span></label>
                            <select name="atlit_id" id="atlit_id"
                                class="form-control @error('atlit_id') is-invalid @enderror" required>
                                <option value="{{ $prestasi->atlit->id }}" selected>
                                    {{ $prestasi->atlit->nama_lengkap }}
                                    @if ($prestasi->atlit->klub)
                                        ({{ $prestasi->atlit->klub->nama_klub }})
                                    @endif
                                </option>
                            </select>
                            @error('atlit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Data Kejuaraan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_kejuaraan">Nama Kejuaraan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kejuaraan" id="nama_kejuaraan"
                                class="form-control @error('nama_kejuaraan') is-invalid @enderror"
                                value="{{ old('nama_kejuaraan', $prestasi->nama_kejuaraan) }}" required
                                placeholder="Contoh: Pekan Olahraga Nasional 2024">
                            @error('nama_kejuaraan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_kejuaraan">Jenis Kejuaraan <span class="text-danger">*</span></label>
                            <select name="jenis_kejuaraan" id="jenis_kejuaraan"
                                class="form-control @error('jenis_kejuaraan') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Kejuaraan</option>
                                <option value="Nasional"
                                    {{ old('jenis_kejuaraan', $prestasi->jenis_kejuaraan) == 'Nasional' ? 'selected' : '' }}>
                                    Nasional</option>
                                <option value="Internasional"
                                    {{ old('jenis_kejuaraan', $prestasi->jenis_kejuaraan) == 'Internasional' ? 'selected' : '' }}>
                                    Internasional</option>
                                <option value="Regional"
                                    {{ old('jenis_kejuaraan', $prestasi->jenis_kejuaraan) == 'Regional' ? 'selected' : '' }}>
                                    Regional</option>
                                <option value="Provinsi"
                                    {{ old('jenis_kejuaraan', $prestasi->jenis_kejuaraan) == 'Provinsi' ? 'selected' : '' }}>
                                    Provinsi</option>
                                <option value="Kabupaten/Kota"
                                    {{ old('jenis_kejuaraan', $prestasi->jenis_kejuaraan) == 'Kabupaten/Kota' ? 'selected' : '' }}>
                                    Kabupaten/Kota</option>
                            </select>
                            @error('jenis_kejuaraan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tingkat_kejuaraan">Tingkat Kejuaraan <span class="text-danger">*</span></label>
                            <input type="text" name="tingkat_kejuaraan" id="tingkat_kejuaraan"
                                class="form-control @error('tingkat_kejuaraan') is-invalid @enderror"
                                value="{{ old('tingkat_kejuaraan', $prestasi->tingkat_kejuaraan) }}" required
                                placeholder="Contoh: PON, POPNAS, SEA Games, Asian Games">
                            @error('tingkat_kejuaraan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tempat_kejuaraan">Tempat Kejuaraan <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_kejuaraan" id="tempat_kejuaraan"
                                class="form-control @error('tempat_kejuaraan') is-invalid @enderror"
                                value="{{ old('tempat_kejuaraan', $prestasi->tempat_kejuaraan) }}" required
                                placeholder="Contoh: Jakarta, Indonesia">
                            @error('tempat_kejuaraan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                value="{{ old('tanggal_mulai', $prestasi->tanggal_mulai->format('Y-m-d')) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                value="{{ old('tanggal_selesai', $prestasi->tanggal_selesai->format('Y-m-d')) }}"
                                required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="number" name="tahun" id="tahun"
                                class="form-control @error('tahun') is-invalid @enderror"
                                value="{{ old('tahun', $prestasi->tahun) }}" min="1900" max="{{ date('Y') + 5 }}"
                                placeholder="Otomatis dari tanggal mulai">
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan untuk otomatis dari tanggal mulai</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomor_pertandingan">Nomor/Kategori Pertandingan</label>
                            <input type="text" name="nomor_pertandingan" id="nomor_pertandingan"
                                class="form-control @error('nomor_pertandingan') is-invalid @enderror"
                                value="{{ old('nomor_pertandingan', $prestasi->nomor_pertandingan) }}"
                                placeholder="Contoh: 100m Putra, Kata Individu Putri">
                            @error('nomor_pertandingan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="peringkat">Peringkat <span class="text-danger">*</span></label>
                            <select name="peringkat" id="peringkat"
                                class="form-control @error('peringkat') is-invalid @enderror" required>
                                <option value="">Pilih Peringkat</option>
                                <option value="1"
                                    {{ old('peringkat', $prestasi->peringkat) == '1' ? 'selected' : '' }}>Juara 1</option>
                                <option value="2"
                                    {{ old('peringkat', $prestasi->peringkat) == '2' ? 'selected' : '' }}>Juara 2</option>
                                <option value="3"
                                    {{ old('peringkat', $prestasi->peringkat) == '3' ? 'selected' : '' }}>Juara 3</option>
                                <option value="4"
                                    {{ old('peringkat', $prestasi->peringkat) == '4' ? 'selected' : '' }}>Peringkat 4
                                </option>
                                <option value="5"
                                    {{ old('peringkat', $prestasi->peringkat) == '5' ? 'selected' : '' }}>Peringkat 5
                                </option>
                                <option value="6"
                                    {{ old('peringkat', $prestasi->peringkat) == '6' ? 'selected' : '' }}>Peringkat 6
                                </option>
                                <option value="7"
                                    {{ old('peringkat', $prestasi->peringkat) == '7' ? 'selected' : '' }}>Peringkat 7
                                </option>
                                <option value="8"
                                    {{ old('peringkat', $prestasi->peringkat) == '8' ? 'selected' : '' }}>Peringkat 8
                                </option>
                                <option value="partisipasi"
                                    {{ old('peringkat', $prestasi->peringkat) == 'partisipasi' ? 'selected' : '' }}>
                                    Partisipasi</option>
                            </select>
                            @error('peringkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medali">Medali</label>
                            <select name="medali" id="medali"
                                class="form-control @error('medali') is-invalid @enderror">
                                <option value="">Tidak Ada</option>
                                <option value="Emas" {{ old('medali', $prestasi->medali) == 'Emas' ? 'selected' : '' }}>
                                    Emas</option>
                                <option value="Perak"
                                    {{ old('medali', $prestasi->medali) == 'Perak' ? 'selected' : '' }}>Perak</option>
                                <option value="Perunggu"
                                    {{ old('medali', $prestasi->medali) == 'Perunggu' ? 'selected' : '' }}>Perunggu
                                </option>
                            </select>
                            @error('medali')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Otomatis berdasarkan peringkat</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sertifikat">Sertifikat/Foto</label>
                            <input type="file" name="sertifikat" id="sertifikat"
                                class="form-control-file @error('sertifikat') is-invalid @enderror"
                                accept="image/*,.pdf">
                            @error('sertifikat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, PDF. Maksimal 5MB</small>

                            @if ($prestasi->sertifikat)
                                <div class="mt-2">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Sertifikat saat ini: <strong>{{ $prestasi->sertifikat }}</strong>
                                        <a href="{{ route('prestasi.download-sertifikat', $prestasi->id) }}"
                                            class="btn btn-sm btn-outline-info ml-2" target="_blank">
                                            <i class="fas fa-download"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror" required>
                                <option value="pending"
                                    {{ old('status', $prestasi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified"
                                    {{ old('status', $prestasi->status) == 'verified' ? 'selected' : '' }}>Terverifikasi
                                </option>
                                <option value="rejected"
                                    {{ old('status', $prestasi->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                        rows="3" placeholder="Keterangan tambahan tentang prestasi ini...">{{ old('keterangan', $prestasi->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Prestasi
                    </button>
                    <a href="{{ route('prestasi.show', $prestasi->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('prestasi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto set tahun dari tanggal mulai
            $('#tanggal_mulai').change(function() {
                if (this.value && !$('#tahun').val()) {
                    var year = new Date(this.value).getFullYear();
                    $('#tahun').val(year);
                }
            });

            // Auto set medali berdasarkan peringkat
            $('#peringkat').change(function() {
                var peringkat = this.value;
                var medalSelect = $('#medali');

                // Only auto-set if current medali is empty
                if (!medalSelect.val()) {
                    if (peringkat == '1') {
                        medalSelect.val('Emas');
                    } else if (peringkat == '2') {
                        medalSelect.val('Perak');
                    } else if (peringkat == '3') {
                        medalSelect.val('Perunggu');
                    }
                }
            });

            // Load atlit berdasarkan cabor
            $('#cabang_olahraga_id').change(function() {
                var caborId = this.value;
                var atlitSelect = $('#atlit_id');
                var currentAtlitId = '{{ $prestasi->atlit_id }}';

                if (caborId) {
                    atlitSelect.prop('disabled', true).html('<option value="">Loading...</option>');

                    $.ajax({
                        url: '{{ route('prestasi.api.atlit-by-cabor') }}',
                        method: 'GET',
                        data: {
                            cabor_id: caborId
                        },
                        success: function(data) {
                            var options = '<option value="">Pilih Atlet</option>';

                            $.each(data, function(index, atlit) {
                                var selected = (atlit.id == currentAtlitId) ?
                                    'selected' : '';
                                options += '<option value="' + atlit.id + '" ' +
                                    selected + '>';
                                options += atlit.nama_lengkap;
                                if (atlit.klub) {
                                    options += ' (' + atlit.klub.nama_klub + ')';
                                }
                                options += '</option>';
                            });

                            atlitSelect.html(options).prop('disabled', false);

                            // Set old value if exists
                            @if (old('atlit_id'))
                                atlitSelect.val('{{ old('atlit_id') }}');
                            @endif
                        },
                        error: function() {
                            atlitSelect.html('<option value="">Error loading data</option>')
                                .prop('disabled', false);
                        }
                    });
                } else {
                    atlitSelect.html('<option value="">Pilih cabang olahraga terlebih dahulu</option>')
                        .prop('disabled', true);
                }
            });

            // Load atlit on page load if cabor is selected
            $('#cabang_olahraga_id').trigger('change');

            // Validate tanggal selesai
            $('#tanggal_selesai').change(function() {
                var tanggalMulai = new Date($('#tanggal_mulai').val());
                var tanggalSelesai = new Date(this.value);

                if (tanggalSelesai < tanggalMulai) {
                    alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai');
                    this.value = '';
                }
            });

            // Form validation
            $('#prestasiForm').submit(function(e) {
                var tanggalMulai = $('#tanggal_mulai').val();
                var tanggalSelesai = $('#tanggal_selesai').val();

                if (tanggalMulai && tanggalSelesai) {
                    if (new Date(tanggalSelesai) < new Date(tanggalMulai)) {
                        e.preventDefault();
                        alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai');
                        return false;
                    }
                }
            });
        });
    </script>
@endpush
