<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas por Sanctum
Route::middleware('auth:sanctum')->group(function (): void {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Usuarios
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    // Partidos
    Route::get('/matches', [MatchController::class, 'index']);
    Route::post('/matches', [MatchController::class, 'store']);
    Route::get('/matches/{id}', [MatchController::class, 'show']);
    Route::put('/matches/{id}', [MatchController::class, 'update']);
    Route::post('/matches/{id}/join', [MatchController::class, 'join']);
    Route::delete('/matches/{id}/leave', [MatchController::class, 'leave']);
    Route::patch('/matches/{id}/cancel', [MatchController::class, 'cancel']);
});
