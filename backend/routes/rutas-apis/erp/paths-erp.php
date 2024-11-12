<?php

use App\Http\Controllers\modulo_configuracion\AsignarRolesController;
use App\Http\Controllers\modulo_configuracion\RolesController;
use App\Http\Controllers\modulo_configuracion\RolesPermisosController;
use Illuminate\Support\Facades\Route;

/*ERP*/
use App\Http\Controllers\erp\erp_AdminController;
use App\Http\Controllers\erp\erp_AdminUserController;
use App\Http\Controllers\erp\erp_clientesController;
use App\Http\Controllers\erp\erp_connetionsOdbcController;
use App\Http\Controllers\erp\erp_licenciamientoController;
use App\Http\Controllers\erp\erp_migracionesController;
use App\Http\Controllers\erp\erp_navbarController;
use App\Http\Controllers\erp\erp_permisos_rolesController;
use App\Http\Controllers\erp\erp_respuestasController;
use App\Http\Controllers\erp\erp_tipoCargoController;
use App\Http\Controllers\erp\erp_tipoEntidadController;
use App\Http\Controllers\erp\erp_UsuariosController;
use Illuminate\Support\Facades\DB;

//asignacion de roles
Route::get('/modulo_erp/asignacionRoles/show/{id}', [erp_permisos_rolesController::class, 'show']);
Route::post('/modulo_erp/asignacionRoles', [erp_permisos_rolesController::class, 'create']);
Route::post('/modulo_erp/asignacionRoles/update/{id}', [erp_permisos_rolesController::class, 'update']);
Route::delete('/modulo_erp/asignacionRoles/delete/{id}', [erp_permisos_rolesController::class, 'destroy']);
Route::put('/modulo_erp/asignacionRoles/updateStatus/{id}', [erp_permisos_rolesController::class, 'changeStatus']);


//usuario T1
Route::get('/admin_main/T1/show', [erp_AdminController::class, 'show']);
Route::post('/admin_main/T1', [erp_AdminController::class, 'create']);
Route::post('admin_main/T1/update/{id}', [erp_AdminController::class, 'update']);
Route::delete('/admin_main/T1/delete/{id}', [erp_AdminController::class, 'destroy']);
Route::put('/admin_main/T1/updateStatus/{id}', [erp_AdminController::class, 'updateStatus']);

//usuario T4
Route::get('/admin_user/T4/show/{id}', [erp_AdminUserController::class, 'show']);
Route::post('/admin_user/T4', [erp_AdminUserController::class, 'create']);
Route::post('/admin_user/T4/update/{id}', [erp_AdminUserController::class, 'update']);
Route::post('/admin_user/T4/delete/{id}', [erp_AdminUserController::class, 'destroy']);
Route::put('/admin_user/T4/updateStatus/{id}', [erp_AdminUserController::class, 'updateStatus']);
Route::get('/admin_user/T4/companiesUsers', [erp_AdminUserController::class, 'getCompanies']);
Route::put('/admin_user/T4/statusCompanie', [erp_AdminUserController::class, 'updateStatusByCompanie']);

//usuario T3
Route::get('/user/T3/show', [erp_UsuariosController::class, 'show']);
Route::post('/user/T3', [erp_UsuariosController::class, 'create']);
Route::post('/user/T3/update/{id}', [erp_UsuariosController::class, 'update']);
Route::delete('/user/T3/delete/{id}', [erp_UsuariosController::class, 'destroy']);
Route::put('/user/T3/updateStatus/{id}', [erp_UsuariosController::class, 'updateStatus']);
Route::get('/user/T3/show2', [erp_UsuariosController::class, 'showSinValidate']);

//consumo navbar
Route::get('/navbar/autoConstruccionNavbar', [erp_navbarController::class, 'autoConstruccionNavbar']);
Route::get('/navbar/autoConstruccionNavbar/modulos', [erp_navbarController::class, 'UsuariosModulos']);






//clientes
Route::get('erp/clientes/show', [erp_clientesController::class, 'show']);
Route::post('erp/clientes', [erp_clientesController::class, 'create']);
Route::post('erp/clientes/update/{id}', [erp_clientesController::class, 'update']);
Route::delete('erp/clientes/delete/{id}', [erp_clientesController::class, 'destroy']);
Route::put('erp/clientes/updateStatus/{id}', [erp_clientesController::class, 'updateStatus']);


