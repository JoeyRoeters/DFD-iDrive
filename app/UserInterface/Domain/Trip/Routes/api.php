<?php

use App\UserInterface\Domain\Trip\Controllers\Main;
use Illuminate\Support\Facades\Route;

Route::post('/', function () {
    return response()->json([
        'message' => 'Hello World!',
    ]);
});
