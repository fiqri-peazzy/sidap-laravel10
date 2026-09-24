@extends('layouts.app')

@section('title', 'Laporan Data Atlet')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan Data Atlet</h1>
            <div>
                <a href="{{ route('sekolah.laporan.cetak-pdf', request()->query()) }}"
                    class="btn btn-sm btn-danger shadow-sm">
                    <i class="fas fa-file-pdf fa-sm"></i> Cetak PDF
                </a>
                <a href="{{ route('sekolah.laporan.cetak-excel', request()->query()) }}"
                    class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-file-excel fa-sm"></i> Export Excel
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('sekolah.laporan.index') }}" method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select name="cabang_olahraga_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Cabang Olahraga</option>
                            @foreach ($cabangOlahraga as $cabor)
                                <option value="{{ $cabor->id }}"
                                    {{ request('cabang_olahraga_id') == $cabor->id ? 'selected' : '' }}>
                                    {{ $cabor->nama_cabang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status_verifikasi" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Status Verifikasi</option>
                            <option value="pending" {{ request('status_verifikasi') == 'pending' ? 'selected' : '' }}>
                                Menunggu</option>
                            <option value="verified" {{ request('status_verifikasi') == 'verified' ? 'selected' : '' }}>
                                Terverifikasi</option>
                            <option value="rejected" {{ request('status_verifikasi') == 'rejected' ? 'selected' : '' }}>
                                Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('sekolah.laporan.index') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-undo"></i> Reset Filter
                        </a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Klub</th>
                                <th>Cabang Olahraga</th>
                                <th>Kategori</th>
                                <th>Status Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($atlit as $index => $item)
                                <tr>
                                    <td>{{ $atlit->firstItem() + $index }}</td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->klub->nama_klub ?? '-' }}</td>
                                    <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                                    <td>{{ $item->kategoriAtlit->nama_kategori ?? '-' }}</td>
                                    <td>{!! $item->status_verifikasi_badge !!}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data atlet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $atlit->links() }}
            </div>
        </div>
    </div>
@endsection
