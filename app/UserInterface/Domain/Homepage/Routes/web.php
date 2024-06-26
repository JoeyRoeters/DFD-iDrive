<?php

use Illuminate\Support\Facades\Route;
use App\UserInterface\Domain\Homepage\Controllers\Main;

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

    Route::get('/', [Main::class, 'run'])->name('homepage');
    Route::get("/stats", [Main::class, 'get_stats'])->name("stats");

});
