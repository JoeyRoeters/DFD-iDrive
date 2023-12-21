<?php

use App\UserInterface\Domain\Trip\Controllers\Main;
use App\UserInterface\Domain\Trip\Controllers\TripOverviewController;
use App\UserInterface\Domain\Trip\Controllers\TripReviewController;
use Illuminate\Support\Facades\Route;

Route::match(['post', 'get'], '/', [Main::class, 'run'])->name('trip.main');


Route::prefix('/{id}')->group(function () {
    Route::get('/overview', [TripOverviewController::class, 'run'])->name('trip.show.overview');

    Route::get('/review', [TripReviewController::class, 'run'])->name('trip.show.review');
    Route::prefix('/review/graph')->group(function () {
        Route::get('/', [TripReviewController::class, 'getGraph'])->name('trip.show.review.graph');
        Route::get('/data', [TripReviewController::class, 'getGraphData'])->name('trip.show.review.graph.data');
    });


});


