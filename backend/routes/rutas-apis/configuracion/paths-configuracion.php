<?php


/*CONFIGURACION*/

use App\Http\Controllers\erp\erp_connetionsOdbcController;
use App\Http\Controllers\modulo_configuracion\AsignacionRolesController;
use App\Http\Controllers\modulo_configuracion\erp_logImportacionesController;
use App\Http\Controllers\modulo_configuracion\erp_menusController;
use App\Http\Controllers\modulo_configuracion\erp_modulosController;
use App\Http\Controllers\modulo_configuracion\erp_permisos_modulosController;
use App\Http\Controllers\modulo_configuracion\erp_roles_vistasController;
use App\Http\Controllers\modulo_configuracion\erp_submenusController;
use App\Http\Controllers\modulo_configuracion\erp_variablesGlobalesController;
use App\Http\Controllers\modulo_configuracion\erp_vistasController;
use Illuminate\Support\Facades\Route;




//metodos de obtencion de datos de modulos de configuracion
Route::get('/modulo_configuracion/usuarios/permisos', [erp_permisos_modulosController::class, 'ObtenerUsuariosPermisos']);
Route::get('/modulo_configuracion/usuarios/permisos/usuarios', [erp_permisos_modulosController::class, 'ObtenerUsuarioEmpresa']);
Route::get('/modulo_configuracion/usuarios/permisos/modulos', [erp_permisos_modulosController::class, 'ObtenerModulosEmpresa']);

//metodos de accion de datos de modulos de configuracion
Route::post('/modulo_configuracion/usuarios/permisos/crear', [erp_permisos_modulosController::class, 'create']);
Route::post('/modulo_configuracion/usuarios/permisos/actualizar/{id}', [erp_permisos_modulosController::class, 'update']);
Route::put('/modulo_configuracion/usuarios/permisos/estado/{id}', [erp_permisos_modulosController::class, 'changeStatus']);
Route::delete('/modulo_configuracion/usuarios/permisos/eliminar/{id}', [erp_permisos_modulosController::class, 'destroy']);

//modulos usuarios
Route::put('/modulo_configuracion/modulosUsuario/{id}', [erp_permisos_modulosController::class, 'update']);
Route::post('/modulo_configuracion/modulosUsuario', [erp_permisos_modulosController::class, 'create']);
Route::delete('/modulo_configuracion/modulosUsuario/{id}/delete', [erp_permisos_modulosController::class, 'destroy']);

//METODOS DE OBTENCIÓN DE DATOS DE MODULOS CONFIGURACIÓN
Route::get('/modulo_configuracion/usuarios/permisos', [erp_permisos_modulosController::class, 'ObtenerUsuariosPermisos']);
Route::get('/modulo_configuracion/usuarios/permisos/usuarios', [erp_permisos_modulosController::class, 'ObtenerUsuarioEmpresa']);
Route::get('/modulo_configuracion/usuarios/permisos/modulos', [erp_permisos_modulosController::class, 'ObtenerModulosEmpresa']);

//METODOS DE ACCIÓN DE DATOS DE MODULOS CONFIGURACIÓN
Route::post('/modulo_configuracion/usuarios/permisos/crear', [erp_permisos_modulosController::class, 'create']);
Route::post('/modulo_configuracion/usuarios/permisos/actualizar/{id}', [erp_permisos_modulosController::class, 'update']);
Route::put('/modulo_configuracion/usuarios/permisos/estado/{id}', [erp_permisos_modulosController::class, 'changeStatus']);
Route::delete('/modulo_configuracion/usuarios/permisos/eliminar/{id}', [erp_permisos_modulosController::class, 'destroy']);

// GESTION NAVBAR
//modulos
Route::get('/modulo_configuracion/get_modulos', [erp_modulosController::class, 'getModulos']);
Route::post('/modulo_configuracion/diseno_modulos', [erp_modulosController::class, 'create']);
Route::put('/modulo_configuracion/diseno_modulos', [erp_modulosController::class, 'edit']);
Route::delete('/modulo_configuracion/diseno_modulos/{id}/delete', [erp_modulosController::class, 'destroy']);
Route::put('/modulo_configuracion/diseno_modulos/status', [erp_modulosController::class, 'updateStatus']);

