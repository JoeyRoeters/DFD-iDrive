<?php

namespace App\UserInterface\Domain\Auth\Controllers;

use App\UserInterface\Domain\Auth\Requests\LoginRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function login(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended();
        }
        return view('login');
    }

    /**
     * @throws ValidationException
     */
    public function postLogin(LoginRequest $request): RedirectResponse| ValidationException
    {
        $credentials = $request->only('email', 'password');

        // Check of de gebruiker met het opgegeven e-mailadres bestaat
        $userExists = Auth::getProvider()->retrieveByCredentials($credentials);

        if (!$userExists) {
            // Geen gebruiker gevonden met het opgegeven e-mailadres
            throw ValidationException::withMessages(['email' => 'No user found with this email']);
        }

        // Probeer de gebruiker in te loggen
        if (Auth::attempt($credentials)) {
            // Succesvol ingelogd
            return redirect()->intended();
        }

        // Onjuist wachtwoord
        throw ValidationException::withMessages(['password' => 'Invalid password']);
    }
}
