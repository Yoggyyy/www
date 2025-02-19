<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MessageController;

// Rutas principales
Route::view('/', 'welcome')->name('home');
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::view('/where', 'where')->name('where');

// Rutas de autenticación
Route::controller(AuthController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/account', 'showAccount')->name('account');
        Route::delete('/account', 'deleteAccount')->name('account.delete');
        Route::post('/logout', 'logout')->name('logout');
    });

    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
});

// Rutas de jugadores
Route::controller(PlayerController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/players/create', 'create')->name('players.create');
        Route::get('/players/{player}', 'show')->name('players.show');
        Route::get('/players/{player}/edit', 'edit')->name('players.edit');

        Route::put('/players/{player}', 'update')->name('players.update');
        Route::delete('/players/{player}', 'destroy')->name('players.destroy');

        Route::post('/players', 'store')->name('players.store');
        Route::post('/players/{player}/visibility', 'toggleVisibility')->name('players.visibility');
    });

    Route::get('/players', 'index')->name('players.index');
});

// Rutas de eventos
Route::controller(EventController::class)->group(function () {
    // Rutas protegidas para administradores
    Route::middleware('auth')->group(function () {
        Route::post('/events', 'store')->name('events.store');
        Route::get('/events/create', 'create')->name('events.create');
        Route::get('/events/{event}', 'show')->name('events.show');
        Route::get('/events/{event}/edit', 'edit')->name('events.edit');
        Route::put('/events/{event}', 'update')->name('events.update');
        Route::delete('/events/{event}', 'destroy')->name('events.destroy');

        Route::post('/events/{id}/like', 'toggleLike')->name('events.like');
        Route::patch('/events/{id}/toggle', 'toggleVisibility')->name('event.like');
    });

    Route::get('/events', 'index')->name('events.index');
});


// Rutas de mensajes
Route::controller(MessageController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/messages', 'index')->name('messages.index');
        Route::get('/messages/{message}', 'show')->name('messages.show');
        Route::delete('/messages/{message}', 'destroy')->name('messages.destroy');
    });

    Route::post('/messages', 'store')->name('messages.store');
});

// Rutas legales y contacto
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');
Route::view('/contact', 'contact')->name('contact');
