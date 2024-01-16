@extends('auth.base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/_auth.scss')
@endsection

@section('title')
    Setup New Password
@endsection

@section('content')
    <p id="top-link-wrapper" class="mt-0">Have you already reset the password?
        <a href="{{ route('login') }}">Sign in</a>
    </p>

    <form method="post" action="{{route("password.update")}}">
        @csrf
        <input type="hidden" name="token" value="{{$token ?? ''}}">

        <input id="email" type="email" readonly placeholder="Email"
               class="disabled rounded-2 form-control form-control-lg @error('email') is-invalid @enderror"
               name="email" value="{{$email ?? ''}}">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input id="password" type="password" placeholder="Password"
               class="form-control rounded-2 form-control-lg @error('password') is-invalid @enderror"
               name="password" required autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <div class="form-outline">
            <input id="password_confirmation" type="password" placeholder="Confirm Password"
                   class="form-control rounded-2 form-control-lg @error('password_confirmation') is-invalid @enderror"
                   name="password_confirmation" required
                   autocomplete="current-password">

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button class="btn btn-primary w-100 mt-3" type="submit">Submit</button>

    </form>
@endsection
