@extends('auth.base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/_auth.scss')
@endsection

@section('content')

    <h4 class="text-center">Please confirm your email address first</h4>

    <div class="d-flex justify-content-center mt-2">
        <button class="btn btn-primary rounded-2" type="button">
            <a class="text-white text-decoration-none" href="{{ route('verification.resend') }}">Resend Verification Email</a>
        </button>
    </div>

@endsection
