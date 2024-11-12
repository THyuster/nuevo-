<?php

use Illuminate\Support\Facades\Route;

/*LOGISTICA*/
use App\Http\Controllers\modulo_logistica\logistica_blindajesController;
use App\Http\Controllers\modulo_logistica\logistica_combustibleController;
use App\Http\Controllers\modulo_logistica\logistica_ejesController;
use App\Http\Controllers\modulo_logistica\logistica_grupos_vehiculosController;
use App\Http\Controllers\modulo_logistica\logistica_marcasController;
use App\Http\Controllers\modulo_logistica\logistica_trailersController;
use App\Http\Controllers\modulo_logistica\logistica_vehiculosController;


Route::prefix('logistica')->group(function () {

    Route::prefix('grupo_vehiculo')->group(function () {
        Route::get('show', [logistica_grupos_vehiculosController::class, 'show']);
        Route::post('', [logistica_grupos_vehiculosController::class, 'create']);
        Route::put('update/{id}', [logistica_grupos_vehiculosController::class, 'update']);
        Route::delete('delete/{id}', [logistica_grupos_vehiculosController::class, 'destroy']);
    });

    Route::prefix('trailers')->group(function () {
        Route::post('', [logistica_trailersController::class, 'create']);
        Route::post('{id}', [logistica_trailersController::class, 'update']);
        Route::delete('{id}', [logistica_trailersController::class, 'destroy']);
        Route::get('show', [logistica_trailersController::class, 'show']);
    });
    
    Route::prefix('vehiculos')->group(function () {
        Route::get('show', [logistica_vehiculosController::class, 'show']);
        Route::post('', [logistica_vehiculosController::class, 'create']);
        Route::post('{id}', [logistica_vehiculosController::class, 'update']);
        Route::delete('{id}', [logistica_vehiculosController::class, 'destroy']);
        Route::put('estado/{id}', [logistica_vehiculosController::class, 'estado']);
        Route::get('entidades', [logistica_vehiculosController::class, 'entidades']);
        Route::get('obtenerTiposVehiculos', [
            logistica_vehiculosController::class,
            'getTypesVehicles'
        ]);
    });

    Route::prefix('marcas')->group(function () {
        Route::get('', [logistica_marcasController::class, 'Obtener']);
        Route::get('desencrypt', [logistica_marcasController::class, 'ObtenerDesencrypt']);
        Route::post('', [logistica_marcasController::class, 'Crear']);
        Route::post('{id}', [logistica_marcasController::class, 'Actualizar']);
        Route::delete('{id}', [logistica_marcasController::class, 'delete']);
    });

    Route::prefix('combustibles')->group(function () {
        Route::get('', [logistica_combustibleController::class, 'show']);
    });

});

Route::prefix('logistica_vehiculos')->group(function () {
    Route::prefix('vehiculos')->group(function () {
        Route::get('', [logistica_vehiculosController::class, 'getSSR']);
        Route::get('by/placa/{placa}', [
            logistica_vehiculosController::class,
            'GetVehiculoByPlaca'
        ]);
    });
});

Route::prefix('modulo_logistica')->group(function () {
    Route::prefix('blindajes')->group(function () {
        Route::get('', [logistica_blindajesController::class, 'show']);
        Route::post('', [logistica_blindajesController::class, 'create']);
        Route::put('update/{id}', [logistica_blindajesController::class, 'update']);
        Route::delete('{id}', [logistica_blindajesController::class, 'destroy']);

    });
    Route::prefix('ejes')->group(function () {
        Route::get('', [logistica_ejesController::class, 'show']);
        Route::post('', [logistica_ejesController::class, 'create']);
        Route::put('update/{id}', [logistica_ejesController::class, 'update']);
        Route::delete('{id}', [logistica_ejesController::class, 'destroy']);
    });
});