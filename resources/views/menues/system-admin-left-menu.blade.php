@section('system-admin-left-menu')
    <nav>

        <ul>
            <li>
            <a href="{{ route('sys.admin.dashboard') }}" @hasCurrentRoute('sys.admin.dashboard') current="true" @else current="false"
                    @endif><i class="fa-solid fa-tv"></i><span>Dashboard</span></a>
            </li>

            <li>
            <a href="{{ route('school-management') }}" @hasCurrentRoute('school-management.new', 'school-management.view', 'school-management.edit', 'school-management', 'school-management.students', 'school-management.view.attendances') current="true" @else current="false" @endif><i class="fa-solid fa-school"></i><span>School
                        Management</span></a>
            </li>

            <li>
                <a href="{{ route('student-management') }}" @hasCurrentRoute('student-management', 'student-management.new', 'student-management.view', 'student-management.edit', 'student-management.view.attendances', 'student-management.parents', 'student-management.parents.new') current="true" @endif><i
                        class="fa-solid fa-user-group"></i><span>Student Management</span></a>
            </li>

            <li>
                <a href="{{ route('parent-management') }}" @hasCurrentRoute('parent-management', 'parent-management.new', 'parent-management.view', 'parent-management.edit') current="true" @endif><i
                        class="fa-solid fa-chalkboard-user"></i><span>Parent Management</span></a>
            </li>

            @hasRole('super-admin')
                <li>
                <a href="{{ route('admin-management') }}" @hasCurrentRoute('admin-management', 'admin-management.new', 'admin-management.view', 'admin-management.edit') current="true" @else current="false"
                        @endif><i class="fa-solid fa-user-tie"></i><span>Admin
                            Management</span></a>
                </li>
                @endif

                <li>
                    <a href="{{ route('profile-management') }}" @hasCurrentRoute('profile-management') current="true" @endif><i
                            class="fa-solid fa-user-gear"></i><span>Profile Management</span></a>
                </li>
                <li>
                    <a href="{{ route('sys.admin.dashboard') }}" data-bs-toggle="modal" data-bs-target="#logout-model"><i
                            class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
                </li>
            </ul>
        </nav>
    @endsection
