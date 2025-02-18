<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AuthenticateMiddleware extends Middleware
{
    /**
     * Redireccionar a la ruta de login si el usuario no está autenticado.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            session()->flash('error', 'Inicie sessión para continuar');
            return route('login');
        }

        return null; // Para peticiones Ajax/api
    }
}
