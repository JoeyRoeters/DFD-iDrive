<?php
/**
 * @var \App\Domain\Device\Model\Device $device
 */

?>
@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Devices/Resources/sass/_devices.scss')
@endsection

@section('content')
    <div id="single-view-wrapper" class="container">
        <div id="single-view-header" class="row">
            <div class="card">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-2 icon">
                            <i class="fa-solid fa-{{ $device->type->value === 'sim' ? "computer" : "car" }}"></i>
                        </div>
                        <div class="col-10 details">
                            <div class="row">
                                <div class="col-12 name">
                                    <h3>{{ $device->name }}</h3>
                                    <p>{{ $device->getLastActiveFormatted() }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 badges">
                                    <div class="badge">
                                        <div class="badge-value fs-4">
                                            <i class="fa-regular fa-car"></i>
                                            <span>{{ $device->type->getLabel() }}</span>
                                        </div>
                                        <div class="badge-label fs-6">
                                            <span>Device type</span>
                                        </div>
                                    </div>
                                    <div class="badge">
                                        <div class="badge-value fs-4">
                                            <i class="fa-regular fa-road"></i>
                                            <span>{{ $device->trips()->count() }}</span>
                                        </div>
                                        <div class="badge-label fs-6">
                                            <span>Total  trips</span>
                                        </div>
                                    </div>
                                    <div class="badge">
                                        <div class="badge-value fs-4">
                                            <i class="fa-regular fa-gauge-simple-high"></i>
                                            <span>{{ $device->getTotalKilometers() }}</span>
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
                        <a class="nav-link active" id="endpoints-tab" data-bs-toggle="tab" data-bs-target="#endpoints" type="button" role="tab" aria-controls="endpoints" aria-selected="false">Setup</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="trip-history-tab" data-bs-toggle="tab" data-bs-target="#trip-history" type="button" role="tab" aria-controls="trip-history" aria-selected="false">Trip history</a>
                    </li>
                </ul>
            </div>
        </div>

        <div id="device-tabs" class="row mb-3 p-0">
            <div class="tab-content text-black p-0" id="myTabContent">
                <div class="card tab-pane fade show active text-black" id="endpoints" role="tabpanel" aria-labelledby="endpoints-tab">
                    @include("components/stepper")
                </div>
                <div class="tab-pane fade text-black" id="trip-history" role="tabpanel" aria-labelledby="trip-history-tab">
                    @include("overview/data_tables_clean")
                </div>
            </div>
        </div>
    </div>
@endsection
