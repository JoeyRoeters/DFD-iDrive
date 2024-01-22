@extends('auth.base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/_auth.scss')
@endsection

@section('title')
    Forgot Password?
@endsection

@section('content')
    <form method="post">
        @csrf
        <input id="email" type="email" placeholder="Email"
               class="form-control rounded-2 form-control-lg @error('email') is-invalid @enderror"
               name="email" value="{{ old('email') }}" required autocomplete="email"
               autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="d-flex justify-content-center mt-2">
            <button class="btn btn-primary mr-2" type="submit">Submit</button>

            <a href="{{ route('login') }}" class="btn btn-back">Close</a>
        </div>

    </form>
@endsection
