@extends('layouts.left-menu-page')
@include('menues.account-manager-left-menu')
@include('user-account-manager.student-management.navigation')


@section('left-menu')
    @yield('account-manager-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-group"></i>Students</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account-manager.student-management') }}">Students</a></li>
                <li class="breadcrumb-item"><a href="{{route('account-manager.student-management.edit', ['student' => $student->id])}}">Edit #{{$student->id}}</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">
        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>Edit Student #{{ $student->id }}</h4>
            <p>All fields are necessary.</p>


            @error('error-message')
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <form action="{{ route('account-manager.student-management.edit', ['student' => $student->id]) }}" method="post">
                @csrf
                <div class="mt-4">
                    <div class="form-floating">
                        <input type="text" class="form-control   @error('firstname') is-invalid @enderror" id="firstname"
                            name="firstname" placeholder="Firstname" value="{{ old('firstname') ?? $student->firstname }}"
                            required>
                        <label for="firstname">First Name</label>
                        @error('firstname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control   @error('lastname') is-invalid @enderror" id="lastname"
                            name="lastname" placeholder="Lastname" value="{{ old('lastname') ?? $student->lastname }}"
                            required>
                        <label for="lastname">Last Name</label>
                        @error('lastname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('local_index') is-invalid @enderror"
                            id="local_index" name="local_index" placeholder="local_index Address"
                            value="{{ old('local_index') ?? $student->tag_id }}" required>
                        <label for="local_index">Local Index Number</label>
                        @error('local_index')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <label for="address_line_1" class="mt-4 mb-2">Residence</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror"
                            id="address_line_1" name="address_line_1" placeholder="Address line 1"
                            value="{{ old('address_line_1') ?? $student->address_line_1 }}" required>
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
                            value="{{ old('address_line_2') ?? $student->address_line_2 }}" required>
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
                            value="{{ old('address_line_3') ?? $student->address_line_3 }}">
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
                                <option value="{{ $city->id }}" @if ((old('city') ?? $student->city_id) == $city->id) selected @endif>
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

                    <label for="text" class="mt-4 mb-2">Authentication</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('tag_id') is-invalid @enderror" id="tag_id"
                            name="tag_id" placeholder="tag_id" value="{{ old('tag_id') ?? $student->tag_id }}" required>
                        <label for="tag_id">RFID Tag ID</label>
                        @error('tag_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label for="phone_number_1" class="mt-4 mb-2">Notifications</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('phone_number_1') is-invalid @enderror"
                            id="phone_number_1" name="phone_number_1" placeholder="Address line 3"
                            value="{{ old('phone_number_1') ?? $student->phone_number_1 }}">
                        <label for="phone_number_1">Phone Number 1</label>
                        @error('phone_number_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('phone_number_2') is-invalid @enderror"
                            id="phone_number_2" name="phone_number_2" placeholder="Address line 3"
                            value="{{ old('phone_number_2') ?? $student->phone_number_2 }}">
                        <label for="phone_number_2">Phone Number 2 (Optional)</label>
                        @error('phone_number_2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label for="email" class="mt-4 mb-2">Parental access</label>
                    <div class="form-floating">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" value="{{ old('email') ?? $student->email }}">
                        <label for="email">Email Address</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mt-4">
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active"
                            name="is_active" aria-label="Is Active" required>
                            <option selected disabled value="-1">Choose one</option>
                            <option value="0" @if ((old('is_active') ?? $student->is_active) == 0) selected @endif>Deactivated</option>
                            <option value="1" @if ((old('is_active') ?? $student->is_active) == 1) selected @endif>Activated</option>
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
                    <a href="{{ route('account-manager.student-management') }}" class="btn btn-light me-2"><i
                            class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>



    </main>
@endsection