//gestion de migraciones
Route::get('/modulo_configuracion/erp_migraciones', [erp_migracionesController::class, 'index'])->name("erp_migraciones.index");
Route::post('/modulo_configuracion/erp_migraciones', [erp_migracionesController::class, 'create']);
Route::put('/modulo_configuracion/erp_migraciones/edit/{id}', [erp_migracionesController::class, 'edit']);
Route::delete('/modulo_configuracion/erp_migraciones/{id}/delete', [erp_migracionesController::class, 'destroy']);
Route::put('/modulo_configuracion/erp_migraciones/status/{id}', [erp_migracionesController::class, 'updateStatus']);


//clientes
Route::get('erp/clientes/show', [erp_clientesController::class, 'show']);
Route::post('erp/clientes', [erp_clientesController::class, 'create']);
Route::post('erp/clientes/update/{id}', [erp_clientesController::class, 'update']);
Route::delete('erp/clientes/delete/{id}', [erp_clientesController::class, 'destroy']);
Route::put('erp/clientes/updateStatus/{id}', [erp_clientesController::class, 'updateStatus']);

//licencias
Route::get('/su_admin/licencias/show', [erp_licenciamientoController::class, 'show']);
Route::post('/su_admin/licencias', [erp_licenciamientoController::class, 'create']);
Route::post('/su_admin/licencias/update/{id}', [erp_licenciamientoController::class, 'update']);
Route::delete('/su_admin/licencias/delete/{id}', [erp_licenciamientoController::class, 'destroy']);
Route::put('/su_admin/licencias/updateStatus/{id}', [erp_licenciamientoController::class, 'updateStatus']);


//asignacion de roles
Route::get('/modulo_erp/asignacionRoles/show/{id}', [erp_permisos_rolesController::class, 'show']);
Route::post('/modulo_erp/asignacionRoles', [erp_permisos_rolesController::class, 'create']);
Route::post('/modulo_erp/asignacionRoles/update/{id}', [erp_permisos_rolesController::class, 'update']);
Route::delete('/modulo_erp/asignacionRoles/delete/{id}', [erp_permisos_rolesController::class, 'destroy']);
Route::put('/modulo_erp/asignacionRoles/updateStatus/{id}', [erp_permisos_rolesController::class, 'changeStatus']);



//consumos
Route::get('/erp/tipoEntidades', [erp_tipoEntidadController::class, 'show']);
Route::get('/erp/respuestas', [erp_respuestasController::class, 'show']);
Route::get('/erp/tipoCargo', [erp_tipoCargoController::class, 'show']);

Route::get("/erp/tipos_servicio", function () {
    $tiposServicios = DB::connection('app')->table("tipos_servicio")->get();
    return $tiposServicios->toArray();
});


Route::get('v1/modulo_erp/connectionOdbc', [erp_connetionsOdbcController::class, 'show']);
Route::get('v1/modulo_erp/connectionOdbc/{id}', [erp_connetionsOdbcController::class, 'showById']);
Route::post('v1/modulo_erp/connectionOdbc', [erp_connetionsOdbcController::class, 'create']);
Route::put('v1/modulo_erp/connectionOdbc/{id}', [erp_connetionsOdbcController::class, 'update']);
Route::delete('v1/modulo_erp/connectionOdbc/{id}', [erp_connetionsOdbcController::class, 'destroy']);


Route::post('erp/roles/create', [RolesController::class, 'store']);
Route::delete('erp/roles/{id}', [RolesController::class, 'destroy']);
Route::get('erp/roles/all', [RolesController::class, 'show']);
Route::post('erp/roles/update', [RolesController::class, 'update']);

Route::get('erp/roles/asignar/{id}', [RolesPermisosController::class, 'index']);
Route::post('erp/roles/asignar/crear/{id}', [RolesPermisosController::class, 'createPermisosRol']);

Route::delete('erp/roles/asignar/usuario/eliminar/{id}', [AsignarRolesController::class, 'destroy']);
Route::post('erp/roles/asignar/usuario/crear', [AsignarRolesController::class, 'store']);
Route::get('/erp/roles/asignar/usuario/obtener', [AsignarRolesController::class, 'show']);
