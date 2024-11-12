<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use App\Utils\CatchToken;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\MyFunctions;
use Illuminate\Support\Facades\DB;
use App\Utils\Constantes\ConstantConsultations;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Encryption\EncryptionFunction;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class ConsultasModulos
{

    protected $sql, $dynamicsCrud, $nameDataBase;
    protected $myFunctions, $sqlConsultas, $currentDate, $sqlCompanies;

    public function __construct()
    {
        $this->dynamicsCrud = new RepositoryDynamicsCrud;
        $this->sql = new ConstantConsultations;
        $this->myFunctions = new MyFunctions;
        $this->sqlConsultas = new ConstantConsultations;
        $this->sqlCompanies = new SqlCompanies;
        $this->currentDate = date('Y-m-d h:i:s');
        $this->nameDataBase = "erp_permisos_modulos";
    }

    public function insertData($jsonData)
    {
        try {

            $idUsuario = $jsonData['idUsuario'];
            $modulo = $jsonData['idModulos'][0];
            $idModulos = $jsonData['idModulos'];

            if ($idUsuario == 0 || $modulo == 0) {
                throw new Exception("Usuario no valido", 404);
            }

            $claims_token = JWTAuth::parseToken()->getPayload();

            $empresaId = $claims_token->get("id_empresa");
            $empresaId = EncryptionFunction::StaticDesencriptacion($empresaId);
            $query = "SELECT * FROM erp_permisos_modulos WHERE user_id = '$idUsuario' AND modulo_id = '$modulo' AND empresa_id = '$empresaId'";

            $modulosAsignados = $this->dynamicsCrud->sqlFunction($query);

            if (!empty($modulosAsignados)) {
                throw new Exception("Modulo ya asigando a este usuario", 1);
            }

            $this->checkEmpresaExistente($empresaId);

            $modulos = $this->checkModulosExistente($empresaId, $idModulos);

            $this->checkUsuarioExistenteRelacion($idUsuario);

            $buscarModulo = array_search(24, $idModulos);

            if ($buscarModulo >= 0 && count($idModulos) > 1) {
                throw new \Exception("Esta mandando el permiso de todos no puede enviar otro", 400);
            }

            $data = $this->relacionArray($modulos, $idUsuario, $empresaId);

            $modulo_id = $data[0]["modulo_id"];
            $sqlNombreModulo = "SELECT descripcion FROM  `erp_modulos` WHERE `id` = '$modulo_id'";

            $modulo = $this->dynamicsCrud->sqlFunction($sqlNombreModulo);

            $data[0]["modulo"] = $modulo[0]->descripcion;

            $sql  = $this->sql->sqlValidarModuloSinRolAsignado($idUsuario, $modulo_id);
            $rolesAsignadoAlModulo = $this->dynamicsCrud->sqlFunction($sql);
            if ($rolesAsignadoAlModulo) {
                throw new \Exception("El usuario ya tiene roles asignados a ese modulo, debe retirarlos para poder asignarle el modulo ", 400);
            }
            return $this->dynamicsCrud->createInfo($this->nameDataBase, $data);
        } catch (\Throwable $error) {
            throw ($error);
        }
    }
    public function updateModule($datos, $idUsuario)
    {
        try {
            $idsModulos = $datos['idModulos'];
            $empresaId = $datos['empresaId'];

            $this->checkUsuarioExistente($idUsuario);
            $this->checkModulosExistente($empresaId, $idsModulos);
            $this->checkEmpresaExistente($empresaId);

            $anadirModulos = $this->anadirOEliminarModulos($idUsuario, $idsModulos);
            $data = $this->relacionArray($anadirModulos, $idUsuario, $empresaId);
            if (!$data) {
                throw new \Exception('No selecciono ninguna empresa', 400);
            }

            return $this->dynamicsCrud->createInfo($this->nameDataBase, $data);
        } catch (\Exception $error) {
            throw ($error);
        }
    }




    private function anadirOEliminarModulos(int $idAdmin, array $idModulos)
    {
        $sql = $this->sql->sqlPermisosPorId($idAdmin);
        $respuestaModulos = $this->dynamicsCrud->sqlFunction($sql);

        $modulosAdd = array_diff($idModulos, array_column($respuestaModulos, 'id'));
        $eliminar = array_diff(array_column($respuestaModulos, 'id'), $idModulos);
        $eliminarIds = implode(",", $eliminar);

        if ($eliminarIds) {
            $sqlDelete = $this->sql->sqlEliminarModulosPorId($idAdmin, $eliminarIds);

            $this->dynamicsCrud->sqlFunction($sqlDelete);
        }
        return $modulosAdd;
    }



    public function deleteData($id)
    {
        $usuario = $this->dynamicsCrud->sqlFunction("SELECT id FROM $this->nameDataBase WHERE id = $id");

        if (!$usuario) {
            throw new \Exception('Dato no encontrado', 404);
        }
        $sql = "DELETE FROM erp_permisos_modulos WHERE `erp_permisos_modulos`.`id` = '$id'";
        return $this->dynamicsCrud->sqlFunction($sql);
    }



    public function checkModulosExistente(int $empresaId, array $idModulos)
    {
        $arrayModulos = implode(",", $idModulos);

        $sql = $this->sqlConsultas->sqlObtenerModulosPorLicenciaYEmprasa($empresaId, $arrayModulos);

        $response = $this->dynamicsCrud->sqlFunction($sql);
        $idExistentes = array_diff($idModulos, array_column($response, "id"));

        if ($idExistentes) {
            $idFalsos = implode(",", $idExistentes);
            throw new \Exception("Modulos pertenecientes: ($idFalsos)");
        }
        return $idModulos;
    }

    public function checkUsuarioExistente($userId)
    {
        $sql = $this->sql->getSqlCheckUserExist($userId);
        return $this->buscarRegistro($sql, "Usuario no encontrado....", 404);
    }
    public function checkUsuarioExistenteRelacion($userId)
    {
        $sql = $this->sql->getSqlRelacionUser($userId);
        $obtenerUsuario = $this->dynamicsCrud->sqlFunction($sql);

        // if ($obtenerUsuario) {
        //     throw new \Exception("Ya existe un usuario registrado", 400);
        // }
    }
    public function checkEmpresaExistente($empresaId)
    {
        $sql = "SELECT * FROM contabilidad_empresas WHERE id = '$empresaId'";
        return $this->buscarRegistro($sql, "Empresa no encontrada", 404);
    }

    public function relacionArray(array $idsRelacionModulo, int $usuarioId, int $empresaId)
    {
        return array_map(function ($idRelacion) use ($usuarioId, $empresaId) {
            return [
                "modulo_id" => $idRelacion,
                "user_id" => $usuarioId,
                "empresa_id" => $empresaId,
                "estado" => 'ACTIVO',
                'created_at' => $this->currentDate,
            ];
        }, $idsRelacionModulo);
    }


    private function buscarRegistro($sql, $messageError, $status)
    {

        $response = $this->dynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new \Exception($messageError, $status);
        }
        return $response;
    }

    public function cambiarEstado($id)
    {
        $sql = "SELECT estado FROM erp_permisos_modulos WHERE erp_permisos_modulos.id = $id";
        $response = $this->buscarRegistro($sql, "Registrpo no encontrado", 404);
        $estado = array('estado' => $response[0]->estado ? 0 : 1);
        return $this->dynamicsCrud->updateInfo($this->nameDataBase, $estado, $id);
    }

    public function checkModulos()
    {
        $query = DB::table('erp_permisos_modulos')
            ->leftjoin('users', 'users.id', '=', 'erp_permisos_modulos.user_id')
            ->select('erp_permisos_modulos.id', 'users.name', 'erp_permisos_modulos.modulo', 'erp_permisos_modulos.estado', 'users.id as users_id');
        $resultado = MyFunctions::validar_administrador();
        if ($resultado == 'SI') {
            return $query->where('users.id', '<>', '0')->get();
        }
        return $query->where('users.id', '=', '0')->get();
    }



    public function verificacionModuloAll($user_id, $modulo_id)
    {
        $sql = "SELECT * FROM erp_permisos_modulos WHERE user_id = '$user_id' AND modulo_id = '$modulo_id'";
        return (!(empty($this->dynamicsCrud->sqlFunction($sql)))) ? true : false;
    }

    public function verificacionModulosUser(int $idUser)
    {
        $sql = "SELECT c.descripcion modulos ,
        c.ruta from users a inner join erp_permisos_modulos b
        on a.id = b.user_id inner join erp_modulos c on b.modulo_id = c.id
        WHERE a.id = '$idUser' and c.descripcion = 'Todos' ";

        $datos = $this->dynamicsCrud->sqlFunction($sql);

        return (!(empty($datos))) ? true : false;
    }

    public function getAllModulos()
    {

        if (MyFunctions::validar_superadmin()) {
            $sql = "SELECT DESCRIPCION AS  modulos, ruta FROM erp_modulos
            WHERE DESCRIPCION <> 'Todos' AND erp_modulos.activo = 1 order by orden , id desc";
        } else {
            $sql = "SELECT DESCRIPCION AS  modulos, ruta FROM erp_modulos
            WHERE DESCRIPCION <> 'Todos'  AND DESCRIPCION <> 'Super Admin' AND erp_modulos.activo = 1 order by orden , id desc ";
        }

        return json_encode($this->dynamicsCrud->sqlFunction($sql));
    }

    public function getModulos(int $id)
    {
        $sql = "SELECT c.descripcion modulos , c.ruta
        from users a inner join erp_permisos_modulos b on a.id = b.user_id
        inner join erp_modulos c on b.modulo_id = c.id
        WHERE a.id =  '$id' AND c.descripcion <> 'Todos' AND c.activo = 1 ORDER BY c.orden , c.id DESC  ";
        return $this->dynamicsCrud->sqlFunction($sql);
    }

    public function CheckUsuarioModulos()
    {
        $sql = "SELECT users.id, users.name, users.estado  FROM `users` WHERE users.estado = 'ACTIVO'";
        return $this->dynamicsCrud->sqlFunction($sql);
    }
}
