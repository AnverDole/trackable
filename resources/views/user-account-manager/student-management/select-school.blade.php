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
                        <form id="search-school-form" onsubmit="return searchSchools()">
                            <div class="row g-2">
                                <div class="col-12 col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="school_name" name="name"
                                            placeholder="Search school name" value="{{ request()->get('name') }}">
                                        <label for="school_name">School name</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="province" name="province" aria-label="Province">
                                            <option selected value="">Choose one</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}"
                                                    @if (request()->get('province') == $province->id) selected @endif>
                                                    {{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="province">Province</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="city" name="city" aria-label="City">
                                            <option selected value="">Choose one</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    @if (request()->get('city') == $city->id) selected @endif>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="city">City</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3  pb-4">
                                <button type="button" onclick="clearSearch()" class="btn btn-light me-2"><i
                                        class="fa-solid fa-rotate-left"></i>&nbsp;Reset</button>
                                <button class="btn btn-primary"><i
                                        class="fa-solid fa-magnifying-glass"></i>&nbsp;Search</button>
                            </div>
                        </form>
                        <div id="search-not-initiated" class="w-100 py-4 my-4 px-2 d-flex flex-column align-items-center">
                            <img src="{{ asset('images/ilustrations/starry-window.svg') }}" alt="No results"
                                style="max-width: 80px; width:100%">
                            <h3 class="mt-4">Search schools</h3>
                            <p>Enter name, province or city to find the school...</p>

                        </div>
                        <div id="search-no-results"
                            class="w-100 py-4 my-4 px-2 d-flex flex-column align-items-center d-none">
                            <img src="{{ asset('images/ilustrations/starry-window.svg') }}" alt="No results"
                                style="max-width: 80px; width:100%">
                            <h3 class="mt-4">Ops...</h3>
                            <p>No schools were found in your search.</p>
                        </div>
                        <div id="search-results" class="container d-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectSchoolObservers = [];


        let schoolSearchForm = $("#search-school-form");
        let searchResultsContainer = $("#search-results");
        let searchNoResultsContainer = $("#search-no-results");
        let searchNotInitiated = $("#search-not-initiated");

        let schoolName = schoolSearchForm.find("#school_name");
        let province = schoolSearchForm.find("#province");
        let city = schoolSearchForm.find("#city");

        let selectSchoolModelContainer = $("#select-school");

        let selectSchoolModel = new bootstrap.Modal(document.getElementById('select-school'), {});



        function clearSearch() {
            searchNoResultsContainer.addClass("d-none");
            searchNotInitiated.removeClass("d-none");
            searchResultsContainer.addClass("d-none");
            searchResultsContainer.html("");

            schoolName.val("");
            province.val("");
            city.val("");
        }

        function searchSchools() {
            searchResultsContainer.html("");

            axios.post("{{ route('account-manager.school-management.select-school') }}", {
                    name: schoolName.val(),
                    province: province.val(),
                    city: city.val()
                })
                .then(function(response) {
                    let schools = response.data || [];

                    searchResultsContainer.html("");

                    if (schools.length > 0) {
                        for (let school of schools) {
                            searchResultsContainer.append(searchResultHtml(school));
                        }
                        searchNoResultsContainer.addClass("d-none");
                        searchNotInitiated.addClass("d-none");
                        searchResultsContainer.removeClass("d-none");
                    } else {
                        searchNoResultsContainer.removeClass("d-none");
                        searchNotInitiated.addClass("d-none");
                        searchResultsContainer.addClass("d-none");
                    }

                })
                .catch(function(error) {
                    console.log(error.response)
                });

            return false;
        }

        function searchResultHtml(school) {
            let html = `<div class="s-school bg-white text-dark text-decoration-none border row rounded p-2 mt-3 align-items-center">
                    <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                        <small class="fw-lighter">ID</small>
                        <span>${school.id}</span>
                    </div>
                    <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                        <small class="fw-lighter">Name</small>
                        <span>${school.name}</span>
                    </div>
                    <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                        <small class="fw-lighter">Province & City</small>
                        <span>${school.city.province.name} - ${school.city.name}</span>
                    </div>
                    <div class="col-12 col-md-3 d-flex flex-column">
                        <button class="btn btn-light select" province="${school.city.province.name}" city="${school.city.name}" school-name="${school.name}" school-id="${school.id}"><i class="fas fa-plus-square"></i>&nbsp;Select</button>
                    </div>
                </div>`;

            return html;
        }

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
