@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Latihan</h1>
        <a href="{{ route('jadwal-latihan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Jadwal Latihan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal-latihan.store') }}" method="POST">
                @csrf

                <!-- Baris 1: Nama Kegiatan & Tanggal -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                                placeholder="Contoh: Latihan Rutin Bulutangkis">
                            @error('nama_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Latihan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                                name="tanggal" value="{{ old('tanggal') }}" min="{{ date('Y-m-d') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Baris 2: Jam Mulai, Jam Selesai & Lokasi -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror"
                                id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}">
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror"
                                id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}">
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lokasi">Lokasi Latihan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                                name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: GOR Nani Wartabone">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Baris 3: Cabang Olahraga, Pelatih & Klub -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cabang_olahraga_id">Cabang Olahraga <span class="text-danger">*</span></label>
                            <select class="form-control @error('cabang_olahraga_id') is-invalid @enderror"
                                id="cabang_olahraga_id" name="cabang_olahraga_id">
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
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pelatih_id">Pelatih <span class="text-danger">*</span></label>
                            <select class="form-control @error('pelatih_id') is-invalid @enderror" id="pelatih_id"
                                name="pelatih_id">
                                <option value="">Pilih Pelatih</option>
                                @foreach ($pelatih as $p)
                                    <option value="{{ $p->id }}" data-cabor="{{ $p->cabang_olahraga_id }}"
                                        {{ old('pelatih_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelatih_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="klub_id">Klub (Opsional)</label>
                            <select class="form-control @error('klub_id') is-invalid @enderror" id="klub_id"
                                name="klub_id">
                                <option value="">Pilih Klub</option>
                                @foreach ($klub as $k)
                                    <option value="{{ $k->id }}" {{ old('klub_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_klub }}
                                    </option>
                                @endforeach
                            </select>
                            @error('klub_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Baris 4: Catatan & Status -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                                placeholder="Catatan khusus untuk latihan ini...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status">
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Tombol Submit -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Jadwal
                    </button>
                    <a href="{{ route('jadwal-latihan.index') }}" class="btn btn-secondary">
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
            // Filter pelatih berdasarkan cabang olahraga
            $('#cabang_olahraga_id').change(function() {
                var caborId = $(this).val();
                var pelatihSelect = $('#pelatih_id');

                // Reset pelatih dropdown
                pelatihSelect.find('option:not(:first)').hide();
                pelatihSelect.val('');

                if (caborId) {
                    // Show pelatih yang sesuai dengan cabang olahraga
                    pelatihSelect.find('option[data-cabor="' + caborId + '"]').show();
                } else {
                    // Show all pelatih if no cabor selected
                    pelatihSelect.find('option').show();
                }
            });

            // Validasi jam selesai harus lebih besar dari jam mulai
            $('#jam_selesai').change(function() {
                var jamMulai = $('#jam_mulai').val();
                var jamSelesai = $(this).val();

                if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                    alert('Jam selesai harus lebih besar dari jam mulai!');
                    $(this).val('');
                }
            });

            // Validasi jam mulai ketika diubah
            $('#jam_mulai').change(function() {
                var jamMulai = $(this).val();
                var jamSelesai = $('#jam_selesai').val();

                if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                    alert('Jam mulai harus lebih kecil dari jam selesai!');
                    $('#jam_selesai').val('');
                }
            });

            // Set default jam mulai dan selesai jika kosong
            if (!$('#jam_mulai').val()) {
                $('#jam_mulai').val('08:00');
            }
            if (!$('#jam_selesai').val()) {
                $('#jam_selesai').val('10:00');
            }

            // Trigger filter pelatih saat halaman dimuat jika ada old value
            if ($('#cabang_olahraga_id').val()) {
                $('#cabang_olahraga_id').trigger('change');
            }
        });
    </script>
@endpush
