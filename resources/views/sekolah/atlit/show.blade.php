@extends('layouts.app')

@section('title', 'Detail Atlet')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Atlet</h1>
            <div>
                <a href="{{ route('sekolah.atlit.dokumen.index', $atlit->id) }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-file-pdf fa-sm"></i> Kelola Dokumen
                </a>
                <a href="{{ route('sekolah.atlit.edit', $atlit->id) }}" class="btn btn-sm btn-warning shadow-sm">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <a href="{{ route('sekolah.atlit.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm"></i> Kembali
                </a>
            </div>
        </div>

        @if ($atlit->status_verifikasi === 'rejected' && $atlit->catatan_verifikasi)
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i> Data ini ditolak verifikator. Alasan:
                {{ $atlit->catatan_verifikasi }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{{ $atlit->foto_url }}" alt="{{ $atlit->nama_lengkap }}" class="img-fluid rounded mb-2"
                    style="max-height: 220px;">
                <div>{!! $atlit->status_verifikasi_badge !!}</div>
            </div>
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="180"><strong>Nama Lengkap</strong></td>
                                <td>{{ $atlit->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td>{{ $atlit->nik }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat, Tanggal Lahir</strong></td>
                                <td>{{ $atlit->tempat_lahir }}, {{ $atlit->tanggal_lahir->format('d F Y') }}
                                    ({{ $atlit->umur }} tahun)</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>{{ $atlit->jenis_kelamin_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>{{ $atlit->alamat_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon</strong></td>
                                <td>{{ $atlit->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $atlit->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Klub</strong></td>
                                <td>{{ $atlit->klub->nama_klub ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Cabang Olahraga</strong></td>
                                <td>{{ $atlit->cabangOlahraga->nama_cabang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kategori</strong></td>
                                <td>{{ $atlit->kategoriAtlit->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Atlet</strong></td>
                                <td>{!! $atlit->status_badge !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
