<?php

namespace App\UserInterface\Domain\Auth\Controllers;
use App\Models\User;
use App\UserInterface\Domain\Auth\Requests\RegisterRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function register()
    {
        return view('register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $credentials = $request->only('email', 'password', 'firstname', 'lastname');

        // Check of de gebruiker met het opgegeven e-mailadres bestaat
        $userExists = Auth::getProvider()->retrieveByCredentials($credentials);

        if ($userExists) {
            // Geen gebruiker gevonden met het opgegeven e-mailadres
            throw ValidationException::withMessages(['email' => 'User already exists']);
        }

        $user = new User([
            'email' => $request->input('email'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'password' => Hash::make($request->input('password'))
        ]);

        if ($user->save()) {
//            event(new Registered($user));
            $credentials = [
                'username' => $request->input('email'),
                'password' => $request->input('password')
            ];

            Auth::login($user);
            return redirect()->intended('/');
        } else {
            throw ValidationException::withMessages(['error' => 'Something went wrong']);
        }
    }
}
