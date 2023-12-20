<?php

use App\UserInterface\Domain\Trip\Controllers\Main;
use App\UserInterface\Domain\Trip\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::match(['post', 'get'], '/', [Main::class, 'run'])->name('trip.main');
Route::get('/{id}', [TripController::class, 'run'])->name('trip.show');
