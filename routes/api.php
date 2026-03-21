<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\SymptomController;
use App\Support\ApiResponse;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return ApiResponse::success(['pong' => true], 'API en ligne');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctors/search', [DoctorController::class, 'search']);
Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('symptoms', SymptomController::class);
    Route::apiResource('appointments', AppointmentController::class);
});

Route::fallback(function () {
    return ApiResponse::error(['route' => ['Endpoint introuvable.']], 'Ressource introuvable', 404);
});
