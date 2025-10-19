<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('pageTitle', 'Authentication')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Lottie Files -->
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js" type="module"></script>

    <style>
        body {
            background: #ffffff !important;
            font-family: 'Nunito', sans-serif;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .auth-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 600px;
        }

        .lottie-container {
            margin-bottom: 30px;
        }

        .auth-left h3 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center;
        }

        .auth-left p {
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            font-size: 14px;
        }

        .auth-right {
            padding: 60px 50px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 120px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05);
        }

        .auth-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
            text-align: center;
        }

        .auth-subtitle {
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .form-control-icon {
            padding-left: 50px !important;
            padding-right: 50px !important;
            height: 50px;
            border-radius: 25px;
            border: 2px solid #e0e6ed;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .form-control-icon:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .form-control-icon:focus+i {
            color: #667eea;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #95a5a6;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .custom-checkbox {
            margin-bottom: 25px;
        }

        .custom-checkbox label {
            color: #2c3e50;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            height: 50px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e6ed;
        }

        .divider span {
            background: #ffffff;
            padding: 0 15px;
            position: relative;
            color: #95a5a6;
            font-size: 14px;
        }

        .auth-links {
            text-align: center;
            margin-top: 20px;
        }

        .auth-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
            font-weight: 600;
        }

        .auth-links a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .alert {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .invalid-feedback {
            font-size: 13px;
            margin-top: 5px;
            padding-left: 20px;
        }

        @media (max-width: 991px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                padding: 40px 30px;
            }
        }

        @media (max-width: 576px) {
            .auth-right {
                padding: 30px 20px;
            }

            .auth-title {
                font-size: 24px;
            }

            .logo-container img {
                max-width: 100px;
            }
        }
    </style>

    @livewireStyles
</head>

<body>
    <div class="auth-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="auth-card">
                        <div class="row g-0">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

    @livewireScripts

    @stack('scripts')
</body>

</html>
