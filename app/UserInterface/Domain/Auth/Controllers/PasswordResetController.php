<?php

namespace App\UserInterface\Domain\Auth\Controllers;

use App\Domain\User\Model\User;
use App\Helpers\SweetAlert\SweetAlert;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;


    public function resetPasswordView(): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }

        return view('password.password-reset');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if (isset($request->email)) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                SweetAlert::createError('Email not found');
                return redirect()->back();
            }
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            SweetAlert::createSuccess('Password reset link sent to your email');
        } else {
            SweetAlert::createError($status);
        }
        return redirect(route('login'));
    }

    public function setNewPasswordView(Request $request): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect()->intended();
        }
        //get email and sent to view
        if (isset($request->email)) {
            $email = $request->email;
        }
        $token = $request->route('token');

        return view('password.password-set-new', compact('email', 'token'));
    }

    public function handlePasswordReset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|sometimes',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            SweetAlert::createSuccess('Password reset successfully');
        } else {
            SweetAlert::createError($status);
        }
        return redirect(route('login'));
    }


}
