@section('student.management.navigation')
    <nav>
        <div class="btn-group bg-white p-1 mb-4" role="group" aria-label="Navigation">
            <a href="{{route('account-manager.student-management')}}" class="btn @isCurrentRoute('account-manager.student-management') btn-primary @else btn-secondery @endif">All Students</a>
            <a href="{{route('account-manager.student-management.new')}}" class="btn @isCurrentRoute('account-manager.student-management.new') btn-primary @else btn-secondery @endif">New Student</a>
        </div>
    </nav>
@endsection