//menus
Route::post('/modulo_configuracion/diseno_menus', [erp_menusController::class, 'create']);
Route::delete('/modulo_configuracion/diseno_menus/{id}/delete', [erp_menusController::class, 'destroy']);
Route::put('/modulo_configuracion/diseno_menus/{id}/update', [erp_menusController::class, 'update']);
Route::put('/modulo_configuracion/diseno_menus/{id}/checkStatus', [erp_menusController::class, 'checkStatus']);

//submenus
Route::post("/modulo_configuracion/diseno_submenus/create/{id}", [erp_submenusController::class, 'create']);
Route::delete("/modulo_configuracion/diseno_submenus/destroy/{id}", [erp_submenusController::class, 'destroy']);
Route::put("/modulo_configuracion/diseno_submenus/update/{id}", [erp_submenusController::class, 'update']);
Route::put("/modulo_configuracion/diseno_submenus/status/{id}", [erp_submenusController::class, 'changeStatus']);

//vistas
Route::delete('/modulo_configuracion/diseno_vistas/delete/{id}', [erp_vistasController::class, 'destroy']);
Route::post('/modulo_configuracion/diseno_vistas/create/{id}', [erp_vistasController::class, 'create']);
Route::put('/modulo_configuracion/diseno_vistas/update/{id}', [erp_vistasController::class, 'update']);
Route::put('/modulo_configuracion/diseno_vistas/changeStatus/{id}', [erp_vistasController::class, 'changeStatus']);

//asignacion modulos usuario laravel
Route::put('/modulo_configuracion/modulosUsuario/{id}', [erp_permisos_modulosController::class, 'update']);
Route::post('/modulo_configuracion/modulosUsuario', [erp_permisos_modulosController::class, 'create']);
Route::delete('/modulo_configuracion/modulosUsuario/{id}/delete', [erp_permisos_modulosController::class, 'destroy']);

//validador base de datos
Route::post('/modulo_configuracion/diseno_modulos/validationdb', [erp_modulosController::class, 'validationdb']);



Route::get('v1/modulo_erp/connectionOdbc', [erp_connetionsOdbcController::class, 'show']);
Route::get('v1/modulo_erp/connectionOdbc2', [erp_connetionsOdbcController::class, 'show2']);
Route::get('v1/modulo_erp/connectionOdbc/{id}', [erp_connetionsOdbcController::class, 'showById']);
Route::post('v1/modulo_erp/connectionOdbc', [erp_connetionsOdbcController::class, 'create']);
Route::put('v1/modulo_erp/connectionOdbc/{id}', [erp_connetionsOdbcController::class, 'update']);
Route::delete('v1/modulo_erp/connectionOdbc/{id}', [erp_connetionsOdbcController::class, 'destroy']);

//log importaciones
Route::get('v1/modulo_erp/logImportaciones', [erp_logImportacionesController::class, 'show']);

//log importaciones
Route::get('v1/modulo_erp/variablesGlobales', [erp_variablesGlobalesController::class, 'listar']);
Route::post('v1/modulo_erp/variablesGlobales', [erp_variablesGlobalesController::class, 'crear']);
Route::put('v1/modulo_erp/variablesGlobales/actualizar', [erp_variablesGlobalesController::class, 'actualizar']);
Route::delete('v1/modulo_erp/variablesGlobales/eliminar', [erp_variablesGlobalesController::class, 'eliminar']);

//log importaciones
Route::get('v1/asignacionRol', [AsignacionRolesController::class, 'getAsignacionRoles']);
Route::post('v1/asignacionRol', [AsignacionRolesController::class, 'crear']);
Route::put('v1/asignacionRol/{id}', [AsignacionRolesController::class, 'actualizar']);
Route::delete('v1/asignacionRol/{id}', [AsignacionRolesController::class, 'destroy']);
Route::get('v1/asignacionRol/roles', [AsignacionRolesController::class, 'roles']);
