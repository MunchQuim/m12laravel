<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\RoleMiddleware;



Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
});
// Ruta de inicio, redirige a la lista de proyectos
Route::get('/projects', function () {
    return redirect()->route('projects.index');
});

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/menu', function () {
    return view('menu');
});
// Rutas del CRUD para Project
Route::resource('projects', ProjectController::class);

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
Route::middleware([RoleMiddleware::class.':admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
