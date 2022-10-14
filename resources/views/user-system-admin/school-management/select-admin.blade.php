@section('select-admin-model')
    <div class="modal fade modal-lg" id="select-admin" tabindex="-1" aria-labelledby="select-adminLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="select-adminLabel">Select Account Manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="search" style="min-height: 350px">
                        <form id="search-admin-form" onsubmit="return searchAdmins()">
                            <div class="row g-2">
                                <div class="col-12 col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="admin_name" name="name"
                                            placeholder="Search name" value="{{ request()->get('name') }}">
                                        <label for="admin_name">Name</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Search email" value="{{ request()->get('email') }}">
                                        <label for="email">Email</label>
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
                            <h3 class="mt-4">Search Account Managers</h3>
                            <p>Enter name or email to find the account manager...</p>

                        </div>
                        <div id="search-no-results"
                            class="w-100 py-4 my-4 px-2 d-flex flex-column align-items-center d-none">
                            <img src="{{ asset('images/ilustrations/starry-window.svg') }}" alt="No results"
                                style="max-width: 80px; width:100%">
                            <h3 class="mt-4">Ops...</h3>
                            <p>No account managers were found in your search.</p>
                        </div>
                        <div id="search-results" class="container d-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-associate-new-admin" tabindex="-1"
        aria-labelledby="confirm-associate-new-adminLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <form action="{{ route('school-management.admin.associate', ['school' => $school->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="admin_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-associate-new-adminLabel">Confirm New Association</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="search">
                            <p>Are you sure that you want to associate <b class="admin-name">'Admin name'</b> with this school?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-target="#select-admin" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let adminSearchForm = $("#search-admin-form");
        let searchResultsContainer = $("#search-results");
        let searchNoResultsContainer = $("#search-no-results");
        let searchNotInitiated = $("#search-not-initiated");

        let adminName = adminSearchForm.find("#admin_name");
        let email = adminSearchForm.find("#email");

        let selectAdminModelContainer = $("#select-admin");
        let confirmNewAssociationModelContainer = $("#confirm-associate-new-admin");
        let selectAdminModel = new bootstrap.Modal(document.getElementById('select-admin'), {});
        let confirmNewAssociationModel = new bootstrap.Modal(document.getElementById('confirm-associate-new-admin'), {});

        function clearSearch() {
            searchNoResultsContainer.addClass("d-none");
            searchNotInitiated.removeClass("d-none");
            searchResultsContainer.addClass("d-none");
            searchResultsContainer.html("");

            adminName.val("");
            email.val("");
        }

        function searchAdmins() {
            searchResultsContainer.html("");
            axios.post("{{ route('admin-management.select-admin') }}", {
                    name: adminName.val(),
                    email: email.val()
                })
                .then(function(response) {
                    let admins = response.data || [];

                    searchResultsContainer.html("");

                    if (admins.length > 0) {
                        for (let admin of admins) {
                            searchResultsContainer.append(searchResultHtml(admin));
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

        function searchResultHtml(admin) {
            let html = `<div class="s-admin bg-white text-dark text-decoration-none border row rounded p-2 mt-3 align-items-center">
                    <div class="col-12 mb-2 mb-md-0 col-md-1 d-flex flex-column">
                        <small class="fw-lighter">ID</small>
                        <span>${admin.id}</span>
                    </div>
                    <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                        <small class="fw-lighter">Name</small>
                        <span>${admin.firstname} ${admin.lastname}</span>
                    </div>
                    <div class="col-12 mb-4 mb-md-0 col-md-4 d-flex flex-column">
                        <small class="fw-lighter">Email</small>
                        <span>${admin.email}</span>
                    </div>
                    <div class="col-12 col-md-3 d-flex flex-column">
                        <button class="btn btn-light select" admin-id="${admin.id}" admin-name="${admin.firstname} ${admin.lastname}"><i class="fas fa-plus-square"></i>&nbsp;Select</button>
                    </div>
                </div>`;

            return html;
        }

        $(document).on("click", "#search-results .s-admin .select", function() {
            let school = $(this);
            let name = school.attr("admin-name");
            let id = school.attr("admin-id");
            confirmNewAssociationModelContainer.find(".admin-name").text(name);
            confirmNewAssociationModelContainer.find("input[name=admin_id]").val(id);
            selectAdminModel.hide();
            confirmNewAssociationModel.show();
        });
    </script>
@endpush
