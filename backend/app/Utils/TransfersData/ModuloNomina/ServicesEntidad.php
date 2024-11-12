<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\moduloContabilidad\Third;
use Exception;

class ServicesEntidad implements IServiceEntidadesNomina
{


    private RepositoryDynamicsCrud $_repository;
    private $table = "nomina_entidades";


    public function __construct(RepositoryDynamicsCrud $repository)
    {

        $this->_repository = $repository;

    }
    public function obtenerTodasEntidades()
    {
        $sql = "SELECT ne.*, ete.descripcion tipoDescripcion FROM nomina_entidades ne 
        LEFT JOIN erp_tipos_entidades ete ON ne.tipo_entidad_id = ete.id";
        return $this->_repository->sqlFunction($sql);
    }
    public function buscarCodigoEntidad(string $codigo, int $id = null)
    {
        $sql = (!$id) ?
            "SELECT * FROM $this->table WHERE codigo = '$codigo'" :
            "SELECT * FROM $this->table WHERE codigo = '$codigo' AND id != '$id'";
        $response = $this->_repository->sqlFunction($sql);
        if ($response) {
            throw new Exception("Codigo ya registrado");
        }
        return $response;


    }
    public function crearEntidad(array $entidadEntidad)
    {
        try {
            $this->buscarCodigoEntidad($entidadEntidad['codigo']);
            $this->buscarNit($entidadEntidad['nit']);
            return $this->_repository->createInfo($this->table, $entidadEntidad);
        } catch (\Throwable $th) {
            throw $th;
        }

    }
    public function actualizarEntidad(string $id, array $entidadEntidad)
    {
        try {
            $this->obtenerEntidad($id);
            $this->buscarNit($entidadEntidad['nit'], $id);
            $this->buscarCodigoEntidad($entidadEntidad['codigo'], $id);
            return $this->_repository->updateInfo($this->table, $entidadEntidad, $id);
        } catch (\Throwable $th) {
            throw $th;
        }

    }
    public function eliminarEntidad(string $id)
    {
        try {
            $this->obtenerEntidad($id);
            return $this->_repository->deleteInfoAllOrById($this->table, $id);
        } catch (\Throwable $th) {
            throw $th;
        }

    }
    public function obtenerEntidad(int $id)
    {
        $sql = "SELECT * FROM nomina_entidades WHERE id = $id";
        return $this->buscarRegistro($sql, "Entidad no encontrada");
    }
    public function buscarNit($nit, $id = null)
    {
        $sql = (!$id) ?
            "SELECT * FROM nomina_entidades WHERE nit = $nit" :
            "SELECT * FROM nomina_entidades WHERE nit = $nit AND id !=$id";

        $response = $this->_repository->sqlFunction($sql);
        if ($response) {
            throw new Exception("Nit ya registrado");
        }
        return $response;
    }


    public function buscarTipoEntidad($id)
    {
        $sql = "SELECT * FROM erp_tipos_entidades WHERE id =$id";
        return $this->buscarRegistro($sql, "Tipo entidad no encontrada");
    }


    private function buscarRegistro($sql, $messageError)
    {

        $response = $this->_repository->sqlFunction($sql);
        if (!$response) {
            throw new Exception($messageError);
        }
        return $response;
    }


}
