<?php
/**
 * @var \App\Domain\Trip\Model\Trip $trip
 */

?>
@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Devices/Resources/sass/_trips.scss')
@endsection

@section('content')

    <div id="single-view-wrapper" class="container">
        <div id="single-view-header" class="row">
            <div class="card">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-2 icon">
                            <i class="fa-solid fa-road }}"></i>
                        </div>
                        <div class="col-10 details">
                            <div class="row">
                                <div class="col-12 name">
                                    <h3>{{ $trip->getTimeFormatted()}}</h3>
                                    <p>{{ $trip->getDateFormatted() }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 badges">
                                    <div class="badge">
                                        <div class="badge-value fs-4">
                                            <i class="fa-solid fa-{{ $trip->device()->first()->type->value === 'sim' ? "computer" : "car" }}"></i>
                                            <span>{{$trip->getDeviceName() }}</span>
                                        </div>
                                        <div class="badge-label fs-6">
                                            <span>Device</span>
                                        </div>
                                    </div>
                                    <div class="badge">
                                        <div class="badge-value fs-4">
                                            <i class="fa-regular fa-trophy-star"></i>
                                            <span>{{ $trip->getScoreFormatted() }}</span>
                                        </div>
                                        <div class="badge-label fs-6">
                                            <span>Score</span>
                                        </div>
                                    </div>
                                    <div class="badge">
                                        <div class="badge-value fs-4">
                                            <i class="fa-regular fa-gauge-simple-high"></i>
                                            <span>{{ $trip->getDistanceFormatted() }}</span>
                                        </div>
                                        <div class="badge-label fs-6">
                                            <span>Total  KM's</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator"></div>

                <ul  class="nav nav-tabs text-black" id="single-view-content-pages">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="false">Overview</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="case-review-tab" data-bs-toggle="tab" data-bs-target="#case-review" type="button" role="tab" aria-controls="case-review" aria-selected="false">Case review</a>
                    </li>
                </ul>
            </div>
        </div>

        <div id="trip-tabs" class="row mb-3 p-0">
            <div class="tab-content text-black p-0" id="myTabContent">
                <div class="tab-pane fade show active text-black" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    @include('trip_overview')
                </div>
                <div class="tab-pane fade text-black" id="case-review" role="tabpanel" aria-labelledby="case-review-tab">
{{--                    @include('trip_review')--}}
                </div>
            </div>
        </div>
    </div>
@endsection
