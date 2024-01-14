<?php

use App\UserInterface\Domain\Trip\Controllers\Main;
use App\UserInterface\Domain\Trip\Controllers\TripShowController;
use App\UserInterface\Domain\Trip\Controllers\TripReviewController;
use Illuminate\Support\Facades\Route;

Route::match(['post', 'get'], '/', [Main::class, 'run'])->name('trip.main');

Route::get('/{id}', [TripShowController::class, 'run'])->name('trip.show');

Route::get('/{id}/review', [TripReviewController::class, 'run'])->name('trip.show.review');
