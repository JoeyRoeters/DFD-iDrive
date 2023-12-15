<?php

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
        return Redirect::route("homepage");
    });

    Route::get('/tokens', function () {
        $user = auth()->user();
        $devices = $user->devices()->get();

        $items = [];
        ;
        foreach ($devices as $device) {
            $items[$device->name] = $user->getApiToken($device);
        }

        return response()->json([
            'tokens' => $items,
        ], 200);
    });

});
