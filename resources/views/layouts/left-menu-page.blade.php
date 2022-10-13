@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ mix('styles/left-menu-page/left-menu-page.css') }}">
@endpush


@section('body')
    <div id="left-menu-page" class="left-menu-page container"
        collapsed="{{ Cookie::get('left_menu') == '1' ? 'true' : 'false' }}">
        <aside class="shadow">
            <div class="menu-head">
                <button id="left-menu-toggle" class="menu-toggle">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <img src="{{ asset('logo/logo.png') }}" alt="Logo">
            </div>
            <div class="auth-info">
                <span class="name text-truncate" style="max-width: 100%;">{{ Auth::user()->firstname }}
                    {{ Auth::user()->lastname }}</span>
                <span class="email text-truncate" style="max-width: 100%;">{{ Auth::user()->email }}</span>
                <span class="role text-truncate" style="max-width: 100%;">{{ Auth::user()->roleText() }}</span>
            </div>
            @yield('left-menu')
        </aside>
        <div class="content">
            @yield('content-head')
            @yield('content-main')

            @hasSection('content-footer')
                @yield('content-footer')
            @else
                <div class="content-footer">
                    <span class="fw-light">{{ config('app.copyright') }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="logout-model" tabindex="-1" aria-labelledby="logout-modelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('auth.signout') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logout-modelLabel">Loggin Out</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to log out of your account?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i
                                class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function init() {
            let rootContainer = $("#left-menu-page");

            $("#left-menu-toggle").on("click", function() {
                if (rootContainer.attr("collapsed") == "true") {
                    rootContainer.attr("collapsed", "false");
                    rememberMenuState(false);
                } else {
                    rootContainer.attr("collapsed", "true");
                    rememberMenuState(true);
                }


            });

            function rememberMenuState(isCollapsed) {
                document.cookie = "left_menu=" + (isCollapsed == true ? "1" : "0");
            }

            function isMenuOpened() {
                var name = "left_menu" + "=";
                var ca = document.cookie.split(';');
                var state = null;
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i].trim();
                    if (c.indexOf(name) == 0) {
                        state = c.substring(name.length, c.length);
                    }
                }

                return state == 1;
            }

        })();
    </script>
@endpush

@push("scripts")
    <script src="{{mix('scripts/app.js')}}"></script>
@endpush
