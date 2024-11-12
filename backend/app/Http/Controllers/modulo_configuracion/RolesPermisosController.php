<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Models\erp_roles_asignado_usuario;
use App\Models\RolesAsignar;
use App\Utils\AuthUser;
use App\Utils\ResponseHandler;
use App\Utils\TransfersData\Erp\Roles\Interfaces\IRolesPermisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesPermisosController extends Controller
{
    //
    protected IRolesPermisos $rolesPermisos;
    public function __construct(IRolesPermisos $rolesPermisos)
    {
        $this->rolesPermisos = $rolesPermisos;
    }

    public function index(string $id)
    {
        $response = new ResponseHandler("Permisos del rol traidos Con Exito");
        $roles = $this->rolesPermisos->getServicesPermisosRoles($id);
        $response->setData($roles);
        return $response->responses();
    }

    public function createPermisosRol(string $id, Request $request)
    {
        $response = new ResponseHandler("Permisos Asignados Correctamente");
        $this->rolesPermisos->createServicesRoles($id, $request->all());
        return $response->responses();
    }

}
