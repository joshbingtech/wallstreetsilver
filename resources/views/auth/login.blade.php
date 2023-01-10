@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="auth-form text-left">
                <img class="banner mb-3" src="{{ asset('images/banner.png') }}" />
                <h4> We just like Silver. </h4>
                <h6 class="font-weight-light"> Sign in to continue. </h6>
                <form class="pt-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-block btn-gradient-primary btn-lg auth-form-btn"> SIGN IN </button>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                Remember Me
                            <i class="input-helper"></i></label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link"> Forgot password? </a>
                        @endif
                    </div>
                    <div class="text-center mt-4">
                        Don't have an account? <a href="{{ route('register') }}" class="auth-link"> Sign Up </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
