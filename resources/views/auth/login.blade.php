@extends('layouts.guest')
@section('pageTitle', 'Login')

@section('content')
    <!-- Left Side - Illustration -->
    <div class="col-lg-6 d-none d-lg-block">
        <div class="auth-left">
            <div class="lottie-container">
                <dotlottie-wc src="https://lottie.host/0befd26f-b968-420a-9ba2-fb345dcb3de6/GKQC7S4YuR.lottie"
                    style="width: 350px; height: 350px;" autoplay loop>
                </dotlottie-wc>
            </div>
            <h3>Selamat Datang di SIDAP PPLP</h3>
            <p>Sistem Informasi Data Atlet PPLP - Kelola data atlet dengan mudah dan efisien</p>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="col-lg-6">
        <div class="auth-right">
            <!-- Logo -->
            <div class="logo-container">
                <img src="{{ asset('template/img/logo_1.png') }}" alt="Logo SIDAP PPLP">
            </div>

            <!-- Title -->
            <h1 class="auth-title">Masuk ke Akun Anda</h1>
            <p class="auth-subtitle">Silakan masukkan email dan password Anda</p>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Status Message -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <input type="email" class="form-control form-control-icon @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="Alamat Email">
                    <i class="fas fa-envelope"></i>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <input type="password" class="form-control form-control-icon @error('password') is-invalid @enderror"
                        id="password" name="password" required autocomplete="current-password" placeholder="Password">
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                    <label class="custom-control-label" for="remember_me">Ingat Saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>atau</span>
            </div>

            <!-- Additional Links -->
            <div class="auth-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        <i class="fas fa-key mr-1"></i> Lupa Password?
                    </a>
                @endif
            </div>

            @if (Route::has('register'))
                <div class="auth-links mt-3">
                    <span style="color: #7f8c8d; font-size: 14px;">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="ml-2">
                        <i class="fas fa-user-plus mr-1"></i> Buat Akun Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle Password Visibility
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // Add focus effect to input icons
            const formInputs = document.querySelectorAll('.form-control-icon');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    const icon = this.parentElement.querySelector('i.fa-envelope, i.fa-lock');
                    if (icon) {
                        icon.style.color = '#667eea';
                    }
                });

                input.addEventListener('blur', function() {
                    const icon = this.parentElement.querySelector('i.fa-envelope, i.fa-lock');
                    if (icon && !this.value) {
                        icon.style.color = '#95a5a6';
                    }
                });
            });

            // Form validation animation
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('.btn-login');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
                    submitBtn.disabled = true;
                });
            }
        });
    </script>
@endpush
