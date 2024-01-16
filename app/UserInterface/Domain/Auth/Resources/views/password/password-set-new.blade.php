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
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="post" action="{{route("password.update")}}">
                                        @csrf
                                        <h3 class="pb-1">Reset Password</h3>
                                        <input type="hidden" name="token" value="{{$token}}">


                                        <label for="email" class="form-label">Email</label>
                                        <input id="email" type="email" readonly
                                               class="disabled form-control form-control-lg @error('email') is-invalid @enderror"
                                               name="email" value="{{$email}}">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <label for="password" class="form-label">Password</label>
                                        <input id="password" type="password"
                                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror


                                        <div class="form-outline">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
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


                                        <button class="btn btn-primary mt-3" type="submit">Reset</button>

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
