<?php

namespace App\Utils\TransfersData\ModuloInventario\Linea;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\Linea\CLinea;
use App\Utils\DataManagerApi;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SLineaInventario extends RepositoryDynamicsCrud implements ILineaInventario
{

    private CLinea $_linea;
    private  $tablaLinea, $serviceLogImportaciones;
    private MyFunctions $myFunction;
    public function __construct(CLinea $cColor)
    {
        $this->_linea = $cColor;
        $this->myFunction = new MyFunctions;
        $this->tablaLinea = tablas::getTablaClienteInventarioLinea();
        $this->serviceLogImportaciones = new LogImportaciones;
    }
    public function getLineaInventario()
    {
        return $this->sqlFunction($this->_linea->sqlSelectAll());
    }
    public function addLineaInventario($inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_linea->sqlSelectByCode($inventarios['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$inventarios['codigo']}", 1);
        }

        foreach ($inventarios as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_linea->sqlInsert($inventarios));
        return $result;
    }
    public function removeLineaInventario($id)
    {
        return $this->sqlFunction($this->_linea->sqlDelete($id));
    }
    public function updateLineaInventario($id, $inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_linea->sqlSelectByCode(strtoupper($inventarios['codigo'])));
        $entidad = $this->sqlFunction($this->_linea->sqlSelectById($id));

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

        $result = $this->sqlFunction($this->_linea->sqlUpdate($id, $inventarios));

        return $result;
    }
    public function updateEstadoLineaInventario($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_linea->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_linea->sqlUpdateEstado($id, $estado));
    }

    public function importacionLineaTns($dsn)
    {

        try {
            $codigos = $this->obtenerCodigoLineaBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT CODLINEA codigo , DESLINEA descripcion, 1 estado FROM LINEA WHERE CODLINEA NOT IN ($codigosString)";
            $dataMapeada =  $this->myFunction->getDataOdbc($sqlQuery, $dsn);
            $this->createInfo($this->tablaLinea, $dataMapeada);

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Linea", "Creo");
        } catch (\Throwable $th) {

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Linea", "No creo");
            return "Importacion de linea del modulo inventarios fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoLineaBD()
    {
        $codigosLineaDB =  $this->sqlFunction("SELECT codigo FROM $this->tablaLinea");
        return array_column($codigosLineaDB, "codigo");
    }
    private function mapearCodigo($codigosLineas)
    {
        foreach ($codigosLineas as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosLineas;
    }
}