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
                </div>
                <div class="col-9">
                    <div id="unloadedChart"></div>

                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.onload = function () {
        window.$(document).ready(function () {
            $.ajax({
                url: '{{route("trip.show.review.graph", ['id' => $trip->id])}}', // Vervang dit door de URL naar je Laravel route
                type: 'GET',
                data: {graph: 'speed'},
                success: function (data) {
                    $('#unloadedChart').html(data);
                },
                error: function (error) {
                    // Behandel de fout
                    console.error("Er is een fout opgetreden: ", error);
                }
            });
        });
    }
</script>







