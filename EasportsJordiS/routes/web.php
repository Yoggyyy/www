<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MessageController;

// Autenticación de usuarios**
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Páginas estáticas**
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/terms', 'legal.terms')->name('terms');

// Página de inicio**
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas accesibles para todos los usuarios**
## Eventos (solo lectura)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

## Jugadores (solo lectura)
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

// Rutas protegidas para usuarios autenticados**
Route::middleware(['auth'])->group(function () {
    // Contacto
    Route::get('/contact', [MessageController::class, 'create'])->name('contact');
    Route::post('/contact', [MessageController::class, 'store'])->name('contact.send');

    // "Me gusta" en eventos
    Route::post('/events/{id}/like', [EventController::class, 'likeEvent'])->name('events.like');
});

//  Rutas protegidas para administradores**
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
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});


