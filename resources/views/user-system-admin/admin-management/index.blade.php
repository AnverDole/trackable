@extends('layouts.left-menu-page')
@include('menues.system-admin-left-menu')
@include('user-system-admin.admin-management.navigation')
@include('snippets.no-result', ['message' => 'There are no admins found for your query..'])


@section('left-menu')
    @yield('system-admin-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-user-tie"></i>Admin Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-management') }}">Admin Management</a></li>
            </ol>
        </nav>
    </div>
@endsection



@section('content-main')
    <main class="menu-content-body">
        @yield('admin.management.navigation')

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>Search Admins</h4>
            <form action="{{ route('admin-management') }}" method="get">
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
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Search email" value="{{ request()->get('email') }}">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select" id="admin_role" name="admin_role" aria-label="Admin Role">
                                <option selected value="">Any</option>
                                @foreach ($adminRoles as $adminId => $adminRole)
                                    <option value="{{ $adminId }}" @if (request()->get('admin_role') == $adminId) selected @endif>
                                        {{ $adminRole }}</option>
                                @endforeach
                            </select>
                            <label for="admin_role">Admin Role</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('admin-management') }}" class="btn btn-light me-2"><i
                            class="fa-solid fa-rotate-left"></i>&nbsp;Reset</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        @if ($admins->count() > 0)
            <div class="w-100 mt-4 container">
                @foreach ($admins as $admin)
                    <a href="{{ route('admin-management.view', ['admin' => $admin->id]) }}"
                        class="bg-white text-dark text-decoration-none card-hover shadow row rounded p-2 school mt-3">
                        <div class="col-12 mb-2 mb-lg-0 col-lg-1 d-flex flex-column">
                            <small class="fw-lighter">ID</small>
                            <span>{{ $admin->id }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 d-flex flex-column">
                            <small class="fw-lighter">Name</small>
                            <span>{{ $admin->firstname . ' ' . $admin->lastname }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-4 d-flex flex-column">
                            <small class="fw-lighter">Email</small>
                            <span class="text-truncate">{{ $admin->email }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 ol-lg-5 d-flex flex-column">
                            <div class="d-flex flex-column">
                                <small class="fw-lighter">Role</small>
                                <span class="text-truncate">{{ $admin->roleText() }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-1 d-flex flex-column align-lg-items-end">
                            <div class="d-flex flex-column">
                                <small class="fw-lighter">Status</small>
                                @if ($admin->is_active)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Deactivated</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{ $admins->links() }}
        @else
            @yield('no-result')
        @endif
    </main>
@endsection
