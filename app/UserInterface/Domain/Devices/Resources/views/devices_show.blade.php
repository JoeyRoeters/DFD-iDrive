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

    <div class="container-fluid pt-4">
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
                            <button href="" class="btn btn-lg btn-primary"><a class="text-white" href="http://localhost:8000/devices/show/657f0bb2fa2af9ea170a9a12">Edit</a></button>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-start">
                            <button href="" class="btn btn-lg btn-danger"><a class="text-white" href="http://localhost:8000/devices/show/657f0bb2fa2af9ea170a9a12">Delete</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
