@extends('auth.base_clean')

@section('body')
    <div class="row h-100">
        <div id="auth" class="col-6">
            <div class="auth-wrapper">
                <h1 class="title">
                    @yield('title')
                </h1>

                @yield('content')
            </div>

            <div class="auth-footer">
                <p>© {{ (new DateTime())->format('Y') }} Digital Society Hub. All rights reserved.</p>
            </div>
        </div>
        <div id="auth-right-side" class="col-6">

            <img id="logo" src="{{ Vite::image('logos/logo_blue.png') }}"/>

            <img id="preview" src="{{ Vite::image('auth/preview.svg') }}"/>

            <h2>Enhance, Excel and Save</h2>

            <p>
                Enhance your driving skills with real-time feedback and save money on driving lessons
            </p>
        </div>
    </div>
@endsection
