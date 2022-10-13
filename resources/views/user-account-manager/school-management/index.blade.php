@extends('layouts.left-menu-page')
@include('menues.account-manager-left-menu')
@include('snippets.no-result', ['message' => 'There are no schools found for your query..'])

@section('left-menu')
    @yield('account-manager-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-school fa-sm"></i>Schools</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account-manager.school-management') }}">Schools</a></li>
            </ol>
        </nav>
    </div>
@endsection



@section('content-main')
    <main class="menu-content-body">
        @yield('school.management.navigation')


        @if ($schools->count() > 0)
            <div class="w-100 mt-2 container">
                <div class="row">
                    @foreach ($schools as $school)
                        <a href="{{ route('account-manager.school-management.view', ['school' => $school->id]) }}"
                            class="bg-white text-dark text-decoration-none card-hover shadow rounded p-4 school col-12 col-md-4 me-4 mb-4">
                            <div class="col-12 mb-2 mb-md-0 d-flex flex-column">
                                <h4 class="fw-lighter">School #{{$school->id}}</h4>
                            </div>
                            <div class="col-12 mb-2 mb-md-0 d-flex flex-column mt-2">
                                <small class="fw-lighter">Name</small>
                                <span>{{ $school->name }}</span>
                            </div>
                            <div class="col-12 mb-2 mb-md-0 d-flex flex-column mt-2">
                                <small class="fw-lighter">Province</small>
                                <span>{{ $school->City->Province->name ?? 'N/A' }}</span>
                            </div>
                            <div class="col-12 ol-md-4 d-flex flex-column mt-2">
                                <small class="fw-lighter">City</small>
                                <span>{{ $school->City->name ?? 'N/A' }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            @yield('no-result')
        @endif
    </main>
@endsection
