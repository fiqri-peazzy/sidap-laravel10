@extends('layouts.app')

@section('title', 'Import Data Atlet')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Import Data Atlet</h1>
            <a href="{{ route('sekolah.atlit.index') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Upload File Excel</h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('sekolah.atlit.import.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Pilih File Excel (.xlsx)</label>
                                <input type="file" class="form-control-file" id="file" name="file"
                                    accept=".xlsx,.xls" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload & Import
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Petunjuk</h6>
                    </div>
                    <div class="card-body">
                        <p>Download template terlebih dahulu, isi data sesuai kolom yang tersedia, lalu upload
                            kembali.</p>
                        <a href="{{ route('sekolah.atlit.import.template') }}" class="btn btn-outline-success btn-sm mb-3">
                            <i class="fas fa-file-excel"></i> Download Template
                        </a>

                        <h6 class="font-weight-bold text-primary">Keterangan Kolom:</h6>
                        <ul class="small mb-0">
                            <li><strong>nama_lengkap*</strong> — nama lengkap atlet</li>
                            <li><strong>nik*</strong> — 16 digit, harus unik (belum pernah dipakai)</li>
                            <li><strong>tempat_lahir*</strong></li>
                            <li><strong>tanggal_lahir*</strong> — format YYYY-MM-DD, harus sebelum hari ini</li>
                            <li><strong>jenis_kelamin*</strong> — isi "L" atau "P"</li>
                            <li><strong>alamat*</strong></li>
                            <li>telepon, email — opsional</li>
                            <li><strong>nama_klub*</strong> — harus sama persis dengan nama klub yang terdaftar di
                                sistem</li>
                            <li><strong>nama_cabang_olahraga*</strong> — harus sama persis dengan nama cabor yang
                                terdaftar</li>
                            <li><strong>nama_kategori*</strong> — harus sesuai kategori pada cabor tersebut</li>
                            <li>status — aktif/nonaktif/pensiun (default: aktif)</li>
                        </ul>
                        <p class="small text-muted mt-2 mb-0">
                            <i class="fas fa-info-circle"></i> Baris yang datanya tidak valid akan dilewati dan
                            dilaporkan alasannya, baris lain yang valid tetap diproses. Semua data yang berhasil
                            diimpor akan berstatus <strong>menunggu verifikasi</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
