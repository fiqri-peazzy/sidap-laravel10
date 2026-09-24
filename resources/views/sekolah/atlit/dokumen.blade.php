@extends('layouts.app')

@section('title', 'Dokumen Atlet')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-pdf fa-fw mr-2"></i>Dokumen {{ $atlit->nama_lengkap }}
            </h1>
            <a href="{{ route('sekolah.atlit.show', $atlit->id) }}"
                class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Lengkapi dokumen atlet ini (Ijazah, Akta Kelahiran, Kartu Pelajar,
            Dokumen Pendukung) agar bisa diverifikasi oleh verifikator.
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle fa-fw mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle fa-fw mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <!-- Dokumen Content -->
        <div class="row">
            <div class="col-12">
                <livewire:dokumen-atlit-component :atlit="$atlit" download-route-name="sekolah.atlit.dokumen.download" />
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
