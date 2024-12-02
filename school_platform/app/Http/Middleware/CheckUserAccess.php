<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\RelUserProject;
use App\Models\User;
use App\Models\Project;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Obtener el ID del usuario logueado
        $userId = auth()->id();

        // Obtener el proyecto desde la ruta
        $project = $request->route('project'); // Esto obtiene el objeto del proyecto
        if (auth()->user()->role != 'admin') {
            // Verificar si el proyecto tiene una relación con el usuario logueado
            $relUserProject = RelUserProject::where('project_id', $project->id)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhereHas('project', function ($query) use ($userId) {
                            $query->where('user_id', $userId);
                        });
                })
                ->exists();

            if (!$relUserProject) {
                return abort(403, 'No tienes acceso a este proyecto.');
            }
        }


        return $next($request);
    }
}