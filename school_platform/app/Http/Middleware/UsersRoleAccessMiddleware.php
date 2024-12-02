<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersRoleAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener el id del usuario desde la ruta
        $userId = $request->route('user_id');

        // Verificar si el usuario tiene el rol 'admin'
        if ($user->role === 'admin') {
            // Los administradores pueden acceder a cualquier /users/{user_id}
            return $next($request);
        }

        // Verificar si el usuario tiene el rol 'teacher'
        if ($user->role === 'teacher') {
            // Comprobar si el usuario al que se está accediendo tiene el rol 'student'
            $targetUser = \App\Models\User::find($userId); // O usar tu modelo de usuario

            if ($targetUser && $targetUser->role === 'student') {
                // Los profesores solo pueden acceder a /users/{user_id} de estudiantes
                return $next($request);
            }
           
            // Si el usuario no es un estudiante, negar el acceso
            return abort(403, 'No tienes acceso a este usuario.');
        }

        // Si el rol no es 'admin' ni 'teacher', negar el acceso
        return abort(403, 'No tienes acceso a este usuario.');
    }
}
