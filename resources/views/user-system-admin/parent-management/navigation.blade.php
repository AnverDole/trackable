@section('parent.management.navigation')
    <nav>
        <div class="btn-group bg-white p-1 mb-4" role="group" aria-label="Navigation">
            <a href="{{route('parent-management')}}" class="btn @isCurrentRoute('parent-management') btn-primary @else btn-secondery @endif">All parents</a>
            <a href="{{route('parent-management.new')}}" class="btn @isCurrentRoute('parent-management.new') btn-primary @else btn-secondery @endif">New parent</a>
        </div>
    </nav>
@endsection
