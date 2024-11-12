<?php
namespace App\Utils\TransfersData\moduloContabilidad\Areas;

use App\Utils\Constantes\ModuloContabilidad\Areas\CAreas;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;


class SContabilidadAreas extends RepositoryDynamicsCrud implements IContabilidadAreas
{

    private CAreas $_Areas;

    public function __construct(CAreas $ca){
        $this->_Areas = $ca;
    }
    public function getContabilidadAreas()
    {
        return $this->sqlFunction($this->_Areas->sqlSelectAll());

    }    
    public function addContabilidadAreas($contabilidadEntidad)
    {
        $codigoModel = $this->sqlFunction($this->_Areas->sqlSelectByCode($contabilidadEntidad['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$contabilidadEntidad['codigo']}", 1);
        }

        foreach ($contabilidadEntidad as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_Areas->sqlInsert($contabilidadEntidad));
        return $result;
    }
    public function removeContabilidadAreas($id)
    {
        return $this->sqlFunction($this->_Areas->sqlDelete($id));

    }
    public function updateContabilidadAreas($id, $contabilidad)
    {
        $codigoModel = $this->sqlFunction($this->_Areas->sqlSelectByCode(strtoupper($contabilidad['codigo'])));
        $entidad = $this->sqlFunction($this->_Areas->sqlSelectById($id));

        if ($codigoModel) {
            if ($codigoModel[0]->codigo !== $entidad[0]->codigo) {
                throw new Exception("Este codigo {$contabilidad['codigo']} ya esta asignado", 1);
            }
        }

        foreach ($contabilidad as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_Areas->sqlUpdate($id, $contabilidad));

        return $result;
    }
    public function updateEstadoContabilidadAreas($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_Areas->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_Areas->sqlUpdateEstado($id, $estado));
    }

}