@extends('layouts.left-menu-page')
@include('menues.account-manager-left-menu')


@section('no-result-bottom')
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#select-admin"><i
            class="fa-solid fa-square-plus"></i>&nbsp;Associate Now</button>
@endsection

@include('snippets.no-result', [
    'title' => 'Hmm...',
    'message' => 'There are no account managers associated with this school.',
])


@section('left-menu')
    @yield('account-manager-left-menu')
@endsection


@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-school fa-sm"></i>School Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('school-management') }}">School Management</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">School #{{ $school->id }}</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">

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

        <div class="container">
            <div class="row" style="max-width: 720px;width:100%">
                <div class="bg-white shadow-lg w-100 rounded p-4">
                    <h4>School #{{ $school->id }}</h4>

                    <div class="container p-0">
                        <div class="row">
                            <div class="col-6">
                                <span class="fw-light">Name</span>
                                <p>{{ $school->name }}</p>
                            </div>
                            <div class="col-6">
                                <span class="fw-light">Email</span>
                                <p>{{ $school->email }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <span class="fw-light">Telephone</span>
                                <p>{{ $school->telephone }}</p>
                            </div>
                            <div class="col-6">
                                <span class="fw-light">Address</span>
                                <p>{{ $school->Address }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <span class="fw-light">RFID Detectors (Mac Addresses)</span>
                                <p>{{ $school->RFIDDetectors->pluck('mac_address')->join(', ') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <a href="{{ route('account-manager.school-management') }}"
                            class="mt-2 col-md btn btn-light me-2"><i
                                class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                        <a href="{{ route('account-manager.school-management.students', ['school' => $school->id]) }}" class="mt-2 col-md btn btn-light me-2">
                            View Students</a>
                        <a href="{{ route('account-manager.school-management.view.attendances', ['school' => $school->id]) }}" class="mt-2 col-md btn btn-light me-2">
                            View Attendance</a>
                    </div>
                </div>
                @if ($school->AssociatedAccountManagers->count() > 0)
                    <div class="mt-4 p-0 ">
                        <div class="d-flex bg-white shadow-lg rounded justify-content-between align-items-center px-4 py-3">
                            <h5 class="m-0">Account Managers</h5>
                        </div>
                        <div class="container">
                            @foreach ($school->AssociatedAccountManagers as $AssociatedAccountManager)
                                <a href="{{ route('account-manager.admin-management.view', ['admin' => $AssociatedAccountManager->id]) }}"
                                    target="_new"
                                    class="bg-white text-dark text-decoration-none card-hover shadow row rounded p-2 school mt-3">
                                    <div class="col-12 mb-2 mb-md-0 col-md-2 d-flex flex-column">
                                        <small class="fw-lighter">ID</small>
                                        <span>{{ $AssociatedAccountManager->id }}</span>
                                    </div>
                                    <div class="col-12 mb-2 mb-md-0 col-md-5 d-flex flex-column">
                                        <small class="fw-lighter">Name</small>
                                        <span>{{ $AssociatedAccountManager->firstname . ' ' . $AssociatedAccountManager->lastname }}</span>
                                    </div>
                                    <div class="col-12 mb-2 mb-md-0 col-md-5 d-flex flex-column">
                                        <small class="fw-lighter">Email</small>
                                        <span>{{ $AssociatedAccountManager->email }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-4 bg-white shadow-lg rounded p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Account Managers</h5>
                            @if ($school->AssociatedAccountManagers->count() > 0)
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#select-admin"><i class="fas fa-plus-square"></i></button>
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

    <div class="modal fade" id="remove-admin" tabindex="-1" aria-labelledby="remove-adminLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <form action="{{ route('school-management.admin.dissociate', ['school' => $school->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="admin_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="remove-adminLabel">Confirm Dissociation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="search">
                            <p>Are you sure that you want to dissociate <b class="admin-name">'Admin name'</b> with this
                                school?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-target="#remove-admin" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
