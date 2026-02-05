<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacacionController;
use Illuminate\Support\Facades\Route;

// Ruta de bienvenida (pública)
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Rutas de Perfil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas RESTful para vacaciones, rutas de paquetes vacacionales
    Route::resource('vacaciones', VacacionController::class);
    
    // Rutas adicionales para vacaciones
    Route::post('vacaciones/{vacacion}/reservar', [VacacionController::class, 'reservar'])
         ->name('vacaciones.reservar');
    
    Route::post('vacaciones/{vacacion}/comentario', [VacacionController::class, 'agregarComentario'])
         ->name('vacaciones.comentario');
    
    Route::delete('comentarios/{comentario}', [VacacionController::class, 'eliminarComentario'])
         ->name('comentarios.destroy');
});

// Rutas de autenticación (Laravel Breeze)
require __DIR__.'/auth.php';