<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\CatchToken;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\ConstantesTipoArticulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Illuminate\Support\Facades\Auth;

class ServiceTipoArticulos
{
    protected $constantesTipoArticulos, $tablaLogImportaciones;
    protected $repository, $tableName, $date, $serviceLogImportaciones;
    public function __construct()
    {
        $this->constantesTipoArticulos = new ConstantesTipoArticulos;
        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->tableName = tablas::getTablaClienteInventarioTiposArticulos();
        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
        $this->date = date("Y-m-d H:i:s");
    }

    public function createTipoArticulos($dataCreate)
    {
        $codigoModel = $this->repository->sqlFunction($this->constantesTipoArticulos->sqlSelectByCode($dataCreate['codigo']));
        //return CatchToken::Claims();
        // return $codigoModel;
        if (!empty($codigoModel)) {
            return "Ya existe " . $dataCreate['codigo'];
        }

        if ($dataCreate['codigo'] == "" || $dataCreate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataCreate['descripcion'] == "" || $dataCreate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesTipoArticulos->sqlInsert($dataCreate['codigo'], $dataCreate['descripcion']));
        return "Creo";
    }

    public function updateTipoArticulos($id, $dataUpdate)
    {
        $TipoArticulosModel = $this->repository->sqlFunction($this->constantesTipoArticulos->sqlSelectById($id));

        $codigoModel = $this->repository->sqlFunction($this->constantesTipoArticulos->sqlSelectByCode($dataUpdate['codigo']));

        if (!empty($codigoModel) && $codigoModel[0]->codigo != $dataUpdate['codigo']) {
            return  " Ya existe el codigo " . $dataUpdate['codigo'];
        }


        if (empty($TipoArticulosModel)) {
            return "No existe";
        }

        if ($dataUpdate['codigo'] == "" || $dataUpdate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataUpdate['descripcion'] == "" || $dataUpdate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }
        // $sql = $this->constantesTipoArticulos->sqlUpdate($id, $dataUpdate['codigo'], $dataUpdate['descripcion']);
        // throw new Exception($sql, 1);

        $this->repository->sqlFunction($this->constantesTipoArticulos->sqlUpdate($id, $dataUpdate['codigo'], $dataUpdate['descripcion']));

        $TipoArticulosModel = $this->repository->sqlFunction($this->constantesTipoArticulos->sqlSelectById($id));
        return ($TipoArticulosModel[0]->codigo == $dataUpdate['codigo'] &&
            $TipoArticulosModel[0]->descripcion == $dataUpdate['descripcion']) ? "Actualizo" : "No actualizo";
    }

    public function deleteGrupoArticulos($id)
    {
        $this->repository->sqlFunction($this->constantesTipoArticulos->sqlDelete($id));
        $bodegaModel = $this->repository->sqlFunction($this->constantesTipoArticulos->sqlSelectById($id));
        return (empty($bodegaModel)) ? "elimino" : "no elimino";
    }

    public function importacionTiposArticulosTns($dsn)
    {

        try {
            $dataMapeada = [
                ["codigo" => "01", "descripcion" => "Materia Prima"],
                ["codigo" => "02", "descripcion" => "Mano de Obra"],
                ["codigo" => "03", "descripcion" => "Equipo"],
                ["codigo" => "04", "descripcion" => "Producto Proceso"],
                ["codigo" => "05", "descripcion" => "Producto Terminado"],
                ["codigo" => "06", "descripcion" => "Administrativo"],
                ["codigo" => "07", "descripcion" => "Actividad"],
            ];
            $this->repository->createInfo($this->tableName, $dataMapeada);

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Tipos Articulos", "Creo");
        } catch (\Throwable $th) {

            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Tipos Articulos", "No creo");
            return "Importacion de tipos articulos de articulos fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
}