@extends('layouts.app')

@section('pageTitle', 'Profil Pengguna')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-circle text-primary mr-2"></i>
            Profil Pengguna
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Left Column - Profile Photo & Quick Info -->
        <div class="col-xl-4 col-lg-5">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <i class="fas fa-user-cog text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary">Foto Profil</h6>
                </div>
                <div class="card-body text-center">
                    @livewire('profile.profile-photo-form')
                </div>
            </div>

            <!-- Account Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <i class="fas fa-info-circle text-info mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary">Info Akun</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Status Akun</small>
                        <div class="font-weight-bold text-success">
                            <i class="fas fa-check-circle mr-1"></i>
                            Aktif
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Bergabung Sejak</small>
                        <div class="font-weight-bold">
                            {{ auth()->user()->created_at->format('d F Y') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Email Terverifikasi</small>
                        <div class="font-weight-bold">
                            @if (auth()->user()->hasVerifiedEmail())
                                <span class="text-success">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="text-warning">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Belum Terverifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                    @if (auth()->user()->two_factor_secret)
                        <div class="mb-3">
                            <small class="text-muted">Two Factor Authentication</small>
                            <div class="font-weight-bold text-success">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Aktif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Forms -->
        <div class="col-xl-8 col-lg-7">
            <!-- Personal Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <i class="fas fa-user-edit text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Personal</h6>
                </div>
                <div class="card-body">
                    @livewire('profile.update-profile-information-form')
                </div>
            </div>

            <!-- Change Password -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <i class="fas fa-key text-warning mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                </div>
                <div class="card-body">
                    @livewire('profile.update-password-form')
                </div>
            </div>

            {{-- 
            <!-- Delete Account -->
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="card shadow mb-4 border-left-danger">
                    <div class="card-header py-3 d-flex align-items-center bg-danger text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <h6 class="m-0 font-weight-bold">Zona Berbahaya</h6>
                    </div>
                    <div class="card-body">
                        @livewire('profile.delete-user-form')
                    </div>
                </div>
            @endif --}}
        </div>
    </div>

    <!-- Custom CSS for Profile Page -->
    <style>
        .profile-avatar {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .profile-upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.2);
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }
    </style>
@endsection
