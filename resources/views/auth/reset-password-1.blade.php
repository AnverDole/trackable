@extends('layouts.app')


@section('body')
    <div class="app-container d-flex flex-column justify-content-center align-items-center min-vh-100 p-2 p-md-5">
        <div class="d-flex justify-content-center py-5 px-2">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo">
        </div>
        <div class=" shadow-lg bg-white  py-5 px-4 my-4 mx-2 w-100 rounded d-flex flex-column align-items-center"
            style="max-width:400px">
            <h2>Reset Account</h2>
            <p class="text-black-50">Please enter your account email.</p>

            @if (Session::has('message'))
                <div class="alert alert-success d-flex align-items-baseline">
                    <i class="fa-solid fa-circle-check"></i>
                    <p class="ms-2 mb-0">{{ Session::get('message') }}</p>
                </div>
            @endif

            <form action="{{ route('auth.forgot-password.verify') }}" method="POST" class="w-100 mt-2">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" aria-describedby="email" placeholder="Enter email" value="{{ old('email') }}"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-4">Submit</button>

                <div class="d-flex justify-content-center mt-4">
                    <p class="text-black-50">No need, just goto&nbsp;<a href="{{ route('auth.login') }}">Login</a></p>
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
