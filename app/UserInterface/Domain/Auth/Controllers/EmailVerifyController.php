<?php

namespace App\UserInterface\Domain\Auth\Controllers;

use App\Helpers\SweetAlert\SweetAlert;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class EmailVerifyController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;


    public function noticeVerify(): View|RedirectResponse
    {
        if (Auth::user()->hasVerifiedEmail()) {
            SweetAlert::createError("Email is already verified!")->setTimer(null);
            return redirect()->intended();
        }
        return view('verify.verify-email');
    }

    public function confirmVerify(EmailVerificationRequest $request): RedirectResponse
    {
        if (Auth::user()->hasVerifiedEmail()) {
            SweetAlert::createError("Email is already verified!")->setTimer(null);
            return redirect()->intended();
        }

        if (!$request->hasValidSignature()) {
            SweetAlert::createError("Invalid verification link!")->setTimer(null);
            return redirect()->intended();
        }

        $request->fulfill();
        SweetAlert::createSuccess("Email is verified successfully!");
        Auth::logout();
        return redirect()->intended();
    }

    public function resendVerify(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            SweetAlert::createError("Email is already verified!")->setTimer(null);
            return redirect()->intended();
        }

        $request->user()->sendEmailVerificationNotification();
        SweetAlert::createSuccess("Email verification link has been sent to your email.");

        return back();
    }


}
