<?php

use Illuminate\Support\Facades\Route;

/*INVENTARIO*/
use App\Http\Controllers\modulo_inventarios\inventarios_articulosController;
use App\Http\Controllers\modulo_inventarios\inventarios_bodegasController;
use App\Http\Controllers\modulo_inventarios\inventarios_colorController;
use App\Http\Controllers\modulo_inventarios\inventarios_departamentosController;
use App\Http\Controllers\modulo_inventarios\inventarios_grupo_articulosController;
use App\Http\Controllers\modulo_inventarios\inventarios_grupos_contablesController;
use App\Http\Controllers\modulo_inventarios\inventarios_homologacionesController;
use App\Http\Controllers\modulo_inventarios\inventarios_lineaController;
use App\Http\Controllers\modulo_inventarios\inventarios_marcasController;
use App\Http\Controllers\modulo_inventarios\inventarios_tallaController;
use App\Http\Controllers\modulo_inventarios\inventarios_tipos_articulosController;
use App\Http\Controllers\modulo_inventarios\inventarios_unidadesController;



//bodegas
Route::post('modulo_inventarios/bodegas', [inventarios_bodegasController::class, 'create']);
Route::get('modulo_inventarios/bodegas/show', [inventarios_bodegasController::class, 'show']);
Route::put('modulo_inventarios/bodegas/update/{id}', [inventarios_bodegasController::class, 'update']);
Route::put('modulo_inventarios/bodegas/estado/{id}', [inventarios_bodegasController::class, 'editEstado']);
Route::delete('modulo_inventarios/bodegas/delete/{id}', [inventarios_bodegasController::class, 'destroy']);

//grupo de articulos
Route::get('modulo_inventarios/grupo_articulos/show', [inventarios_grupo_articulosController::class, 'show']);
Route::post('modulo_inventarios/grupo_articulos', [inventarios_grupo_articulosController::class, 'create']);
Route::put('modulo_inventarios/grupo_articulos/update/{id}', [inventarios_grupo_articulosController::class, 'update']);
Route::delete('modulo_inventarios/grupo_articulos/delete/{id}', [inventarios_grupo_articulosController::class, 'destroy']);

//tipo articulos
Route::get('modulo_inventarios/tipos_articulos/show', [inventarios_tipos_articulosController::class, 'show']);
Route::post('modulo_inventarios/tipos_articulos', [inventarios_tipos_articulosController::class, 'create']);
Route::put('modulo_inventarios/tipos_articulos/update/{id}', [inventarios_tipos_articulosController::class, 'update']);
Route::delete('modulo_inventarios/tipos_articulos/delete/{id}', [inventarios_tipos_articulosController::class, 'destroy']);

//unidades
Route::get('modulo_inventarios/unidades/show', [inventarios_unidadesController::class, 'show']);
Route::post('modulo_inventarios/unidades', [inventarios_unidadesController::class, 'create']);
Route::put('modulo_inventarios/unidades/update/{id}', [inventarios_unidadesController::class, 'update']);
Route::delete('modulo_inventarios/unidades/delete/{id}', [inventarios_unidadesController::class, 'destroy']);

//grupos gontables
Route::get('modulo_inventarios/grupos_contables/show', [inventarios_grupos_contablesController::class, 'show']);
Route::post('modulo_inventarios/grupos_contables', [inventarios_grupos_contablesController::class, 'create']);
Route::put('modulo_inventarios/grupos_contables/update/{id}', [inventarios_grupos_contablesController::class, 'update']);
Route::delete('modulo_inventarios/grupos_contables/delete/{id}', [inventarios_grupos_contablesController::class, 'destroy']);

//marcas
Route::get('modulo_inventarios/marcas/show', [inventarios_marcasController::class, 'show']);
Route::post('modulo_inventarios/marcas', [inventarios_marcasController::class, 'create']);
Route::put('modulo_inventarios/marcas/update/{id}', [inventarios_marcasController::class, 'update']);
Route::delete('modulo_inventarios/marcas/delete/{id}', [inventarios_marcasController::class, 'destroy']);

//articulos
Route::get('modulo_inventarios/articulos/show', [inventarios_articulosController::class, 'show']);
Route::post('modulo_inventarios/articulos', [inventarios_articulosController::class, 'create']);
Route::post('modulo_inventarios/articulos/update/{id}', [inventarios_articulosController::class, 'update']);
Route::put('modulo_inventarios/articulos/estado/{id}', [inventarios_articulosController::class, 'updateStatus']);
Route::delete('modulo_inventarios/articulos/delete/{id}', [inventarios_articulosController::class, 'destroy']);
Route::get('modulo_inventarios/articulosPorHomologacion', [inventarios_articulosController::class, 'articulosConHomologacion']);
Route::get('modulo_inventarios/articulosPrincipalesHomologacion', [inventarios_articulosController::class, 'obtenerArticulosPrincipalesHomologacion']);

//departamentos articulos
Route::get('/v1/inventarios/departamentos', [inventarios_departamentosController::class, 'obtener']);
Route::post('/v1/inventarios/departamentos', [inventarios_departamentosController::class, 'crear']);
Route::post('/v1/inventarios/departamentos/{id}', [inventarios_departamentosController::class, 'actualizar']);
Route::delete('/v1/inventarios/departamentos/{id}', [inventarios_departamentosController::class, 'eliminar']);
Route::put('/v1/inventarios/departamentos/{id}', [inventarios_departamentosController::class, 'estado']);

//linea articulos
Route::get('/v1/inventarios/linea', [inventarios_lineaController::class, 'obtener']);
Route::post('/v1/inventarios/linea', [inventarios_lineaController::class, 'crear']);
Route::post('/v1/inventarios/linea/{id}', [inventarios_lineaController::class, 'actualizar']);
Route::delete('/v1/inventarios/linea/{id}', [inventarios_lineaController::class, 'eliminar']);
Route::put('/v1/inventarios/linea/{id}', [inventarios_lineaController::class, 'estado']);

//talla articulos
Route::get('/v1/inventarios/talla', [inventarios_tallaController::class, 'obtener']);
Route::post('/v1/inventarios/talla', [inventarios_tallaController::class, 'crear']);
Route::post('/v1/inventarios/talla/{id}', [inventarios_tallaController::class, 'actualizar']);
Route::delete('/v1/inventarios/talla/{id}', [inventarios_tallaController::class, 'eliminar']);
Route::put('/v1/inventarios/talla/{id}', [inventarios_tallaController::class, 'estado']);

//color articulos
Route::get('/v1/inventarios/color', [inventarios_colorController::class, 'obtener']);
Route::post('/v1/inventarios/color', [inventarios_colorController::class, 'crear']);
Route::post('/v1/inventarios/color/{id}', [inventarios_colorController::class, 'actualizar']);
Route::delete('/v1/inventarios/color/{id}', [inventarios_colorController::class, 'eliminar']);
Route::put('/v1/inventarios/color/{id}', [inventarios_colorController::class, 'estado']);

//Homologaciones
Route::get('/v1/inventarios/homologacion', [inventarios_homologacionesController::class, 'obtener']);
Route::post('/v1/inventarios/homologacion', [inventarios_homologacionesController::class, 'crear']);
Route::post('/v1/inventarios/homologacion/{id}', [inventarios_homologacionesController::class, 'actualizar']);
Route::delete('/v1/inventarios/homologacion/{id}', [inventarios_homologacionesController::class, 'eliminar']);
Route::put('/v1/inventarios/homologacion/{id}', [inventarios_homologacionesController::class, 'estado']);
