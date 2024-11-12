<?php

use App\Http\Controllers\modulo_sagrilaft\ColorController;
use App\Http\Controllers\modulo_sagrilaft\sagrilaftEmpleadoController;
use App\Http\Controllers\modulo_sagrilaft\sagrilaftUrlController;
use App\Http\Controllers\modulo_sagrilaft\tipoValidacionController;
use Illuminate\Support\Facades\Route;


// Route::post();
Route::prefix('sagrilaft')->group(function () {
    Route::group(['prefix' => 'url'], function () {
        Route::post('', [sagrilaftUrlController::class, 'store']);
        Route::get('', [sagrilaftUrlController::class, 'show']);
        Route::delete('{id}', [sagrilaftUrlController::class, 'destroy']);
        Route::get('tipos-validacion', [tipoValidacionController::class, 'show']);
        Route::get('GetsColors', [ColorController::class, 'getAllColors']); 
    });

    Route::group(['prefix' => 'validacion'], function () {
        // Route::post('validacion')
        Route::group(['prefix' => 'empleado'], function () {
            Route::post('', [sagrilaftEmpleadoController::class,'store']);
        });
    });
});