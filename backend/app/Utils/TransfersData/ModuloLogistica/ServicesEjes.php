<?php

namespace App\Utils\TransfersData\ModuloLogistica;

use App\Utils\Constantes\ModuloLogistica\CEjes;
use App\Utils\Repository\RepositoryDynamicsCrud;


class ServicesEjes implements IServicesEjes
{
    protected $repositoryDynamicsCrud, $nombreTable = "logistica_ejes";
    private CEjes $cEjes;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->cEjes = new CEjes;
    }

    public function crearEjes(array $data)
    {
        $this->buscarCodigoConOSinId($data['codigo']);
        return $this->repositoryDynamicsCrud->createInfo($this->nombreTable, $data);

    }
    public function actualizarEjes(int $id, array $data)
    {
        $this->buscarCodigoConOSinId($data['codigo'], $id);
        return $this->repositoryDynamicsCrud->updateInfo($this->nombreTable, $data, $id);

    }
    public function eliminarEjes(int $id)
    {

        $this->buscarContratoPorId($id);
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nombreTable, $id);

    }
    private function buscarCodigoConOSinId($codigo, $id = null)
    {
        $sql = (!$id) ? $this->cEjes->sqlbuscarCodigo($codigo)
            : $this->cEjes->sqlbuscarCodigoPorId($codigo, $id);
        ;
        return $this->buscarRegistro($sql, "Codigo ya registrado", 400);

    }
    private function buscarContratoPorId($id)
    {
        $sql = $this->cEjes->sqlbuscarContratoPorId($id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (empty($response)) {
            throw new \Exception("Eje no encontrado", 404);
        }
        return $response;

    }
    private function buscarRegistro($sql, $mensajeError, $codigoEstatus)
    {
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($response) {
            throw new \Exception($mensajeError, $codigoEstatus);
        }
        return $response;
    }
}