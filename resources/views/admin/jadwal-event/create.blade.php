@extends('layouts.app')

@section('title', 'Tambah Jadwal Event')

@push('styles')
    <style>
        .form-section {
            background: #f8f9fc;
            border-radius: 0.35rem;
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-section h6 {
            color: #5a5c69;
            font-weight: 700;
            margin-bottom: 15px;
            border-bottom: 1px solid #e3e6f0;
            padding-bottom: 10px;
        }

        .required {
            color: #e74a3b;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Event</h1>
            <a href="{{ route('jadwal-event.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <form action="{{ route('jadwal-event.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <!-- Informasi Event -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Event</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama_event">Nama Event <span class="required">*</span></label>
                                        <input type="text" name="nama_event" id="nama_event"
                                            class="form-control @error('nama_event') is-invalid @enderror"
                                            value="{{ old('nama_event') }}" required>
                                        @error('nama_event')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_event">Jenis Event <span class="required">*</span></label>
                                        <select name="jenis_event" id="jenis_event"
                                            class="form-control @error('jenis_event') is-invalid @enderror" required>
                                            <option value="">Pilih Jenis Event</option>
                                            <option value="pertandingan"
                                                {{ old('jenis_event') == 'pertandingan' ? 'selected' : '' }}>Pertandingan
                                            </option>
                                            <option value="seleksi" {{ old('jenis_event') == 'seleksi' ? 'selected' : '' }}>
                                                Seleksi</option>
                                            <option value="uji_coba"
                                                {{ old('jenis_event') == 'uji_coba' ? 'selected' : '' }}>Uji Coba</option>
                                            <option value="kejuaraan"
                                                {{ old('jenis_event') == 'kejuaraan' ? 'selected' : '' }}>Kejuaraan</option>
                                        </select>
                                        @error('jenis_event')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cabang_olahraga_id">Cabang Olahraga <span
                                                class="required">*</span></label>
                                        <select name="cabang_olahraga_id" id="cabang_olahraga_id"
                                            class="form-control @error('cabang_olahraga_id') is-invalid @enderror" required>
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
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_mulai">Tanggal Mulai <span class="required">*</span></label>
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                            class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                            value="{{ old('tanggal_mulai') }}" required>
                                        @error('tanggal_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_selesai">Tanggal Selesai <span class="required">*</span></label>
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                            class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                            value="{{ old('tanggal_selesai') }}" required>
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lokasi">Lokasi <span class="required">*</span></label>
                                        <input type="text" name="lokasi" id="lokasi"
                                            class="form-control @error('lokasi') is-invalid @enderror"
                                            value="{{ old('lokasi') }}" required>
                                        @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="penyelenggara">Penyelenggara <span class="required">*</span></label>
                                        <input type="text" name="penyelenggara" id="penyelenggara"
                                            class="form-control @error('penyelenggara') is-invalid @enderror"
                                            value="{{ old('penyelenggara') }}" required>
                                        @error('penyelenggara')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Status dan Atlet -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Event</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">Status <span class="required">*</span></label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Atlet Peserta -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Atlet Peserta</h6>
                        </div>
                        <div class="card-body">
                            <div id="atlit-container">
                                <p class="text-muted text-center">
                                    <i class="fas fa-info-circle"></i>
                                    Pilih cabang olahraga terlebih dahulu
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Simpan Event
                                </button>
                                <a href="{{ route('jadwal-event.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const caborSelect = document.getElementById('cabang_olahraga_id');
            const atlitContainer = document.getElementById('atlit-container');
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            tanggalMulai.min = today;
            tanggalSelesai.min = today;

            // Update tanggal selesai minimum when tanggal mulai changes
            tanggalMulai.addEventListener('change', function() {
                tanggalSelesai.min = this.value;
                if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                    tanggalSelesai.value = this.value;
                }
            });

            // Load athletes when cabang olahraga changes
            caborSelect.addEventListener('change', function() {
                const caborId = this.value;

                if (caborId) {
                    loadAtlit(caborId);
                } else {
                    atlitContainer.innerHTML = `
                <p class="text-muted text-center">
                    <i class="fas fa-info-circle"></i> 
                    Pilih cabang olahraga terlebih dahulu
                </p>
            `;
                }
            });

            function loadAtlit(caborId) {
                atlitContainer.innerHTML = `
            <div class="text-center">
                <i class="fas fa-spinner fa-spin"></i> 
                Memuat data atlet...
            </div>
        `;

                fetch(`/api/atlit/by-cabor/${caborId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            let html = '<div class="form-group">';
                            html += '<label>Pilih Atlet:</label>';
                            html +=
                                '<div style="max-height: 200px; overflow-y: auto; border: 1px solid #d1d3e2; padding: 10px; border-radius: 0.35rem;">';

                            data.forEach(atlit => {
                                html += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       name="atlit_ids[]" value="${atlit.id}" 
                                       id="atlit_${atlit.id}">
                                <label class="form-check-label" for="atlit_${atlit.id}">
                                    ${atlit.nama_lengkap}
                                </label>
                            </div>
                        `;
                            });

                            html += '</div>';
                            html +=
                                '<small class="text-muted">Centang atlet yang akan mengikuti event ini</small>';
                            html += '</div>';

                            atlitContainer.innerHTML = html;
                        } else {
                            atlitContainer.innerHTML = `
                        <p class="text-muted text-center">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Tidak ada atlet aktif di cabang olahraga ini
                        </p>
                    `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        atlitContainer.innerHTML = `
                    <p class="text-danger text-center">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Gagal memuat data atlet
                    </p>
                `;
                    });
            }

            // Load athletes if cabang olahraga already selected (for old input)
            if (caborSelect.value) {
                loadAtlit(caborSelect.value);
            }
        });
    </script>
@endpush
