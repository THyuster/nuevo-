<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use App\Utils\CatchToken;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloConfiguracion\DisenoModulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TypesAdministrators;
use Exception;
use Illuminate\Support\Facades\Auth;

class ServicioAsignacionRoles
{

    private String $tablaAsignacionRoles, $tablaUsuarios, $tablaRol, $date, $tablaPermisosModulos, $tablaRolesPermisos;
    private RepositoryDynamicsCrud $repository;
    private CatchToken $catchToken;
    private DisenoModulos $disenoModulos;

    public function __construct()
    {
        $this->tablaRol = tablas::getTablaErpRol();
        $this->tablaUsuarios = tablas::getTablaAppUser();
        $this->tablaPermisosModulos = tablas::getTablaErpPermisosModulos();
        $this->tablaAsignacionRoles = tablas::getTablaErpAsignacionRoles();
        $this->tablaRolesPermisos = tablas::getTablaErpRolesPermisos();

        $this->catchToken = new CatchToken;
        $this->disenoModulos = new DisenoModulos;
        $this->repository = new RepositoryDynamicsCrud;

        $this->date = date('Y-m-d H:i:s');
    }

    public function getAsignacionRoles()
    {
        $sql = "SELECT erau.erp_roles_asignado_usuario_id idAsignacion, u.id id_user, u.name usuario, er.id role_id, er.descripcion rol FROM erp_roles_asignado_usuario erau LEFT JOIN erp_roles er ON er.id = erau.role_id LEFT JOIN users u on u.id = erau.user_id";
        return  $this->repository->sqlFunction($sql);
    }

    private function validarAdministrador()
    {

        if (Auth::user()->tipo_administrador != TypesAdministrators::COMPANY_ADMINISTRATOR) {
            throw new Exception("No tienes permisos para realizar esta accion", 1);
        }
    }
    private function verificarRoles($userId, $nuevoRol)
    {
        $rolesString = implode(",", array_column($nuevoRol, 'role_id'));

        $sql = "SELECT er.descripcion FROM $this->tablaAsignacionRoles erau LEFT JOIN $this->tablaRol er ON er.id = erau.role_id WHERE erau.user_id = $userId AND erau.role_id IN  ($rolesString)";
        $response = $this->repository->sqlFunction($sql);

        if (!$response) {
            return true;
        }
        $descripciones =   array_map(function ($role) {
            return ['role' => $role['descripcion']];
        }, json_decode(json_encode($response), true));
        $descripcionesString = implode(",", array_column($descripciones, 'role'));
        throw new Exception("El usuario ya tiene asignado los siguientes roles: $descripcionesString", 1);
    }


    public function create(array $nuevoRol)
    {
        try {
            $this->validarAdministrador();
            $this->buscarUsuarioPorId($nuevoRol['user_id']);
            $roles = $this->buscarRolPorId($nuevoRol['user_id'], $nuevoRol['roles']);
            $nuevosRoles = $this->mapperRoles($nuevoRol['user_id'], $roles);
            $this->verificarRoles($nuevoRol['user_id'], $nuevosRoles);

            return $this->repository->createInfo($this->tablaAsignacionRoles, $nuevosRoles);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function delete(int $idAsignacion)
    {
        try {
            $this->validarAdministrador();
            $this->buscarAsignacionPorId($idAsignacion);
            $sql = "DELETE FROM $this->tablaAsignacionRoles WHERE erp_roles_asignado_usuario_id  = '$idAsignacion'";
            $this->repository->sqlFunction($sql);
            return response()->json(json_encode("Registro borrado exitosamente"), 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function obtenerRoles()
    {
        $empresaId = $this->catchToken->Claims();
        $sql = "SELECT * FROM $this->tablaRol WHERE  empresa_id = $empresaId";
        return $this->repository->sqlFunction($sql);
    }

    private function buscarAsignacionPorId(int $id)
    {
        $sql = "SELECT * FROM $this->tablaAsignacionRoles WHERE erp_roles_asignado_usuario_id  = '$id'";
        $response =  $this->repository->sqlFunction($sql);
        if (!$response) {
            throw new Exception("Asignacion  no encontrada", 1);
        }
        return $response[0];
    }


    private function buscarUsuarioPorId(int $id)
    {
        $sql = "SELECT * FROM $this->tablaUsuarios WHERE id = '$id'";
        $response =  $this->repository->sqlFunction($sql);
        if (!$response) {
            throw new Exception("Usuario no encontrado", 1);
        }
        return $response;
    }

    private function validarRolVista(array $roles)
    {

        $rolesArrayString = implode(",", $roles);
        $sql = " SELECT * FROM erp_roles er LEFT JOIN roles_permiso erp ON erp.roles_id= er.id WHERE erp.roles_id IN ($rolesArrayString)";
        $response = $this->repository->sqlFunction($sql);

        $rolesSinVista = array_diff(array_column($response, "id"), $roles);
        if ($rolesSinVista) {
            $rolesString  = implode(",", array_column($response, "descripcion"));
            // throw new Exception(" data: " . json_encode($rolesSinVista));
            throw new Exception(" Hay roles que no tienen vistas asociadas : $rolesString", 1);
        }
    }
    private function buscarRolPorId($userId, array $idsRoles): array
    {
        $idsRoleString = implode(",", $idsRoles);
        $sql = "SELECT * FROM $this->tablaRol WHERE id IN ($idsRoleString)";
        $response =  $this->repository->sqlFunction($sql);

        $idNoexistentes = array_diff($idsRoles, array_column($response, 'id'));
        if (count($idNoexistentes) > 0) {
            throw new Exception("Roles no existente", 1);
        }
        $this->validarRolVista($idsRoles);

        array_map(function ($rol) use ($userId) {
            $sql = $this->disenoModulos->sqlObtenerModuloDelRol($rol->id);
            $modulosPertenecientesRol = $this->repository->sqlFunction($sql);

            $sql = $this->disenoModulos->sqlValidarModuloNoTengaRol($userId, $rol->id);
            $response = $this->repository->sqlFunction($sql);

            $modulosPertenecientesRol = json_decode(json_encode($modulosPertenecientesRol), true);

            $modulosStrings = implode(",", (array_column($modulosPertenecientesRol, 'modulos')));
            if ($response) {
                $modulosStrings = implode(",", array_unique(array_column($modulosPertenecientesRol, 'modulos')));
                throw new Exception("Usuario ya tiene asignado modulos: ( $modulosStrings ) relacionados con el rol $rol->descripcion ", 1);
            }
        }, $response);
        return $idsRoles;
    }
    private function mapperRoles(int $userId, array $roles): array
    {

        return  array_map(function ($rol) use ($userId) {

            return [
                'user_id' => $userId,
                'role_id' => $rol,
                'created_at' => $this->date
            ];
        }, $roles);
    }
}
