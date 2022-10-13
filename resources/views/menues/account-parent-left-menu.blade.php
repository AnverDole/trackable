@section('account-parent-left-menu')
    <nav>

        <ul>
            <li>
            <a href="{{ route('parent.dashboard') }}" @hasCurrentRoute('parent.dashboard') current="true" @else current="false"
                    @endif><i class="fa-solid fa-tv"></i><span>Dashboard</span></a>
            </li>

            <li>
                <a href="{{ route('parent.profile-management') }}" @hasCurrentRoute('parent.profile-management') current="true" @endif><i class="fa-solid fa-user-gear"></i><span>Profile Management</span></a>
            </li>
            <li>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#logout-model"><i
                        class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
            </li>
        </ul>
    </nav>
@endsection
