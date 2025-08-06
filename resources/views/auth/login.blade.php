@extends('layouts.guest')

@section('pageTitle', 'Login')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
    </div>

    <x-validation-errors class="mb-4" />

    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="user">
        @csrf

        <div class="form-group">
            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="Enter Email Address...">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                id="password" name="password" required autocomplete="current-password" placeholder="Password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox small">
                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                <label class="custom-control-label" for="remember_me">Remember Me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Login
        </button>

        <hr>

        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            {{-- Add social login buttons here if needed --}}
        @endif
    </form>

    <hr>

    <div class="text-center">
        @if (Route::has('password.request'))
            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
        @endif
    </div>

    <div class="text-center">
        @if (Route::has('register'))
            <a class="small" href="{{ route('register') }}">Create an Account!</a>
        @endif
    </div>
@endsection
