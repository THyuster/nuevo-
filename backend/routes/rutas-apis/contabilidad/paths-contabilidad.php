<?php

use App\Http\Controllers\modulo_contabilidad\PlanUnicoCuentas\CuentasAuxiliaresController;
use App\Http\Middleware\LoginSesionActive;
use Illuminate\Support\Facades\Route;

/*MANTENIMIENTO */
use App\Http\Controllers\modulo_contabilidad\contabilidad_afiscalController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_areasController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_bancosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_centrosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_departamentosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_empresasController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_municipiosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_periodosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_prefijosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_sucursalesController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tercerosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tipos_comprobantesController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tipos_identificacionesController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tipos_tercerosController;


Route::group(['prefix' => 'modulo_contabilidad'], function () {
    Route::group(['prefix' => 'empresas'], function () {
        /*empresas */
        Route::get('show', [contabilidad_empresasController::class, 'show']);
        Route::post('', [contabilidad_empresasController::class, 'create']);
        Route::post('update/{id}', [contabilidad_empresasController::class, 'update']);
        Route::delete('delete/{id}', [contabilidad_empresasController::class, 'destroy']);
        Route::put('updateStatus/{id}', [contabilidad_empresasController::class, 'updateStatus']);
    });

    Route::group(['prefix' => 'sucursales'], function () {
        /*sucursales*/
        Route::get('show', [contabilidad_sucursalesController::class, 'show']);
        Route::post('', [contabilidad_sucursalesController::class, 'create']);
        Route::put('{id}', [contabilidad_sucursalesController::class, 'update']);
        Route::delete('{id}', [contabilidad_sucursalesController::class, 'destroy']);
        Route::put('{id}/updateStatus', [contabilidad_sucursalesController::class, 'changeStatus']);
    });

    Route::group(['prefix' => 'departamentos'], function () {
        /*departamentos*/
        Route::get('show', [contabilidad_departamentosController::class, 'show'])
            ->withoutMiddleware([LoginSesionActive::class]);
        Route::post('', [contabilidad_departamentosController::class, 'create']);
        Route::delete('{id}', [contabilidad_departamentosController::class, 'destroy']);
        Route::put('{id}', [contabilidad_departamentosController::class, 'update']);
    });

    Route::group(['prefix' => 'municipios'], function () {
        Route::get('show', [contabilidad_municipiosController::class, 'show'])
            ->withoutMiddleware([LoginSesionActive::class]);
        Route::post('', [contabilidad_municipiosController::class, 'create']);
        Route::put('{id}', [contabilidad_municipiosController::class, 'update']);
        Route::delete('{id}', [contabilidad_municipiosController::class, 'destroy']);
        Route::get('municipality', [contabilidad_municipiosController::class, 'municipality']);
    });

    Route::group(['prefix' => 'afiscal'], function () {
        //año fiscal
        Route::get('', [contabilidad_afiscalController::class, 'index']);
        Route::get('show', [contabilidad_afiscalController::class, 'show']);
        Route::post('', [contabilidad_afiscalController::class, 'create']);
        Route::post('update/{id}', [contabilidad_afiscalController::class, 'update']);
        Route::delete('delete/{id}', [contabilidad_afiscalController::class, 'destroy']);
        Route::put('updateStatus/{id}', [contabilidad_afiscalController::class, 'updateStatus']);
    });

    Route::group(['prefix' => 'periodos'], function () {
        //periodos
        Route::get('show', [contabilidad_periodosController::class, 'show']);
        Route::post('', [contabilidad_periodosController::class, 'create']);
        Route::post('update/{id}', [contabilidad_periodosController::class, 'update']);
        Route::delete('delete/{id}', [contabilidad_periodosController::class, 'destroy']);
        Route::put('updateStatus/{id}', [contabilidad_periodosController::class, 'updateStatus']);
        Route::post('repeatYear', [contabilidad_periodosController::class, 'replicateYear']);
        Route::get('filterPeriodsByYear/{id}', [contabilidad_periodosController::class, 'filterPeriodsByYear']);
    });

    Route::group(['prefix' => 'terceros'], function () {
        /*terceros*/
        Route::get('show', [contabilidad_tercerosController::class, 'show']);
        Route::post('', [contabilidad_tercerosController::class, 'create']);
        Route::post('{id}', [contabilidad_tercerosController::class, 'update']);
        Route::delete('{id}', [contabilidad_tercerosController::class, 'destroy']);
        Route::put('{id}/updateStatus', [contabilidad_tercerosController::class, 'updateStatus']);
        Route::get('search', [contabilidad_tercerosController::class, 'GetTerceroByFilter']);
    });

    Route::group(['prefix' => 'tipos_identificaciones'], function () {
        /*tipos de identificaciones*/
        Route::get('show', [contabilidad_tipos_identificacionesController::class, 'show'])->withoutMiddleware([LoginSesionActive::class]);
        Route::post('', [contabilidad_tipos_identificacionesController::class, 'create']);
        Route::put('{id}', [contabilidad_tipos_identificacionesController::class, 'update']);
        Route::delete('{id}', [contabilidad_tipos_identificacionesController::class, 'destroy']);
    });

    Route::group(['prefix' => 'tipos_terceros'], function () {
        /*tipos de terceros*/
        Route::get('show', [contabilidad_tipos_tercerosController::class, 'show']);
        Route::post('', [contabilidad_tipos_tercerosController::class, 'create']);
        Route::post('{id}', [contabilidad_tipos_tercerosController::class, 'update']);
        Route::delete('{id}', [contabilidad_tipos_tercerosController::class, 'destroy']);
        Route::get('thirdParty', [contabilidad_tipos_tercerosController::class, 'thirdParty']);
    });
    Route::group(['prefix' => 'bancos'], function () {
        /*bancos*/
        Route::get('', [contabilidad_bancosController::class, 'obtener']);
        Route::post('', [contabilidad_bancosController::class, 'crear']);
        Route::post('{id}', [contabilidad_bancosController::class, 'actualizar']);
        Route::delete('{id}', [contabilidad_bancosController::class, 'eliminar']);
        Route::put('{id}', [contabilidad_bancosController::class, 'estado']);
        Route::post('Tns', [contabilidad_bancosController::class, 'conversionDatosTns']);
    });
});


