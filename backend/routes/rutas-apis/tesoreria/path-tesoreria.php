<?php

use App\Http\Controllers\modulo_tesoreria\TesoreriaConceptosController;
use App\Http\Controllers\modulo_tesoreria\TesoreriaGruposConceptosController;
use Illuminate\Support\Facades\Route;

Route::prefix('modulo_tesoreria')->group(function () {

    Route::prefix('grupoConcepto')->group(function () {
        Route::get('', [TesoreriaGruposConceptosController::class, 'index']);
        Route::post('', [TesoreriaGruposConceptosController::class, 'crear']);
        Route::put('',[TesoreriaGruposConceptosController::class, 'actualizar']);
        Route::delete('{id}', [TesoreriaGruposConceptosController::class, 'eliminar']);
    });
    
    Route::prefix('concepto')->group(function () {
        Route::get('', [TesoreriaConceptosController::class, 'index']);
        Route::get('v2', [TesoreriaConceptosController::class, 'indexSinEncriptar']);
        Route::post('', [TesoreriaConceptosController::class, 'crear']);
        Route::put('',[TesoreriaConceptosController::class, 'actualizar']);
        Route::delete('{id}', [TesoreriaConceptosController::class, 'eliminar']);
    });
});