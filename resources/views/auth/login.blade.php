@extends('auth.layouts.app')
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
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="POST" action="{{ route('postLogin') }}">
                                        @csrf

                                        <h1 class="fw-normal pb-1" style="letter-spacing: 1px;">Welcome back</h1>

                                        <div class="form-outline ">
                                            <label class="form-label" for="form2Example17">Email</label>
                                            <input id="email" type="email"
                                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                                   autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-outline ">
                                            <label class="form-label" for="form2Example27">Password</label>
                                            <input id="password" type="password"
                                                   class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror

                                        </div>


                                        <a class="small text-muted" href="#!">Forgot password?</a>

                                        <div class="pt-1 ">
                                            <button id="loginBtn" class="btn text-white btn-lg btn-block rounded-3"
                                                    type="submit">Login
                                            </button>
                                        </div>


                                        <p class=" pb-lg-2">Don't have an account?
                                            <a href="{{route("register")}}"><b>Register here</b></a></p>

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
