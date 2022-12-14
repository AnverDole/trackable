@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')

@section('left-menu')
    @yield('system-admin-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-tv fa-sm"></i>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sys.admin.dashboard') }}">Dashboard</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">
        <div class="container m-0">
            <h4 class="mb-3">Today's</h4>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="shadow bg-white rounded p-4 mb-4">
                        <h5 class="d-flex">Total Attendence</h5>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info fa-xl text-primary"></i>
                            <span class="fs-2 ms-2">{{$data->totalAttendance}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="shadow bg-white rounded p-4 mb-4">
                        <h5 class="d-flex">Absentees</h5>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info fa-xl text-primary"></i>
                            <span class="fs-2 ms-2">{{$data->absentees}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="shadow bg-white rounded p-4 mb-4">
                        <h5 class="d-flex">Late Students</h5>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info fa-xl text-primary"></i>
                            <span class="fs-2 ms-2">{{$data->lateStudents}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="mb-3 mt-4">Overall</h4>
            <div class="row">
                <a href="{{ route('school-management') }}" class="text-decoration-none col-12 col-md-6 col-lg-4">
                    <div class="shadow bg-white rounded p-4 mb-4">
                        <h5 class="d-flex text-dark">Schools</h5>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info fa-xl text-primary"></i>
                            <span class="fs-2 ms-2 text-dark">{{ $data->schools }}</span>
                        </div>
                    </div>
                </a>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="shadow bg-white rounded p-4 mb-4">
                        <h5 class="d-flex">Students</h5>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info fa-xl text-primary"></i>
                            <span class="fs-2 ms-2">{{$data->students}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
