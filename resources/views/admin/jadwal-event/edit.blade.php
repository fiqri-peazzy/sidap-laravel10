@extends('layouts.app')

@section('title', 'Edit Jadwal Event')

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

        .current-athletes {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #d1d3e2;
            padding: 10px;
            border-radius: 0.35rem;
            background: #f8f9fc;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Event</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.jadwal-event.index') }}">Jadwal Event</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.jadwal-event.show', $jadwalEvent) }}">{{ $jadwalEvent->nama_event }}</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.jadwal-event.show', $jadwalEvent) }}" class="btn btn-sm btn-info mr-2">
                    <i class="fas fa-eye"></i> Detail
                </a>
                <a href="{{ route('admin.jadwal-event.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <form action="{{ route('admin.jadwal-event.update', $jadwalEvent) }}" method="POST">
            @csrf
            @method('PUT')
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
                                            value="{{ old('nama_event', $jadwalEvent->nama_event) }}" required>
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
                                                {{ old('jenis_event', $jadwalEvent->jenis_event) == 'pertandingan' ? 'selected' : '' }}>
                                                Pertandingan</option>
                                            <option value="seleksi"
                                                {{ old('jenis_event', $jadwalEvent->jenis_event) == 'seleksi' ? 'selected' : '' }}>
                                                Seleksi</option>
                                            <option value="uji_coba"
                                                {{ old('jenis_event', $jadwalEvent->jenis_event) == 'uji_coba' ? 'selected' : '' }}>
                                                Uji Coba</option>
                                            <option value="kejuaraan"
                                                {{ old('jenis_event', $jadwalEvent->jenis_event) == 'kejuaraan' ? 'selected' : '' }}>
                                                Kejuaraan</option>
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
                                                    {{ old('cabang_olahraga_id', $jadwalEvent->cabang_olahraga_id) == $cabor->id ? 'selected' : '' }}>
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
                                            value="{{ old('tanggal_mulai', $jadwalEvent->tanggal_mulai->format('Y-m-d')) }}"
                                            required>
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
                                            value="{{ old('tanggal_selesai', $jadwalEvent->tanggal_selesai->format('Y-m-d')) }}"
                                            required>
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
                                            value="{{ old('lokasi', $jadwalEvent->lokasi) }}" required>
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
                                            value="{{ old('penyelenggara', $jadwalEvent->penyelenggara) }}" required>
                                        @error('penyelenggara')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                    class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $jadwalEvent->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Status Event -->
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
                                    <option value="aktif"
                                        {{ old('status', $jadwalEvent->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="selesai"
                                        {{ old('status', $jadwalEvent->status) == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="dibatalkan"
                                        {{ old('status', $jadwalEvent->status) == 'dibatalkan' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Atlet Peserta Saat Ini -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Atlet Peserta</h6>
                            <span class="badge badge-info">{{ $jadwalEvent->jumlah_atlet }} Atlet</span>
                        </div>
                        <div class="card-body">
                            @if ($jadwalEvent->atlit->count() > 0)
                                <div class="current-athletes">
                                    @foreach ($jadwalEvent->atlit as $atlit)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-user-athlete text-primary mr-2"></i>
                                            <span class="small">{{ $atlit->nama_lengkap }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('admin.jadwal-event.manage-atlit', $jadwalEvent) }}"
                                        class="btn btn-sm btn-primary btn-block">
                                        <i class="fas fa-edit"></i> Kelola Atlet
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-users text-muted mb-2"></i>
                                    <p class="text-muted mb-3">Belum ada atlet</p>
                                    <a href="{{ route('admin.jadwal-event.manage-atlit', $jadwalEvent) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Atlet
                                    </a>
                                </div>
                            @endif

                            <div id="new-atlit-container" class="mt-3">
                                <!-- Container untuk atlet baru akan dimuat di sini -->
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-save"></i> Update Event
                                </button>
                                <a href="{{ route('admin.jadwal-event.show', $jadwalEvent) }}"
                                    class="btn btn-info btn-block">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                                <a href="{{ route('admin.jadwal-event.index') }}" class="btn btn-secondary btn-block">
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
            const newAtlitContainer = document.getElementById('new-atlit-container');
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');

            // Set minimum date to today for new events, but allow past dates for existing events
            const today = new Date().toISOString().split('T')[0];
            const currentStartDate = tanggalMulai.value;

            // Only set minimum date if the current start date is in the future
            if (currentStartDate >= today) {
                tanggalMulai.min = today;
            }

            // Always set minimum end date based on start date
            tanggalSelesai.min = currentStartDate;

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
                    loadNewAtlit(caborId);
                } else {
                    newAtlitContainer.innerHTML = '';
                }
            });

            function loadNewAtlit(caborId) {
                newAtlitContainer.innerHTML = `
            <div class="text-center">
                <i class="fas fa-spinner fa-spin"></i> 
                Memuat data atlet...
            </div>
        `;

                fetch(`/api/atlit/by-cabor/${caborId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            // Get current athlete IDs
                            const currentAthletes = @json($jadwalEvent->atlit->pluck('id')->toArray());

                            let html = '<div class="border-top pt-3">';
                            html += '<h6 class="font-weight-bold text-primary mb-2">';
                            html += '<i class="fas fa-plus-circle"></i> Tambah Atlet Baru';
                            html += '</h6>';
                            html +=
                                '<div style="max-height: 150px; overflow-y: auto; border: 1px solid #d1d3e2; padding: 10px; border-radius: 0.35rem;">';

                            data.forEach(atlit => {
                                // Only show athletes not currently in the event
                                if (!currentAthletes.includes(atlit.id)) {
                                    html += `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="atlit_ids[]" value="${atlit.id}" 
                                           id="new_atlit_${atlit.id}">
                                    <label class="form-check-label" for="new_atlit_${atlit.id}">
                                        ${atlit.nama_lengkap}
                                    </label>
                                </div>
                            `;
                                }
                            });

                            html += '</div>';
                            html +=
                                '<small class="text-muted">Centang atlet yang ingin ditambahkan ke event ini</small>';
                            html += '</div>';

                            newAtlitContainer.innerHTML = html;
                        } else {
                            newAtlitContainer.innerHTML = `
                        <div class="border-top pt-3">
                            <p class="text-muted text-center mb-0">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Tidak ada atlet baru tersedia
                            </p>
                        </div>
                    `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        newAtlitContainer.innerHTML = `
                    <div class="border-top pt-3">
                        <p class="text-danger text-center mb-0">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Gagal memuat data atlet
                        </p>
                    </div>
                `;
                    });
            }

            // Load new athletes if cabang olahraga already selected
            if (caborSelect.value) {
                loadNewAtlit(caborSelect.value);
            }
        });
    </script>
@endpush
