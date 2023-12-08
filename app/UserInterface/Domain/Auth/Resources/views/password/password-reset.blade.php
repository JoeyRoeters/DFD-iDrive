@extends('auth.base')

@section('head')
    @vite('app/UserInterface/Domain/Auth/Resources/sass/auth.scss')
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
                                <div class="card-body p-4 p-lg-5 text-black text-center">

                                    <form method="post">
                                        @csrf
                                        <h3>Reset Password</h3>
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
