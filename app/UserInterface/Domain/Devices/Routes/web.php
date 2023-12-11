<?php

use App\UserInterface\Domain\Devices\Controllers\OverviewController;
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

    Route::get('/', [OverviewController::class, 'run'])->name('devices.overview');
    Route::get('/edit', [OverviewController::class, 'run'])->name('devices.mutate');

});
