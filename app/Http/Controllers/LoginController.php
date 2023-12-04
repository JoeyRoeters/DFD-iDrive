<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login()
    {
        return view('auth/login');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Check of de gebruiker met het opgegeven e-mailadres bestaat
        $userExists = Auth::getProvider()->retrieveByCredentials($credentials);

        if (!$userExists) {
            // Geen gebruiker gevonden met het opgegeven e-mailadres
            throw ValidationException::withMessages(['email' => 'Geen gebruiker gevonden met dit e-mailadres']);
        }

        // Probeer de gebruiker in te loggen
        if (Auth::attempt($credentials)) {
            // Succesvol ingelogd
            return redirect()->intended('/');
        }

        // Onjuist wachtwoord
        throw ValidationException::withMessages(['password' => 'Onjuist wachtwoord']);
    }
}
