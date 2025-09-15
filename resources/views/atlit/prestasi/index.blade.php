@extends('layouts.app')

@section('title', 'Prestasi Saya')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-trophy fa-fw mr-2 text-warning"></i>Prestasi Saya
            </h1>
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

        <!-- Prestasi Content -->
        <div class="row">
            <div class="col-12">
                <livewire:prestasi-atlit :atlit="$atlit" />
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .achievement-card {
            transition: all 0.3s ease;
            border-left: 4px solid #e74a3b;
        }

        .achievement-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .achievement-card.gold {
            border-left-color: #f1c40f;
        }

        .achievement-card.silver {
            border-left-color: #95a5a6;
        }

        .achievement-card.bronze {
            border-left-color: #e67e22;
        }

        .achievement-card.verified {
            border-left-color: #27ae60;
        }

        .achievement-card.pending {
            border-left-color: #f39c12;
        }

        .achievement-card.rejected {
            border-left-color: #e74c3c;
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 2rem;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: -2rem;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item:last-child:before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: 4px;
            top: 8px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #28a745;
        }

        .medal-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }

        .medal-gold {
            color: #ffd700;
        }

        .medal-silver {
            color: #c0c0c0;
        }

        .medal-bronze {
            color: #cd7f32;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto hide flash messages after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
