<?php

use App\Http\Controllers\modulo_produccion_minera\pm_bodegasController;
use App\Http\Controllers\modulo_produccion_minera\pm_codigosController;
use App\Http\Controllers\modulo_produccion_minera\pm_contabilizacionController;
use App\Http\Controllers\modulo_produccion_minera\pm_cuposController;
use App\Http\Controllers\modulo_produccion_minera\pm_granulometriaController;
use App\Http\Controllers\modulo_produccion_minera\pm_patiosController;
use App\Http\Controllers\modulo_produccion_minera\pm_pmCalidadesController;
use App\Http\Controllers\modulo_produccion_minera\pm_productosController;
use App\Http\Controllers\modulo_produccion_minera\pm_TarifaRegaliaController;
use App\Http\Controllers\modulo_produccion_minera\pm_tarifasTrasladosController;
use App\Http\Controllers\modulo_produccion_minera\pm_techoCalidadController;
use App\Http\Controllers\modulo_produccion_minera\pm_techoCodigoController;
use App\Http\Controllers\modulo_produccion_minera\pm_TipoRegaliaController;
use App\Http\Controllers\modulo_produccion_minera\pm_tiposCodigosController;
use App\Http\Controllers\modulo_produccion_minera\pm_tiposMovimientosController;
use App\Http\Controllers\modulo_produccion_minera\pm_tiposPatiosController;
use App\Http\Controllers\modulo_produccion_minera\pm_tipoUsoController;
use App\Http\Controllers\modulo_produccion_minera\pm_zonasController;
use Illuminate\Support\Facades\Route;




Route::get('modulo_pm/tiposCodigos', [pm_tiposCodigosController::class, 'obtener']);
Route::post('modulo_pm/tiposCodigos', [pm_tiposCodigosController::class, 'crear']);
Route::put('modulo_pm/tiposCodigos/{id}', [pm_tiposCodigosController::class, 'actualizar']);
Route::delete('modulo_pm/tiposCodigos/{id}', [pm_tiposCodigosController::class, 'eliminar']);

Route::get('modulo_pm/tiposPatios', [pm_tiposPatiosController::class, 'obtener']);

Route::get('modulo_pm/tiposMovimientos', [pm_tiposMovimientosController::class, 'obtener']);
Route::post('modulo_pm/tiposMovimientos', [pm_tiposMovimientosController::class, 'crear']);
Route::put('modulo_pm/tiposMovimientos/{id}', [pm_tiposMovimientosController::class, 'actualizar']);
Route::delete('modulo_pm/tiposMovimientos/{id}', [pm_tiposMovimientosController::class, 'eliminar']);
Route::put('modulo_pm/tiposMovimientos/estado/{id}/', [pm_tiposMovimientosController::class, 'actualizarEstado']);


Route::get('modulo_pm/tipoUso', [pm_tipoUsoController::class, 'obtener']);

Route::get('modulo_pm/patios', [pm_patiosController::class, 'obtener']);
Route::post('modulo_pm/patios', [pm_patiosController::class, 'crear']);
Route::put('modulo_pm/patios/{id}', [pm_patiosController::class, 'actualizar']);
Route::delete('modulo_pm/patios/{id}', [pm_patiosController::class, 'eliminar']);
Route::put('modulo_pm/patios/estado/{id}/', [pm_patiosController::class, 'actualizarEstado']);


Route::get('modulo_pm/bodegas', [pm_bodegasController::class, 'obtener']);
Route::post('modulo_pm/bodegas', [pm_bodegasController::class, 'crear']);
Route::put('modulo_pm/bodegas/{id}', [pm_bodegasController::class, 'actualizar']);
Route::delete('modulo_pm/bodegas/{id}', [pm_bodegasController::class, 'eliminar']);
Route::put('modulo_pm/bodegas/estado/{id}/', [pm_bodegasController::class, 'actualizarEstado']);


Route::get('modulo_pm/tarifasTraslados', [pm_tarifasTrasladosController::class, 'obtener']);
Route::post('modulo_pm/tarifasTraslados', [pm_tarifasTrasladosController::class, 'crear']);
Route::put('modulo_pm/tarifasTraslados/{id}', [pm_tarifasTrasladosController::class, 'actualizar']);
Route::delete('modulo_pm/tarifasTraslados/{id}', [pm_tarifasTrasladosController::class, 'eliminar']);
Route::put('modulo_pm/tarifasTraslados/estado/{id}/', [pm_tarifasTrasladosController::class, 'actualizarEstado']);


Route::get('modulo_pm/productos', [pm_productosController::class, 'obtener']);
Route::post('modulo_pm/productos', [pm_productosController::class, 'crear']);
Route::put('modulo_pm/productos/{id}', [pm_productosController::class, 'actualizar']);
Route::delete('modulo_pm/productos/{id}', [pm_productosController::class, 'eliminar']);

