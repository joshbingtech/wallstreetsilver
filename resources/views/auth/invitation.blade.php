@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="auth-form text-left">
                <img class="banner mb-3" src="{{ asset('images/banner.png') }}" />
                <h4> We just like Silver. </h4>
                <h6 class="font-weight-light"> You have been invited to Wall Street Silver. </h6>
                <form class="pt-3" method="POST" action="{{ route('accept-invitation') }}" novalidate>
                    @csrf
                    <input type="hidden" name="invite_token" value="{{ $invited_user->invite_token }}">
                    <div class="form-group">
                        <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $invited_user->email }}" disabled>
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-block btn-gradient-primary btn-lg auth-form-btn"> JOIN </button>
                    </div>
                    <div class="text-center mt-4">
                        Already have an account? <a href="{{ route('login') }}" class="auth-link"> Sign In </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
