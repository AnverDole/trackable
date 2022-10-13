@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('user-system-admin.admin-management.navigation')


@section('left-menu')
    @yield('system-admin-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-tie"></i>Admin Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-management') }}">Admin Management</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin-management.view', ['admin' => $admin->id]) }}">Admin
                        #{{ $admin->id }}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">
        @yield('admin.management.navigation')

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>Edt Admin #{{ $admin->id }}</h4>
            <p>All fields are necessary.</p>


            @error('error-message')
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <form action="{{ route('admin-management.edit', ['admin' => $admin->id]) }}" method="post">
                @csrf
                <div class="mt-4">
                    <div class="form-floating">
                        <input type="text" class="form-control   @error('firstname') is-invalid @enderror" id="firstname"
                            name="firstname" placeholder="Type school's name"
                            value="{{ old('firstname') ?? $admin->firstname }}" required>
                        <label for="firstname">First Name</label>
                        @error('firstname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control   @error('lastname') is-invalid @enderror" id="lastname"
                            name="lastname" placeholder="First name" value="{{ old('lastname') ?? $admin->lastname }}"
                            required>
                        <label for="lastname">Last Name</label>
                        @error('lastname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email address" value="{{ old('email') ?? $admin->email }}"
                            required>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                            name="telephone" placeholder="Telephone" value="{{ old('telephone') ?? $admin->telephone }}"
                            required>
                        <label for="telephone">Telephone</label>
                        @error('telephone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label for="address_line_1" class="mt-4 mb-2">Residence</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror"
                            id="address_line_1" name="address_line_1" placeholder="Address line 1"
                            value="{{ old('address_line_1') ?? $admin->address_line_1 }}" required>
                        <label for="address_line_1">Address Line 1</label>
                        @error('address_line_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('address_line_2') is-invalid @enderror"
                            id="address_line_2" name="address_line_2" placeholder="Address line 2"
                            value="{{ old('address_line_2') ?? $admin->address_line_2 }}" required>
                        <label for="address_line_2">Address Line 2</label>
                        @error('address_line_2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('address_line_3') is-invalid @enderror"
                            id="address_line_3" name="address_line_3" placeholder="Address line 3"
                            value="{{ old('address_line_3') ?? $admin->address_line_3 }}">
                        <label for="address_line_3">Address Line 3</label>
                        @error('address_line_3')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mt-2">
                        <select class="form-select @error('city') is-invalid @enderror" id="city" name="city"
                            aria-label="City" required>
                            <option selected disabled value="-1">Choose one</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @if ((old('city') ?? $admin->city_id) == $city->id) selected @endif>
                                    {{ $city->name }}</option>
                            @endforeach
                        </select>
                        <label for="city">City</label>
                        @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mt-4">
                        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id"
                            aria-label="Role" required>
                            <option selected disabled value="-1">Choose one</option>
                            @foreach ($roleIds as $roleId => $role)
                                <option value="{{ $roleId }}" @if ((old('role_id') ?? $admin->role) == $roleId) selected @endif>
                                    {{ $role }}</option>
                            @endforeach
                        </select>
                        <label for="role_id">Role</label>
                        @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mt-4">
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active"
                            name="is_active" aria-label="Is Active" required>
                            <option selected disabled value="-1">Choose one</option>
                            <option value="0" @if ((old('is_active') ?? $admin->is_active) == 0) selected @endif>Deactivated</option>
                            <option value="1" @if ((old('is_active') ?? $admin->is_active) == 1) selected @endif>Activated</option>
                        </select>

                        <label for="is_active">Account Status</label>
                        @error('is_active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>


                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('school-management.view', ['school' => $admin->id]) }}"
                        class="btn btn-light me-2"><i class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>



    </main>
@endsection
