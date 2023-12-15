<?php

use App\UserInterface\Domain\Trip\Controllers\ApiTripController;
use Illuminate\Support\Facades\Route;

Route::post('/', [ApiTripController::class, 'create']);

// group groutes with id
Route::group(['prefix' => '/{id}'], function () {
    Route::patch('/', [ApiTripController::class, 'update']);
    Route::post('/events', [ApiTripController::class, 'createEvents']);
});
