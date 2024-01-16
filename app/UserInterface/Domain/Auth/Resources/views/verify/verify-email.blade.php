@extends('auth.base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/_auth.scss')
@endsection

@section('content')

    <div id="auth">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div id="imageSide" class="col-md-6 col-lg-5 d-none d-md-block">
                                <img id="logo" src="{{ Vite::image('logos/logo_red.png') }}"
                                     alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;"/>
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center justify-content-space-even flex-direction">
                                <div class="card-body p-4 p-lg-5 text-black text-center">

                                    <h4>Please confirm your email address first</h4>

                                    <button class="btn btn-primary" type="button">
                                        <a class="text-white text-decoration-none" href="{{ route('verification.resend') }}">Resend Verification Email</a>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
