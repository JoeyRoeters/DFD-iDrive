<?php

namespace App\UserInterface\Domain\Auth\Controllers;

use App\UserInterface\Domain\Auth\Requests\LoginRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LogoutController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }

}
