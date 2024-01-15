@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_homepage.scss')
@endsection

@section('content')
    <div class="homepage-under-construction">
        <div class="container"> 
            <div class="row">
                <div class="col-sm-12">
                    <h4>Current Device</h4>
                    <div class="row">
                    <div class="cols-sm-12">
                            <div class="card">Device name</div>
                        </div> 
                    </div>
                </div>
                <div class="col-sm-6 mt-2">
                    <h4>Weekly Review</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="review">Speed</div>
                            <div class="review mt-1">Gear</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="review">Brake</div>
                            <div class="review mt-1">Steering</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mt-2">
                    <h4>Recent Trips</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="recent">
                                <a class="nav-link" href="#">Trip #1</a>
                            </div>
                            <div class="recent mt-1">
                                <a class="nav-link" href="#">Trip #2</a>
                            </div>
                            <div class="recent mt-1">
                                <a class="nav-link" href="#">Trip #3</a>
                            </div>
                            <div class="recent mt-1">
                                <a class="nav-link" href="#">Trip #4</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    
@endsection
