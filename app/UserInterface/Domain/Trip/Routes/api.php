<?php

use App\UserInterface\Domain\Trip\Controllers\ApiTripController;
use Illuminate\Support\Facades\Route;

Route::post('/', [ApiTripController::class, 'create']);
