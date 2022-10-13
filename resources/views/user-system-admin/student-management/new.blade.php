@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('user-system-admin.student-management.select-school')
@include('user-system-admin.student-management.select-parent')
@include('user-system-admin.student-management.navigation')


@section('left-menu')
    @yield('system-admin-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-group"></i>Student Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student-management') }}">Student Management</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">New</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">
        @yield('student.management.navigation')

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>New Student</h4>
            <p>All fields are necessary.</p>

            @error('error-message')
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <form action="{{ route('student-management.new') }}" method="post">
                @csrf
                <div class="mt-4">
                    <div class="form-floating">
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

                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('local_index') is-invalid @enderror"
                            id="local_index" name="local_index" placeholder="local_index Address"
                            value="{{ old('local_index') }}" required>
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

                    <label for="text" class="mt-4 mb-2">Authentication</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('tag_id') is-invalid @enderror" id="tag_id"
                            name="tag_id" placeholder="tag_id" value="{{ old('tag_id') }}" required>
                        <label for="tag_id">RFID Tag ID</label>
                        @error('tag_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <label for="parent_email" class="mt-4 mb-2">Parent</label>
                    <div id="no-associated-parents"
                        class="associated-parents container m-0 @if (old('parent_id') != null) d-none @endif "
                        style="max-width:320px">
                        <div class="row">
                            <div
                                class="border rounded px-3 py-2 d-flex justify-content-between align-items-center @error('parent_id') border-danger @enderror">
                                <div class="d-flex flex-column">
                                    <span>No parent selected</span>
                                </div>
                                <div class="ml-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#select-parent"><i class="fas fa-plus-square"></i></button>
                                </div>
                            </div>
                        </div>
                        @error('parent_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                    <div id="associated-parents"
                        class="associated-parents container m-0 @if (old('parent_id') == null) d-none @endif"
                        style="max-width:320px">

                        @if (old('parent_id') != null)
                            <div class="row">
                                <div
                                    class="border rounded px-3 py-2 d-flex justify-content-between align-items-center @error('parent_id') border-danger @enderror">
                                    <input type="hidden" name="parent_id" value="{{ old('parent_id') }}">

                                    <div class="d-flex flex-column">
                                        <span>{{ old('parent_name') }}</span>
                                        <span class="fw-lighter">{{ old('parent_email') }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <button type="button" class="btn btn-danger remove-parent"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @error('parent_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>




                    <div class="d-flex justify-content-between align-items-center" style="max-width:320px">
                        <label for="email" class="mt-4 mb-2">School</label>
                    </div>
                    <div id="no-associated-schools"
                        class="associated-schools container m-0 @if (old('school_id') != null) d-none @endif "
                        style="max-width:320px">
                        <div class="row">
                            <div
                                class="border rounded px-3 py-2 d-flex justify-content-between align-items-center @error('school_id') border-danger @enderror">
                                <div class="d-flex flex-column">
                                    <span>No school selected</span>
                                </div>
                                <div class="ml-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#select-school"><i class="fas fa-plus-square"></i></button>
                                </div>
                            </div>
                        </div>
                        @error('school_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                    <div id="associated-schools"
                        class="associated-schools container m-0 @if (old('school_id') == null) d-none @endif"
                        style="max-width:320px">

                        @if (old('school_id') != null)
                            <div class="row">
                                <div
                                    class="border rounded px-3 py-2 d-flex justify-content-between align-items-center @error('school_id') border-danger @enderror">
                                    <input type="hidden" name="school_id" value="{{ old('school_id') }}">
                                    <input type="hidden" name="school_province" value="{{ old('school_province') }}">
                                    <input type="hidden" name="school_city" value="{{ old('school_city') }}">
                                    <input type="hidden" name="school_name" value="{{ old('school_name') }}">
                                    <div class="d-flex flex-column">
                                        <span>{{ old('school_name') }}</span>
                                        <span class="fw-lighter">{{ old('school_province') }} -
                                            {{ old('school_city') }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <button type="button" class="btn btn-danger remove-school"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @error('school_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                </div>


                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('student-management') }}" class="btn btn-light me-2"><i
                            class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>



    </main>

    @yield('select-parent-model')
    @yield('select-school-model')
@endsection

@push('scripts')
    <script>
        let noAssociatedSchoolsContainer = $("#no-associated-schools");
        let associatedSchoolsContainer = $("#associated-schools");

        let noAssociatedParentsContainer = $("#no-associated-parents");
        let associatedParentsContainer = $("#associated-parents");

        $("#show-password").on("change", function() {
            if ($(this).prop("checked")) {
                $("#password").attr("type", "text");
            } else {
                $("#password").attr("type", "password");
            }
        });

        function genarateSchoolHtml(data) {
            return `<div class="row">
                            <div class="border rounded p-3 d-flex justify-content-between align-items-center">
                                <input type="hidden" name="school_id" value="${data.id}">
                                <input type="hidden" name="school_name" value="${data.name}">
                                <input type="hidden" name="school_province" value="${data.province}">
                                <input type="hidden" name="school_city" value="${data.city}">
                                <div class="d-flex flex-column">
                                    <span>${data.name}</span>
                                    <span class="fw-lighter">${data.province} - ${data.city}</span>
                                </div>
                                <div class="ml-4">
                                    <button type="button" class="btn btn-danger remove-school"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </div>
                        </div>`;
        }

        function genarateParentHtml(data) {
            return `<div class="row">
                        <div
                            class="border rounded px-3 py-2 d-flex justify-content-between align-items-center">
                            <input type="hidden" name="parent_id" value="${data.id}">
                            <input type="hidden" name="parent_name" value="${data.name}">
                            <input type="hidden" name="parent_email" value="${data.email}">

                            <div class="d-flex flex-column">
                                <span>${data.name}</span>
                                <span class="fw-lighter">${data.email}</span>
                            </div>
                            <div class="ml-4">
                                <button type="button" class="btn btn-danger remove-parent"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                    </div>`;
        }

        $(document).on("click", "#associated-schools .remove-school", function() {
            let school = $(this).parent().parent().parent();
            school.remove();

            noAssociatedSchoolsContainer.removeClass("d-none");
            associatedSchoolsContainer.addClass("d-none");
        });
        $(document).on("click", "#associated-parents .remove-parent", function() {
            let parent = $(this).parent().parent().parent();
            parent.remove();

            noAssociatedParentsContainer.removeClass("d-none");
            associatedParentsContainer.addClass("d-none");
        });
        registerSchoolSelectedEventObserver(function(data) {
            associatedSchoolsContainer.html("");
            associatedSchoolsContainer.append(genarateSchoolHtml(data));

            noAssociatedSchoolsContainer.addClass("d-none");
            associatedSchoolsContainer.removeClass("d-none");
        });

        registerParentSelectedEventObserver(function(data) {
            associatedParentsContainer.html("");
            associatedParentsContainer.append(genarateParentHtml(data));

            noAssociatedParentsContainer.addClass("d-none");
            associatedParentsContainer.removeClass("d-none");
        });
    </script>
@endpush
