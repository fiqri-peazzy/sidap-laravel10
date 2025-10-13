@extends('layouts.app')

@section('title', 'Statistik Verifikasi')

@section('content')
    <div class="container-fluid">
        <!-- Render Livewire Component -->
        @livewire('verifikator.statistik-verifikasi')
    </div>
@endsection

@push('styles')
    <style>
        /* Custom styling untuk chart */
        .apexcharts-canvas {
            margin: 0 auto;
        }

        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }

        /* Loading animation */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
@endpush
