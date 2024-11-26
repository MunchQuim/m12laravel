<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});
// Ruta de inicio, redirige a la lista de proyectos
Route::get('/index', function () {
    return redirect()->route('projects.index');
});
// Rutas del CRUD para Project
Route::resource('projects', ProjectController::class);
