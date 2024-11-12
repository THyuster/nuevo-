<?php

use App\Http\Controllers\erp\erp_clientesController;
use App\Http\Controllers\modulo_nomina\nomina_convocatoriasController;
use App\Http\Middleware\LoginSesionActive;
use App\Utils\MyFunctions;
use Illuminate\Support\Facades\Route;
/*ERP*/
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\modulo_superadmin\superadminController;
use App\Http\Controllers\UserController;
/*ADMINISTRADORES*/
use App\Http\Controllers\modulo_administradores\gestion_roles\gestionRolesController;

Route::get('grupos/empresas', [erp_clientesController::class, 'getGruposEmpresarialAndEmpresas']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'api'], function () {

    Route::post('session/active', [AuthController::class, 'SessionActive']);
    Route::put('cerrar', [AuthController::class, 'logout']);

    Route::middleware([LoginSesionActive::class])->group(function () {

        Route::get("asignar/{id}", [AuthController::class, "LoginEmpresa"]);

        Route::get("estados", function () {
            $myfuction = new MyFunctions();
            return $myfuction->obtenerEstados();
        });

        Route::get("prioridades", function () {
            $myfuction = new MyFunctions();
            return $myfuction->obtenerPrioridades();
        });

        //modulo administracion
        Route::group([
            'middleware' => ['admin.empresa.valid'],
            'prefix' => 'administradores/empresa/roles'
        ], function () {
            Route::get("", [gestionRolesController::class, 'get_roles']);
            Route::post("", [gestionRolesController::class, 'crear_rol']);
            Route::post("actualizar", [gestionRolesController::class, 'modificar_roles']);
            Route::delete("", [gestionRolesController::class, 'eliminar_roles']);
            Route::put("", [gestionRolesController::class, 'activacion_roles']);
        });

        Route::group(['prefix' => 'su_administrador/crear/superadmin'], function () {
            Route::post('', [superadminController::class, 'create']);
            Route::get('', [superadminController::class, 'index']);
            Route::get('{nombre}/{email}', [superadminController::class, 'index']);
        });

        //usuarios laravel
        Route::group(['prefix' => 'usuarios'], function () {
            Route::get('show', [UserController::class, 'show']);
            Route::put('estado/{id}', [UserController::class, 'changeStatus']);
            Route::put('administrador/{id}', [UserController::class, 'changeAdministrador']);
            Route::delete('delete/{id}', [UserController::class, 'destroy']);
        });


        // --> ERP
        require __DIR__ . '/rutas-apis/erp/paths-erp.php';

        // --> MODULO CONFIGURACION
        require __DIR__ . '/rutas-apis/configuracion/paths-configuracion.php';

        // --> MODULO CONTABILIDAD
        require __DIR__ . '/rutas-apis/contabilidad/paths-contabilidad.php';

        // --> MODULO MANTENIMIENTO
        require __DIR__ . '/rutas-apis/mantenimiento/paths-mantenimiento.php';

        // --> MODULO INVENTARIO
        require __DIR__ . '/rutas-apis/inventario/paths-inventario.php';

        // --> MODULO LOGISTICA
        require __DIR__ . '/rutas-apis/logistica/paths-logistica.php';

        // --> MODULO NOMINA
        require __DIR__ . '/rutas-apis/nomina/paths-nomina.php';

        // --> MODULO DE GESTION DE CALIDAD
        require __DIR__ . '/rutas-apis/gestion-calidad/paths-gestion-calidad.php';

        // --> MODULO ACTIVOS FIJOS
        require __DIR__ . '/rutas-apis/activos-fijos/paths-activos-fijos.php';

        // --> MODULO SEGURIDAD SST
        require __DIR__ . '/rutas-apis/seguridad-sst/paths-seguridad-sst.php';

        // --> MODULO IMPORTACION
        require __DIR__ . '/rutas-apis/importacion/paths-importacion.php';

        require __DIR__ . '/rutas-apis/Sagrilaft/paths-sagrilaft.php';
        // --> MODULO PRODUCCION MINERA
        require __DIR__ . '/rutas-apis/produccionMinera/paths-produccionMinera.php';

        require __DIR__ . '/rutas-apis/erp/paths-erp.php';

        // --> MODULO GESTION COMPRAS
        require __DIR__ . '/rutas-apis/gestionCompras/paths-compras.php';

        // --> MODULO GESTION TESORERIA
        require __DIR__ . '/rutas-apis/tesoreria/path-tesoreria.php';
    });
});
