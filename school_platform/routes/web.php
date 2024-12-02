<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\ShareUserRole;
use App\Http\Middleware\CheckUserAccess;
use App\Http\Middleware\UsersRoleAccessMiddleware;




// Ruta de inicio, redirige a la lista de proyectos

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/projects', function () {
    return redirect()->route('projects.index');
});



Route::middleware([RoleMiddleware::class.':admin,teacher',ShareUserRole::class])->group(function () {
    // Rutas del CRUD para User
    /* Route::resource('users', UserController::class); */
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users.store', [UserController::class, 'store'])->name('users.store');
    
});
Route::middleware([UsersRoleAccessMiddleware::class,ShareUserRole::class])->group(function () {
    Route::get('/users/{user_id}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user_id}/delete', [UserController::class, 'destroy'])->name('users.destroy');    
    Route::get('/users/{user_id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users.update', [UserController::class, 'update'])->name('users.update');
});


Route::middleware([RoleMiddleware::class.':admin,teacher,student',ShareUserRole::class])->group(function () {
    // Rutas del CRUD para Project
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects.store', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('projects.update', [ProjectController::class, 'update'])->name('projects.update');
/*     Route::resource('projects', ProjectController::class); */

    Route::get('/download-file/{userId}/{projectId}', [FileController::class, 'downloadFile'])->name('download.file');
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
});


Route::middleware([CheckUserAccess::class,ShareUserRole::class])->group(function(){
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::delete('/projects/{project}/delete', [ProjectController::class, 'destroy'])->name('projects.destroy');

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