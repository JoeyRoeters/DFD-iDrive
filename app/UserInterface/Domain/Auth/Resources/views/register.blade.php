@extends('auth.base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/_auth.scss')
@endsection

@section('title')
    Sign Up
@endsection

@section('content')
    <form method="POST" action="{{ route('postRegister') }}">
        @csrf

        <div class="form-outline ">
            <input id="email" type="email"
                   placeholder="Email"
                   class="form-control rounded-2 form-control-lg @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required
                   autocomplete="email"
                   autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline">
            <input id="firstname" type="text" placeholder="First Name"
                   class="form-control rounded-2 form-control-lg @error('firstname') is-invalid @enderror"
                   name="firstname" value="{{ old('firstname') }}" required
                   autocomplete="firstname"
                   autofocus>

            @error('firstname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline">
            <input id="lastname" type="text" placeholder="Last Name"
                   class="form-control rounded-2 form-control-lg @error('lastname') is-invalid @enderror"
                   name="lastname" value="{{ old('lastname') }}" required
                   autocomplete="lastname"
                   autofocus>

            @error('lastname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline ">
            <input id="password" type="password" placeholder="Password"
                   class="form-control rounded-2 form-control-lg @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password">

            <span class="form-tooltip">
                Use 8 or more characters with a mix of letters, numbers & symbols.
            </span>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline">
            <input id="password_confirmation" type="password" placeholder="Confirm Password"
                   class="form-control form-control-lg rounded-2 @error('password_confirmation') is-invalid @enderror"
                   name="password_confirmation" required
                   autocomplete="current-password">

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline terms-group">
            <label for="terms" class="form-label">I accept the <a href="#">Terms</a></label>
            <input id="terms" type="checkbox"
                   class="form-check rounded-4 @error('terms') is-invalid @enderror"
                   name="terms" required
                   autocomplete="terms">

            @error('terms')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>


        <div class="pt-1 ">
            <button id="loginBtn" class="btn text-white btn-lg btn-block rounded-2"
                    type="submit">Sign up
            </button>
        </div>

        <p id="bottom-link-wrapper">Already have an account?
            <a href="{{route("login")}}">Sign in</a>
        </p>

    </form>
@endsection
