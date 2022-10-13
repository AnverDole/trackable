@section('admin.management.navigation')
    <nav>
        <div class="btn-group bg-white p-1 mb-4" role="group" aria-label="Navigation">
            <a href="{{route('admin-management')}}" class="btn @isCurrentRoute('admin-management') btn-primary @else btn-secondery @endif">All Admins</a>
            <a href="{{route('admin-management.new')}}" class="btn @isCurrentRoute('admin-management.new') btn-primary @else btn-secondery @endif">New Admin</a>
        </div>
    </nav>
@endsection
