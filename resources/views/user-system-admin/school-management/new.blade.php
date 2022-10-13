@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('user-system-admin.school-management.navigation')

@section('left-menu')
    @yield('system-admin-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-school fa-sm"></i>School Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('school-management') }}">School Management</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">
        @yield('school.management.navigation')

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>New School</h4>
            <p>Fill in all the fields to create a new school.</p>

            @if (session()->has('success-message'))
                <div class="alert alert-success" role="alert">
                    <i class="fa-solid fa-circle-check"></i> {{ session()->get('success-message') }}
                </div>
            @endif

            @error('error-message')
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <form action="{{ route('school-management.new') }}" method="post">
                @csrf
                <div class="mt-4">
                    <h5 class="mb-4">Informations of the school</h5>

                    <div class="form-floating">
                        <input type="text" class="form-control   @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Type school's name" value="{{ old('name') }}" required>
                        <label for="name">Name</label>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Type school's email" value="{{ old('email') }}" required>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                            name="telephone" placeholder="Type school's name" value="{{ old('telephone') }}" required>
                        <label for="telephone">Telephone</label>
                        @error('telephone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label for="address_line_1" class="mt-4 mb-2">School Address</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror"
                            id="address_line_1" name="address_line_1" placeholder="Type school's name"
                            value="{{ old('address_line_1') }}" required>
                        <label for="address_line_1">Address Line 1</label>
                        @error('address_line_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror"
                            id="address_line_2" name="address_line_2" placeholder="Type school's name"
                            value="{{ old('address_line_1') }}" required>
                        <label for="address_line_2">Address Line 2</label>
                        @error('address_line_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('address_line_3') is-invalid @enderror"
                            id="address_line_3" name="address_line_3" placeholder="Type school's name"
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

                    <div class="d-flex justify-content-between align-items-center mt-4" style="max-width: 425px">
                        <label>MAC Addresses OF RFID detectors</label>
                        <button id="add-mac-btn" type="button" class="btn btn-primary ms-2"><i
                                class="fa-solid fa-square-plus"></i></button>
                    </div>
                    <div id="mac-addresses" class="d-flex flex-column" style="max-width: 425px">
                        @php $i = 0; @endphp
                        @foreach ((array) (old('mac_addresses') ?? ['']) as $mac)

                            <div class="d-flex w-100 mac-addr">
                                <div class="mt-2 mr-2 flex-grow-1">
                                    <input type="tel" class="form-control @error('mac_addresses.' . $i) is-invalid @enderror"
                                        name="mac_addresses[]" placeholder="MAC Adresses" value="{{ $mac }}"
                                        required>
                                </div>
                                <div class="ms-2 pt-2">
                                    <button type="button" class="btn btn-danger remove"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                        @error('mac_addresses.*')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('mac_addresses')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>


                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('school-management') }}" class="btn btn-light me-2"><i
                            class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-square-plus"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        let macAddresses = $("#mac-addresses");


        $(document).on("click", "#add-mac-btn", function() {
            addMacAddress();
        });
        $(document).on("click", ".mac-addr .remove", function() {
            $(this).parent().parent().remove();
        });

        function addMacAddress() {
            let html = `
                <div class="d-flex w-100 mac-addr">
                    <div class="mt-2 mr-2 flex-grow-1">
                        <input type="tel" class="form-control"
                            name="mac_addresses[]" placeholder="MAC Address" required>
                    </div>
                    <div class="ms-2 pt-2">
                        <button type="button" class="btn btn-danger remove"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>
            `;
            macAddresses.append($(html));

        }
    </script>
@endpush
