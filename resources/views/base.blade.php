@extends('base_clean')

@section('body')
    <header class="header" id="header">
        <div class="header_toggle"><i class='bx bx-menu' id="header-toggle"></i></div>
        <div class="d-flex align-items-center justify-content-around">
            <div class="header_img"><img src="https://i.imgur.com/hczKIze.jpg" alt=""></div>
            <div class="header_name ml-1">Hello, {{ Auth::user()?->name ?? "John Doe" }} </div>
        </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav_logo">
                    <img style="width: 50px" src="{{ Vite::image('logos/logo_red.png') }}" alt="Logo">
                </a>
                <hr>
            </div>

            <div class="nav_list">
                <a href="{{ route('homepage') }}" class="nav_link active">
                    <i class="fa-regular fa-house"></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a href="{{ route('trip.main') }}" class="nav_link">
                    <i class="fa-regular fa-road"></i>
                    <span class="nav_name">Trips</span>
                </a>
                <a href="#" class="nav_link">
                    <i class="fa-regular fa-webhook"></i>
                    <span class="nav_name">Devices</span>
                </a>
            </div>
            <div>
                <hr>
                <a href="{{ route('logout') }}" class="nav_link">
                    <i class='fa-regular fa-arrow-right-from-bracket'></i>
                    <span class="nav_name" style="margin-left: 3px;">Sign Out</span>
                </a>
            </div>
        </nav>
    </div>

    @includeWhen(
    isset($pageHeader) && $pageHeader instanceof \App\Helpers\View\ValueObject\PageHeaderValueOject,
    'components.page_header',
    ['pageHeader' => $pageHeader]
   )
    <!--Container Main start-->
    <div class="h-100">
        @yield('content')
    </div>

@endsection

