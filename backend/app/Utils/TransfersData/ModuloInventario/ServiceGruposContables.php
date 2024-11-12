<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\ConstantesGruposContables;
use App\Utils\Constantes\ModuloInventario\ConstantesUnidades;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Illuminate\Support\Facades\Auth;

class ServiceGruposContables
{
    protected $constantesGruposContables, $myFunctions, $nameDataBase, $tablaLogImportaciones;
    protected $repository, $date, $serviceLogImportaciones;
    public function __construct()
    {
        $this->constantesGruposContables = new ConstantesGruposContables;
        $this->repository = new RepositoryDynamicsCrud;
        $this->myFunctions = new MyFunctions;
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->nameDataBase = tablas::getTablaClienteInventarioGrupoContables();
        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
        $this->date = date("Y-m-d H:i:s");
    }

    public function createGruposContables($dataCreate)
    {
        $codigoModel = $this->repository->sqlFunction($this->constantesGruposContables->sqlSelectByCode($dataCreate['codigo']));

        if (!empty($codigoModel)) {
            return  "Ya existe" . $dataCreate['codigo'];
        }

        if ($dataCreate['codigo'] == "" || $dataCreate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataCreate['descripcion'] == "" || $dataCreate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesGruposContables->sqlInsert($dataCreate['codigo'], $dataCreate['descripcion']));
        return "Creo";
    }

    public function updateGruposContables($id, $dataUpdate)
    {
        $unidadModel = $this->repository->sqlFunction($this->constantesGruposContables->sqlSelectById($id));
        $codigoModel = $this->repository->sqlFunction($this->constantesGruposContables->sqlSelectByCode($dataUpdate['codigo']));

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

        $this->repository->sqlFunction($this->constantesGruposContables->sqlUpdate($id, $dataUpdate['codigo'], $dataUpdate['descripcion']));
        $unidadModel = $this->repository->sqlFunction($this->constantesGruposContables->sqlSelectById($id));
        return ($unidadModel[0]->codigo == $dataUpdate['codigo'] &&
            $unidadModel[0]->descripcion == $dataUpdate['descripcion']) ? "Actualizo" : "No actualizo";
    }

    public function deleteGruposContables($id)
    {
        $this->repository->sqlFunction($this->constantesGruposContables->sqlDelete($id));
        $unidadModel = $this->repository->sqlFunction($this->constantesGruposContables->sqlSelectById($id));
        return (empty($unidadModel)) ? "elimino" : "no elimino";
    }
    public function importacionGruposContablesTns($dsn)
    {

        try {
            $codigos = $this->obtenerCodigoGrupoContableBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT CODIGO codigo , DESCRIP descripcion FROM GCMAT WHERE CODIGO NOT IN ($codigosString)";
            $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);
            $this->repository->createInfo($this->nameDataBase, $dataMapeada);

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Grupos Contables", "Creo");
        } catch (\Throwable $th) {
            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Grupos Contables", "No creo");
            return "Importacion  de grupos contables modulo de inventario fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoGrupoContableBD()
    {
        $codigosGrupoContableDB =  $this->repository->sqlFunction("SELECT codigo FROM $this->nameDataBase");
        return array_column($codigosGrupoContableDB, "codigo");
    }
    private function mapearCodigo($codigosGrupoContable)
    {
        foreach ($codigosGrupoContable as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosGrupoContable;
    }
}