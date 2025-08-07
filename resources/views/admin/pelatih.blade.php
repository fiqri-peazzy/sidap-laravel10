@extends('layouts.app')

@section('pageTitle', 'Data Pelatih')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pelatih PPLP</h1>
    </div>

    @livewire('pelatih-component')

    <!-- Custom CSS -->
    <style>
        .table-responsive {
            border-radius: 0.35rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.775rem;
        }

        .badge {
            font-size: 0.7rem;
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .text-truncate-custom {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: -1;
        }
    </style>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('livewire:init', () => {
            // Listen untuk success message
            Livewire.on('show-success-message', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: event[0] || 'Operasi berhasil dilakukan!',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });

            // Listen untuk error message
            Livewire.on('show-error-message', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: event[0] || 'Terjadi kesalahan sistem!',
                    timer: 5000,
                    showConfirmButton: true
                });
            });

            // Listen untuk export data
            Livewire.on('export-data', () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Export Data',
                    text: 'Fitur export sedang dalam pengembangan',
                    showConfirmButton: true
                });
            });
        });
    </script>
@endsection
