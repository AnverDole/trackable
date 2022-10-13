@extends('layouts.app')


@section('body')
    <div class="app-container d-flex flex-column justify-content-center align-items-center min-vh-100 p-2 p-md-5">
        <div class="d-flex justify-content-center py-5 px-2">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo">
        </div>
        <div class=" shadow-lg  py-5 px-4 my-4 mx-2 w-100 rounded d-flex flex-column align-items-center" style="max-width:350px">
            <h2>Reset Account</h2>
            <p class="text-black-50">Welcome back! Please enter your account details.</p>

            <form class="w-100 mt-2">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="email"
                        placeholder="Enter email">
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="d-flex justify-content-between py-4">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="remember-me">
                        <label class="form-check-label" for="remember-me">Remember Me</label>
                    </div>
                    <a href="javascript:void(0)">Forgot password</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>

                <div class="d-flex justify-content-center mt-4">
                    <p class="text-black-50">Don’t have an account?&nbsp;<a href="javascript:void(0)">Sign Up</a></p>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-between py-4">
            <span class="text-black-50 font-size-2"><small>{{ config('app.copyright') }}</small></span>
        </div>

    </div>
@endsection


@push('styles')
@endpush
@push('scripts')
@endpush
