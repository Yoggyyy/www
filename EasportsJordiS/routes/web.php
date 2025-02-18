<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MessageController;

// Autenticación de usuarios**
Route::controller(AuthController::class)->group(function () {
    // Rutas de cuenta (protegidas)
    Route::middleware(['auth'])->group(function () {
        Route::get('/cuenta', 'showAccount')->name('account');
        Route::delete('/cuenta', 'deleteAccount')->name('account.delete');
    });

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// Páginas estáticas**
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/terms', 'legal.terms')->name('terms');
Route::get('/where', function () {
    return view('where');
})->name('where');
Route::get('/contact', function () {
    return view('contacto');
})->name('contact');
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas accesibles para todos los usuarios**
// Eventos (solo lectura)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Jugadores (solo lectura)
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

// Rutas protegidas para usuarios autenticados**
Route::middleware(['auth'])->group(function () {
    // "Me gusta" en eventos
    Route::post('/events/{id}/like', [EventController::class, 'likeEvent'])->name('events.like');
});

// Rutas protegidas para administradores**
Route::middleware(['auth', 'admin'])->group(function () {
    // Eventos (CRUD y gestión)
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::patch('/events/{id}/toggle', [EventController::class, 'toggleVisibility'])->name('events.toggle');

    // Jugadores (CRUD y visibilidad)
    Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/players/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/players/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/players/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');
    Route::patch('/players/{player}/toggle', [PlayerController::class, 'toggleVisibility'])->name('players.toggle');

    // Mensajes (solo administradores)
    Route::get('/mensajes', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/mensajes/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/mensajes', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/mensajes/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
