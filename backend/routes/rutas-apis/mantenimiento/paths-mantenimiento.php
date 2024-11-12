<?php

use Illuminate\Support\Facades\Route;

/*MANTENIMIENTO */
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_actasController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_entregasDirectasController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_estacionesController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_ItemsDiagnosticoController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_medicionesController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_ordenesController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_solicitudesController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_tecnicosController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_tipos_ordenesController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_tipos_solicitudesController;


Route::prefix('mantenimiento')->group(function () {

    Route::prefix('ordenes')->group(function () {
        Route::get('tecnicos', [mantenimiento_tecnicosController::class, 'GetTecnicosSSRByIdOrden']);
        Route::get('', [mantenimiento_ordenesController::class, 'obtener']);
        Route::post('', [mantenimiento_ordenesController::class, 'crear']);
        Route::post('asignacion/{id}', [mantenimiento_ordenesController::class, 'actualizar']);
        Route::delete('{id}', [mantenimiento_ordenesController::class, 'eliminar']);
    });

    Route::prefix('itemsDiagnotico')->group(function () {
        Route::get('', [mantenimiento_ItemsDiagnosticoController::class, 'show']);
        Route::post('', [mantenimiento_ItemsDiagnosticoController::class, 'create']);
        Route::put('', [mantenimiento_ItemsDiagnosticoController::class, 'update']);
        Route::post('delete', [mantenimiento_ItemsDiagnosticoController::class, 'destroy']);
        Route::put('estado', [mantenimiento_ItemsDiagnosticoController::class, 'updateStatus']);
    });

    Route::prefix('itemsDiagnoticoRespuesta')->group(function () {
        Route::get('', [mantenimiento_ItemsDiagnosticoController::class, 'itemsConRespuesta']);
    });

    Route::prefix('itemsDiagnoticoTiposOrdenes')->group(function () {
        Route::get('{id}/{idActa}', [mantenimiento_ItemsDiagnosticoController::class, 'itemsConTipoOrden']);
    });

    Route::prefix('mediciones')->group(function () {
        Route::get('', [mantenimiento_medicionesController::class, "obtener"]);
        Route::delete('{id}', [mantenimiento_medicionesController::class, "eliminar"]);
        Route::post('{id}', [mantenimiento_medicionesController::class, "actualizar"]);
        Route::post('', [mantenimiento_medicionesController::class, "crear"]);
        Route::get('{id}', [mantenimiento_medicionesController::class, "obtenerMedicionID"]);
    });

    Route::prefix('estaciones')->group(function () {
        Route::get('', [mantenimiento_estacionesController::class, 'obtener']);
        Route::post('', [mantenimiento_estacionesController::class, 'crear']);
        Route::post('{id}', [mantenimiento_estacionesController::class, 'actualizar']);
        Route::delete('{id}', [mantenimiento_estacionesController::class, 'eliminar']);
        Route::put('{id}', [mantenimiento_estacionesController::class, 'estado']);
    });

    Route::prefix('itemsDiagnostico')->group(function () {
        Route::get('', [mantenimiento_ItemsDiagnosticoController::class, 'show']);
        Route::post('', [mantenimiento_ItemsDiagnosticoController::class, 'create']);
        Route::put('', [mantenimiento_ItemsDiagnosticoController::class, 'update']);
        Route::post('delete', [mantenimiento_ItemsDiagnosticoController::class, 'destroy']);
        Route::put('estado', [mantenimiento_ItemsDiagnosticoController::class, 'updateStatus']);
    });

    Route::prefix('actas')->group(function () {
        Route::get('/show', [mantenimiento_actasController::class, 'show']);
        Route::post('', [mantenimiento_actasController::class, 'create']);
        Route::post('actualizar/{id}', [mantenimiento_actasController::class, 'update']);
        Route::post('tecnicos/{id}', [mantenimiento_actasController::class, 'tecnicosOrden']);
        Route::post('obtenerCentro', [mantenimiento_actasController::class, 'obtenerCentro']);
        Route::post('obtenerEV', [mantenimiento_actasController::class, 'obtenerEV']);
    });

    Route::prefix('tecnicos')->group(function () {
        Route::get('', [mantenimiento_tecnicosController::class, 'GetTecnicosSSR']);
    });
});

Route::prefix('modulo_mantenimiento')->group(function () {

    Route::prefix('tipos_solicitudes')->group(function () {
        Route::get('show', [mantenimiento_tipos_solicitudesController::class, 'show']);
        Route::post('', [mantenimiento_tipos_solicitudesController::class, 'create']);
        Route::delete('delete/{id}', [mantenimiento_tipos_solicitudesController::class, 'destroy']);
        Route::put('update/{id}', [mantenimiento_tipos_solicitudesController::class, 'update']);
    });

    Route::prefix('tipos_ordenes')->group(function () {
        Route::get('show', [mantenimiento_tipos_ordenesController::class, 'show']);
        Route::post('', [mantenimiento_tipos_ordenesController::class, 'create']);
        Route::post('update/{id}', [mantenimiento_tipos_ordenesController::class, 'update']);
        Route::delete('delete/{id}', [mantenimiento_tipos_ordenesController::class, 'destroy']);
        Route::put('updateStatus/{id}', [mantenimiento_tipos_ordenesController::class, 'updateStatus']);
    });

    Route::prefix('solicitudes')->group(function () {
        Route::get('show', [mantenimiento_solicitudesController::class, 'show']);
        Route::get('terceros', [mantenimiento_solicitudesController::class, 'terceros']);
        Route::post('', [mantenimiento_solicitudesController::class, 'create']);
        Route::post('{id}', [mantenimiento_solicitudesController::class, 'update']);
        Route::delete('{id}', [mantenimiento_solicitudesController::class, 'destroy']);
        Route::get('{id}', [mantenimiento_solicitudesController::class, 'searchId']);
        Route::post('firmar/{id}', [mantenimiento_solicitudesController::class, 'firmarSolicitud']);
    });
    Route::prefix('tecnicos')->group(function () {
        Route::get('show', [mantenimiento_tecnicosController::class, 'show']);
        Route::post('', [mantenimiento_tecnicosController::class, 'create']);
        Route::delete('delete/{id}', [mantenimiento_tecnicosController::class, 'destroy']);
    });
});

Route::prefix('v1/mantenimiento')->group(function () {

    Route::prefix('entregasDirectas')->group(function () {
        Route::get('', [mantenimiento_entregasDirectasController::class, 'obtener']);
        Route::post('', [mantenimiento_entregasDirectasController::class, 'crear']);
        Route::put('actualizar', [mantenimiento_entregasDirectasController::class, 'actualizar']);
        Route::delete('eliminar', [mantenimiento_entregasDirectasController::class, 'eliminar']);
    });
});
