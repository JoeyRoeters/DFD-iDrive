<?php
/**
 * @var App\Domain\Trip\Model\Trip $trip
 * @var App\Domain\Trip\Model\TripData $tripData
 * @var App\Domain\Trip\Model\TripEvent $tripEvent
 * @var App\Domain\Trip\Model\TripStatistic $tripStatistic
 */

?>
@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Trip/Resources/sass/_trips.scss')
@endsection

@section('script')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
@endsection

@section('content')

    <div class="container-fluid pt-2">
        <div class="row">
            <div class="col-11 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-2">
                            <span class="d-block r-type-inline-d">{{$trip->state->getTranslation()}}</span> <span
                                class="r-type-inline-l">State</span>
                        </div>
                        <div class="col-2">
                            <span class="d-block r-type-inline-d">{{$trip->getDateFormatted()}}</span> <span
                                class="r-type-inline-l">Date</span>
                        </div>
                        <div class="col-2">
                            <span class="d-block r-type-inline-d">{{$trip->getTimeFormatted()}}</span> <span
                                class="r-type-inline-l">Time</span>
                        </div>
                        <div class="col-2">
                            <span class="d-block r-type-inline-d">{{$trip->getDistanceFormatted()}}</span> <span
                                class="r-type-inline-l">Distance</span>
                        </div>
                        <div class="col-2">
                            <span class="d-block r-type-inline-d">{{$trip->getScoreFormatted()}}</span> <span
                                class="r-type-inline-l">Score</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('tripContent')

    </div>
@endsection
