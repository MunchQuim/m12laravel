<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Jetstream\Role;
use Symfony\Component\HttpFoundation\Response;

class ShareUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $role = auth()->check() ? auth()->user()->role : 'noRole';
        view()->share('role', $role);
        return $next($request);
    }
    /* este middleware tecnicamente pasa el rol a una vista */
}
