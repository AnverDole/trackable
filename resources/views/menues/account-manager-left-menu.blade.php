@section('account-manager-left-menu')
    <nav>

        <ul>
            <li>
            <a href="{{ route('account-manager.dashboard') }}" @hasCurrentRoute('account-manager.dashboard') current="true" @else current="false"
                    @endif><i class="fa-solid fa-tv"></i><span>Dashboard</span></a>
            </li>

            <li>
            <a href="{{ route('account-manager.school-management') }}" @hasCurrentRoute('account-manager.school-management.new', 'account-manager.school-management.view', 'account-manager.school-management.edit', 'account-manager.school-management', 'account-manager.school-management.students', 'account-manager.school-management.view.attendances') current="true" @else
                    current="false" @endif><i class="fa-solid fa-school"></i><span>Schools</span></a>
            </li>
            <li>

            <li>
                <a href="{{ route('account-manager.student-management') }}" @hasCurrentRoute('account-manager.student-management', 'account-manager.student-management.new', 'account-manager.student-management.view', 'account-manager.student-management.edit', 'account-manager.student-management.view.attendances') current="true" @endif><i class="fa-solid fa-user-group"></i><span>Students</span></a>
            </li>
            <li>
                <a href="{{ route('account-manager.profile-management') }}" @hasCurrentRoute('account-manager.profile-management') current="true" @endif><i class="fa-solid fa-user-gear"></i><span>Profile Management</span></a>
            </li>
            <li>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#logout-model"><i
                        class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
            </li>
        </ul>
    </nav>
@endsection
