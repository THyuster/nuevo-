<?php

use App\Http\Controllers\modulo_nomina\Blacklist\nomina_blacklistController;
use App\Http\Controllers\modulo_nomina\empleados\empleadosController;
use App\Http\Controllers\modulo_nomina\Gestion\GestionCargosSena;
use App\Http\Controllers\modulo_nomina\Gestion\NominaArea;
use App\Http\Controllers\modulo_nomina\Gestion\NominaCentroCostos;
use App\Http\Controllers\modulo_nomina\Gestion\NominaSeccion;
use App\Http\Controllers\modulo_nomina\nomina_convocatoriasController;
use App\Http\Controllers\modulo_nomina\nomina_solicitud_empleoController;
use App\Http\Controllers\modulo_nomina\Postulantes\postulanteController;
use App\Http\Middleware\LoginSesionActive;
use Illuminate\Support\Facades\Route;

/*NOMINA */
use App\Http\Controllers\modulo_nomina\nomina_cargosController;
use App\Http\Controllers\modulo_nomina\nomina_centros_trabajoController;
use App\Http\Controllers\modulo_nomina\nomina_entidadesController;
use App\Http\Controllers\modulo_nomina\nomina_TipoContratoController;
use App\Http\Controllers\modulo_nomina\nomina_userCentrosController;

Route::prefix('modulo_nomina')->group(function () {

    // Centro de trabajo
    Route::prefix('centros_trabajo')->group(function () {
        Route::get('show', [nomina_centros_trabajoController::class, 'show']);
        Route::post('', [nomina_centros_trabajoController::class, 'create']);
        Route::delete('{id}', [nomina_centros_trabajoController::class, 'destroy']);
        Route::post('{id}', [nomina_centros_trabajoController::class, 'update']);
        Route::put('{id}', [nomina_centros_trabajoController::class, 'status']);
    });

    // Usuario centro de trabajo
    Route::prefix('usuario_centro_trabajo')->group(function () {
        Route::get('show', [nomina_userCentrosController::class, 'show']);
        Route::post('', [nomina_userCentrosController::class, 'create']);
        Route::delete('{id}', [nomina_userCentrosController::class, 'destroy']);
        Route::post('{id}', [nomina_userCentrosController::class, 'update']);
        Route::put('{id}', [nomina_userCentrosController::class, 'status']);
    });

    // Cargos
    Route::prefix('cargos')->group(function () {
        Route::get('', [nomina_cargosController::class, 'obtener']);
        Route::post('', [nomina_cargosController::class, 'crear']);
        Route::delete('{id}', [nomina_cargosController::class, 'eliminar']);
        Route::post('{id}', [nomina_cargosController::class, 'actualizar']);
        Route::get('filter', [nomina_cargosController::class, 'filterCargos']);
    });

    // Tipo de contrato
    Route::prefix('tipo_contrato')->group(function () {
        Route::get('', [nomina_TipoContratoController::class, 'show']);
        Route::post('', [nomina_TipoContratoController::class, 'create']);
        Route::put('{id}', [nomina_TipoContratoController::class, 'update']);
        Route::delete('{id}', [nomina_TipoContratoController::class, 'destroy']);
    });

});

