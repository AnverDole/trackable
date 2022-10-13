@section('select-parent-model')
    <div class="modal fade modal-lg" id="select-parent" tabindex="-1" aria-labelledby="select-parentLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="select-parentLabel">
                        Select Parents
                        <a href="{{ route('student-management.parents.new') }}" target="_blank" class="btn btn-primary"><i
                                class="fas fa-plus-square"></i>&nbsp;New</a>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="search" style="min-height: 350px">
                        <form id="search-parent-form" onsubmit="return searchParents()">
                            <div class="row g-2">
                                <div class="col-12 col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="parent_email" name="parent_email"
                                            placeholder="Search parent email" value="{{ request()->get('email') }}">
                                        <label for="parent_email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="parent_phone_number"
                                            name="parent_phone_number" placeholder="Search parent email"
                                            value="{{ request()->get('email') }}">
                                        <label for="parent_phone_number">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3  pb-4">
                                <button type="button" onclick="clearSearchParents()" class="btn btn-light me-2"><i
                                        class="fa-solid fa-rotate-left"></i>&nbsp;Reset</button>
                                <button class="btn btn-primary"><i
                                        class="fa-solid fa-magnifying-glass"></i>&nbsp;Search</button>
                            </div>
                        </form>
                        <div id="search-not-initiated-parents"
                            class="w-100 py-4 my-4 px-2 d-flex flex-column align-items-center">
                            <img src="{{ asset('images/ilustrations/starry-window.svg') }}" alt="No results"
                                style="max-width: 80px; width:100%">
                            <h3 class="mt-4">Search parents</h3>
                            <p>Enter email or phone number to find the parent...</p>

                        </div>
                        <div id="search-no-result-parents"
                            class="w-100 py-4 my-4 px-2 d-flex flex-column align-items-center d-none">
                            <img src="{{ asset('images/ilustrations/starry-window.svg') }}" alt="No results"
                                style="max-width: 80px; width:100%">
                            <h3 class="mt-4">Ops...</h3>
                            <p>No parents were found in your search.</p>
                        </div>
                        <div id="search-result-parents" class="container d-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectParentObservers = [];


        let parentSearchForm = $("#search-parent-form");
        let searchParentResultsContainer = $("#search-result-parents");
        let searchNoParentResultsContainer = $("#search-no-result-parents");
        let searchParentNotInitiated = $("#search-not-initiated-parents");

        let parentEmail = parentSearchForm.find("#parent_email");
        let parentPhoneNumber = parentSearchForm.find("#parent_phone_number");


        let selectParentModel = new bootstrap.Modal(document.getElementById('select-parent'), {});



        function clearSearchParents() {
            searchNoParentResultsContainer.addClass("d-none");
            searchParentNotInitiated.removeClass("d-none");
            searchParentResultsContainer.addClass("d-none");
            searchParentResultsContainer.html("");

            parentEmail.val("");
            parentPhoneNumber.val("");
        }

        function searchParents() {
            searchParentResultsContainer.html("");

            axios.post("{{ route('student-management.parents') }}", {
                    email: parentEmail.val(),
                    phone_number: parentPhoneNumber.val()
                })
                .then(function(response) {
                    let parents = response.data || [];

                    searchParentResultsContainer.html("");

                    if (parents.length > 0) {
                        for (let parent of parents) {
                            searchParentResultsContainer.append(searchParentResultHtml(parent));
                        }
                        searchNoParentResultsContainer.addClass("d-none");
                        searchParentNotInitiated.addClass("d-none");
                        searchParentResultsContainer.removeClass("d-none");
                    } else {
                        searchNoParentResultsContainer.removeClass("d-none");
                        searchParentNotInitiated.addClass("d-none");
                        searchParentResultsContainer.addClass("d-none");
                    }

                })
                .catch(function(error) {
                    console.log(error.response)
                });

            return false;
        }

        function searchParentResultHtml(parent) {
            let html = `<div class="s-parent bg-white text-dark text-decoration-none border row rounded p-2 mt-3 align-items-center">
                    <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                        <small class="fw-lighter">ID</small>
                        <span>${parent.id}</span>
                    </div>
                    <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                        <small class="fw-lighter">Name</small>
                        <span>${parent.firstname} ${parent.lastname}</span>
                    </div>
                    <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                        <small class="fw-lighter">Email</small>
                        <span>${parent.email}</span>
                    </div>

                    <div class="col-12 col-md-3 d-flex flex-column">
                        <button class="btn btn-light select" email="${parent.email}" parent-name="${parent.firstname} ${parent.lastname}" parent-id="${parent.id}"><i class="fas fa-plus-square"></i>&nbsp;Select</button>
                    </div>
                </div>`;

            return html;
        }

        function registerParentSelectedEventObserver(callback) {
            selectParentObservers.push(callback)
        }

        function executeParentSelectedEventObservers(data) {
            for (selectParentObserver of selectParentObservers) {
                selectParentObserver(data);
            }
        }

        $(document).on("click", "#search-result-parents .s-parent .select", function() {
            let parent = $(this);
            let email = parent.attr("email");
            let name = parent.attr("parent-name");
            let id = parent.attr("parent-id");

            executeParentSelectedEventObservers({
                id,
                email,
                name
            });

            selectParentModel.hide();
        });
    </script>
@endpush
