@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('user-system-admin.school-management.navigation')
@include('snippets.no-result', ['message' => 'There are no schools found for your query..'])

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
            <h4>Search Schools</h4>
            <form action="{{ route('school-management') }}" method="get">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="school_name" name="name"
                                placeholder="Search school name" value="{{ request()->get('name') }}">
                            <label for="school_name">School name</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select" id="province" name="province" aria-label="Province">
                                <option selected value="">Any</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" @if (request()->get('province') == $province->id) selected @endif>
                                        {{ $province->name }}</option>
                                @endforeach
                            </select>
                            <label for="province">Province</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select" id="city" name="city" aria-label="City">
                                <option selected value="">Any</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @if (request()->get('city') == $city->id) selected @endif>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                            <label for="city">City</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('school-management') }}" class="btn btn-light me-2"><i
                            class="fa-solid fa-rotate-left"></i>&nbsp;Reset</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        @if ($schools->count() > 0)
            <div class="w-100 mt-4 container">
                @foreach ($schools as $school)
                    <a href="{{ route('school-management.view', ['school' => $school->id]) }}"
                        class="bg-white text-dark text-decoration-none card-hover shadow row rounded p-2 school mt-3">
                        <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                            <small class="fw-lighter">ID</small>
                            <span>{{ $school->id }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-md-0 col-md-5 d-flex flex-column">
                            <small class="fw-lighter">Name</small>
                            <span>{{ $school->name }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-md-0 col-md-3 d-flex flex-column">
                            <small class="fw-lighter">Province</small>
                            <span>{{ $school->City->Province->name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-12 col-md-3 ol-md-4 d-flex flex-column">
                            <small class="fw-lighter">City</small>
                            <span>{{ $school->City->name ?? 'N/A' }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            {{ $schools->links() }}
        @else
            @yield('no-result')
        @endif
    </main>
@endsection
