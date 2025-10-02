@extends('layouts.app')

@section('title', 'Verifikasi Prestasi')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-trophy text-primary"></i> Verifikasi Prestasi Atlet
        </h1>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Livewire Component -->
    @livewire('verifikator.verifikasi-prestasi-index')
@endsection

@push('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fc;
        }

        .badge-counter {
            font-size: 0.65rem;
            position: relative;
            top: -2px;
        }

        /* Loading overlay styling */
        [wire\:loading] {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        [wire\:loading].position-fixed {
            opacity: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
