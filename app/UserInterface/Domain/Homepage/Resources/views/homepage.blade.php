@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Homepage/Resources/sass/_homepage.scss')
@endsection

@section('content')
    <div class="homepage-under-construction">
        <div class="homepage-under-construction_image">
            <img src="{{ Vite::image('Illustrations/coming_soon.svg') }}" alt="Under Construction">
        </div>

        <div class="homepage-under-construction_text">
            <p>
                This page is under construction. Please check back later.
            </p>
        </div>
    </div>
@endsection
