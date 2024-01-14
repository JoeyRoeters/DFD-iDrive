<?php

use App\UserInterface\Domain\Devices\Controllers\ApiDeviceController;
use Illuminate\Support\Facades\Route;

Route::get('/testConnection', [ApiDeviceController::class, 'testConnection']);
