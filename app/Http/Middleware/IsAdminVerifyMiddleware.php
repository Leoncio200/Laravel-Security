<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if($user == null)
            return response()->view('errors',['message' => "No se a iniciado la session"]);

        if($user->rol_id == 1)
            if(!$request->user()->isVerify())
                return response()->view('errors',['message' => "Usuario no verificado"]);

        return $next($request);
    }
}
