<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
     if (auth()->check() && auth()->user()->role === 'admin') {
     return $next($request);
     }
     return $next($request); // por ahora por si entro como estudiante poder auto logoutear 
    
     /* return redirect('/logout'); // Redirige si no tiene el rol */
    }
}
