<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiMethodController;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/register', [AuthController::class, 'register']);

// Recibe el JSON de la API
Route::get('/json', [ApiMethodController::class, 'getApiData']);

// Rutas de API protegidas
Route::group(['middleware' => 'auth:api'], function(){
    // Recoger todas las APIs
    Route::get('/apis', [ApiController::class, 'index']);
    // Crear una nueva API
    Route::post('/apis', [ApiController::class, 'store']);
    // Obtener la información de una API específica
    Route::get('/apis/{api}', [ApiController::class, 'show']);
    // Actualizar la información de una API específica
    Route::put('/apis/{api}', [ApiController::class, 'update']);
    // Eliminar una API específica
    Route::delete('/apis/{api}', [ApiController::class, 'destroy']);

    // Recoger todos los metodos de la API
    Route::get('/apis/{api}/methods', [ApiMethodController::class, 'index']);
    // Crear un nuevo método en una API específica
    Route::post('/apis/{api}/methods', [ApiMethodController::class, 'store']);
    // Obtener la información de un método específico de una API específica
    Route::get('/apis/{api}/methods/{method}', [ApiMethodController::class, 'show']);
    // Actualizar la información de un método específico de una API específica
    Route::put('/apis/{api}/methods/{method}', [ApiMethodController::class, 'update']);
    // Eliminar un método específico de una API específica
    Route::delete('/apis/{api}/methods/{method}', [ApiMethodController::class, 'destroy']);
});
