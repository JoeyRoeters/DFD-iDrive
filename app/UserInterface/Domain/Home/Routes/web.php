<?php

use App\Helpers\SweetAlert\SweetAlert;
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


Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        // you can use this to test the sweet alert
        // you will be redirected to the homepage with a sweet alert
        SweetAlert::createError('Test')->setTimer(null);

        return Redirect::to('/home/test');
    });

    Route::get('/test', function () {
        return view('homepage');
    });
});


