@extends('layouts.left-menu-page')
@include('menues.account-parent-left-menu')

@section('left-menu')
    @yield('account-parent-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-tv fa-sm"></i>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Dashboard</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content-main')
    <main class="menu-content-body">
        <div class="container m-0">
            <div class="row">
                @foreach ($data->childs as $child)
                    <div class="col-12 col-md-6 col-lg-4 p-2">
                        <div class="bg-white rounded shadow p-4 d-flex flex-column">
                            <h6><b>Student #{{ $child->id }}</b></h6>
                            <span class="fw-lighter mt-2 fs-7">Name</span>
                            <span>{{ $child->firstname }} {{ $child->lastname }}</span>
                            <span class="fw-lighter mt-2 fs-7">School</span>
                            <span>{{ $child->school->name }}</span>
                            <span class="fw-lighter mt-2 fs-7">Index Number</span>
                            <span>{{ $child->local_index }}</span>
                            <span class="fw-lighter mt-2 fs-7">RFID Tag ID</span>
                            <span>{{ $child->tag_id }}</span>

                            <div class="mt-4">
                                <a href="{{ route('parent.attendances', ['student' => $child->id]) }}"
                                    class="btn btn-sm btn-primary">View Attendance</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
