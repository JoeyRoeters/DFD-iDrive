@extends('base_clean')

@section('body')
    <header class="header" id="header">
        <div class="header-toggle-wrapper"><i class="fa-solid fa-bars" id="header-toggle"></i></div>

    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div id="header-logo" href="#" class="nav_logo">
                    <img style="width: 50px" src="{{ Vite::image('logos/logo_white.png') }}" alt="Logo">
                    <span>VAR</span>
                </div>
            </div>

            <div class="nav_list">
                <a href="{{ route('homepage') }}" class="nav_link {{ \Illuminate\Support\Facades\Route::current()->getPrefix() === "homepages" ? 'active' : '' }}">
                    <i class="fa-regular fa-house"></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a href="{{ route('trip.main') }}" class="nav_link {{ \Illuminate\Support\Facades\Route::current()->getPrefix() === "trips" ? 'active' : '' }}">
                    <i class="fa-regular fa-road"></i>
                    <span class="nav_name">Trips</span>
                </a>
                <a href="{{route("devices.overview")}}" class="nav_link {{ \Illuminate\Support\Facades\Route::current()->getPrefix() === "devices" ? 'active' : '' }}">
                    <i class="fa-regular fa-webhook"></i>
                    <span class="nav_name">Devices</span>
                </a>
            </div>
            <div class="pos-absolute b-0 z-0">
                <a href="#" class="nav_link user no-click">
                    <div class="user_img"><img src="https://i.imgur.com/hczKIze.jpg" alt=""></div>
                    <span class="nav_name text-wrap user_name">{{ Auth::user()?->firstname . " " . Auth::user()?->lastname ?? "John Doe" }} </span>
                </a>
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
    ['pageHeader' => $pageHeader, 'breadCrumbs' => $breadCrumbs ?? []]
   )
    <!--Container Main start-->
    <div id="content-page" class="h-100 container">
        @yield('content')
    </div>

@endsection

