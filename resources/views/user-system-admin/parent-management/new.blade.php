@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')


@section('left-menu')
    @yield('system-admin-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-group"></i>Parent Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('parent-management') }}">Parent Management</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">New</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>New Parent</h4>
            <p>All fields are necessary.</p>

            @if (session()->has('success-message'))
                <div class="alert alert-success mb-4" role="alert">
                    <i class="fa-solid fa-circle-check"></i> {{ session()->get('success-message') }}
                </div>
            @endif
            @error('error-message')
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <form action="{{ route('student-management.parents.new') }}" method="post">
                @csrf
                <div>
                    <div class="form-floating">
                        <input type="text" class="form-control   @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="email" value="{{ old('email') }}" required>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control   @error('firstname') is-invalid @enderror" id="firstname"
                            name="firstname" placeholder="Firstname" value="{{ old('firstname') }}" required>
                        <label for="firstname">First Name</label>
                        @error('firstname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control   @error('lastname') is-invalid @enderror" id="lastname"
                            name="lastname" placeholder="Lastname" value="{{ old('lastname') }}" required>
                        <label for="lastname">Last Name</label>
                        @error('lastname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label for="address_line_1" class="mt-4 mb-2">Residence</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror"
                            id="address_line_1" name="address_line_1" placeholder="Address line 1"
                            value="{{ old('address_line_1') }}" required>
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
                            value="{{ old('address_line_2') }}" required>
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
                            value="{{ old('address_line_3') }}">
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
                                <option value="{{ $city->id }}" @if (old('city') == $city->id) selected @endif>
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

                    <label for="phone_number" class="mt-4 mb-2">Notifications & Contacts</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" placeholder="Address line 3"
                            value="{{ old('phone_number') }}">
                        <label for="phone_number">Phone Number</label>
                        @error('phone_number')
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
