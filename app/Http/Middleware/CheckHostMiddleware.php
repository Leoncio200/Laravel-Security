<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckHostMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Verifica si el host no es igual a "10.0.0.4"
        if ($request->getHost() != "10.0.0.4") {
            return response()->json(['error' => 'Permiso Denegado'], 400);
        }

        return $next($request);
    }
}
