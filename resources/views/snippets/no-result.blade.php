@section('no-result')
    <div class="w-100 py-5 my-4 px-2 d-flex flex-column align-items-center">
        <img src="{{ asset('images/ilustrations/starry-window.svg') }}" alt="No results" style="max-width: 150px; width:100%">
        <h3 class="mt-4">{{ $title ?? 'Ops...' }}</h3>
        <p>{{ $message ?? 'No results found' }}</p>

        @yield('no-result-bottom')

    </div>
@endsection
