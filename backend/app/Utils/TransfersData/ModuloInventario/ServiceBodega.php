<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\ConstantesBodega;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ServiceBodega
{
    protected $constantesBodegas, $tablaBodega, $serviceLogImportaciones;
    protected $repository, $myFunctions, $tablaLogImportaciones, $date;
    public function __construct()
    {
        $this->constantesBodegas = new ConstantesBodega;
        $this->repository = new RepositoryDynamicsCrud;
        $this->myFunctions = new MyFunctions;
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->tablaBodega = tablas::getTablaClienteInventarioBodega();
        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
        $this->date = date("Y-m-d H:i:s");
    }

    public function createBodega($dataCreate)
    {
        $sucursalModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSucursalesByid($dataCreate['sucursal_id']));

        $codigoModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSelectByCode($dataCreate['codigo']));


        if (!empty($codigoModel)) {
            return  " Ya existe el codigo " . $dataCreate['codigo'];
        }
        if ($dataCreate['codigo'] == "" || $dataCreate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataCreate['sucursal_id'] == "" || $dataCreate['sucursal_id'] == null) {
            return "el dato de sucursal_id esta vacio";
        }

        if (empty($sucursalModel)) {
            return "Sucursal invalida";
        }

        if ($dataCreate['descripcion'] == "" || $dataCreate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction(
            $this->constantesBodegas->sqlInsert($dataCreate['sucursal_id'], $dataCreate['codigo'], $dataCreate['descripcion'])
        );
        return "Creo";
    }

    public function updateBodega($id, $dataUpdate)
    {
        $bodegaModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSelectById($id));
        $codigoModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSelectByCode($dataUpdate['codigo']));
        $sucursalModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSucursalesByid($dataUpdate['sucursal_id']));

        if (empty($bodegaModel)) {
            return "No existe";
        }

        if (!empty($codigoModel) && $codigoModel[0]->codigo != $dataUpdate['codigo']) {
            return  " Ya existe el codigo " . $dataUpdate['codigo'];
        }

        if ($dataUpdate['codigo'] == "" || $dataUpdate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if (empty($sucursalModel)) {
            return "Sucursal invalida";
        }

        if ($dataUpdate['sucursal_id'] == "" || $dataUpdate['sucursal_id'] == null) {
            return "el dato de sucursal_id esta vacio";
        }

        if ($dataUpdate['descripcion'] == "" || $dataUpdate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesBodegas->sqlUpdate($id, $dataUpdate['sucursal_id'], $dataUpdate['codigo'], $dataUpdate['descripcion']));
        $bodegaModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSelectById($id));
        // return $bodegaModel;
        return ($bodegaModel[0]->codigo == $dataUpdate['codigo'] &&
            $bodegaModel[0]->descripcion == $dataUpdate['descripcion']) ? "Actualizo" : "No actualizo";
    }

    public function delete($id)
    {
        $this->repository->sqlFunction($this->constantesBodegas->sqlDelete($id));
        $bodegaModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSelectById($id));
        return (empty($bodegaModel)) ? "elimino" : "no elimino";
    }

    public function updateStatusBodega($id)
    {
        $bodegaModel = $this->repository->sqlFunction($this->constantesBodegas->sqlSelectById($id));
        $estado = ($bodegaModel[0]->estado == 1) ? 0 : 1;
        $this->repository->sqlFunction($this->constantesBodegas->sqlUpdateEstado($id, $estado));
    }

    public function importacionBodegasTns($dsn)
    {


        try {
            $codigos = $this->obtenerCodigoBodegasBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT BODEGA.CODIGO codigo,  BODEGA.NOMBRE descripcion, 1 estado, CASE WHEN BODEGA.SUCID IS NULL THEN 1 ELSE BODEGA.SUCID END AS sucursal_id FROM BODEGA WHERE BODEGA.CODIGO NOT IN ($codigosString)";

            $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);
            $this->repository->createInfo($this->tablaBodega, $dataMapeada);

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Bodega", "Creo");
        } catch (\Throwable $th) {
            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Bodega", "No creo");
            return "Importacion de BODEGA de inventarios fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoBodegasBD()
    {
        $codigosBodegasDB =  $this->repository->sqlFunction("SELECT codigo FROM $this->tablaBodega");
        return array_column($codigosBodegasDB, "codigo");
    }
    private function mapearCodigo($codigosBodegas)
    {
        foreach ($codigosBodegas as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosBodegas;
    }
}