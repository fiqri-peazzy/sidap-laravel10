@extends('layouts.guest')

@section('pageTitle', 'Register')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}" class="user">
        @csrf

        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name"
                name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Full Name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Email Address">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                    id="password" name="password" required autocomplete="new-password" placeholder="Password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="password"
                    class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Repeat Password">
            </div>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="form-group">
                <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input @error('terms') is-invalid @enderror" id="terms"
                        name="terms" required>
                    <label class="custom-control-label" for="terms">
                        I agree to the
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <a target="_blank" href="{{ route('terms.show') }}">Terms of Service</a> and
                            <a target="_blank" href="{{ route('policy.show') }}">Privacy Policy</a>
                        @endif
                    </label>
                    @error('terms')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        @endif

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Register Account
        </button>

        <hr>

        {{-- Add social registration buttons here if needed --}}
    </form>

    <hr>

    <div class="text-center">
        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
    </div>

    <div class="text-center">
        <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
    </div>
@endsection
