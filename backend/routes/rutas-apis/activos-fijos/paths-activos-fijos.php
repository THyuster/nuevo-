<?php

// use Illuminate\Support\Facades\Route;

/*ACTIVOS FIJOS*/
use App\Http\Controllers\modulo_activos_fijos\activos_fijos_equiposController;
use App\Http\Controllers\modulo_activos_fijos\activos_fijos_grupos_equiposController;
use App\Models\modulo_activos_fijos\activos_fijos_grupos_equipos;
use Illuminate\Support\Facades\Route;


Route::prefix('activos_fijos')->group(function () {
    
    Route::prefix('equipos')->group(function () {
        Route::get('show', [activos_fijos_equiposController::class, 'retrieveDatatableData']);
        Route::post('', [activos_fijos_equiposController::class, 'create']);
        Route::post('update/{id}', [activos_fijos_equiposController::class, 'update']);
        Route::delete('delete/{id}', [activos_fijos_equiposController::class, 'destroy']);
        Route::put('{id}/updateStatus', [activos_fijos_equiposController::class, 'updateEquipoStatus']);
        Route::get('', [activos_fijos_equiposController::class, 'fetchActivosFijosByFilter']);
        Route::get('{id}', [activos_fijos_equiposController::class, 'getEquipoDetailsById']);
    });

    Route::prefix('grupos_equipos')->group(function () {
        Route::get('', [activos_fijos_grupos_equiposController::class, 'index']);
        Route::get('show', [activos_fijos_grupos_equiposController::class, 'show']);
        Route::post('', [activos_fijos_grupos_equiposController::class, 'create']);
        Route::put('update/{id}', [activos_fijos_grupos_equiposController::class, 'update']);
        Route::delete('delete/{id}', [activos_fijos_grupos_equiposController::class, 'destroy']);
        Route::get('ssr', [activos_fijos_grupos_equiposController::class, 'getGrupoEquipoServerSide']);
    });

});


