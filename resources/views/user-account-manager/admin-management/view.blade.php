@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('user-system-admin.admin-management.navigation')


@include('snippets.no-result', [
    'title' => 'Hmm...',
    'message' => 'There are no schools associated with this admin.',
])



@section('left-menu')
    @yield('system-admin-left-menu')
@endsection


@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-school fa-sm"></i>Schools</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account-manager.school-management') }}">Schools</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Account Manager #{{ $admin->id }}</a></li>
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
                        <a href="{{ route('account-manager.school-management') }}" class="btn btn-light me-2"><i
                                class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                    </div>
                </div>

                @if ($admin->AssociatedSchools->count() > 0)
                    <div class="mt-4 p-0 ">
                        <div class="d-flex bg-white shadow-lg rounded justify-content-between align-items-center px-4 py-3">
                            <h5 class="m-0">Associated Schools</h5>
                        </div>
                        <div class="container">
                            @foreach ($admin->AssociatedSchools as $associatedSchool)
                                <div target="_new"
                                    class="bg-white text-dark text-decoration-none shadow row rounded p-2 school mt-3">
                                    <div class="col-12 mb-2 mb-md-0 col-md-2 d-flex flex-column">
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
                                </div>
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


@endsection
