<?php

namespace App\Utils\TransfersData\ModuloInventario\Departamentos;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\Departamentos\CDepartamentos;
use App\Utils\DataManagerApi;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;

class SDepartamentosInventario extends RepositoryDynamicsCrud implements IDepartamentosInventario
{

    private CDepartamentos $_departamentos;
    private $tablaDepartamentos, $tablaLogImportacion, $serviceLogImportaciones, $myFunctions;

    public function __construct(CDepartamentos $cColor)
    {
        $this->_departamentos = $cColor;
        $this->tablaDepartamentos = tablas::getTablaClienteInventarioDepartamento();
        $this->tablaLogImportacion = tablas::getTablaClienteLogImportaciones();
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->myFunctions = new MyFunctions;
    }
    public function getDepartamentosInventario()
    {
        return $this->sqlFunction($this->_departamentos->sqlSelectAll());
    }
    public function addDepartamentosInventario($inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_departamentos->sqlSelectByCode($inventarios['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$inventarios['codigo']}", 1);
        }

        foreach ($inventarios as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $result = $this->sqlFunction($this->_departamentos->sqlInsert($inventarios));
        return $result;
    }
    public function removeDepartamentosInventario($id)
    {
        return $this->sqlFunction($this->_departamentos->sqlDelete($id));
    }
    public function updateDepartamentosInventario($id, $inventarios)
    {
        $codigoModel = $this->sqlFunction($this->_departamentos->sqlSelectByCode(strtoupper($inventarios['codigo'])));
        $entidad = $this->sqlFunction($this->_departamentos->sqlSelectById($id));

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

        $result = $this->sqlFunction($this->_departamentos->sqlUpdate($id, $inventarios));

        return $result;
    }
    public function updateEstadoDepartamentosInventario($id)
    {
        $entidadVehiculo = $this->sqlFunction($this->_departamentos->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        return $this->sqlFunction($this->_departamentos->sqlUpdateEstado($id, $estado));
    }

    public function importacionDepartamentoInventariosTns($dsn)
    {

        try {

            $codigos = $this->obtenerCodigoDepartamentoBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT DEPTOART.CODIGO codigo , DEPTOART.DESCRIP descripcion, 1 estado  FROM DEPTOART WHERE DEPTOART.CODIGO NOT IN ($codigosString)";

            $dataDecodificada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);

            $this->createInfo($this->tablaDepartamentos, $dataDecodificada);

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Departamento", "Creo");
        } catch (\Throwable $th) {

            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Departamento", "No creo");
            // return "Importacion de departamento2a de inventarios fallada";
            throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoDepartamentoBD()
    {
        $codigosDepartamentoDB =  $this->sqlFunction("SELECT codigo FROM $this->tablaDepartamentos");
        return array_column($codigosDepartamentoDB, "codigo");
    }
    private function mapearCodigo($codigosDepartamentoDB)
    {
        foreach ($codigosDepartamentoDB as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosDepartamentoDB;
    }
}