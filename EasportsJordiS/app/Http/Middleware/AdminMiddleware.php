<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Primero verificamos si hay una sesión activa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página');
        }

        // Luego verificamos si el usuario es administrador
        /** @var User */
        $user = Auth::user();
        if (!$user->is_admin()) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página');
        }

        return $next($request);
    }
}
