<?php

namespace App\Utils\TransfersData\Erp;

use Illuminate\Support\Facades\Auth;
use App\Utils\Constantes\Erp\SqlAdmin;
use App\Utils\Constantes\Erp\SqlRoleAssignment;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\AdminGeneral\AdminServices;
use App\Utils\TransfersData\moduloContabilidad\Companies;
use App\Utils\TypesAdministrators;

class RoleAssignment
{

    private $repositoryDynamicsCrud, $userServices, $nameDataBase;
    private $date, $companiesServices, $sqlRoleAssignment, $sqlAdminUser;


    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->nameDataBase = "erp_permisos_roles";

        $this->sqlAdminUser = new SqlAdmin;
        $this->userServices = new AdminServices;
        $this->companiesServices = new Companies;
        $this->sqlRoleAssignment = new SqlRoleAssignment;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }

    public function createAssignment(array $newAssigment)
    {
        try {

            $this->userServices->findAdmin($newAssigment["userId"]);
            $this->validateAdmin($newAssigment["userId"]);

            $this->companiesServices->findCompanieById($newAssigment["companieId"]);
            $this->findRole($newAssigment["roleId"]);

            $this->findAssigment($newAssigment);
            $this->validateAssignment($newAssigment["companieId"], $newAssigment["roleId"]);

            $newRole = $this->dataMapper($newAssigment);
            return $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $newRole);
        } catch (\Throwable $error) {
            throw $error;
        }
    }
    public function updateAssignment(int $idRecord, array $updateAssigment)
    {
        try {

            $this->userServices->findAdmin($updateAssigment["userId"]);
            $this->validateAdmin($updateAssigment["userId"]);

            $this->companiesServices->findCompanieById($updateAssigment["companieId"]);
            $this->findRole($updateAssigment["roleId"]);

            $this->findAssigment($updateAssigment);
            $this->validateAssignment($updateAssigment["companieId"], $updateAssigment["roleId"]);

            $newRole = $this->dataMapper($updateAssigment);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newRole, $idRecord);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function deleteAssignment(int $idRecord)
    {
        try {
            $this->findAssignmentRole($idRecord);
            return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $idRecord);
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    public function changeStatus(int $idAssignment)
    {
        try {

            $assignment = $this->findAssignmentRole($idAssignment);
            $status = array('estado' => $assignment[0]->estado ? 0 : 1);

            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $status, $idAssignment);
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    private function findRole(int $id)
    {
        $sql = "SELECT id, estado FROM erp_roles WHERE erp_roles.id = $id";
        return $this->findRecord($sql, "Rol no encontrado", 404);
    }
    private function findAssignmentRole(int $id)
    {
        $sql = "SELECT  estado FROM erp_permisos_roles WHERE erp_permisos_roles.id = $id";
        return $this->findRecord($sql, "Asignacion no encontrada no encontrado", 404);
    }

    private function findRecord(string $sql, string $messageError, int $status)
    {
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new \Exception($messageError, $status);
        }
        return $response;
    }

    private function dataMapper(array $data)
    {
        return [
            "empresa_id" => $data["companieId"],
            "user_id" => $data["userId"],
            "rol_id" => $data["roleId"],
            "created_at" => $this->date
        ];
    }

    private function findAssigment(array $data)
    {
        $sql = $this->sqlRoleAssignment->findAssignmentByCompanieUserRole($data);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if ($response) {
            throw new \Exception("Ya existe la asignacion de este rol al usuario en la empresa seleccionada", 400);
        }
        return true;
    }

    private function validateAssignment(int $empresaId, int $rolId)
    {

        $sql = $this->sqlRoleAssignment->findAssignmentByCompanieId($empresaId, $rolId);
        $getPermission = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$getPermission) {
            throw new \Exception("Modulo no existente para la empresa seleccionada");
        }
        return true;
    }

    private function validateAdmin(int $idAdmin)
    {

        $user = $this->userServices->findAdmin($idAdmin);
        if ($user[0]->tipo_administrador != TypesAdministrators::USER) {
            throw new \Exception("EL usuario seleccionado no es T3", 400);
        }
        $userResponse = Auth::user();
        $typeUser = $userResponse->tipo_administrador;
        $response = $this->sqlAdminUser->getSqlRealtionUserClient($typeUser, $idAdmin);
        if (!$response) {
            throw new \Exception("El administrador no es del mismo grupo empresarial", 400);
        }
        return true;
    }
}
