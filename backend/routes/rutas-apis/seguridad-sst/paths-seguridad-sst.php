<?php

use Illuminate\Support\Facades\Route;

/*SEGURIDAD SST */
//use App\Http\Controllers\modulo_seguridadsst\seguridadsst_partesCuerpoController;
use App\Http\Controllers\modulo_seguridadsst\seguridadsst_partesCuerpoController;


//Partes del Cuerpo
Route::get('/modulo_seguridadsst/partes_cuerpo', [seguridadsst_partesCuerpoController::class, 'obtener']);
Route::post('/modulo_seguridadsst/partes_cuerpo', [seguridadsst_partesCuerpoController::class, 'crear']);
Route::post('/modulo_seguridadsst/partes_cuerpo/{id}', [seguridadsst_partesCuerpoController::class, 'actualizar']);
Route::delete('/modulo_seguridadsst/partes_cuerpo/{id}', [seguridadsst_partesCuerpoController::class, 'eliminar']);
Route::put('/modulo_seguridadsst/partes_cuerpo/{id}', [seguridadsst_partesCuerpoController::class, 'estado']);



