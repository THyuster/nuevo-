<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Utils\Constantes\ModuloNomina\CTipoContratos;
use App\Utils\Repository\RepositoryDynamicsCrud;


class ServicesTipoContrato implements IServicesTipoContrato
{
    protected $repositoryDynamicsCrud, $nombreTable = "logistica_tipo_contrato";
    private CTipoContratos $cTipoContratos;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->cTipoContratos = new CTipoContratos;
    }

    public function crearTipoContrato(array $data)
    {
        $this->buscarCodigoConOSinId($data['codigo']);
        return $this->repositoryDynamicsCrud->createInfo($this->nombreTable, $data);

    }
    public function actualizarTipoContrato(int $id, array $data)
    {
        $this->buscarCodigoConOSinId($data['codigo'], $id);
        return $this->repositoryDynamicsCrud->updateInfo($this->nombreTable, $data, $id);

    }
    public function eliminarTipoContrato(int $id)
    {

        $this->buscarContratoPorId($id);
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nombreTable, $id);

    }
    private function buscarCodigoConOSinId($codigo, $id = null)
    {
        $sql = (!$id) ? $this->cTipoContratos->sqlbuscarCodigo($codigo)
            : $this->cTipoContratos->sqlbuscarCodigoPorId($codigo, $id);
        ;
        return $this->buscarRegistro($sql, "Codigo ya registrado", 400);

    }
    private function buscarContratoPorId($id)
    {
        $sql = $this->cTipoContratos->sqlbuscarContratoPorId($id);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (empty($response)) {
            throw new \Exception("Tipo de contrato no encontrado", 404);
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