Route::group(['prefix' => 'contabilidad'], function () {
    Route::group(['prefix' => 'prefijos'], function () {
        /*prefijos*/
        Route::get('show', [contabilidad_prefijosController::class, 'show']);
        Route::post('', [contabilidad_prefijosController::class, 'create']);
        Route::post('update/{id}', [contabilidad_prefijosController::class, 'update']);
        Route::delete('delete/{id}', [contabilidad_prefijosController::class, 'destroy']);
        Route::put('{id}/updateStatus', [contabilidad_prefijosController::class, 'updateStatus']);
    });
    Route::group(['prefix' => 'tipos_comprobantes'], function () {
        /*tipos de comprobantes*/
        Route::get('show', [contabilidad_tipos_comprobantesController::class, 'show']);
        Route::post('', [contabilidad_tipos_comprobantesController::class, 'create']);
        Route::post('update/{id}', [contabilidad_tipos_comprobantesController::class, 'update']);
        Route::delete('{id}/delete', [contabilidad_tipos_comprobantesController::class, 'destroy']);
        Route::put('{id}/updateStatus', [contabilidad_tipos_comprobantesController::class, 'updateStatus']);
        Route::put('{id}/updateSign', [contabilidad_tipos_comprobantesController::class, 'updateSign']);
    });
    Route::group(['prefix' => 'centros'], function () {
        /*centros*/
        Route::get('', [contabilidad_centrosController::class, 'obtener']);
        Route::post('', [contabilidad_centrosController::class, 'crear']);
        Route::post('{id}', [contabilidad_centrosController::class, 'actualizar']);
        Route::delete('{id}', [contabilidad_centrosController::class, 'eliminar']);
        Route::put('{id}', [contabilidad_centrosController::class, 'estado']);
    });

    Route::group(['prefix' => 'areas'], function () {
        /*areas*/
        Route::get('', [contabilidad_areasController::class, 'obtener']);
        Route::post('', [contabilidad_areasController::class, 'crear']);
        Route::post('{id}', [contabilidad_areasController::class, 'actualizar']);
        Route::delete('{id}', [contabilidad_areasController::class, 'eliminar']);
        Route::put('{id}', [contabilidad_areasController::class, 'estado']);
    });

    Route::group(['prefix' => 'cuentaAuxiliar'], function () {
        Route::get('', [CuentasAuxiliaresController::class, 'obtener']);
    });
});