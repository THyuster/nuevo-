<?php

use App\Http\Controllers\importaciones\ImportacionController;
use App\Http\Controllers\modulo_configuracion\erp_logImportacionesController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/realizarImportacion', [ImportacionController::class, 'registrarImportacion']);
Route::post('v1/modulo_importacion/importacionTns', [erp_logImportacionesController::class, 'show']);