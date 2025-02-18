<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedMiddleware
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard()->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
