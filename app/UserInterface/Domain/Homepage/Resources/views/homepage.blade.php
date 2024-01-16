@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_homepage.scss')
@endsection

@section('content')
    <div class="homepage-under-construction">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>Current Device</h4>

                    <div class="card">Device name</div>

                </div>
            </div>


            <div class="row mt-1">
                <div class="col-6">
                    <h4>Weekly Review</h4>
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Speed</div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Gear</div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Brake</div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="review">Steering</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <h4>Recent Trips</h4>
                    <div class="row">
                        <div class="col-12">
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