Route::prefix('nomina')->group(function () {

    // Rutas para entidades
    Route::prefix('entidades')->group(function () {
        Route::get('', [nomina_entidadesController::class, 'obtener']);
        Route::post('', [nomina_entidadesController::class, 'crear']);
        Route::put('actualizar/{id}', [nomina_entidadesController::class, 'actualizar']);
        Route::delete('eliminar/{id}', [nomina_entidadesController::class, 'eliminar']);
    });

    // Rutas para área
    Route::prefix('area')->group(function () {
        Route::get('get', [NominaArea::class, 'show']);
        Route::post('crear', [NominaArea::class, 'store']);
        Route::post('actualizar/{id}', [NominaArea::class, 'update']);
        Route::delete('eliminar/{id}', [NominaArea::class, 'destroy']);
        Route::put('cambiar/estado/{id}', [NominaArea::class, 'cambiarEstado']);
    });

    // Rutas para centro de costos
    Route::prefix('centro/costos')->group(function () {
        Route::get('get', [NominaCentroCostos::class, 'show']);
        Route::post('crear', [NominaCentroCostos::class, 'store']);
        Route::post('actualizar/{id}', [NominaCentroCostos::class, 'update']);
        Route::delete('eliminar/{id}', [NominaCentroCostos::class, 'destroy']);
        Route::put('cambiar/estado/{id}', [NominaCentroCostos::class, 'cambiarEstado']);
    });

    // Rutas para sección
    Route::prefix('seccion')->group(function () {
        Route::get('get', [NominaSeccion::class, 'show']);
        Route::post('crear', [NominaSeccion::class, 'store']);
        Route::post('actualizar/{id}', [NominaSeccion::class, 'update']);
        Route::delete('eliminar/{id}', [NominaSeccion::class, 'destroy']);
        Route::put('cambiar/estado/{id}', [NominaSeccion::class, 'cambiarEstado']);
    });

    // Rutas para cargos SENA
    Route::prefix('cargos/sena')->group(function () {
        Route::get('get', [GestionCargosSena::class, 'show']);
        Route::post('crear', [GestionCargosSena::class, 'store']);
        Route::post('actualizar/{id}', [GestionCargosSena::class, 'update']);
        Route::delete('eliminar/{id}', [GestionCargosSena::class, 'destroy']);
        Route::put('cambiar/estado/{id}', [GestionCargosSena::class, 'cambiarEstado']);
        Route::get('lista', [GestionCargosSena::class, 'getListCargosSena']);
    });

    // Rutas para solicitud de empleo
    Route::prefix('solicitud/empleo')->group(function () {
        Route::post('store', [nomina_solicitud_empleoController::class, 'store']);
        Route::get('get', [nomina_solicitud_empleoController::class, 'show']);
        Route::post('update/{id}', [nomina_solicitud_empleoController::class, 'update']);
        Route::delete('destroy/{id}', [nomina_solicitud_empleoController::class, 'destroy']);
        Route::get('get/{id}', [nomina_solicitud_empleoController::class, 'getSolicitudEmpleoById']);
        Route::get('list', [nomina_solicitud_empleoController::class, 'getSolicitudEmpleoList']);
    });

    // Rutas para convocatorias
    Route::prefix('convocatorias')->group(function () {
        Route::get('get', [nomina_convocatoriasController::class, 'show']);
        Route::post('store', [nomina_convocatoriasController::class, 'store']);
        Route::post('update/{id}', [nomina_convocatoriasController::class, 'update']);
        Route::delete('destroy/{id}', [nomina_convocatoriasController::class, 'destroy']);
        Route::post('aceptar/solicitud', [nomina_convocatoriasController::class, 'aceptarConvocatoriaSolicitud']);
        Route::get('rechazar/solicitud/{id}', [nomina_convocatoriasController::class, 'rejectConvocatoriaBySolicitud']);
        Route::get('list', [nomina_convocatoriasController::class, 'getListConvocatorias'])
            ->withoutMiddleware([LoginSesionActive::class]);
        Route::get('all', [nomina_convocatoriasController::class, 'getAllConvocatorias'])
            ->withoutMiddleware([LoginSesionActive::class]);
    });

    // Ruta para blacklist
    Route::prefix('blacklist')->group(function () {
        Route::get('', [nomina_blacklistController::class, 'show']);
        Route::post('', [nomina_blacklistController::class, 'store']);
        Route::post('{id}', [nomina_blacklistController::class, 'update']);
        Route::delete('{id}', [nomina_blacklistController::class, 'destroy']);
    });

    Route::prefix('postulante')->group(function () {
        Route::get('convocatoria/{id}', [postulanteController::class, 'show']);
        Route::put('{id}', [postulanteController::class, 'statu']);
        Route::get('{id}', [postulanteController::class, 'postulante']);
        Route::post('', [postulanteController::class, 'store'])->withoutMiddleware([LoginSesionActive::class]);
    });

    Route::prefix('empleado')->group(function () {
        Route::get('', [empleadosController::class, 'show']);
    });
});