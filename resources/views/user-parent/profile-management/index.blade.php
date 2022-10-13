@extends('layouts.left-menu-page')
@include('menues.account-parent-left-menu')


@section('left-menu')
    @yield('account-parent-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-gear"></i>Profile Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('parent.profile-management') }}">Profile Management</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')

    <main class="menu-content-body">
        <div id="update-profile" class="bg-white shadow-lg w-100 rounded p-4">
            <h4>Edt Profile #{{ $user->id }}</h4>
            <p>All fields are necessary.</p>


            @if (session()->has('update-profile-success-message'))
                <div class="alert alert-success mb-4" role="alert">
                    <i class="fa-solid fa-circle-check"></i> {{ session()->get('update-profile-success-message') }}
                </div>
            @endif
            @error('update-profile-error-message')
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <form action="{{ route('parent.profile-management.edit') }}" method="post">
                @csrf

                <div class="mt-4">
                    <div class="form-floating">
                        <input type="text"
                            class="form-control   @error('firstname', 'updateProfile') is-invalid @enderror" id="firstname"
                            name="firstname" placeholder="First Name" value="{{ old('firstname') ?? $user->firstname }}"
                            required>
                        <label for="firstname">First Name</label>
                        @error('firstname', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text"
                            class="form-control   @error('lastname', 'updateProfile') is-invalid @enderror" id="lastname"
                            name="lastname" placeholder="Last name" value="{{ old('lastname') ?? $user->lastname }}"
                            required>
                        <label for="lastname">Last Name</label>
                        @error('lastname', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="email" class="form-control @error('email', 'updateProfile') is-invalid @enderror"
                            id="email" name="email" placeholder="Email address"
                            value="{{ old('email') ?? $user->email }}" required>
                        <label for="email">Email</label>
                        @error('email', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="tel" class="form-control @error('telephone', 'updateProfile') is-invalid @enderror"
                            id="telephone" name="telephone" placeholder="Telephone"
                            value="{{ old('telephone') ?? $user->telephone }}" required>
                        <label for="telephone">Telephone</label>
                        @error('telephone', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label for="address_line_1" class="mt-4 mb-2">Residence</label>
                    <div class="form-floating">
                        <input type="text"
                            class="form-control @error('address_line_1', 'updateProfile') is-invalid @enderror"
                            id="address_line_1" name="address_line_1" placeholder="Address line 1"
                            value="{{ old('address_line_1') ?? $user->address_line_1 }}" required>
                        <label for="address_line_1">Address Line 1</label>
                        @error('address_line_1', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text"
                            class="form-control @error('address_line_2', 'updateProfile') is-invalid @enderror"
                            id="address_line_2" name="address_line_2" placeholder="Address line 2"
                            value="{{ old('address_line_2') ?? $user->address_line_2 }}" required>
                        <label for="address_line_2">Address Line 2</label>
                        @error('address_line_2', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text"
                            class="form-control @error('address_line_3', 'updateProfile') is-invalid @enderror"
                            id="address_line_3" name="address_line_3" placeholder="Address line 3"
                            value="{{ old('address_line_3') ?? $user->address_line_3 }}">
                        <label for="address_line_3">Address Line 3</label>
                        @error('address_line_3', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mt-2">
                        <select class="form-select @error('city', 'updateProfile') is-invalid @enderror" id="city"
                            name="city" aria-label="City" required>
                            <option selected disabled value="-1">Choose one</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @if ((old('city') ?? $user->city_id) == $city->id) selected @endif>
                                    {{ $city->name }}</option>
                            @endforeach
                        </select>
                        <label for="city">City</label>
                        @error('city', 'updateProfile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
        <div id="change-password" class="bg-white shadow-lg w-100 rounded p-4 mt-4">
            <h4>Change Account Password</h4>
            <p>Here you can change your account password.</p>

            @if (session()->has('change-pass-success-message'))
                <div class="alert alert-success mb-4" role="alert">
                    <i class="fa-solid fa-circle-check"></i> {{ session()->get('change-pass-success-message') }}
                </div>
            @endif
            @error('change-pass-error-message')
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <form action="{{ route('parent.profile-management.update-password') }}" method="post">
                @csrf
                <div class="mt-4">
                    <div class="form-floating">
                        <input type="password"
                            class="form-control   @error('current_password', 'passwordChange') is-invalid @enderror"
                            id="current_password" name="current_password" placeholder="Type school's name" required>
                        <label for="current_password">Current Password</label>
                        @error('password-change', 'passwordChange')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="password"
                            class="form-control   @error('new_password', 'passwordChange') is-invalid @enderror"
                            id="new_password" name="new_password" placeholder="Type school's name" required>
                        <label for="new_password">New Password</label>
                        @error('password-change', 'passwordChange')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="password"
                            class="form-control   @error('new_password_confirmation', 'passwordChange') is-invalid @enderror"
                            id="new_password_confirmation" name="new_password_confirmation"
                            placeholder="Type school's name" required>
                        <label for="new_password_confirmation">Retype New Password</label>
                        @error('password-change', 'passwordChange')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>



    </main>
@endsection
