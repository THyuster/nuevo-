<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Utils\Constantes\ModuloNomina\CUserCentro;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;

class ServicesUserCentros implements IServicesUserCentros
{

    private RepositoryDynamicsCrud $_repository;
    private $nombreTable = "nomina_user_centros", $cUserCentro;

    public function __construct(RepositoryDynamicsCrud $repository,)
    {
        $this->_repository = $repository;
        $this->cUserCentro = new CUserCentro();
    }
    public function crearUserCentro($entidadTiposSolicitudes)
    {
        try {
            $this->validarUsuario($entidadTiposSolicitudes['user_id']);
            $this->validarCentroTrabajo($entidadTiposSolicitudes['centro_id']);
            $this->validarUsuarioCentro($entidadTiposSolicitudes['user_id'], $entidadTiposSolicitudes['centro_id']);
            $entidadTiposSolicitudes['estado'] = 1;
            return $this->_repository->createInfo($this->nombreTable, $entidadTiposSolicitudes);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function actualizarUserCentro(int $id, $entidadTiposSolicitudes)
    {
        try {
            $this->validarUsuario($entidadTiposSolicitudes['user_id']);
            $this->validarCentroTrabajo($entidadTiposSolicitudes['centro_id']);
            $this->validarUsuarioCentro($entidadTiposSolicitudes['user_id'], $entidadTiposSolicitudes['centro_id']);
            return $this->_repository->updateInfo($this->nombreTable, $entidadTiposSolicitudes, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function eliminarUserCentro(int $id)
    {
        $this->validarUsuarioCentroTrabajo($id);
        return $this->_repository->deleteInfoAllOrById($this->nombreTable, $id);
    }
    public function estadoUserCentro(string $id)
    {
        $usuarioCentroTrabajo = $this->validarUsuarioCentroTrabajo($id);
        $estado = array('estado' => $usuarioCentroTrabajo[0]->estado ? 0 : 1);
        return $this->_repository->updateInfo($this->nombreTable, $estado, $id);
    }
    public function getUserCentro()
    {

        $sql = $this->cUserCentro->slqGetUserCentro();
        return $this->_repository->sqlFunction($sql);
    }

    private function validarUsuarioCentroTrabajo($id)
    {
        $sql = $this->cUserCentro->sqlValidarUsuario($id);
        return $this->buscarRegistro($sql, "Usuario de centro de trabajo no encontrado");
    }

    private function validarUsuario($id)
    {
        $sql = "SELECT * FROM users WHERE id = $id";
        return $this->buscarRegistro($sql, "Usuario no encontrado");
    }
    private function validarCentroTrabajo($id)
    {
        $sql = $this->cUserCentro->sqlValidarUsuarioCentroTrabajo($id);
        return $this->buscarRegistro($sql, "Centro de trabajo no encontrado");
    }

    private function validarUsuarioCentro($usuarioId, $centroTrabajoId)
    {
        $sql = "SELECT * FROM nomina_user_centros WHERE user_id = $usuarioId AND centro_id = $centroTrabajoId";
        $response = $this->_repository->sqlFunction($sql);
        if ($response) {
            throw new Exception("El usuario ya esta asignado en el centro de trabajo");
        }
        return $centroTrabajoId;
    }



    private function buscarRegistro($sql, $mensajeError)
    {
        $response = $this->_repository->sqlFunction($sql);
        if (!$response) {
            throw new Exception($mensajeError);
        }
        return $response;
    }
}
