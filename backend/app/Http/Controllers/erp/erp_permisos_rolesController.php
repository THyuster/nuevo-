<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\RoleAssignmentValidation;
use App\Utils\Constantes\Erp\SqlRoleAssignment;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\RoleAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class erp_permisos_rolesController extends Controller
{

    private $roleServices, $sqlRoleAssignment, $repositoryDynamicsCrud;

    public function __construct()
    {
        $this->roleServices = new RoleAssignment;
        $this->sqlRoleAssignment = new SqlRoleAssignment;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }


    public function create(RoleAssignmentValidation $request)
    {
        $this->validatePermission();
        return $this->roleServices->createAssignment($request->all());
    }
    public function show(string $empresaId)
    {
        $this->validatePermission();
        $sql = $this->sqlRoleAssignment->getAssignmentUserByCompanie($empresaId);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }


    public function update(RoleAssignmentValidation $request, string $id)
    {
        $this->validatePermission();
        return $this->roleServices->updateAssignment($id, $request->all());
    }

    public function destroy(string $id)
    {
        $this->validatePermission();
        return $this->roleServices->deleteAssignment($id);
    }
    public function changeStatus(string $id)
    {
        $this->validatePermission();
        return $this->roleServices->changeStatus($id);
    }


    private function getUser()
    {
        return Auth::check() ?
            Auth::user()
            : throw new \Exception("No esta logueado", 403);
    }

    private function validatePermission()
    {
        $user = $this->getUser();
        $adminType = $user->tipo_administrador;

        if ($adminType != 4) {
            throw new \Exception("Acceso denegado no tiene permisos", 403);
        }
        return true;
    }
}