Route::get('modulo_pm/calidades', [pm_pmCalidadesController::class, 'obtener']);
Route::post('modulo_pm/calidades', [pm_pmCalidadesController::class, 'crear']);
Route::put('modulo_pm/calidades/{id}', [pm_pmCalidadesController::class, 'actualizar']);
Route::delete('modulo_pm/calidades/{id}', [pm_pmCalidadesController::class, 'eliminar']);


Route::get('modulo_pm/tipoRegalia', [pm_TipoRegaliaController::class, 'obtener']);
Route::post('modulo_pm/tipoRegalia', [pm_TipoRegaliaController::class, 'crear']);
Route::put('modulo_pm/tipoRegalia/{id}', [pm_TipoRegaliaController::class, 'actualizar']);
Route::delete('modulo_pm/tipoRegalia/{id}', [pm_TipoRegaliaController::class, 'eliminar']);
Route::put('modulo_pm/tipoRegalia/estado/{id}', [pm_TipoRegaliaController::class, 'actualizarEstado']);

Route::get('modulo_pm/tarifaRegalia', [pm_TarifaRegaliaController::class, 'obtener']);
Route::post('modulo_pm/tarifaRegalia', [pm_TarifaRegaliaController::class, 'crear']);
Route::put('modulo_pm/tarifaRegalia/{id}', [pm_TarifaRegaliaController::class, 'actualizar']);
Route::delete('modulo_pm/tarifaRegalia/{id}', [pm_TarifaRegaliaController::class, 'eliminar']);
Route::put('modulo_pm/tarifaRegalia/estado/{id}', [pm_TarifaRegaliaController::class, 'actualizarEstado']);


Route::get('modulo_pm/granulometria', [pm_granulometriaController::class, 'obtener']);
Route::post('modulo_pm/granulometria', [pm_granulometriaController::class, 'crear']);
Route::put('modulo_pm/granulometria/{id}', [pm_granulometriaController::class, 'actualizar']);
Route::delete('modulo_pm/granulometria/{id}', [pm_granulometriaController::class, 'eliminar']);

Route::get('modulo_pm/techoCalidad', [pm_techoCalidadController::class, 'obtener']);
Route::post('modulo_pm/techoCalidad', [pm_techoCalidadController::class, 'crear']);
Route::put('modulo_pm/techoCalidad/{id}', [pm_techoCalidadController::class, 'actualizar']);
Route::delete('modulo_pm/techoCalidad/{id}', [pm_techoCalidadController::class, 'eliminar']);
Route::put('modulo_pm/techoCalidad/estado/{id}', [pm_techoCalidadController::class, 'actualizarEstado']);

Route::get('modulo_pm/contabilizacion', [pm_contabilizacionController::class, 'obtener']);
Route::post('modulo_pm/contabilizacion', [pm_contabilizacionController::class, 'crear']);
Route::put('modulo_pm/contabilizacion/{id}', [pm_contabilizacionController::class, 'actualizar']);
Route::delete('modulo_pm/contabilizacion/{id}', [pm_contabilizacionController::class, 'eliminar']);

Route::get('modulo_pm/zonas', [pm_zonasController::class, 'obtener']);
Route::post('modulo_pm/zonas', [pm_zonasController::class, 'crear']);
Route::put('modulo_pm/zonas/{id}', [pm_zonasController::class, 'actualizar']);
Route::delete('modulo_pm/zonas/{id}', [pm_zonasController::class, 'eliminar']);

Route::get('modulo_pm/codigos', [pm_codigosController::class, 'obtener']);
Route::post('modulo_pm/codigos', [pm_codigosController::class, 'crear']);
Route::put('modulo_pm/codigos/{id}', [pm_codigosController::class, 'actualizar']);
Route::delete('modulo_pm/codigos/{id}', [pm_codigosController::class, 'eliminar']);

Route::get('modulo_pm/cupos', [pm_cuposController::class, 'obtener']);
Route::post('modulo_pm/cupos', [pm_cuposController::class, 'crear']);
Route::put('modulo_pm/cupos/{id}', [pm_cuposController::class, 'actualizar']);
Route::delete('modulo_pm/cupos/{id}', [pm_cuposController::class, 'eliminar']);
Route::put('modulo_pm/cupos/estado/{id}/', [pm_cuposController::class, 'actualizarEstado']);

Route::get('modulo_pm/techoCodigos', [pm_techoCodigoController::class, 'obtener']);
Route::post('modulo_pm/techoCodigos', [pm_techoCodigoController::class, 'crear']);
Route::put('modulo_pm/techoCodigos/{id}', [pm_techoCodigoController::class, 'actualizar']);
Route::delete('modulo_pm/techoCodigos/{id}', [pm_techoCodigoController::class, 'eliminar']);
Route::put('modulo_pm/techoCodigos/estado/{id}/', [pm_techoCodigoController::class, 'actualizarEstado']);
