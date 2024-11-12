<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\CatchToken;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\ConstantesGrupoArticulos;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Illuminate\Support\Facades\Auth;

class ServiceGrupoArticulos
{
    protected $constantesGrupoArticulos, $myFunctions, $nameDataBase, $tablaLogImportaciones;
    protected $repository, $date, $serviceLogImportaciones;
    public function __construct()
    {
        $this->constantesGrupoArticulos = new ConstantesGrupoArticulos;
        $this->repository = new RepositoryDynamicsCrud;
        $this->myFunctions = new MyFunctions;
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->nameDataBase = tablas::getTablaClienteInventarioGrupoArticulos();
        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
        $this->date = date("Y-m-d H:i:s");
    }

    public function createGrupoArticulos($dataCreate)
    {
        try {
            $codigoModel = $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlSelectByCode($dataCreate['codigo']));

            if (!empty($codigoModel)) {
                return "Ya existe " . $dataCreate['codigo'];
            }
            if ($dataCreate['codigo'] == "" || $dataCreate['codigo'] == null) {
                return "el dato de codigo esta vacio";
            }

            if ($dataCreate['descripcion'] == "" || $dataCreate['descripcion'] == null) {
                return "el dato de descripcion esta vacio";
            }
            //return CatchToken::Claims();
            return $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlInsert($dataCreate['codigo'], $dataCreate['descripcion']));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateGrupoArticulos($id, $dataUpdate)
    {
        $grupoArticulosModel = $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlSelectById($id));
        $codigoModel = $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlSelectByCode($dataUpdate['codigo']));

        if (!empty($codigoModel) && $codigoModel[0]->codigo != $dataUpdate['codigo']) {
            return  " Ya existe el codigo " . $dataUpdate['codigo'];
        }

        if (empty($grupoArticulosModel)) {
            return "No existe";
        }

        if ($dataUpdate['codigo'] == "" || $dataUpdate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataUpdate['descripcion'] == "" || $dataUpdate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlUpdate($id, $dataUpdate['codigo'], $dataUpdate['descripcion']));
        $grupoArticulosModel = $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlSelectById($id));
        return ($grupoArticulosModel[0]->codigo == $dataUpdate['codigo'] &&
            $grupoArticulosModel[0]->descripcion == $dataUpdate['descripcion']) ? "Actualizo" : "No actualizo";
    }

    public function deleteGrupoArticulos($id)
    {
        $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlDelete($id));
        $bodegaModel = $this->repository->sqlFunction($this->constantesGrupoArticulos->sqlSelectById($id));
        return (empty($bodegaModel)) ? "elimino" : "no elimino";
    }
    public function importacionGruposArticulosTns($dsn)
    {

        try {
            $codigos = $this->obtenerCodigoGruposArticulosBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT CODIGO codigo , DESCRIP descripcion FROM GRUPMAT WHERE CODIGO  NOT IN ($codigosString)";
            $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);
            $this->repository->createInfo($this->nameDataBase, $dataMapeada);

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Grupos Articulos", "Creo");
        } catch (\Throwable $th) {
            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Grupos Articulos", "No creo");
            return "Importacion de departamento de grupos articulos fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoGruposArticulosBD()
    {
        $codigosGruposArticulosDB =  $this->repository->sqlFunction("SELECT codigo FROM $this->nameDataBase");
        return array_column($codigosGruposArticulosDB, "codigo");
    }
    private function mapearCodigo($codigosGrupoArticulos)
    {
        foreach ($codigosGrupoArticulos as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosGrupoArticulos;
    }
}