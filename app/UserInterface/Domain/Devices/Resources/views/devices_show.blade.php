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

    <div class="container-fluid pt-2">
        <div class="row">
            <div class="col-11 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-4">
                            <span class="d-block r-type-inline-d">{{$device->name}}</span> <span
                                class="r-type-inline-l">Name</span>
                        </div>
                        <div class="col-2">
                        <span class="d-block r-type-inline-d">
                            @if($device->lastActive)
                                {{ $device->lastActive }}
                            @else
                                never
                            @endif
                            </span>
                            <span class="r-type-inline-l">Last Seen</span>
                        </div>
                        <div class="col-2">
                            <span class="d-block r-type-inline-d">{{$device->type}}</span> <span
                                class="r-type-inline-l">Model</span>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <button class="btn btn-lg btn-primary">
                                <a class="text-white"
                                   href="{{route("devices.mutate.edit", ["id" => $device->id])}}">Edit</a>
                            </button>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-start">
                            <button href="" class="btn btn-lg btn-danger">
                                <a class="text-white"
                                   href="{{route("devices.delete.message", ["id" => $device->id])}}">Delete</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col-11 mx-auto">
                <div class="card">
                    <h3>Device endpoints</h3>
                    <div class="row">
                        <div class="col-5">
                            <label for="password" class="form-label">Device token</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="text" value="{{$api_token}}" class="form-control" id="api_token">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row pt-3 pb-3">
            <div class="col-11 mx-auto">
                <div class="card">
                    <h3>Device history</h3>
                    @include("overview/data_tables_clean")
                </div>
            </div>
        </div>

    </div>
@endsection
