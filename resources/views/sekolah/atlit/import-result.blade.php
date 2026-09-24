@extends('layouts.app')

@section('title', 'Hasil Import Data Atlet')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hasil Import Data Atlet</h1>
            <div>
                <a href="{{ route('sekolah.atlit.import.create') }}" class="btn btn-sm btn-outline-primary shadow-sm">
                    <i class="fas fa-upload fa-sm"></i> Import Lagi
                </a>
                <a href="{{ route('sekolah.atlit.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-list fa-sm"></i> Lihat Daftar Atlet
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Berhasil
                                    Diimpor</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $importedCount }} atlet</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Gagal / Dilewati
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($errors) }} baris</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (count($errors) > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Detail Baris yang Gagal</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="80">Baris Ke-</th>
                                    <th width="200">Nama</th>
                                    <th>Alasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($errors as $error)
                                    <tr>
                                        <td>{{ $error['row'] }}</td>
                                        <td>{{ $error['nama'] }}</td>
                                        <td>
                                            <ul class="mb-0 pl-3">
                                                @foreach ($error['messages'] as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle"></i> Perbaiki data pada baris di atas lalu upload ulang hanya
                        baris yang gagal tersebut.
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection
