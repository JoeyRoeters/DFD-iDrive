@extends('auth.base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/_auth.scss')
@endsection

@section('title')
    Sign In
@endsection

@section('content')
    <form method="POST" action="{{ route('postLogin') }}">
        @csrf

        <div class="form-outline">
            <input id="email" type="email"
                   class="form-control rounded-2 form-control-lg @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}"
                   required autocomplete="email" placeholder="Email"
                   autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline ">
            <input id="password" type="password" placeholder="Password"
                   class="form-control rounded-2 form-control-lg @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>


        <a class="forgot-password" href="{{route("forgot-password")}}">Forgot password?</a>

        <div class="pt-1 ">
            <button id="loginBtn" class="btn text-white btn-lg btn-block rounded-2 mt-2"
                    type="submit">Sign in
            </button>
        </div>

        <p id="bottom-link-wrapper" class=" pb-lg-2">Don't have an account?
            <a href="{{route("register")}}">Sign up</a>
        </p>

    </form>
@endsection
