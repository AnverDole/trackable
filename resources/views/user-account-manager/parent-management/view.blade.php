@extends('layouts.left-menu-page')

@include('menues.account-manager-left-menu')
@include('user-system-admin.student-management.navigation')


@include('snippets.no-result', [
    'title' => 'Hmm...',
    'message' => 'There are no students associated with this parent.',
])


@section('left-menu')
    @yield('account-manager-left-menu')
@endsection


@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-chalkboard-user"></i>Parents</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account-manager.parent-management') }}">Parents</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Parent #{{ $parent->id }}</a></li>
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

        <div class="container">
            <div class="row">
                <div class="bg-white shadow-lg w-100 rounded p-4">
                    <h4>Parent #{{ $parent->id }}</h4>

                    <div class="container p-0">
                        <div class="row">
                            <div class="col-12 col-md-6 d-flex flex-column align-items-start">
                                <span class="fw-light">Status</span>
                                @if ($parent->is_active)
                                    <p class="badge bg-success">Active</p>
                                @else
                                    <p class="badge bg-danger">Deactivated</p>
                                @endif
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12 col-md-6">
                                <span class="fw-light">Name</span>
                                <p>{{ $parent->firstname . ' ' . $parent->lastname }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Address</span>
                                <p>{{ $parent->Address }}</p>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12 col-md-6">
                                <span class="fw-light">Email</span>
                                <p>{{ $parent->email }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="fw-light">Phone Number</span>
                                <p>{{ $parent->telephone }}</p>
                            </div>
                        </div>




                    </div>
                    <div class="mt-4">
                        <a href="{{ route('account-manager.parent-management') }}" class="btn btn-light me-2"><i
                                class="fa-solid fa-circle-arrow-left"></i>&nbsp;Back</a>
                        <a href="{{ route('account-manager.parent-management.edit', ['parent' => $parent->id]) }}"
                            class="btn btn-light me-2"><i class="fa-solid fa-pen"></i>&nbsp;Edit</a>
                    </div>
                </div>


            </div>
            <div class="row">
                @if ($parent->Childs->count() > 0)
                    <div class="mt-4 p-0 ">
                        <div class="d-flex bg-white shadow-lg rounded justify-content-between align-items-center px-4 py-3">
                            <h5 class="m-0">Childs</h5>
                        </div>
                        <div class="container">
                            @foreach ($parent->Childs as $child)
                                <a href="{{ route('account-manager.student-management.view', ['student' => $child->id]) }}" target="_blank"
                                    target="_new"
                                    class="bg-white text-dark text-decoration-none card-hover shadow row rounded p-2 school mt-3">
                                    <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                                        <small class="fw-lighter">ID</small>
                                        <span>{{ $child->id }}</span>
                                    </div>
                                    <div class="col-12 mb-2 mb-md-0 col-md-4 d-flex flex-column">
                                        <small class="fw-lighter">Name</small>
                                        <span>{{ $child->firstname . ' ' . $child->lastname }}</span>
                                    </div>
                                    <div class="col-12 mb-2 mb-md-0 col-md-4 d-flex flex-column">
                                        <small class="fw-lighter">School</small>
                                        <span>{{ $child->school->name }} - {{$child->school->City->name}}</span>
                                    </div>
                                    <div class="col-12 mb-2 mb-md-0 col-md-3 d-flex flex-column">
                                        <small class="fw-lighter">Status</small>
                                        @if($child->is_active)
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="text-danger">Deactivated</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-4 bg-white shadow-lg rounded p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Childs</h5>
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
