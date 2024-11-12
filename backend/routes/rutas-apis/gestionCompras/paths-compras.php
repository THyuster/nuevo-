<?php

use App\Http\Controllers\modulo_gestion_compra\gc_ordenesController;
use App\Http\Controllers\modulo_gestion_compra\gc_presupuestoController;
use App\Http\Controllers\modulo_gestion_compra\gc_requisicionesController;
use Illuminate\Support\Facades\Route;

Route::prefix('modulo_gestion_compras')->group(function () {

    Route::prefix('presupuesto')->group(function () {
        Route::post('', [gc_presupuestoController::class, 'crearPresupuestos']);
        Route::get('', [gc_presupuestoController::class, 'obtenerPresupuestos']);
        Route::put('{id}', [gc_presupuestoController::class, 'actualizarPresupuestos']);
        Route::delete('{id}', [gc_presupuestoController::class, 'eliminarPresupuestos']);

    });

    Route::prefix('requisiciones')->group(function () {
        Route::get('/gruposAsociados', [gc_requisicionesController::class, 'obtenerArticulosYEquipos']);
        Route::post('', [gc_requisicionesController::class, 'crearRequisiciones']);
        Route::get('', [gc_requisicionesController::class, 'obtenerRequisiciones']);
        Route::post('{id}', [gc_requisicionesController::class, 'actualizarRequisiciones']);
        Route::delete('{id}', [gc_requisicionesController::class, 'eliminarRequisiciones']);
        Route::put('{id}/estado', [gc_requisicionesController::class, 'actualizarEstadoRequisiciones']);
    });

    Route::prefix('ordenes')->group(function () {
        Route::post('', [gc_ordenesController::class, 'crearOrdenes']);
        Route::get('', [gc_ordenesController::class, 'obtenerOrdenes']);
        Route::post('{id}', [gc_ordenesController::class, 'actualizarOrdenes']);
        Route::delete('{id}', [gc_ordenesController::class, 'eliminarOrdenes']);
        Route::put('{id}/estado', [gc_ordenesController::class, 'actualizarEstadoRequisiciones']);
    });
});
