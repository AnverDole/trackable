@section('parent.management.navigation')
    <nav>
        <div class="btn-group bg-white p-1 mb-4" role="group" aria-label="Navigation">
            <a href="{{route('account-manager.parent-management')}}" class="btn @isCurrentRoute('account-manager.parent-management') btn-primary @else btn-secondery @endif">All Parents</a>
            <a href="{{route('account-manager.parent-management.new')}}" class="btn @isCurrentRoute('account-manager.parent-management.new') btn-primary @else btn-secondery @endif">New Parent</a>
        </div>
    </nav>
@endsection
