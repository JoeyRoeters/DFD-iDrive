<?php

use App\UserInterface\Domain\Trip\Controllers\Main;
use Illuminate\Support\Facades\Route;

Route::match(['post', 'get'], '/', [Main::class, 'run'])->name('trip.main');
Route::get('/{id}', [Main::class, 'show'])->name('trip.show');
