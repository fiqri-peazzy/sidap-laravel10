@extends('layouts.app')

@section('title', 'Data Atlit - Verifikator')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-friends text-warning mr-2"></i>
                Data Atlit untuk Verifikasi
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('verifikator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Atlit</li>
                </ol>
            </nav>
        </div>

        <!-- Pass stats to Livewire component -->
        @livewire('verifikator.atlit-index', ['initialStats' => $stats])
    </div>
@endsection

@push('styles')
    <style>
        .table-responsive {
            border-radius: 0.35rem;
        }

        .badge {
            font-size: 0.75em;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .card-stats {
            transition: transform 0.15s ease-in-out;
        }

        .card-stats:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert) {
                        alert.style.transition = 'opacity 0.5s ease';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 500);
                    }
                }, 5000);
            });
        });
    </script>
@endpush
