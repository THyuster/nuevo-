<?php

use Illuminate\Support\Facades\Route;

/*GESTION DE CALIDAD */
use App\Http\Controllers\modulo_gestion_calidad\ListaChequeoController;
use App\Http\Controllers\modulo_gestion_calidad\TipoSolicitudController;
use App\Http\Controllers\modulo_gestion_calidad\GestionAuditoriaController;



//modulo gestion de calidad
Route::get('/modulo_gestion_calidad/listaChequeo', [ListaChequeoController::class, 'show']);
Route::post('/modulo_gestion_calidad/listaChequeo', [ListaChequeoController::class, 'create']);
Route::put('/modulo_gestion_calidad/listaChequeo/{id}', [ListaChequeoController::class, 'update']);
Route::put('/modulo_gestion_calidad/listaChequeo/cambiarEstado/{id}', [ListaChequeoController::class, 'actualizarEstado']);
Route::delete('/modulo_gestion_calidad/listaChequeo/{id}/delete', [ListaChequeoController::class, 'destroy']);

//gestion de auditorias
Route::get('/modulo_gestion_calidad/gestionAuditoria', [GestionAuditoriaController::class, 'show']);
Route::post('/modulo_gestion_calidad/gestionAuditoria', [GestionAuditoriaController::class, 'crear']);
Route::post('/modulo_gestion_calidad/gestionAuditoria/{id}', [GestionAuditoriaController::class, 'update']);
Route::delete('/modulo_gestion_calidad/gestionAuditoria/{id}', [GestionAuditoriaController::class, 'destroy']);

//consumos
Route::get('/modulo_gestion_calidad/tipoSolicitud', [TipoSolicitudController::class, 'show']);




