<?php

namespace App\Utils\TransfersData\modulo_administradores\gestionRoles;

use App\Data\Dtos\RolesDto;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\modulo_administradores\gestionRoles\IGestionRoles;
use Exception;

class GestionRoles implements IGestionRoles
{
    private RepositoryDynamicsCrud $_repository;
   
    private $tabla = "erp_roles";
   
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->_repository = $repositoryDynamicsCrud;
    }

    public function crearRol($entidadRol)
    {
        $tabla = $this->tabla;

        $codigo = $entidadRol["codigo"];
        $descripcion = $entidadRol["descripcion"];
        $empresa = $entidadRol["empresa"];

        $codigo  = htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
        $empresa = htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8');
        $estado = 1;

        $sql = "SELECT * FROM $tabla WHERE codigo = '$codigo'  OR descripcion = '$descripcion' AND empresa = '$empresa'";

        $entidad = $this->_repository->sqlFunction($sql);

        if (!empty($entidad)) {
            throw new Exception("Ya existe esta entidad", 1);
        }

        $entidad["codigo"] = $codigo;
        $entidad["descripcion"] = $descripcion;
        $entidad["estado"] = $estado;
        $entidad["empresa"] = $empresa;

        $this->_repository->createInfo($tabla, $entidad);

        return true;
    }
    public function actualizarRol($entidadRol, $id)
    {

        $tabla = $this->tabla;

        $codigo = $entidadRol["codigo"];
        $descripcion = $entidadRol["descripcion"];
        $empresa = $entidadRol["empresa"];

        $codigo  = htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
        $empresa = htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8');

        $sql = "SELECT * FROM $tabla WHERE `descripcion` = '$descripcion' AND `empresa` = '$empresa'";

        $callback_rol = $this->_repository->sqlFunction($sql);

        if ($callback_rol[0]->id != $id) {
            throw new Exception("Error Processing Request", 1);
        }

        $entidad["codigo"] = $codigo;
        $entidad["descripcion"] = $descripcion;
        $entidad["empresa"] = $empresa;

        $this->_repository->updateInfo($tabla, $entidad, $id);

        return true;
    }

    public function activacionRol($id, $empresa)
    {
        $estado = $this->_repository->sqlFunction("SELECT `estado` FROM `$this->tabla` WHERE `id` = '$id' AND `empresa` = '$empresa' ");

        if (empty($empresa)) {
            throw new Exception("Error Processing Request", 1);
        }
        $estado = ($estado[0]->estado == 1) ? 0 : 1;

        $this->_repository->sqlFunction("UPDATE `$this->tabla` SET `estado`='$estado' WHERE `empresa` = '$empresa' AND `id` = '$id' ");

        return true;
    }

    public function obtenerRol($empresa)
    {
        $entidad_rol = [];
        $roles = $this->_repository->sqlFunction("SELECT `codigo`, `descripcion`, `id` FROM $this->tabla WHERE `empresa` = '$empresa'");

        foreach ($roles as $rol) {
            $rolDto = new RolesDto($rol->id, $rol->codigo, $rol->descripcion);
            $entidad_rol[] = $rolDto->jsonSerialize();
        }

        return $entidad_rol;
    }

    public function eliminarRol($id, $empresa)
    {
        $this->_repository->sqlFunction("DELETE FROM `$this->tabla` WHERE `id` = '$id' AND `empresa` = '$empresa'");
        return true;
    }
}
