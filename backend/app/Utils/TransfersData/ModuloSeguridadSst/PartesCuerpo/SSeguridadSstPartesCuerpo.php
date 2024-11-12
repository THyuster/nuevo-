<?php
namespace App\Utils\TransfersData\ModuloSeguridadSst\PartesCuerpo;

use App\Utils\Constantes\ModuloSeguridadSst\PartesCuerpo\CPartesCuerpo;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;


class SSeguridadSstPartesCuerpo extends RepositoryDynamicsCrud implements ISeguridadSstPartesCuerpo
{

    private CPartesCuerpo $_partesCuerpo;

    public function __construct(CPartesCuerpo $ca){
        $this->_partesCuerpo = $ca;
    }
    public function getseguridadsstPartesCuerpo()
    {
        return $this->sqlFunction($this->_partesCuerpo->sqlSelectAll());

    }    
    public function addseguridadsstPartesCuerpo($dataInsert)
    {
        $codigoModel = $this->sqlFunction($this->_partesCuerpo->sqlSelectByCode($dataInsert['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$dataInsert['codigo']} ...", 1);
        }

        foreach ($dataInsert as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_partesCuerpo->sqlInsert($dataInsert));
        return $result;
    }
    public function removeseguridadsstPartesCuerpo($id)
    {
        return $this->sqlFunction($this->_partesCuerpo->sqlDelete($id));

    }
    public function updateseguridadsstPartesCuerpo($id, $dataUpdate)
    {
        $codigoModel = $this->sqlFunction($this->_partesCuerpo->sqlSelectByCode(strtoupper($dataUpdate['codigo'])));
        $entidad = $this->sqlFunction($this->_partesCuerpo->sqlSelectById($id));

        if ($codigoModel) {
            if ($codigoModel[0]->codigo !== $entidad[0]->codigo) {
                throw new Exception("Este codigo {$dataUpdate['codigo']} ya esta asignado", 1);
            }
        }

        foreach ($dataUpdate as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_partesCuerpo->sqlUpdate($id, $dataUpdate));

        return $result;
    }
    public function updateEstadoseguridadsstPartesCuerpo($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_partesCuerpo->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_partesCuerpo->sqlUpdateEstado($id, $estado));
    }

}