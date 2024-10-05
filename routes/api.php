<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\HorarioDisponibleController;
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\SalonController;




Route::resource('/profesores', ProfesorController::class);
Route::apiResource('/horarios_disponibles', HorarioDisponibleController::class);
Route::apiResource('/profesor_materia', ProfesorMateriaController::class);
Route::apiResource('/materias', MateriaController::class);
Route::apiResource('/clases', ClaseController::class);
Route::apiResource('/salones', SalonController::class);
// Registro de usuario
Route::post('/register', [AuthController::class, 'register']);

// Inicio de sesión
Route::post('/login', [AuthController::class, 'login']);

// Cierre de sesión
Route::post('/logout', [AuthController::class, 'logout']);

// Obtener información del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
