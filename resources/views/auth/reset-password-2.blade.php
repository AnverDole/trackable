@extends('layouts.app')


@section('body')
    <div class="app-container d-flex flex-column justify-content-center align-items-center min-vh-100 p-2 p-md-5">
        <div class="d-flex justify-content-center py-5 px-2">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo">
        </div>
        <div class="bg-white shadow-lg  py-5 px-4 my-4 mx-2 w-100 rounded d-flex flex-column align-items-center"
            style="max-width:350px">
            <h2>Reset Account</h2>
            <p class="text-black-50">Create a secure & strong password.</p>

            <form class="w-100 mt-2" accept="{{ route('auth.forgot-password.change') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ request()->get('token') }}">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        aria-describedby="email" placeholder="Email" value="{{ request()->get('email') }}" readonly required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="password">New Passwords</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="New Password" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="password">Retype New Passwords</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"
                        placeholder="Retype New Password" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-4">Update Password</button>
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
