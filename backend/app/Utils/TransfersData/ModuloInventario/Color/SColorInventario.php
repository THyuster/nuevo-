<?php

namespace App\Utils\TransfersData\ModuloInventario\Color;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\Color\CColor;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SColorInventario extends RepositoryDynamicsCrud implements IColorInventario
{

    protected CColor $_CColor;
    private $myFunctions, $tablaColor,  $serviceLogImportaciones, $date;

    public function __construct(CColor $cColor)
    {
        $this->_CColor = $cColor;
        $this->myFunctions = new MyFunctions;
        $this->tablaColor = tablas::getTablaClienteInventarioColor();
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->date = date("Y-m-d H:i:s");
    }

    public function getColorInventario()
    {
        return $this->sqlFunction($this->_CColor->sqlSelectAll());
    }
    public function addColorInventario($inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_CColor->sqlSelectByCode($inventarios['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$inventarios['codigo']}", 1);
        }

        foreach ($inventarios as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_CColor->sqlInsert($inventarios));
        return $result;
    }
    public function removeColorInventario($id)
    {
        return $this->sqlFunction($this->_CColor->sqlDelete($id));
    }
    public function updateColorInventario($id, $inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_CColor->sqlSelectByCode(strtoupper($inventarios['codigo'])));
        $entidad = $this->sqlFunction($this->_CColor->sqlSelectById($id));

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

        $result = $this->sqlFunction($this->_CColor->sqlUpdate($id, $inventarios));

        return $result;
    }
    public function updateEstadoColorInventario($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_CColor->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_CColor->sqlUpdateEstado($id, $estado));
    }

    public function importacionColorTns($dsn)
    {

        try {
            $codigos = $this->obtenerCodigoColorBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT CODCOLOR codigo , DESCOLOR descripcion FROM COLOR WHERE CODCOLOR NOT IN ($codigosString)";
            // $sqlQuery = "SELECT * FROM COLOR";

            return $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);
            // $this->createInfo($this->tablaColor, $dataMapeada);

            // return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Color", "Creo");
        } catch (\Throwable $th) {

            //  $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Color", "No pudo crear");
            return "Importacion de Color del modulo inventarios fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }

    private function obtenerCodigoColorBD()
    {
        $codigosColorDB =  $this->sqlFunction("SELECT codigo FROM $this->tablaColor");
        return array_column($codigosColorDB, "codigo");
    }
    private function mapearCodigo($codigosColor)
    {
        foreach ($codigosColor as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosColor;
    }
}