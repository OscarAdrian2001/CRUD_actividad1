<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;

Route::get('/estudiantes', [EstudianteController::class, 'index']);
Route::post('/estudiantes', [EstudianteController::class, 'store']);
Route::put('/estudiantes/{id}', [EstudianteController::class, 'update']);
Route::delete('/estudiantes/{id}', [EstudianteController::class, 'destroy']);
