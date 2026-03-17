<?php

use App\Support\ApiResponse;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return ApiResponse::success(['pong' => true], 'API en ligne');
});

Route::fallback(function () {
    return ApiResponse::error(['route' => ['Endpoint introuvable.']], 'Ressource introuvable', 404);
});
