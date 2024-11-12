<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\ConstantesUnidades;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ServiceUnidades
{
    protected $constantesUnidades, $myFunctions, $tablaUnidad, $serviceLogImportaciones, $date;

    protected $repository;
    public function __construct()
    {
        $this->constantesUnidades = new ConstantesUnidades;
        $this->repository = new RepositoryDynamicsCrud;
        $this->myFunctions = new MyFunctions;
        $this->tablaUnidad = tablas::getTablaClienteInventarioUnidades();
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->date = date("Y-m-d H:i:s");
    }

    public function createUnidad($dataCreate)
    {
        $codigoModel = $this->repository->sqlFunction($this->constantesUnidades->sqlSelectByCode($dataCreate['codigo']));

        if (!empty($codigoModel)) {
            return  "Ya existe" . $dataCreate['codigo'];
        }

        if ($dataCreate['codigo'] == "" || $dataCreate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataCreate['descripcion'] == "" || $dataCreate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesUnidades->sqlInsert($dataCreate['codigo'], $dataCreate['descripcion']));
        return "Creo";
    }

    public function updateUnidad($id, $dataUpdate)
    {
        $unidadModel = $this->repository->sqlFunction($this->constantesUnidades->sqlSelectById($id));
        $codigoModel = $this->repository->sqlFunction($this->constantesUnidades->sqlSelectByCode($dataUpdate['codigo']));

        if (!empty($codigoModel) && $codigoModel[0]->codigo != $dataUpdate['codigo']) {
            return  " Ya existe el codigo " . $dataUpdate['codigo'];
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

        $this->repository->sqlFunction($this->constantesUnidades->sqlUpdate($id, $dataUpdate['codigo'], $dataUpdate['descripcion']));
        $unidadModel = $this->repository->sqlFunction($this->constantesUnidades->sqlSelectById($id));
        return ($unidadModel[0]->codigo == $dataUpdate['codigo'] &&
            $unidadModel[0]->descripcion == $dataUpdate['descripcion']) ? "Actualizo" : "No actualizo";
    }

    public function deleteUnidad($id)
    {
        $this->repository->sqlFunction($this->constantesUnidades->sqlDelete($id));
        $unidadModel = $this->repository->sqlFunction($this->constantesUnidades->sqlSelectById($id));
        return (empty($unidadModel)) ? "elimino" : "no elimino";
    }

    public function importacionUnidadesTns($dsn)
    {

        try {
            $codigos = $this->obtenerCodigoUnidadesBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT CODIGO codigo , DESCRIPCION descripcion FROM CODIGOSUNIDADES WHERE CODIGO NOT IN ($codigosString)";
            $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);

            $this->repository->createInfo($this->tablaUnidad, $dataMapeada);
            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Unidades", "Creo");
        } catch (\Throwable $th) {

            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Unidades", "No creo");
            return "Importacion de unidades del modulo de inventario fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoUnidadesBD()
    {
        $codigosUnidadesDB =  $this->repository->sqlFunction("SELECT codigo FROM $this->tablaUnidad");
        return array_column($codigosUnidadesDB, "codigo");
    }
    private function mapearCodigo($codigosUnidades)
    {
        foreach ($codigosUnidades as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosUnidades;
    }
}