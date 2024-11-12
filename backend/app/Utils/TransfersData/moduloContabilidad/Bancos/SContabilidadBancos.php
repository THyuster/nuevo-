<?php

namespace App\Utils\TransfersData\moduloContabilidad\Bancos;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloContabilidad\Bancos\CBancos;
use App\Utils\DataManagerApi;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;


class SContabilidadBancos extends RepositoryDynamicsCrud implements IContabilidadBancos
{

    private CBancos $_Bancos;
    private  $nombreTableBancos;

    public function __construct(CBancos $ca)
    {
        $this->_Bancos = $ca;
        $this->nombreTableBancos =  tablas::getTablaClienteContabilidadBancos();
    }
    public function getContabilidadBancos()
    {
        return $this->sqlFunction($this->_Bancos->sqlSelectAll());
    }
    public function addContabilidadBancos($contabilidadEntidad)
    {
        $codigoModel = $this->sqlFunction($this->_Bancos->sqlSelectByCode($contabilidadEntidad['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$contabilidadEntidad['codigo']}", 1);
        }

        foreach ($contabilidadEntidad as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_Bancos->sqlInsert($contabilidadEntidad));
        return $result;
    }
    public function removeContabilidadBancos($id)
    {
        return $this->sqlFunction($this->_Bancos->sqlDelete($id));
    }
    public function updateContabilidadBancos($id, $contabilidad)
    {
        $codigoModel = $this->sqlFunction($this->_Bancos->sqlSelectByCode(strtoupper($contabilidad['codigo'])));
        $entidad = $this->sqlFunction($this->_Bancos->sqlSelectById($id));

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

        $result = $this->sqlFunction($this->_Bancos->sqlUpdate($id, $contabilidad));

        return $result;
    }
    public function updateEstadoContabilidadBancos($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_Bancos->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_Bancos->sqlUpdateEstado($id, $estado));
    }

    public function conversionBancosTnsAErp()
    {
        try {
            $dataManager = new DataManagerApi();
            $dns = "erp_tns";

            $sqlQuery = "SELECT codigo, nombre descripcion, 1 estado, '860.034.313-7' nit FROM BANCO";

            $datos = $dataManager->ObtenerDatos($dns, $sqlQuery);
            return $datos;

            return   $this->createInfo($this->nombreTableBancos, json_decode($datos, true));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
