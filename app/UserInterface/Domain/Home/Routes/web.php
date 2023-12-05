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




Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {

        return Redirect::to('/home/test');
    });

    Route::get('/test', function () {
        return view('homepage');
    });
});


