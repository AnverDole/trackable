@extends('layouts.left-menu-page')
@include('menues.account-parent-left-menu')

@section('left-menu')
    @yield('account-parent-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-tv fa-sm"></i>Attendances</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Student #{{ $data->student->id }}</a>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Attendance</a>
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>Student #{{ $data->student->id }}</h4>
            <div class="container">
                <div class="row p-0">
                    <div class="col-12 col-md-6 d-flex flex-column p-0">
                        <span class="fw-lighter">Name</span>
                        <span>{{ $data->student->firstname }} {{ $data->student->lastname }}</span>
                    </div>
                </div>
                <div class="row p-0 mt-2">
                    <div class="col-12 col-md-6 d-flex flex-column p-0">
                        <span class="fw-lighter">RFID Tag ID</span>
                        <span>{{ $data->student->tag_id }}</span>
                    </div>
                    <div class="col-12 col-md-6 d-flex flex-column p-0">
                        <span class="fw-lighter">Index Number</span>
                        <span>{{ $data->student->local_index }}</span>
                    </div>
                </div>
                <div class="row p-0 mt-2">
                    <div class="col-12 col-md-6 d-flex flex-column p-0">
                        <span class="fw-lighter">School</span>
                        <span>{{ $data->student->School->name }} - {{ $data->student->School->city->name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-lg w-100 rounded p-4 mt-4">
            <h4>Search Attendance</h4>
            <form action="{{ route('parent.attendances', ['student' => $data->student->id]) }}" method="get">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="attendance_date" name="attendance_date"
                                placeholder="Search Local Index" value="{{ request()->get('attendance_date') }}">
                            <label for="attendance_date">Date</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('parent.attendances', ['student' => $data->student->id]) }}"
                        class="btn btn-light me-2"><i class="fa-solid fa-rotate-left"></i>&nbsp;Reset</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        @if ($data->attendances->count() > 0)
            <div class="w-100 mt-4 container">
                @foreach ($data->attendances as $attendance)
                    <div class="bg-white text-dark text-decoration-none  shadow row rounded p-2 school mt-3">
                        <div class="col-12 mb-2 mb-lg-0 col-lg-6 d-flex flex-column">
                            <small class="fw-lighter">Direction</small>
                            <span>
                                @if ($attendance->DirectionText == 'In')
                                    <span class="text-success"><i class="fa-solid fa-arrow-right-long"></i></span>
                                @else
                                    <span class="text-info"><i class="fa-solid fa-arrow-left-long"></i></span>
                                @endif
                                {{ $attendance->DirectionText }}
                            </span>
                        </div>

                        <div class="col-12 col-lg-6 d-flex flex-column align-lg-items-end">
                            <div class="d-flex flex-column">
                                <small class="fw-lighter">Date & Time</small>
                                <span>{{ $attendance->created_at->format('Y-m-d H:i A') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $data->attendances->links() }}
        @else
            @yield('no-result')
        @endif
    </main>
@endsection
