<?php

use App\UserInterface\Domain\Devices\Controllers\DeviceController;
use App\UserInterface\Domain\Devices\Controllers\MutateController;
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

    Route::match(['post', 'get'], '/', [OverviewController::class, 'run'])->name('devices.overview');
    Route::get('/edit/{id}', [MutateController::class, 'run'])->name('devices.mutate.edit');
    Route::get('/new', [MutateController::class, 'run'])->name('devices.mutate.new');

    Route::post('/save', [MutateController::class, 'save'])->name('devices.mutate.save');

    Route::get('/show/{id}', [DeviceController::class, 'save'])->name('devices.show');



});
