<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
  
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene el rol adecuado
        if ($user && in_array($user->rol_id, $roles)) {
            return $next($request);
        }

        // Redirigir o manejar el acceso no autorizado
        abort(403, 'Acceso no autorizado.');
    }
}
