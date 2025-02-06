<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlayerController;



Route::resource('players', PlayerController::class)->except([
    'update', 'store'
]);

Route::resource('events', EventController::class)->except([
    'update', 'store'
]);

Route::resource('messages', MessageController::class)->except([
    'update', 'store'
]);

Route::get('/', function () {
    return view('index');
})->name('index');
