<?php

use App\UserInterface\Domain\Auth\Controllers\EmailVerifyController;
use App\UserInterface\Domain\Auth\Controllers\LoginController;
use App\UserInterface\Domain\Auth\Controllers\LogoutController;
use App\UserInterface\Domain\Auth\Controllers\PasswordResetController;
use App\UserInterface\Domain\Auth\Controllers\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['guest'])->group(function () {
    //Wilcard route
    Route::get('/', function () {
        return Redirect::to('/auth/login');
    });
});

//Login and Register
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'postLogin'])
    ->middleware('throttle:5,20')
    ->name('postLogin');

Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'postRegister'])->name('postRegister');

//Email Verification
Route::get('/email/verify', [EmailVerifyController::class, 'noticeVerify'])->middleware('auth')->name(
    'verification.notice'
);

Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'confirmVerify'])->middleware(
    ['auth', 'signed']
)->name('verification.verify');

Route::get('/email/verification-notification', [EmailVerifyController::class, 'resendVerify'])->middleware(
    ['auth', 'throttle:6,1']
)->name('verification.resend');

//Password Reset
Route::get('/password/forgot-password', [PasswordResetController::class, 'resetPasswordView'])->name(
    'forgot-password'
);
Route::post('/password/forgot-password', [PasswordResetController::class, 'resetPassword'])->name(
    'forgot-password.post'
);

Route::get('/password/reset/{token}', [PasswordResetController::class, 'setNewPasswordView'])->name(
    'password.reset'
);
Route::post('/password/resets', [PasswordResetController::class, 'handlePasswordReset'])->name('password.update');;

//logout:
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
