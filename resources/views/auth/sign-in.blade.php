@extends('layouts.app')


@section('body')
<div class="app-container d-flex flex-column justify-content-center align-items-center min-vh-100 p-2 p-md-5">
        <div class="d-flex justify-content-center py-4 px-2">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo">
        </div>
        <div class="shadow-lg bg-white  py-5 px-4 my-4 mx-2 w-100 rounded d-flex flex-column align-items-center" style="max-width:400px">
            <h2>Log in to your account</h2>
            <p class="text-black-50">Welcome back! Please enter your account details...</p>

            <form class="w-100 mt-2" action="{{route('auth.login')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" aria-describedby="email"
                        placeholder="Enter email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                </div>
                <div class="d-flex justify-content-between py-4">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                        <label class="form-check-label" for="remember_me">Remember Me</label>
                    </div>
                    <a href="{{ route('auth.forgot-password.verify') }}">Forgot password</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>

            </form>
        </div>
        <div class="d-flex justify-content-between py-4">
            <span class="text-black-50 font-size-2"><small>Copyright @ 2022 M.A. Dole</small></span>
        </div>

    </div>
@endsection


@push('styles')
@endpush
@push('scripts')
@endpush
