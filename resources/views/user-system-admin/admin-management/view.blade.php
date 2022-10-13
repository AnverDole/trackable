@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('user-system-admin.admin-management.select-school')
@include('user-system-admin.admin-management.navigation')

@section('no-result-bottom')
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#select-school"><i
            class="fa-solid fa-square-plus"></i>&nbsp;Associate Now</button>
@endsection

@include('snippets.no-result', [
    'title' => 'Hmm...',
    'message' => 'There are no schools associated with this admin.',
])



@section('left-menu')
    @yield('system-admin-left-menu')
@endsection


@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-school fa-sm"></i>Admin Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-management') }}">Admin Management</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin #{{ $admin->id }}</a></li>
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
                    <h4>Admin #{{ $admin->id }}</h4>

                    <div class="container p-0">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Role</span>
                                <p>{{ $admin->roleText() }}</p>
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-column align-items-start">
                                <span class="fw-light">Status</span>
                                @if ($admin->is_active)
                                    <p class="badge bg-success">Active</p>
                                @else
                                    <p class="badge bg-danger">Deactivated</p>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Name</span>
                                <p>{{ $admin->firstname . ' ' . $admin->lastname }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Email</span>
                                <p>{{ $admin->email }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Telephone</span>
                                <p>{{ $admin->telephone }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Address</span>
                                <p>{{ $admin->Address }}</p>
                            </div>
                        </div>

                    </div>
                    <div>
                        <a href="{{ route('admin-management') }}" class="btn btn-light me-2"><i
                                class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                        <a href="{{ route('admin-management.edit', ['admin' => $admin->id]) }}" class="btn btn-primary"><i
                                class="fa-solid fa-pen"></i>&nbsp;Edit</a>
                    </div>
                </div>

                @if ($admin->AssociatedSchools->count() > 0)
                    <div class="mt-4 p-0 ">
                        <div class="d-flex bg-white shadow-lg rounded justify-content-between align-items-center px-4 py-3">
                            <h5 class="m-0">Associated Schools</h5>
                            @if ($admin->AssociatedSchools->count() > 0)
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#select-school"><i class="fas fa-plus-square"></i></button>
                            @endif
                        </div>
                        <div class="container">
                            @foreach ($admin->AssociatedSchools as $associatedSchool)
                                <a href="{{ route('school-management.view', ['school' => $associatedSchool->id]) }}"
                                    target="_new"
                                    class="bg-white text-dark text-decoration-none card-hover shadow row rounded p-2 school mt-3">
                                    <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                                        <small class="fw-lighter">ID</small>
                                        <span>{{ $associatedSchool->id }}</span>
                                    </div>
                                    <div class="col-12 mb-2 mb-md-0 col-md-5 d-flex flex-column">
                                        <small class="fw-lighter">Name</small>
                                        <span>{{ $associatedSchool->name }}</span>
                                    </div>
                                    <div class="col-12 mb-2 mb-md-0 col-md-5 d-flex flex-column">
                                        <small class="fw-lighter">Province</small>
                                        <span>{{ $associatedSchool->City->Province->name }} -
                                            {{ $associatedSchool->City->name }}</span>
                                    </div>
                                    <div class="col-12 col-md-1 ol-md-4 d-flex justify-content-end" onclick="return false">
                                        <button type="button" class="btn btn-danger"
                                            school-id="{{ $associatedSchool->id }}"
                                            school-name="{{ $associatedSchool->name }}"
                                            onclick='confirmDeletePrompt(this)'><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-4 bg-white shadow-lg rounded p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Associated Schools</h5>
                            @if ($admin->AssociatedSchools->count() > 0)
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#select-school"><i class="fas fa-plus-square"></i></button>
                            @endif
                        </div>
                        <div class="row ">
                            <div class="row">
                                @yield('no-result')
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>


    <div class="modal fade" id="remove-school" tabindex="-1" aria-labelledby="remove-schoolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin-management.school.dissociate', ['admin' => $admin->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="school_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="remove-schoolLabel">Confirm Dissociation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="search">
                            <p>Are you sure that you want to dissociate <b class="school-name">'School name'</b> with this
                                admin
                                account?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-target="#select-school"
                            data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</button>
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
        let removeSchoolModelContainer = $("#remove-school");
        let removeSchoolModel = new bootstrap.Modal(document.getElementById('remove-school'), {});

        function confirmDeletePrompt(e) {
            let school_name = $(e).attr("school-name");
            let school_id = $(e).attr("school-id");

            removeSchoolModelContainer.find(".school-name").text(school_name);
            removeSchoolModelContainer.find("input[name=school_id]").val(school_id);
            removeSchoolModel.show();
        }
    </script>
@endpush
