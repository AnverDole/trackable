@extends('layouts.left-menu-page')
@include('menues.account-manager-left-menu')
@include('user-account-manager.parent-management.navigation')
@include('snippets.no-result', ['message' => 'There are no parents found for your query..'])


@section('left-menu')
    @yield('account-manager-left-menu')
@endsection

@section('content-head')
    <div class="menu-content-head">
        <h1><i class="fa-solid fa-chalkboard-user"></i>Parents</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account-manager.parent-management') }}">Parents</a></li>
            </ol>
        </nav>
    </div>
@endsection



@section('content-main')
    <main class="menu-content-body">
        @yield('parent.management.navigation')

        <div class="bg-white shadow-lg w-100 rounded p-4">
            <h4>Search Parent</h4>
            <form action="{{ route('account-manager.parent-management') }}" method="get">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                placeholder="Search Name" value="{{ request()->get('name') }}">
                            <label for="name">Name</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                placeholder="Search Email" value="{{ request()->get('email') }}">
                            <label for="email">Email</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number"
                                placeholder="Search Phone Number" value="{{ request()->get('phone_number') }}">
                            <label for="phone_number">Phone Number</label>
                            @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('account-manager.parent-management') }}" class="btn btn-light me-2"><i
                            class="fa-solid fa-rotate-left"></i>&nbsp;Reset</a>
                    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search</button>
                </div>
            </form>
        </div>

        @if ($parents->count() > 0)
            <div class="w-100 mt-4 container">
                @foreach ($parents as $parent)
                    <a href="{{ route('account-manager.parent-management.view', ['parent' => $parent->id]) }}"
                        class="bg-white text-dark text-decoration-none  card-hover shadow row rounded p-2 school mt-3">
                        <div class="col-12 mb-2 mb-lg-0 col-lg-1 d-flex flex-column">
                            <small class="fw-lighter">ID</small>
                            <span>{{ $parent->id }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 d-flex flex-column">
                            <small class="fw-lighter">Name</small>
                            <span>{{ $parent->firstname . ' ' . $parent->lastname }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 d-flex flex-column">
                            <small class="fw-lighter">Email</small>
                            <span>{{ $parent->email }}</span>
                        </div>
                        <div class="col-12 mb-2 mb-lg-0 col-lg-3 d-flex flex-column">
                            <small class="fw-lighter">Phone Number</small>
                            <span>{{ $parent->telephone }}</span>
                        </div>
                        <div class="col-12 col-lg-1 d-flex flex-column align-lg-items-end">
                            <div class="d-flex flex-column">
                                <small class="fw-lighter">Status</small>
                                @if ($parent->is_active)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Deactivated</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{ $parents->links() }}
        @else
            @yield('no-result')
        @endif
    </main>
@endsection
