<?php

namespace App\Utils\TransfersData\ModuloInventario\Talla;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\Talla\CTalla;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;


class STallaInventario extends RepositoryDynamicsCrud implements ITallaInventario
{

    private CTalla $_talla;
    private $myFunctions, $tablaTalla, $serviceLogImportaciones, $date;

    public function __construct(CTalla $talla)
    {
        $this->_talla = $talla;
        $this->myFunctions = new MyFunctions;
        $this->tablaTalla = tablas::getTablaClienteInventarioTalla();
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->date = date("Y-m-d H:i:s");
    }

    public function getTallaInventario()
    {
        return $this->sqlFunction($this->_talla->sqlSelectAll());
    }
    public function addTallaInventario($inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_talla->sqlSelectByCode($inventarios['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$inventarios['codigo']}", 1);
        }

        foreach ($inventarios as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_talla->sqlInsert($inventarios));
        return $result;
    }
    public function removeTallaInventario($id)
    {
        return $this->sqlFunction($this->_talla->sqlDelete($id));
    }
    public function updateTallaInventario($id, $inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_talla->sqlSelectByCode(strtoupper($inventarios['codigo'])));
        $entidad = $this->sqlFunction($this->_talla->sqlSelectById($id));

        if ($codigoModel) {
            if ($codigoModel[0]->codigo !== $entidad[0]->codigo) {
                throw new Exception("Este codigo {$inventarios['codigo']} ya esta asignado", 1);
            }
        }

        foreach ($inventarios as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_talla->sqlUpdate($id, $inventarios));

        return $result;
    }
    public function updateEstadoTallaInventario($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_talla->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_talla->sqlUpdateEstado($id, $estado));
    }

    public function importacionTallaTns($dsn)
    {

        try {
            $codigos = $this->obtenerCodigoTallaBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT talla.CODTALLA codigo, talla.DESTALLA descripcion, 1 estado  FROM talla WHERE talla.CODTALLA NOT IN ($codigosString)";
            $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);
            $this->createInfo($this->tablaTalla, $dataMapeada);
            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Talla", "Creo");
        } catch (\Throwable $th) {

            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Talla",  "No creo");
            return "Importacion de Talla del modulo de inventario fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoTallaBD()
    {
        $codigosInventarioDB =  $this->sqlFunction("SELECT codigo FROM $this->tablaTalla");
        return array_column($codigosInventarioDB, "codigo");
    }
    private function mapearCodigo($codigosTallas)
    {
        foreach ($codigosTallas as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosTallas;
    }
}