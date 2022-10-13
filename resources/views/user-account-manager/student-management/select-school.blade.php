@section('select-school-model')
    <div class="modal fade modal-lg" id="select-school" tabindex="-1" aria-labelledby="select-schoolLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="select-schoolLabel">Select School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="search" style="min-height: 350px">
                        @if ($schools->count() > 0)
                            <div id="search-results" class="container">
                                @foreach ($schools as $school)
                                    <div
                                        class="s-school bg-white text-dark text-decoration-none border row rounded p-2 mt-3 align-items-center">
                                        <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                                            <small class="fw-lighter">ID</small>
                                            <span>{{ $school->id }}</span>
                                        </div>
                                        <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                                            <small class="fw-lighter">Name</small>
                                            <span>{{ $school->name }}</span>
                                        </div>
                                        <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                                            <small class="fw-lighter">Province & City</small>
                                            <span>{{ $school->City->Province->name }} - {{ $school->City->name }}</span>
                                        </div>
                                        <div class="col-12 col-md-3 d-flex flex-column">
                                            <button class="btn btn-light select"
                                                province="{{ $school->city->province->name }}"
                                                city="{{ $school->city->name }}" school-name="{{ $school->name }}"
                                                school-id="{{ $school->id }}"><i
                                                    class="fas fa-plus-square"></i>&nbsp;Select</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div id="search-no-results"
                                class="w-100 py-4 my-4 px-2 d-flex flex-column align-items-center d-none">
                                <img src="{{ asset('images/ilustrations/starry-window.svg') }}" alt="No results"
                                    style="max-width: 80px; width:100%">
                                <h3 class="mt-4">Ops...</h3>
                                <p>No schools were found in your search.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectSchoolObservers = [];

        let searchResultsContainer = $("#search-results");

        let selectSchoolModelContainer = $("#select-school");

        let selectSchoolModel = new bootstrap.Modal(document.getElementById('select-school'), {});


        function registerSchoolSelectedEventObserver(callback) {
            selectSchoolObservers.push(callback)
        }

        function executeSchoolSelectedEventObservers(data) {
            for (selectSchoolObserver of selectSchoolObservers) {

                selectSchoolObserver(data);
            }
        }

        $(document).on("click", "#search-results .s-school .select", function() {
            let school = $(this);
            let name = school.attr("school-name");
            let id = school.attr("school-id");
            let province = school.attr("province");
            let city = school.attr("city");

            executeSchoolSelectedEventObservers({
                id,
                name,
                province,
                city
            });

            selectSchoolModel.hide();
        });
    </script>
@endpush
