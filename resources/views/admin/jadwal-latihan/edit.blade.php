@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Latihan</h1>
        <div>
            <a href="{{ route('admin.jadwal-latihan.show', $jadwalLatihan) }}"
                class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                <i class="fas fa-eye fa-sm text-white-50"></i> Detail
            </a>
            <a href="{{ route('admin.jadwal-latihan.index') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Jadwal Latihan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal-latihan.update', $jadwalLatihan) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Baris 1: Nama Kegiatan & Tanggal -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan"
                                value="{{ old('nama_kegiatan', $jadwalLatihan->nama_kegiatan) }}"
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
                                name="tanggal" value="{{ old('tanggal', $jadwalLatihan->tanggal->format('Y-m-d')) }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Tanggal saat ini: {{ $jadwalLatihan->tanggal->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Baris 2: Jam Mulai, Jam Selesai & Lokasi -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror"
                                id="jam_mulai" name="jam_mulai"
                                value="{{ old('jam_mulai', $jadwalLatihan->jam_mulai ? \Carbon\Carbon::parse($jadwalLatihan->jam_mulai)->format('H:i') : '') }}">
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror"
                                id="jam_selesai" name="jam_selesai"
                                value="{{ old('jam_selesai', $jadwalLatihan->jam_selesai ? \Carbon\Carbon::parse($jadwalLatihan->jam_selesai)->format('H:i') : '') }}">
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lokasi">Lokasi Latihan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                                name="lokasi" value="{{ old('lokasi', $jadwalLatihan->lokasi) }}"
                                placeholder="Contoh: GOR Nani Wartabone">
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
                                        {{ old('cabang_olahraga_id', $jadwalLatihan->cabang_olahraga_id) == $cabor->id ? 'selected' : '' }}>
                                        {{ $cabor->nama_cabang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cabang_olahraga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Saat ini: {{ $jadwalLatihan->cabangOlahraga->nama_cabang }}
                            </small>
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
                                        {{ old('pelatih_id', $jadwalLatihan->pelatih_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelatih_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Saat ini: {{ $jadwalLatihan->pelatih->nama }}
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="klub_id">Klub (Opsional)</label>
                            <select class="form-control @error('klub_id') is-invalid @enderror" id="klub_id"
                                name="klub_id">
                                <option value="">Pilih Klub</option>
                                @foreach ($klub as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('klub_id', $jadwalLatihan->klub_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_klub }}
                                    </option>
                                @endforeach
                            </select>
                            @error('klub_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($jadwalLatihan->klub)
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Saat ini: {{ $jadwalLatihan->klub->nama_klub }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Baris 4: Catatan & Status -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="4"
                                placeholder="Catatan khusus untuk latihan ini...">{{ old('catatan', $jadwalLatihan->catatan) }}</textarea>
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
                                <option value="aktif"
                                    {{ old('status', $jadwalLatihan->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="selesai"
                                    {{ old('status', $jadwalLatihan->status) == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                                <option value="dibatalkan"
                                    {{ old('status', $jadwalLatihan->status) == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Status saat ini:
                                <span class="text-capitalize font-weight-bold">{{ $jadwalLatihan->status }}</span>
                            </small>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Informasi Tambahan -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle"></i> Informasi Jadwal
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small>
                                        <strong>Dibuat:</strong> {{ $jadwalLatihan->created_at->format('d/m/Y H:i') }}<br>
                                        <strong>Terakhir diupdate:</strong>
                                        {{ $jadwalLatihan->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    @if ($jadwalLatihan->isExpired())
                                        <div class="text-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <small><strong>Peringatan:</strong> Jadwal ini sudah lewat waktu.</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Jadwal
                    </button>
                    <a href="{{ route('admin.jadwal-latihan.show', $jadwalLatihan) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ route('admin.jadwal-latihan.index') }}" class="btn btn-secondary">
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
                var currentPelatihId = '{{ old('pelatih_id', $jadwalLatihan->pelatih_id) }}';

                // Reset pelatih dropdown
                pelatihSelect.find('option:not(:first)').hide();

                if (caborId) {
                    // Show pelatih yang sesuai dengan cabang olahraga
                    pelatihSelect.find('option[data-cabor="' + caborId + '"]').show();

                    // Jika pelatih saat ini tidak sesuai dengan cabang olahraga yang dipilih, reset
                    var currentPelatihCabor = pelatihSelect.find('option[value="' + currentPelatihId + '"]')
                        .data('cabor');
                    if (currentPelatihCabor != caborId && !pelatihSelect.find('option[value="' +
                            currentPelatihId + '"]:visible').length) {
                        pelatihSelect.val('');
                    }
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

            // Trigger filter pelatih saat halaman dimuat
            $('#cabang_olahraga_id').trigger('change');

            // Konfirmasi jika mengubah status menjadi selesai atau dibatalkan
            $('#status').change(function() {
                var status = $(this).val();
                var originalStatus = '{{ $jadwalLatihan->status }}';

                if (originalStatus !== status) {
                    if (status === 'selesai' || status === 'dibatalkan') {
                        var message = status === 'selesai' ?
                            'Mengubah status menjadi "Selesai" akan menandai jadwal ini sebagai telah selesai dilaksanakan.' :
                            'Mengubah status menjadi "Dibatalkan" akan membatalkan jadwal latihan ini.';

                        if (!confirm(message + ' Apakah Anda yakin?')) {
                            $(this).val(originalStatus);
                        }
                    }
                }
            });
        });

        // Auto hide alerts
        setTimeout(function() {
            $('.alert:not(.alert-info)').fadeOut('slow');
        }, 5000);
    </script>
@endpush
