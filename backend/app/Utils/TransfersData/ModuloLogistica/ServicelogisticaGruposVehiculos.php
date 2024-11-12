<?php
namespace App\Utils\TransfersData\ModuloLogistica;

use App\Utils\Constantes\ModuloLogistica\ConstantesLogisticaGruposVehiculos;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicelogisticaGruposVehiculos
{
    protected $constantesLogisticaGruposVehiculos;
    protected $repository;
    public function __construct()
    {
        $this->constantesLogisticaGruposVehiculos = new ConstantesLogisticaGruposVehiculos;
        $this->repository = new RepositoryDynamicsCrud;
    }

    public function createLogisticaGruposVehiculos($dataCreate)
    {
        $codigoModel = $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlSelectByCode($dataCreate['codigo']));
        // return $codigoModel;
        if (!empty($codigoModel)) {
            return "Ya existe" . $dataCreate['codigo'];
        }

        if ($dataCreate['codigo'] == "" || $dataCreate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataCreate['descripcion'] == "" || $dataCreate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlInsert($dataCreate['codigo'], $dataCreate['descripcion']));
        return "Creo";
    }

    public function updateLogisticaGruposVehiculos($id, $dataUpdate)
    {
        $unidadModel = $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlSelectById($id));
        $codigoModel = $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlSelectByCode($dataUpdate['codigo']));

        if (!empty($codigoModel) && $codigoModel[0]->codigo != $dataUpdate['codigo'] ) {
            return "Ya existe" . $dataUpdate['codigo'];
        }

        if (empty($unidadModel)) {
            return "No existe";
        }

        if ($dataUpdate['codigo'] == "" || $dataUpdate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataUpdate['descripcion'] == "" || $dataUpdate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlUpdate($id, $dataUpdate['codigo'], $dataUpdate['descripcion']));
        $unidadModel = $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlSelectById($id));
        return ($unidadModel[0]->codigo == $dataUpdate['codigo'] &&
            $unidadModel[0]->descripcion == $dataUpdate['descripcion']) ? "Actualizo" : "No actualizo";
    }

    public function deleteLogisticaGruposVehiculos($id)
    {
        $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlDelete($id));
        $unidadModel = $this->repository->sqlFunction($this->constantesLogisticaGruposVehiculos->sqlSelectById($id));
        return (empty($unidadModel)) ? "elimino" : "no elimino";
    }

}