<?php
/**
 * @var App\Domain\Trip\Model\Trip $trip
 * @var App\Domain\Trip\Model\TripData $tripData
 * @var App\Domain\Trip\Model\TripEvent $tripEvent
 * @var App\Domain\Trip\Model\TripStatistic $tripStatistic
 */

?>

@extends('trip_base')

@section('tripContent')

    <div class="col-11 mx-auto">
        <div class="card mt-2">
            <div class="row">
                <div class="col-3 border-right">
                    <h2 class="text-center">Speed</h2>
                    <p class="text-center pb-5">In Progress</p>
                </div>
                <div class="col-3 border-right">
                    <h2 class="text-center">Brake</h2>
                    <p class="text-center pb-5">In Progress</p>
                </div>
                <div class="col-3 border-right">
                    <h2 class="text-center">Gear</h2>
                    <p class="text-center pb-5">In Progress</p>
                </div>
                <div class="col-3">
                    <h2 class="text-center">Steering</h2>
                    <p class="text-center pb-5">In Progress</p>
                </div>
            </div>
        </div>
    </div>
@endsection
