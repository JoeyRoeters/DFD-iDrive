@extends('base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/auth.scss')
@endsection

@section('content')
    <div class="auth">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div id="imageSide" class="col-md-6 col-lg-5 d-none d-md-block">
                                <img id="logo" src="{{ asset('assets/images/auth/logo.png') }}"
                                     alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;"/>
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-2 p-lg-3 text-black">

                                    <form method="POST" action="{{ route('postRegister') }}">
                                        @csrf

                                        <h1 class="fw-normal pb-1" style="letter-spacing: 1px;">Welcome to VAR!</h1>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="list-unstyled">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                            <div class="form-outline ">
                                                <label class="form-label">Email</label>
                                                <input id="email" type="email"
                                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                       name="email" value="{{ old('email') }}" required
                                                       autocomplete="email"
                                                       autofocus>

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            {{--                                        firstname--}}
                                            <div class="form-outline">
                                                <label class="form-label">First Name</label>
                                                <input id="firstname" type="text"
                                                       class="form-control form-control-lg @error('firstname') is-invalid @enderror"
                                                       name="firstname" value="{{ old('firstname') }}" required
                                                       autocomplete="firstname"
                                                       autofocus>

                                                @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>


                                            {{--                                        lastname--}}
                                            <div class="form-outline">
                                                <label class="form-label">Last Name</label>
                                                <input id="lastname" type="text"
                                                       class="form-control form-control-lg @error('lastname') is-invalid @enderror"
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
                                                <label class="form-label">Password</label>
                                                <input id="password" type="password"
                                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                       name="password" required autocomplete="current-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            <div class="form-outline">
                                                <label class="form-label">Confirm Password</label>
                                                <input id="password_confirmation" type="password"
                                                       class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                                       name="password_confirmation" required
                                                       autocomplete="current-password">

                                                @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            <div class="form-outline">
                                                <label class="form-label">Terms</label>
                                                <input id="terms" type="checkbox"
                                                       class="form-check @error('terms') is-invalid @enderror"
                                                       name="terms" required
                                                       autocomplete="terms">

                                                @error('terms')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>


                                            <div class="pt-1 ">
                                                <button id="loginBtn" class="btn text-white btn-lg btn-block rounded-3"
                                                        type="submit">Register
                                                </button>
                                            </div>


                                            <p class="">Already have an account?
                                                <a href="{{route("login")}}"><b>Login here</b></a></p>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
