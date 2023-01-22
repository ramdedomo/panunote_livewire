<nav class="navbar fixed-top navbar-expand navbar-light navbar-bg"
    style="background-size: cover; background-image: url({{ asset('img/logos/panugame_banner_main.png') }})">

    <a class="sidebar-toggle js-sidebar-toggle"><i class="hamburger align-self-center rounded-5"></i></a>

    <a class="navbar-brand p-0 m-0 align-self-center text-dark fw-bold fs-3" href="{{route('/')}}">
        <img  style="width: 120px;" src="{{ asset('img/logos/panunote_logo.png') }}" alt="">
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            @livewire('panunote-top-bar')
            @livewire('panunote-request-notification')

            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block " href="#" data-bs-toggle="dropdown">
                    

                    <img style="object-fit: cover;"
                    @if(is_null($image) || empty($image))
                    src="{{ asset('img/avatars/default_dp.jpg') }}"
                    @else
                        src="data:image/png;base64,{{$image}}"
                    @endif
                    class="avatar img-fluid rounded-5 me-1"
                    alt="" 
                    />

                </a>

                <div class="dropdown-menu dropdown-menu-end">

                    <span class="dropdown-item-name fw-bold"></i>Hello {{ $username }}!</span>

                    <div class="dropdown-divider"></div>

                    {{-- <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1"
                            data-feather="user"></i> Profile</a> --}}
                    {{-- <a class="dropdown-item" href="#"><i class="align-middle me-1"
                            data-feather="pie-chart"></i> Analytics</a> --}}
                    <a class="dropdown-item" href="{{ route('logs') }}"><i class="align-middle me-1"
                            data-feather="list"></i>  Activity Logs</a>
                            
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('requestlist') }}"><i class="align-middle me-1"
                        data-feather="send"></i>  Request Access</a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('settings') }}"><i class="align-middle me-1"
                            data-feather="settings"></i> Profile Settings</a>
                    {{-- <a class="dropdown-item" href="#"><i class="align-middle me-1"
                            data-feather="help-circle"></i> Help Center</a> --}}
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item d-flex align-items-center justify-content-end fw-bold text-danger"
                        href="{{ route('signout') }}">

                        Log out
                        <span class="mx-1"></span>
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>

                </div>
            </li>

        </ul>
    </div>

</nav>
