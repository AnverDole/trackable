@section('school.management.navigation')
    <nav>
        <div class="btn-group bg-white p-1 mb-4" role="group" aria-label="Navigation">
            <a href="{{route('school-management')}}" class="btn @isCurrentRoute('school-management') btn-primary @else btn-secondery @endif">All Schools</a>
            <a href="{{route('school-management.new')}}" class="btn @isCurrentRoute('school-management.new') btn-primary @else btn-secondery @endif">New School</a>
        </div>
    </nav>
@endsection
