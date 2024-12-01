<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Jetstream\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$role)
    {
     if (auth()->check() && in_array(auth()->user()->role, $role)) { //ahora $role es un array de roles, ... al poder recibir multiples parametros, uno solo lo convierte en array
     return $next($request);
     }
     //return $next($request); // por ahora por si entro como estudiante poder auto logoutear 
     return redirect('home'); 
    }
}
