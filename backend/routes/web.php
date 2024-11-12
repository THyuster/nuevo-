<?php

use App\Http\Controllers\erp\erp_AdminController;
use App\Http\Controllers\modulo_logistica\logistica_trailersController;
use App\Http\Controllers\modulo_logistica\logistica_vehiculosController;
use App\Http\Middleware\administradorIsValid;
use App\Http\Middleware\SuperAdministradorValid;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\modulo_activos_fijos\activos_fijos_equiposController;
use App\Http\Controllers\modulo_activos_fijos\activos_fijos_grupos_equiposController;
use App\Http\Controllers\modulo_configuracion\erp_menusController;
use App\Http\Controllers\modulo_configuracion\erp_modulosController;
use App\Http\Controllers\modulo_configuracion\erp_submenusController;
use App\Http\Controllers\modulo_configuracion\erp_roles_vistasController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_departamentosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_sucursalesController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_municipiosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tipos_tercerosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tipos_identificacionesController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tercerosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_prefijosController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_tipos_comprobantesController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_empresasController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_afiscalController;
use App\Http\Controllers\modulo_contabilidad\contabilidad_periodosController;
use App\Http\Controllers\erp\erp_migracionesController;
use App\Http\Controllers\modulo_inventarios\inventarios_bodegasController;
use App\Http\Controllers\modulo_inventarios\inventarios_grupos_contablesController;
use App\Http\Controllers\modulo_inventarios\inventarios_grupo_articulosController;
use App\Http\Controllers\modulo_inventarios\inventarios_marcasController;
use App\Http\Controllers\modulo_inventarios\inventarios_tipos_articulosController;
use App\Http\Controllers\modulo_inventarios\inventarios_unidadesController;
use App\Http\Controllers\modulo_logistica\logistica_grupos_vehiculosController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_tipos_solicitudesController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_solicitudesController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_tecnicosController;
use App\Http\Controllers\modulo_mantenimiento\mantenimiento_tipos_ordenesController;
use App\Http\Controllers\erp\erp_clientesController;
use App\Http\Controllers\erp\erp_licenciamientoController;
use App\Http\Controllers\modulo_inventarios\inventarios_articulosController;
use App\Utils\MyFunctions;
use App\Http\Controllers\modulo_configuracion\erp_permisos_modulosController;
use App\Http\Controllers\modulo_configuracion\erp_vistasController;
use App\Http\Controllers\modulo_nomina\nomina_centros_trabajoController;
use App\Http\Controllers\UserController;
use App\Models\modulo_contabilidad\contabilidad_prefijos;
use App\Models\modulo_nomina\nomina_centros_trabajo;
use App\Utils\TransfersData\ModuloConfiguracion\ConsultasMenus;
use App\Http\Controllers\modulo_superadmin\superadminController;
use Illuminate\Support\Facades\Auth;

//*MENU PRINCIPAL*/

