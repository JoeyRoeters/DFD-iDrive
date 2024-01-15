@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_homepage.scss')
@endsection

@section('content')
    <div class="homepage-under-construction">
        <div class="card_name">Current Device</div>
        <div class="card">Device Name</div>   

        <div class="recent_name">Recent Trips</div>
        <div class="recent recent1">Trip #1</div>
        <div class="recent recent2">Trip #2</div>
        <div class="recent recent3">Trip #3</div>
        <div class="recent recent4">Trip #4</div>

        <div class="review_name">Case Reviews</div>
        <div class="review speed">Speed</div>
        <div class="review brake">Brake</div>
        <div class="review gear">Gear</div>
        <div class="review steering">Steering</div>

    </div>

    

</div>
@endsection
