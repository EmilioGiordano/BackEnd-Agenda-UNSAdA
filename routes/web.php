<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    // Si el usuario ya está autenticado, redirigirlo a la página de inicio
    if (Auth::check()) {
        return redirect('/home'); // O a cualquier otra página de inicio
    }
    // De lo contrario, mostrar la vista de inicio de sesión
    return view('auth.login');
})->name('login');


Auth::routes();
Route::resource('plan-courses', App\Http\Controllers\PlanCourseControllerView::class)->middleware('auth');
Route::resource('prerequisites', App\Http\Controllers\PrerequisiteControllerView::class)->middleware('auth');
Route::get( '/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::middleware('api')->group(function () {
//     Route::get('/api/students', [StudentController::class, 'index']);
//     Route::post('/api/students', [StudentController::class, 'store']); // Ruta para crear un estudiante
// });