//* LOGIN DE LA APLICACION */
Route::middleware('throttle:60,1')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    
        Route::get('/dashboard', function () {
            $resultado = MyFunctions::validar_activo("'1'");
            return ($resultado == 'SI') ? view('inicio_vista1') : view('welcome');
        })->name('dashboard');
    
        Route::get('/inicio_vista1', function () {
            return view('inicio_vista1');
        });
    
        // RUTAS MODULARES //
    
        // * SUPER ADMIN
        /*MODULO SUPERADMIN*/
        // Route::middleware(SuperAdministradorValid::class)->group(function () {
    
            Route::get('/admin_main', [erp_AdminController::class, 'index']);
            Route::get('/admin_main/show', [erp_AdminController::class, 'getData']);
            Route::post('/admin_main', [erp_AdminController::class, 'create']);
            Route::post('admin_main/update/{id}', [erp_AdminController::class, 'update']);
            Route::delete('/admin_main/delete/{id}', [erp_AdminController::class, 'destroy']);
            Route::put('/admin_main/updateStatus/{id}', [erp_AdminController::class, 'updateStatus']);
            Route::put('/admin_main/statusAdmin/{id}', [erp_AdminController::class, 'statusAdmin']);
    
            Route::get('/su_admin/grupo_empresarial', [erp_clientesController::class, 'index']);
            Route::get('/su_admin/grupo_empresarial/show', [erp_clientesController::class, 'show']);
            Route::post('/su_admin/grupo_empresarial', [erp_clientesController::class, 'create']);
            Route::post('/su_admin/grupo_empresarial/update/{id}', [erp_clientesController::class, 'update']);
            Route::delete('/su_admin/grupo_empresarial/delete/{id}', [erp_clientesController::class, 'destroy']);
            Route::put('/su_admin/grupo_empresarial/updateStatus/{id}', [erp_clientesController::class, 'updateStatus']);
    
            Route::get('/su_admin/licencias', [erp_licenciamientoController::class, 'index']);
            Route::get('/su_admin/licencias/show', [erp_licenciamientoController::class, 'show']);
            Route::post('su_admin/licencias', [erp_licenciamientoController::class, 'create']);
            Route::post('/su_admin/licencias/update/{id}', [erp_licenciamientoController::class, 'update']);
            Route::delete('/su_admin/licencias/delete/{id}', [erp_licenciamientoController::class, 'destroy']);
            Route::put('/su_admin/licencias/updateStatus/{id}', [erp_licenciamientoController::class, 'updateStatus']);
            Route::get('/su_admin/licencias/relations', [erp_licenciamientoController::class, 'getRelations']);
    
    
            Route::get('su_administrador/crear/superadmin', [superadminController::class, 'index']);
            Route::post('su_administrador/crear/superadmin', [superadminController::class, 'create']);
            Route::get('su_administrador/crear/superadmin/show', [superadminController::class, 'show']);
            Route::delete('su_administrador/crear/superadmin/{id}', [superadminController::class, 'destroy']);
    
            Route::get('/su_administrador/diseno_modulos', [erp_modulosController::class, 'index'])->name("diseno_modulos.index");
            Route::post('/su_administrador/diseno_modulos', [erp_modulosController::class, 'create']);
            Route::post('/su_administrador/diseno_modulos/editar', [erp_modulosController::class, 'edit']);
            Route::delete('/su_administrador/diseno_modulos/{id}/delete', [erp_modulosController::class, 'destroy']);
            Route::put('/su_administrador/diseno_modulos/{id}', [erp_modulosController::class, 'updateStatus']);
    
            /*DISEÑO MENUS*/
            Route::get('/su_administrador/diseno_menus/{id}/menus', [erp_menusController::class, 'index'])->name("diseno_menus.index");
            Route::post('/su_administrador/diseno_menus', [erp_menusController::class, 'create']);
            Route::delete('/su_administrador/diseno_menus/{id}/delete', [erp_menusController::class, 'destroy']);
            Route::put('/su_administrador/diseno_menus/{id}/update', [erp_menusController::class, 'update']);
            Route::put('/su_administrador/diseno_menus/{id}/checkStatus', [erp_menusController::class, 'checkStatus']);
    
            //DISEÑO SUBMENUS//
            Route::get('/su_administrador/diseno_submenus/{id}/submenus', [erp_submenusController::class, 'index'])->name("diseno_submenus.index");
            Route::post("/su_administrador/diseno_submenus/create/{id}", [erp_submenusController::class, 'create']);
            Route::delete("/su_administrador/diseno_submenus/destroy/{id}", [erp_submenusController::class, 'destroy']);
            Route::put("/su_administrador/diseno_submenus/update/{id}", [erp_submenusController::class, 'update']);
            Route::put("/su_administrador/diseno_submenus/status/{id}", [erp_submenusController::class, 'changeStatus']);
    
            // DISEÑO VISTAS//
            Route::get('/su_administrador/diseno_vistas/vistas/{id}', [erp_vistasController::class, 'index'])->name("diseno_vistas.index");
            Route::delete('/su_administrador/diseno_vistas/delete/{id}', [erp_vistasController::class, 'destroy']);
            Route::post('/su_administrador/diseno_vistas/create/{id}', [erp_vistasController::class, 'create']);
            Route::put('/su_administrador/diseno_vistas/update/{id}', [erp_vistasController::class, 'update']);
            Route::put('/su_administrador/diseno_vistas/changeStatus/{id}', [erp_vistasController::class, 'changeStatus']);
    
            Route::get('/su_administrador', function () {
                return view('superAdmin_vista1');
            });
    
            // DISEÑO CLIENTES//
            Route::get('erp/clientes', [erp_clientesController::class, 'index']);
            Route::get('erp/clientes/show', [erp_clientesController::class, 'show']);
            Route::post('erp/clientes', [erp_clientesController::class, 'create']);
            Route::post('erp/clientes/update/{id}', [erp_clientesController::class, 'update']);
            Route::delete('erp/clientes/delete/{id}', [erp_clientesController::class, 'destroy']);
            Route::put('erp/clientes/updateStatus/{id}', [erp_clientesController::class, 'updateStatus']);
    
        // });
    
    
        /*MODULO CONFIGURACION*/
        // Route::middleware(administradorIsValid::class)->group(function () {
            Route::get('/configuracion_vista1', function () {
                return view('configuracion_vista1');
            });
    
            // RUTAS VISTAS //
            /*MODULO    : CONFIGURACION*/
            /*MENU      : SEGURIDAD/
                /*SUBMENU   : ACTIVACION DE USUARIOS*/
            Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index');
            Route::get('usuarios/show', [UserController::class, 'show']);
            Route::put('usuarios/estado/{id}', [UserController::class, 'changeStatus']);
            Route::put('usuarios/administrador/{id}', [UserController::class, 'changeAdministrador']);
            Route::delete('usuarios/delete/{id}', [UserController::class, 'destroy']);
    
            /*MODULO    : CONFIGURACION*/
            /*MENU      : SEGURIDAD/
                /*SUBMENU   : ASIGNACION DE MODULOS*/
            Route::get('/modulo_configuracion/modulosUsuario', [erp_permisos_modulosController::class, 'index'])->name("usuarios_modulos.index");
            Route::put('/modulo_configuracion/modulosUsuario/{id}', [erp_permisos_modulosController::class, 'update']);
            Route::post('/modulo_configuracion/modulosUsuario', [erp_permisos_modulosController::class, 'create']);
            Route::delete('/modulo_configuracion/modulosUsuario/{id}/delete', [erp_permisos_modulosController::class, 'destroy']);
    
            /*MODULO    : CONFIGURACION*/
            /*MENU      : NAVBAR*/
            /*SUBMENU   : ESTRUCTURA*/
            /*VISTA     : DISEÑO MODULOS*/
    
            /*VISTA     : GESTION MIGRACIONES*/
            Route::post('/modulo_configuracion/diseno_modulos/validationdb', [erp_modulosController::class, 'validationdb']);
            Route::get('/modulo_configuracion/erp_migraciones', [erp_migracionesController::class, 'index'])->name("erp_migraciones.index");
            Route::post('/modulo_configuracion/erp_migraciones', [erp_migracionesController::class, 'create']);
            Route::put('/modulo_configuracion/erp_migraciones/edit/{id}', [erp_migracionesController::class, 'edit']);
            Route::delete('/modulo_configuracion/erp_migraciones/{id}/delete', [erp_migracionesController::class, 'destroy']);
            Route::put('/modulo_configuracion/erp_migraciones/status/{id}', [erp_migracionesController::class, 'updateStatus']);
    
            /*VISTA     : GESTION ROLES*/
            Route::get('/modulo_configuracion/diseno_roles', [erp_roles_vistasController::class, 'index'])->name("diseno_roles.index");
    
        // });
    
    
        /*MODULO SRM MANTENIMIENTOS*/
        Route::get('/mantenimiento_vista1', function () {
            $resultado = MyFunctions::validar_modulo("Mantenimiento");
            return ($resultado == 'SI') ? view('srm_vista1') : view('welcome');
        });
    
        /*MODULO BASCULA*/
        Route::get('/bascula_vista1', function () {
            $resultado = MyFunctions::validar_modulo("'Bascula'");
            return ($resultado == 'SI') ? view('bascula_vista1') : view('Inicio_Vista1');
        });
    
        /* RUTAS MODULO CONFIGURACION  DEL MENU*/
        Route::get('/menus', function () {
            $newMenus = new ConsultasMenus();
            $menus = $newMenus->menuCheck();
            return view('modulo_configuracion/erp_menus/index')->with('menus', $menus);
        })->name('erp_menus.index');
    
        /*MODULO CONTABILIDAD*/
        Route::get('/contabilidad_vista1', function () {
            $resultado = MyFunctions::validar_modulo("'Contabilidad'");
            return ($resultado == 'SI') ? view('contabilidad_vista1') : view('Inicio_Vista1');
        });
    
        /*MODULO INVENTARIO */
        Route::get('inventario_vista1', function () {
            $resultado = MyFunctions::validar_modulo("'Inventario'");
            return ($resultado == 'SI') ? view('inventario_vista1') : view('Inicio_Vista1');
        });
    
        /*MODULO LOGISTICA */
        Route::get('logistica_vista1', function () {
            $resultado = MyFunctions::validar_modulo("'Logistica'");
            return ($resultado == 'SI') ? view('logistica_vista1') : view('Inicio_Vista1');
        });
    
        /*MODULO ACTIVOS FIJOS */
        Route::get('activos_fijos_vista1', function () {
            $resultado = MyFunctions::validar_modulo("'activos_fijos_vista1'");
            return ($resultado == 'SI') ? view('activos_fijos_vista1') : view('Inicio_Vista1');
        });
    
    
        /*MODULO NOMINA*/
        Route::get('/nomina_vista1', function () {
            $resultado = MyFunctions::validar_administrador("admin");
            return ($resultado == 'SI') ? view('nomina_vista1') : view('Inicio_Vista1');
        });
    
    
        /*ACTIVOS FIJOS GRUPOS EQUIPOS */
        Route::get('activos_fijos/grupos_equipos', [activos_fijos_grupos_equiposController::class, 'index']);
        Route::get('activos_fijos/grupos_equipos/show', [activos_fijos_grupos_equiposController::class, 'show']);
        Route::post('activos_fijos/grupos_equipos', [activos_fijos_grupos_equiposController::class, 'create']);
        Route::put('activos_fijos/grupos_equipos/update/{id}', [activos_fijos_grupos_equiposController::class, 'update']);
        Route::delete('activos_fijos/grupos_equipos/delete/{id}', [activos_fijos_grupos_equiposController::class, 'destroy']);
    
        /*ACTIVOS FIJOS EQUIPOS */
        Route::get('activos_fijos/equipos', [activos_fijos_equiposController::class, 'index']);
        Route::get('activos_fijos/equipos/show', [activos_fijos_equiposController::class, 'show']);
        Route::post('activos_fijos/equipos', [activos_fijos_equiposController::class, 'create']);
        Route::post('activos_fijos/equipos/update/{id}', [activos_fijos_equiposController::class, 'update']);
        Route::delete('activos_fijos/equipos/delete/{id}', [activos_fijos_equiposController::class, 'destroy']);
        Route::put('activos_fijos/equipos/{id}/updateStatus', [activos_fijos_equiposController::class, 'updateStatus']);
    
        // ? ADMIN
    
        //* MODULOS CLIENTES VALIDAR CODIGO UNICO*/
        Route::get('erp/clientes', [erp_clientesController::class, 'index']);
        Route::get('erp/clientes/show', [erp_clientesController::class, 'show']);
        Route::post('erp/clientes', [erp_clientesController::class, 'create']);
        Route::post('erp/clientes/update/{id}', [erp_clientesController::class, 'update']);
        Route::delete('erp/clientes/delete/{id}', [erp_clientesController::class, 'destroy']);
        Route::put('erp/clientes/updateStatus/{id}', [erp_clientesController::class, 'updateStatus']);
    
        // ! USERS
    
        //* MODULO INVENTARIOS
    
        //* BODEGAS */
        Route::get('modulo_inventarios/bodegas', [inventarios_bodegasController::class, 'index'])->name('bodegas.index');
        Route::post('modulo_inventarios/bodegas', [inventarios_bodegasController::class, 'create']);
        Route::get('modulo_inventarios/bodegas/show', [inventarios_bodegasController::class, 'show']);
        Route::put('modulo_inventarios/bodegas/update/{id}', [inventarios_bodegasController::class, 'update']);
        Route::put('modulo_inventarios/bodegas/estado/{id}', [inventarios_bodegasController::class, 'editEstado']);
        Route::delete('modulo_inventarios/bodegas/delete/{id}', [inventarios_bodegasController::class, 'destroy']);
    
        //*Grupo Articulos
        Route::get('modulo_inventarios/grupo_articulos', [inventarios_grupo_articulosController::class, 'index'])->name('grupo_articulos.index');
        Route::get('modulo_inventarios/grupo_articulos/show', [inventarios_grupo_articulosController::class, 'show']);
        Route::post('modulo_inventarios/grupo_articulos', [inventarios_grupo_articulosController::class, 'create']);
        Route::put('modulo_inventarios/grupo_articulos/update/{id}', [inventarios_grupo_articulosController::class, 'update']);
        Route::delete('modulo_inventarios/grupo_articulos/delete/{id}', [inventarios_grupo_articulosController::class, 'destroy']);
    
        //*Tipo Articulos
        Route::get('modulo_inventarios/tipos_articulos', [inventarios_tipos_articulosController::class, 'index'])->name('tipos_articulos.index');
        Route::get('modulo_inventarios/tipos_articulos/show', [inventarios_tipos_articulosController::class, 'show']);
        Route::post('modulo_inventarios/tipos_articulos', [inventarios_tipos_articulosController::class, 'create']);
        Route::put('modulo_inventarios/tipos_articulos/update/{id}', [inventarios_tipos_articulosController::class, 'update']);
        Route::delete('modulo_inventarios/tipos_articulos/delete/{id}', [inventarios_tipos_articulosController::class, 'destroy']);
    
        //*Articulos
        // Route::get('modulo_inventarios/articulos', [inventarios_articulosController::class, 'index'])->name('articulos.index');
    
        //*unidades
        Route::get('modulo_inventarios/unidades', [inventarios_unidadesController::class, 'index'])->name('iunidades.index');
        Route::get('modulo_inventarios/unidades/show', [inventarios_unidadesController::class, 'show']);
        Route::post('modulo_inventarios/unidades', [inventarios_unidadesController::class, 'create']);
        Route::put('modulo_inventarios/unidades/update/{id}', [inventarios_unidadesController::class, 'update']);
        Route::delete('modulo_inventarios/unidades/delete/{id}', [inventarios_unidadesController::class, 'destroy']);
    
        //*Grupos Contables
        Route::get('modulo_inventarios/grupos_contables', [inventarios_grupos_contablesController::class, 'index'])->name('grupos_contables.index');
        Route::get('modulo_inventarios/grupos_contables/show', [inventarios_grupos_contablesController::class, 'show']);
        Route::post('modulo_inventarios/grupos_contables', [inventarios_grupos_contablesController::class, 'create']);
        Route::put('modulo_inventarios/grupos_contables/update/{id}', [inventarios_grupos_contablesController::class, 'update']);
        Route::delete('modulo_inventarios/grupos_contables/delete/{id}', [inventarios_grupos_contablesController::class, 'destroy']);
    
        //* Marcas
        Route::get('modulo_inventarios/marcas', [inventarios_marcasController::class, 'index'])->name('marcas.index');
        Route::get('modulo_inventarios/marcas/show', [inventarios_marcasController::class, 'show']);
        Route::post('modulo_inventarios/marcas', [inventarios_marcasController::class, 'create']);
        Route::put('modulo_inventarios/marcas/update/{id}', [inventarios_marcasController::class, 'update']);
        Route::delete('modulo_inventarios/marcas/delete/{id}', [inventarios_marcasController::class, 'destroy']);
    
        //*Articulos
        Route::get('modulo_inventarios/articulos', [inventarios_articulosController::class, 'index']);
        Route::get('modulo_inventarios/articulos/show', [inventarios_articulosController::class, 'show']);
        Route::post('modulo_inventarios/articulos', [inventarios_articulosController::class, 'create']);
        Route::post('modulo_inventarios/articulos/update/{id}', [inventarios_articulosController::class, 'update']);
        Route::put('modulo_inventarios/articulos/estado/{id}', [inventarios_articulosController::class, 'updateStatus']);
        Route::delete('modulo_inventarios/articulos/delete/{id}', [inventarios_articulosController::class, 'destroy']);
    
        //* MODULO LOGISTICA
    
        //*TIPOS DE VEHICULOS */
        Route::get('logistica/tipos_vehiculos', [logistica_grupos_vehiculosController::class, 'index']);
        Route::get('logistica/tipos_vehiculos/show', [logistica_grupos_vehiculosController::class, 'show']);
        Route::post('logistica/tipos_vehiculos', [logistica_grupos_vehiculosController::class, 'create']);
        Route::put('logistica/tipos_vehiculos/update/{id}', [logistica_grupos_vehiculosController::class, 'update']);
        Route::delete('logistica/tipos_vehiculos/delete/{id}', [logistica_grupos_vehiculosController::class, 'destroy']);
    
        //*Trailers*/
        Route::get('logistica/trailers', [logistica_trailersController::class, 'index']);
        Route::post('logistica/trailers', [logistica_trailersController::class, 'create']);
        Route::post('logistica/trailers/{id}', [logistica_trailersController::class, 'update']);
        Route::delete('logistica/trailers/{id}', [logistica_trailersController::class, 'destroy']);
        Route::get('logistica/trailers/show', [logistica_trailersController::class, 'show']);
    
        //*VEHICULOS*/
        Route::get('logistica/vehiculos', [logistica_vehiculosController::class, 'index']);
        Route::get('logistica/vehiculos/show', [logistica_vehiculosController::class, 'show']);
        Route::post('logistica/vehiculos', [logistica_vehiculosController::class, 'create']); //No beban cerveza porque a pesar que la cerveza no engorda, quien engorda es usted.
        Route::post('logistica/vehiculos/{id}', [logistica_vehiculosController::class, 'update']);
        Route::delete('logistica/vehiculos/{id}', [logistica_vehiculosController::class, 'destroy']);
        Route::put('logistica/vehiculos/{id}', [logistica_vehiculosController::class, 'estado']);
        Route::get('logistica/vehiculos/entidades', [logistica_vehiculosController::class, 'entidades']);
    
    
        // * Modulo_Mantenimiento */
        // * TIPOS DE SOLICITUDES*/
        Route::get('/modulo_mantenimiento/tipos_solicitudes', [mantenimiento_tipos_solicitudesController::class, 'index']);
        Route::get('/modulo_mantenimiento/tipos_solicitudes/show', [mantenimiento_tipos_solicitudesController::class, 'show']);
        Route::post('/modulo_mantenimiento/tipos_solicitudes', [mantenimiento_tipos_solicitudesController::class, 'create']);
        Route::delete('/modulo_mantenimiento/tipos_solicitudes/delete/{id}', [mantenimiento_tipos_solicitudesController::class, 'destroy']);
        Route::put('/modulo_mantenimiento/tipos_solicitudes/update/{id}', [mantenimiento_tipos_solicitudesController::class, 'update']);
    
        //*TIPOS DE ORDENES*/
        Route::get('modulo_mantenimiento/tipos_ordenes', [mantenimiento_tipos_ordenesController::class, 'index']);
        Route::get('modulo_mantenimiento/tipos_ordenes/show', [mantenimiento_tipos_ordenesController::class, 'show']);
        Route::post('modulo_mantenimiento/tipos_ordenes', [mantenimiento_tipos_ordenesController::class, 'create']);
        Route::post('modulo_mantenimiento/tipos_ordenes/update/{id}', [mantenimiento_tipos_ordenesController::class, 'update']);
        Route::delete('modulo_mantenimiento/tipos_ordenes/delete/{id}', [mantenimiento_tipos_ordenesController::class, 'destroy']);
        Route::put('modulo_mantenimiento/tipos_ordenes/updateStatus/{id}', [mantenimiento_tipos_ordenesController::class, 'updateStatus']);
    
        //* SOLICITUDES*/
        Route::get('/modulo_mantenimiento/solicitudes', [mantenimiento_solicitudesController::class, 'index']);
        Route::get('/modulo_mantenimiento/solicitudes/show', [mantenimiento_solicitudesController::class, 'show']);
        Route::get('/modulo_mantenimiento/solicitudes/terceros', [mantenimiento_solicitudesController::class, 'terceros']);
        Route::post('/modulo_mantenimiento/solicitudes', [mantenimiento_solicitudesController::class, 'create']);
        Route::post('/modulo_mantenimiento/solicitudes/update/{id}', [mantenimiento_solicitudesController::class, 'update']);
        Route::delete('/modulo_mantenimiento/solicitudes/delete/{id}', [mantenimiento_solicitudesController::class, 'destroy']);
    
        //* TECNICOS */
        Route::get('/modulo_mantenimiento/tecnicos', [mantenimiento_tecnicosController::class, 'index']);
        Route::get('/modulo_mantenimiento/tecnicos/show', [mantenimiento_tecnicosController::class, 'show']);
        Route::get('/modulo_mantenimiento/tecnicos/terceros', [mantenimiento_tecnicosController::class, 'terceros']);
        Route::post('/modulo_mantenimiento/tecnicos', [mantenimiento_tecnicosController::class, 'create']);
        Route::post('/modulo_mantenimiento/tecnicos/update/{id}', [mantenimiento_tecnicosController::class, 'update']);
        Route::delete('/modulo_mantenimiento/tecnicos/delete/{id}', [mantenimiento_tecnicosController::class, 'destroy']);
        Route::put('modulo_mantenimiento/tecnicos/updateStatus/{id}', [mantenimiento_tecnicosController::class, 'estado']);
    
        //* MODULO CONTABILIDAD 
        //*EMPRESAS */
        Route::get('modulo_contabilidad/empresas', [contabilidad_empresasController::class, 'index']);
        Route::get('modulo_contabilidad/empresas/show', [contabilidad_empresasController::class, 'show']);
        Route::post('modulo_contabilidad/empresas', [contabilidad_empresasController::class, 'create']);
        Route::post('modulo_contabilidad/empresas/update/{id}', [contabilidad_empresasController::class, 'update']);
        Route::delete('modulo_contabilidad/empresas/delete/{id}', [contabilidad_empresasController::class, 'destroy']);
        Route::put('modulo_contabilidad/empresas/updateStatus/{id}', [contabilidad_empresasController::class, 'updateStatus']);
        Route::get('modulo_contabilidad/empresas/getAll', [contabilidad_empresasController::class, 'getCompanies']);
    
        //* AÑO FISCAL*/
        Route::get('modulo_contabilidad/afiscal', [contabilidad_afiscalController::class, 'index']);
        Route::get('modulo_contabilidad/afiscal/show', [contabilidad_afiscalController::class, 'show']);
        Route::post('modulo_contabilidad/afiscal', [contabilidad_afiscalController::class, 'create']);
        Route::post('modulo_contabilidad/afiscal/update/{id}', [contabilidad_afiscalController::class, 'update']);
        Route::delete('modulo_contabilidad/afiscal/delete/{id}', [contabilidad_afiscalController::class, 'destroy']);
        Route::put('modulo_contabilidad/afiscal/updateStatus/{id}', [contabilidad_afiscalController::class, 'updateStatus']);
    
        //*PERIODOS*/
        Route::get('modulo_contabilidad/periodos', [contabilidad_periodosController::class, 'index']);
        Route::get('modulo_contabilidad/periodos/show', [contabilidad_periodosController::class, 'show']);
        Route::post('modulo_contabilidad/periodos', [contabilidad_periodosController::class, 'create']);
        Route::post('modulo_contabilidad/periodos/update/{id}', [contabilidad_periodosController::class, 'update']);
        Route::delete('modulo_contabilidad/periodos/delete/{id}', [contabilidad_periodosController::class, 'destroy']);
        Route::put('modulo_contabilidad/periodos/updateStatus/{id}', [contabilidad_periodosController::class, 'updateStatus']);
        Route::post('modulo_contabilidad/periodos/repeatYear', [contabilidad_periodosController::class, 'replicateYear']);
        Route::get('modulo_contabilidad/periodos/filterPeriodsByYear/{id}', [contabilidad_periodosController::class, 'filterPeriodsByYear']);
    
    
        /* DEPARTAMENTOS*/
        Route::get('/modulo_contabilidad/departamentos', [contabilidad_departamentosController::class, 'index'])->name("departamentos.index");
        Route::get('/modulo_contabilidad/departamentos/show', [contabilidad_departamentosController::class, 'show']);
        Route::post('/modulo_contabilidad/departamentos', [contabilidad_departamentosController::class, 'create']);
        Route::delete('/modulo_contabilidad/departamentos/{id}', [contabilidad_departamentosController::class, 'destroy']);
        Route::put('/modulo_contabilidad/departamentos/{id}', [contabilidad_departamentosController::class, 'update']);
    
        /* MUNICIPIOS */
        Route::get('/modulo_contabilidad/municipios', [contabilidad_municipiosController::class, 'index'])->name("municipios.index");
        Route::get('/modulo_contabilidad/municipios/show', [contabilidad_municipiosController::class, 'show']);
        Route::post('/modulo_contabilidad/municipios', [contabilidad_municipiosController::class, 'create']);
        Route::put('/modulo_contabilidad/municipios/{id}', [contabilidad_municipiosController::class, 'update']);
        Route::delete('/modulo_contabilidad/municipios/{id}', [contabilidad_municipiosController::class, 'destroy']);
        Route::get('/modulo_contabilidad/municipios/municipality', [contabilidad_municipiosController::class, 'municipality']);
    
        /*RUTA SUCURSALES */
        Route::get('/modulo_contabilidad/sucursales', [contabilidad_sucursalesController::class, 'index'])->name("sucursales.index");
        Route::get('/modulo_contabilidad/sucursales/show', [contabilidad_sucursalesController::class, 'show']);
        Route::post('/modulo_contabilidad/sucursales', [contabilidad_sucursalesController::class, 'create']);
        Route::put('/modulo_contabilidad/sucursales/{id}', [contabilidad_sucursalesController::class, 'update']);
        Route::delete('/modulo_contabilidad/sucursales/{id}', [contabilidad_sucursalesController::class, 'destroy']);
        Route::put('/modulo_contabilidad/sucursales/{id}/updateStatus', [contabilidad_sucursalesController::class, 'changeStatus']);
        /*RUTA TIPO DE TERCEROS */
        Route::get('/modulo_contabilidad/tipos_terceros', [contabilidad_tipos_tercerosController::class, 'index'])->name("tipos_terceros.index");
        Route::get('/modulo_contabilidad/tipos_terceros/show', [contabilidad_tipos_tercerosController::class, 'show']);
        Route::post('/modulo_contabilidad/tipos_terceros', [contabilidad_tipos_tercerosController::class, 'create']);
        Route::put('/modulo_contabilidad/tipos_terceros/{id}', [contabilidad_tipos_tercerosController::class, 'update']);
        Route::delete('/modulo_contabilidad/tipos_terceros/{id}', [contabilidad_tipos_tercerosController::class, 'destroy']);
        Route::get('/modulo_contabilidad/tipos_terceros/thirdParty', [contabilidad_tipos_tercerosController::class, 'thirdParty']);
    
        /*RUTA TERCEROS */
        Route::get('/modulo_contabilidad/terceros', [contabilidad_tercerosController::class, 'index'])->name("terceros.index");
        Route::get('/modulo_contabilidad/terceros/show', [contabilidad_tercerosController::class, 'show']);
        Route::post('/modulo_contabilidad/terceros', [contabilidad_tercerosController::class, 'create']);
        Route::post('/modulo_contabilidad/terceros/{id}', [contabilidad_tercerosController::class, 'update']);
        Route::delete('/modulo_contabilidad/terceros/{id}', [contabilidad_tercerosController::class, 'destroy']);
        Route::put('/modulo_contabilidad/terceros/{id}/updateStatus', [contabilidad_tercerosController::class, 'updateStatus']);
    
        /*RUTA IDENTIFICACIONES */
        Route::get('/modulo_contabilidad/tipos_identificaciones', [contabilidad_tipos_identificacionesController::class, 'index'])->name("tipos_identificaciones.index");
        Route::get('/modulo_contabilidad/tipos_identificaciones/show', [contabilidad_tipos_identificacionesController::class, 'show']);
        Route::post('/modulo_contabilidad/tipos_identificaciones', [contabilidad_tipos_identificacionesController::class, 'create']);
        Route::put('/modulo_contabilidad/tipos_identificaciones/{id}', [contabilidad_tipos_identificacionesController::class, 'update']);
        Route::delete('/modulo_contabilidad/tipos_identificaciones/{id}', [contabilidad_tipos_identificacionesController::class, 'destroy']);
    
        /*RUTA PREFIJOS */
        Route::get('contabilidad/prefijos', [contabilidad_prefijosController::class, 'index']);
        Route::get('contabilidad/prefijos/show', [contabilidad_prefijosController::class, 'show']);
        Route::post('contabilidad/prefijos', [contabilidad_prefijosController::class, 'create']);
        Route::post('contabilidad/prefijos/update/{id}', [contabilidad_prefijosController::class, 'update']);
        Route::delete('contabilidad/prefijos/delete/{id}', [contabilidad_prefijosController::class, 'destroy']);
        Route::put('contabilidad/prefijos/{id}/updateStatus', [contabilidad_prefijosController::class, 'updateStatus']);
    
    
        Route::get('contabilidad/tipos_comprobantes', [contabilidad_tipos_comprobantesController::class, 'index']);
        Route::get('contabilidad/tipos_comprobantes/show', [contabilidad_tipos_comprobantesController::class, 'show']);
        Route::post('contabilidad/tipos_comprobantes', [contabilidad_tipos_comprobantesController::class, 'create']);
        Route::post('contabilidad/tipos_comprobantes/update/{id}', [contabilidad_tipos_comprobantesController::class, 'update']);
        Route::delete('contabilidad/tipos_comprobantes/{id}/delete', [contabilidad_tipos_comprobantesController::class, 'destroy']);
        Route::put('contabilidad/tipos_comprobantes/{id}/updateStatus', [contabilidad_tipos_comprobantesController::class, 'updateStatus']);
        Route::put('contabilidad/tipos_comprobantes/{id}/updateSign', [contabilidad_tipos_comprobantesController::class, 'updateSign']);
    
        /* EMPRESAS */
        Route::get('modulo_contabilidad/empresas', [contabilidad_empresasController::class, 'index']);

        //* MODULOS NOMINA */
        //Centro trabajo
        Route::get('/modulo_nomina/centros_trabajo', [nomina_centros_trabajoController::class, 'index']);
        Route::get('/modulo_nomina/centros_trabajo/show', [nomina_centros_trabajoController::class, 'show']);
        Route::post('/modulo_nomina/centros_trabajo', [nomina_centros_trabajoController::class, 'create']);
        Route::delete('/modulo_nomina/centros_trabajo/{id}', [nomina_centros_trabajoController::class, 'destroy']);
        Route::post('/modulo_nomina/centros_trabajo/{id}', [nomina_centros_trabajoController::class, 'update']);
        Route::put('/modulo_nomina/centros_trabajo/{id}', [nomina_centros_trabajoController::class, 'status']);
    });
});
