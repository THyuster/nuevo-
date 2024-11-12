<?php
namespace App\Utils\TransfersData\moduloContabilidad\Centros;

use App\Utils\Constantes\ModuloContabilidad\Centros\Ccentros;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;


class SContabilidadCentros extends RepositoryDynamicsCrud implements IContabilidadCentros
{

    private Ccentros $_centros;

    public function __construct(Ccentros $centros){
        $this->_centros = $centros;
    }
    public function getContabilidadCentros()
    {
        return $this->sqlFunction($this->_centros->sqlSelectAll());

    }
    public function addContabilidadCentros($contabilidadEntidad)
    {
        $codigoModel = $this->sqlFunction($this->_centros->sqlSelectByCode($contabilidadEntidad['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$contabilidadEntidad['codigo']}", 1);
        }

        foreach ($contabilidadEntidad as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_centros->sqlInsert($contabilidadEntidad));
        return $result;
    }
    public function removeContabilidadCentros($id)
    {
        return $this->sqlFunction($this->_centros->sqlDelete($id));

    }
    public function updateContabilidadCentros($id, $contabilidad)
    {
        $codigoModel = $this->sqlFunction($this->_centros->sqlSelectByCode(strtoupper($contabilidad['codigo'])));
        $entidad = $this->sqlFunction($this->_centros->sqlSelectById($id));

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

        $result = $this->sqlFunction($this->_centros->sqlUpdate($id, $contabilidad));

        return $result;
    }
    public function updateEstadoContabilidadCentros($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_centros->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_centros->sqlUpdateEstado($id, $estado));
    }

}