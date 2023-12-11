<?php

namespace App\UserInterface\Domain\Auth\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class LogoutController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->intended();
    }

}
