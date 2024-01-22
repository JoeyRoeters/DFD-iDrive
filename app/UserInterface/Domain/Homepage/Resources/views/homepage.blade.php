@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_homepage.scss')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_recent_device.scss')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_recent_trip.scss')
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
                                        <i class="fa-solid fa-computer"></i>
                                    </div>
                                    <div class="col-10 details">
                                                <div class="row">
                                                    <div class="col-xl-4 col-md-12 name">
                                                        <h4>{{$device->name ?? ""}}</h4>
                                                        <p>{{ $device ? $device->getLastActiveFormatted() : 'unknown' }}</p>
                                                    </div>
                                                    <div class="col-xl-7 col-md-12 text-xl-end text-md-start badges">
                                                        <div class="badge">
                                                            <div class="badge-value fs-4">
                                                                <i class="fa-regular fa-car"></i>
                                                                <span>{{$device ? $device->type->getLabel() : ""}}</span>
                                                            </div>
                                                            <div class="badge-label fs-6">
                                                                <span>Device type</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge">
                                                            <div class="badge-value fs-4">
                                                                <i class="fa-regular fa-road"></i>
                                                                <span>{{$device ?  $device->trips()->count() : "" }}</span>
                                                            </div>
                                                            <div class="badge-label fs-6">
                                                                <span>Total trips</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge">
                                                            <div class="badge-value fs-4">
                                                                <i class="fa-regular fa-gauge-simple-high"></i>
                                                                <span>{{$device ? $device->getTotalKilometers() : ""}}</span>
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
                            <div class="review">
                                <div class="trip-review-container">
                                    <h5><div style="font-weight: 600; margin-top: 1rem;">Speed<div></h5>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span id="weekly_stats_avg_speed" class="trip-review-value" style="font-size:1.2rem;">
                                                                <i class="fa-regular fa-spin fa-xl fa-spinner-scale"></i>

                                            </span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Average</span>
                                            <span class="trip-review-unit">km/h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="review">
                                <div class="trip-review-container">
                                    <h5><div style="font-weight: 600; margin-top: 1rem;">Gear<div></h5>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">01</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title" style="font-size:1.1rem; font-weight:600;">Excpected Changes</span>
                                        </div>
                                    </div>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">00</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Changes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="review">
                                <div class="trip-review-container">
                                    <h5><div style="font-weight: 600; margin-top: 1rem;">Brake<div></h5>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">12</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Stop short</span>
                                        </div>
                                    </div>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">07</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Inefficient</span>
                                        </div>
                                    </div>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">04</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Perfect</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="review">
                                <div class="trip-review-container">
                                    <h5><div style="font-weight: 600; margin-top: 1rem;">Steering<div></h5>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">01</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Wrong Steering</span>
                                        </div>
                                    </div>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">00</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Inefficient</span>
                                        </div>
                                    </div>
                                    <div class="trip-review">
                                        <div class="trip-review-value-wrapper">
                                            <span class="trip-review-value">00</span>
                                        </div>
                                        <div class="trip-review-title-wrapper">
                                            <span class="trip-review-title">Efficient</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                <div class="col-xl-6 col-md-12 recent_trip">
                    <h4>Recent Trips</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="recent">
                                <td colspan="2">
                                        <div class="d-flex flex-row justify-content-start align-items-center" style="column-gap: 1rem;">
                                            <div class="dt-recent-trip-wrapper">
                                                <span class="number">#0001</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="d-block r-type-inline-d" style="font-size: 1.075rem; font-weight: 600;">Trip #0001</span>
                                                <span class="r-type-inline-l" style="font-size: 0.75rem;">Device: Test</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">12-01-2024</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Date</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">08:39 - 12:00</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Time</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">100 km</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Distance</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.3rem; color: rgb(230, 81, 0);">6.0</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Score</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="http://127.0.0.1:8000/trips/65a00a401f73800b760ccd22" class="btn btn-lg btn-primary float-end">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                        </div>
                                    </td>
                                </td>
                            </div>
                            <div class="recent">
                                <td colspan="2">
                                        <div class="d-flex flex-row justify-content-start align-items-center" style="column-gap: 1rem;">
                                            <div class="dt-recent-trip-wrapper">
                                                <span class="number">#0002</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="d-block r-type-inline-d" style="font-size: 1.075rem; font-weight: 600;">Trip #0002</span>
                                                <span class="r-type-inline-l" style="font-size: 0.75rem;">Device: Test</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">12-01-2024</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Date</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">08:39 - 12:00</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Time</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">100 km</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Distance</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.3rem; color: rgb(230, 81, 0);">6.0</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Score</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="http://127.0.0.1:8000/trips/65a00a401f73800b760ccd22" class="btn btn-lg btn-primary float-end">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                        </div>
                                    </td>
                            </td>
                            </div>
                            <div class="recent">
                                <td colspan="2">
                                        <div class="d-flex flex-row justify-content-start align-items-center" style="column-gap: 1rem;">
                                            <div class="dt-recent-trip-wrapper">
                                                <span class="number">#0003</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="d-block r-type-inline-d" style="font-size: 1.075rem; font-weight: 600;">Trip #0003</span>
                                                <span class="r-type-inline-l" style="font-size: 0.75rem;">Device: Test</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">12-01-2024</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Date</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">08:39 - 12:00</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Time</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">100 km</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Distance</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.3rem; color: rgb(230, 81, 0);">6.0</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Score</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="http://127.0.0.1:8000/trips/65a00a401f73800b760ccd22" class="btn btn-lg btn-primary float-end">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                        </div>
                                    </td>

                                </td>
                            </div>
                            <div class="recent">
                                <td colspan="2">
                                        <div class="d-flex flex-row justify-content-start align-items-center" style="column-gap: 1rem;">
                                            <div class="dt-recent-trip-wrapper">
                                                <span class="number">#0004</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="d-block r-type-inline-d" style="font-size: 1.075rem; font-weight: 600;">Trip #0004</span>
                                                <span class="r-type-inline-l" style="font-size: 0.75rem;">Device: Test</span>
                                            </div>
                                            <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">12-01-2024</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Date</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">08:39 - 12:00</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Time</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.075rem;">100 km</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Distance</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="d-block r-type-inline-d" style="font-size: 1.3rem; color: rgb(230, 81, 0);">6.0</span>
                                            <span class="r-type-inline-l" style="font-size: 0.75rem;">Score</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="http://127.0.0.1:8000/trips/65a00a401f73800b760ccd22" class="btn btn-lg btn-primary float-end">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                        </div>
                                    </td>
                                </td>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Make an AJAX request to get average speed
            fetch('{{ route("stats") }}')
                .then(response => response.json())
                .then(data => {
                    // Update the content of the average speed container
                    document.getElementById('weekly_stats_avg_speed').innerHTML = data.stats.weekly.avg_speed;
                })
                .catch(error => {
                    document.getElementById('weekly_stats_avg_speed').innerHTML = "N/A";
                });
        });
    </script>


@endsection
