@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('snippets.no-result', ['message' => 'There are no students found for your query..'])


@section('left-menu')
    @yield('system-admin-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-group"></i>Student Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('school-management') }}">School Management</a></li>
                <li class="breadcrumb-item"><a href="{{ route('school-management.view', ['school' => $school->id]) }}">School
                        #{{ $school->id }}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Students</a></li>
            </ol>
        </nav>
    </div>
@endsection



@section('content-main')
    <main class="menu-content-body">

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>Search Student</h4>
            <form action="{{ route('school-management.students', ['school' => $school->id]) }}" method="get">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Search name" value="{{ request()->get('name') }}">
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="rfid_tag" name="rfid_tag"
                                placeholder="Search RFID Tag ID" value="{{ request()->get('rfid_tag') }}">
                            <label for="rfid_tag">RFID Tag ID</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="local_index" name="local_index"
                                placeholder="Search Local Index" value="{{ request()->get('local_index') }}">
                            <label for="local_index">Local Index</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('student-management') }}" class="btn btn-light me-2"><i
                            class="fa-solid fa-rotate-left"></i>&nbsp;Reset</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        @if ($students->count() > 0)
            <div class="w-100 mt-4 container">
                @foreach ($students as $student)
                    <a href="{{ route('student-management.view', ['student' => $student->id]) }}" target="_new"
                        class="bg-white text-dark text-decoration-none  card-hover shadow row rounded p-2 school mt-3">
                        <div class="col-12 mb-2 mb-lg-0 col-lg-1 d-flex flex-column">
                            <small class="fw-lighter">ID</small>
                            <span>{{ $student->id }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 d-flex flex-column">
                            <small class="fw-lighter">Name</small>
                            <span>{{ $student->firstname . ' ' . $student->lastname }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 d-flex flex-column">
                            <small class="fw-lighter">RFID Tag ID</small>
                            <span>{{ $student->tag_id }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 d-flex flex-column">
                            <small class="fw-lighter">Local Index Number</small>
                            <span>{{ $student->local_index }}</span>
                        </div>
                        <div class="col-12 col-lg-1 d-flex flex-column align-lg-items-end">
                            <div class="d-flex flex-column">
                                <small class="fw-lighter">Status</small>
                                @if ($student->is_active)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Deactivated</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{ $students->links() }}
        @else
            @yield('no-result')
        @endif
    </main>
@endsection
