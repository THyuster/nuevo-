<?php

namespace App\Utils\TransfersData\ModuloLogistica;

use App\Utils\Constantes\ModuloLogistica\CBlindajes;
use App\Utils\Repository\RepositoryDynamicsCrud;


class ServicesBlindajes implements IServicesBlindajes
{
    protected $repositoryDynamicsCrud, $nombreTable = "logistica_blindajes";
    private CBlindajes $cBlindajes;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->cBlindajes = new CBlindajes;
    }

    public function crearBlindajes(array $data)
    {
        $this->buscarCodigoConOSinId($data['codigo']);
        return $this->repositoryDynamicsCrud->createInfo($this->nombreTable, $data);

    }
    public function actualizarBlindajes(int $id, array $data)
    {
        $this->buscarCodigoConOSinId($data['codigo'], $id);
        return $this->repositoryDynamicsCrud->updateInfo($this->nombreTable, $data, $id);

    }
    public function eliminarBlindajes(int $id)
    {

        $this->buscarBlindajePorId($id);
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nombreTable, $id);

    }
    private function buscarCodigoConOSinId($codigo, $id = null)
    {
        $sql = (!$id) ? $this->cBlindajes->sqlbuscarCodigo($codigo)
            : $this->cBlindajes->sqlbuscarCodigoPorId($codigo, $id);
        ;
        return $this->buscarRegistro($sql, "Codigo ya registrado", 400);

    }
    private function buscarBlindajePorId($id)
    {
        $sql = $this->cBlindajes->sqlbuscarBlindajePorId($id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (empty($response)) {
            throw new \Exception("Blindaje no encontrado", 404);
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