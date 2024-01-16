@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_homepage.scss')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_recent_device.scss')
@endsection

@section('content')
    <div class="homepage-under-construction">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>Recent Device</h4>
                        <div id="recent-device-wrapper" class="container">
                            <div id="recent-device-header" class="row">
                                <div class="row">
                                    <div class="col-md-2 col-xs-12 icon">
                                        <i class="fa-solid fa-car"></i>
                                    </div>
                                    <div class="col-10 details">
                                                <div class="row">
                                                    <div class="col-xl-3 col-md-12 name">
                                                        <h3>Name</h3>
                                                        <p>Last view</p>
                                                    </div>
                                                    <div class="col-xl-8 col-md-12 text-xl-end text-md-start badges">
                                                        <div class="badge">
                                                            <div class="badge-value fs-4">
                                                                <i class="fa-regular fa-car"></i>
                                                                <span>Label</span>
                                                            </div>
                                                            <div class="badge-label fs-6">
                                                                <span>Device type</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge">
                                                            <div class="badge-value fs-4">
                                                                <i class="fa-regular fa-road"></i>
                                                                <span>Trips</span>
                                                            </div>
                                                            <div class="badge-label fs-6">
                                                                <span>Total trips</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge">
                                                            <div class="badge-value fs-4">
                                                                <i class="fa-regular fa-gauge-simple-high"></i>
                                                                <span>Kilometers</span>
                                                            </div>
                                                            <div class="badge-label fs-6">
                                                                <span>Total KM's</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                
                            </div>
                        </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <h4>Weekly Review</h4>
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Speed</div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Gear</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Brake</div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Steering</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12">
                    <h4>Recent Trips</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="recent">
                                <a class="nav-link" href="#">Trip #1</a>
                            </div>
                            <div class="recent">
                                <a class="nav-link" href="#">Trip #2</a>
                            </div>
                            <div class="recent">
                                <a class="nav-link" href="#">Trip #3</a>
                            </div>
                            <div class="recent">
                                <a class="nav-link" href="#">Trip #4</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
