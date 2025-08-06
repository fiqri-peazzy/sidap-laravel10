@extends('layouts.guest')

@section('pageTitle', 'Forgot Password')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
        <p class="mb-4">We get it, stuff happens. Just enter your email address below
            and we'll send you a link to reset your password!</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}" class="user">
        @csrf

        <div class="form-group">
            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email Address...">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Reset Password
        </button>
    </form>

    <hr>

    <div class="text-center">
        <a class="small" href="{{ route('register') }}">Create an Account!</a>
    </div>

    <div class="text-center">
        <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
    </div>
@endsection
