<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\ShareUserRole;





// Ruta de inicio, redirige a la lista de proyectos

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/projects', function () {
    return redirect()->route('projects.index');
});



Route::middleware([RoleMiddleware::class.':admin',RoleMiddleware::class.':teacher',ShareUserRole::class])->group(function () {
    // Rutas del CRUD para Project
    Route::resource('projects', ProjectController::class);
});
Route::middleware([ShareUserRole::class])->group(function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/home', function () {
        return view('home');
    })->name('home'); //home ahora obtiene el rol del usuario mediante el middleware
});



/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

 */
/* 

 */