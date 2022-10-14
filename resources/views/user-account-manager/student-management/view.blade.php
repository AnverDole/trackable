@extends('layouts.left-menu-page')
@include('menues.account-manager-left-menu')
@include('user-account-manager.student-management.select-school')
@include('user-account-manager.student-management.navigation')

@section('no-result-bottom')
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#select-school"><i
            class="fa-solid fa-square-plus"></i>&nbsp;Associate Now</button>
@endsection

@include('snippets.no-result', [
    'title' => 'Hmm...',
    'message' => 'There are no schools associated with this student.',
])


@section('left-menu')
    @yield('account-manager-left-menu')
@endsection


@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-group"></i>Students</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account-manager.student-management') }}">Students</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Student #{{ $student->id }}</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body" style="max-width: 720px;width:100%">
        @yield('school.management.navigation')

        @if (session()->has('success-message'))
            <div class="alert alert-success mb-4" role="alert" style="max-width: 720px;width:100%">
                <i class="fa-solid fa-circle-check"></i> {{ session()->get('success-message') }}
            </div>
        @endif
        @error('error-message')
            <div class="alert alert-danger mb-4" role="alert" style="max-width: 720px;width:100%">
                <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </div>
        @enderror

        <div class="container ">
            <div class="row">
                <div class="bg-white shadow-lg w-100 rounded p-4">
                    <h4>Student #{{ $student->id }}</h4>

                    <div class="container p-0">
                        <div class="row">
                            <div class="col-12 col-md-6 d-flex flex-column align-items-start">
                                <span class="fw-light">Status</span>
                                @if ($student->is_active)
                                    <p class="badge bg-success">Active</p>
                                @else
                                    <p class="badge bg-danger">Deactivated</p>
                                @endif
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12 col-md-6">
                                <span class="fw-light">Name</span>
                                <p>{{ $student->firstname . ' ' . $student->lastname }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Address</span>
                                <p>{{ $student->Address }}</p>
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Parent Account</span>
                                <p class="m-0 p-0">{{ $student->Parent->email }}</p>
                                <p class="m-0 p-0">{{ $student->Parent->telephone }}</p>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 col-md-6">
                                <span class="fw-light">RFID Tag ID</span>
                                <p>{{ $student->tag_id }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Local Index Number</span>
                                <p>{{ $student->local_index }}</p>
                            </div>
                        </div>


                    </div>
                    <div class="mt-4">
                        <a href="{{ route('account-manager.student-management') }}" class="btn btn-light me-2"><i
                                class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                        <a href="{{ route('account-manager.student-management.edit', ['student' => $student->id]) }}"
                            class="btn btn-light me-2"><i class="fa-solid fa-pen"></i>&nbsp;Edit</a>
                        <a href="{{ route('account-manager.student-management.view.attendances', ['student' => $student->id]) }}"
                            class="btn btn-primary">View Attendance</a>
                    </div>
                </div>
                <div class="mt-4 p-0 ">
                    <div class="d-flex bg-white shadow-lg rounded justify-content-between align-items-center px-4 py-3">
                        <h5 class="m-0">Associated School</h5>
                    </div>
                    <div class="container">
                        <a href="{{ route('account-manager.school-management.view', ['school' => $student->School->id]) }}"
                            target="_new"
                            class="bg-white text-dark text-decoration-none card-hover shadow row rounded p-2 school mt-3 align-items-center">
                            <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                                <small class="fw-lighter">ID</small>
                                <span>{{ $student->School->id }}</span>
                            </div>
                            <div class="col-12 mb-2 mb-md-0 col-md-5 d-flex flex-column">
                                <small class="fw-lighter">Name</small>
                                <span>{{ $student->School->name }}</span>
                            </div>
                            <div class="col-12 mb-2 mb-md-0 col-md-5 d-flex flex-column">
                                <small class="fw-lighter">Province</small>
                                <span>{{ $student->School->City->Province->name }} -
                                    {{ $student->School->City->name }}</span>
                            </div>
                            <div class="col-12 col-md-1 ol-md-4 d-flex justify-content-end" onclick="return false">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#select-school"><i class="fa-solid fa-pen-to-square"></i></button>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <div class="modal fade" id="confirm-associate-new-school" tabindex="-1"
        aria-labelledby="confirm-associate-new-schoolLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <form
                    action="{{ route('account-manager.student-management.school.associate', ['student' => $student->id]) }}"
                    method="post">
                    @csrf
                    <input type="hidden" name="school_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-associate-new-schoolLabel">Confirm New Association</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="search">
                            <p>Are you sure that you want to associate <b class="school-name">'School name'</b> with this
                                student?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-target="#select-school" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @yield('select-school-model')
@endsection

@push('scripts')
    <script>
        let confirmNewAssociationModelContainer = $("#confirm-associate-new-school");
        let confirmNewAssociationModel = new bootstrap.Modal(document.getElementById('confirm-associate-new-school'), {});
        registerSchoolSelectedEventObserver(function(data) {
            console.log(data);
            confirmNewAssociationModelContainer.find(".school-name").text(data.name);
            confirmNewAssociationModelContainer.find("input[name=school_id]").val(data.id);
            selectSchoolModel.hide();
            confirmNewAssociationModel.show();
        });
    </script>
@endpush
