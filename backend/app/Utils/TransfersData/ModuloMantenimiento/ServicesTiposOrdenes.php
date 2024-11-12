<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Utils\Constantes\ModuloMantenimiento\CTiposOrdenes;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ServicesTiposOrdenes implements IServicesTiposOrdenes
{
    private CTiposOrdenes $_cTiposOrdenes;
    private RepositoryDynamicsCrud $_repositoryDynamicsCrud;
    private string $_nameDataBase = "mantenimiento_tipos_ordenes";

    public function __construct()
    {
        $this->_repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->_cTiposOrdenes = new CTiposOrdenes;
    }
    public function crearTipoOrden($entidadTiposOrdenes)
    {
        $entidadTiposOrdenes['estado'] = 1;
        return $this->_repositoryDynamicsCrud->createInfo($this->_nameDataBase, $entidadTiposOrdenes);
    }
    public function actualizarTipoOrden(int $id, $entidadTiposOrdenes): string
    {
        $this->buscarTipoOrden($id);
        $entidadActualizadad = $this->_repositoryDynamicsCrud->updateInfo($this->_nameDataBase, $entidadTiposOrdenes, $id);
        return "actualizo";
        // return $entidadActualizadad->getStatusCode() == 200 ? 'Actualizo' : 'No se pudo actualizar';

    }
    public function eliminarTipoOrden(int $id): string
    {
        $sql = "SELECT * FROM mantenimiento_tipos_ordenes WHERE id = '$id' ";

        $tipoOrden = $this->_repositoryDynamicsCrud->sqlFunction($sql);
        $ordenId = $tipoOrden[0]->codigo;

        $sql = "SELECT * FROM mantenimiento_ordenes_tecnicos WHERE tipo_orden_id = '$ordenId' ";
        $ordenAsignada = $this->_repositoryDynamicsCrud->sqlFunction($sql);
        
        if (!empty($ordenAsignada)) {
            throw new Exception("Este tipo de orden ya fue asignada", Response::HTTP_CONFLICT);
        }

        $registroBorrado = $this->_repositoryDynamicsCrud->deleteInfoAllOrById($this->_nameDataBase, $id);
        return $registroBorrado->getStatusCode() == 200 ? 'Registro eliminar' : 'No se pudo eliminar el registro';
    }
    public function getTipoOrden()
    {
        return $this->_repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->_nameDataBase");
    }

    public function actualizarEstado($id)
    {
        try {
            $tipoOrdenBuscada = $this->buscarTipoOrden($id);
            $newStatus = array('estado' => !$tipoOrdenBuscada[0]->estado);
            return $this->_repositoryDynamicsCrud->updateInfo($this->_nameDataBase, $newStatus, $id);
        } catch (\Throwable $e) {
            return $e;
        }
    }

    public function buscarTipoOrden($id)
    {
        $sql = $this->_cTiposOrdenes->sqlSelectById($id);
        $ordenBuscada = $this->_repositoryDynamicsCrud->sqlFunction($sql);
        if (!$ordenBuscada) {
            throw new \Exception('No se encontro el tipo de orden ' . strval($id), 404);
        }
        return $ordenBuscada;
    }


}