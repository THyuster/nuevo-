<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\ConstantesMarcas;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ServiceMarcas
{
    protected $constantesMarcas, $myFunctions, $tablaMarca, $tablaLogImportaciones;
    protected $repository, $date, $serviceLogImportaciones;
    public function __construct()
    {
        $this->constantesMarcas = new ConstantesMarcas;
        $this->repository = new RepositoryDynamicsCrud;
        $this->myFunctions = new MyFunctions;
        $this->tablaMarca = tablas::getTablaClienteInventarioMarcas();
        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
        $this->date = date("Y-m-d H:i:s");
        $this->serviceLogImportaciones = new LogImportaciones;
    }

    public function createMarcas($dataCreate)
    {
        $codigoModel = $this->repository->sqlFunction($this->constantesMarcas->sqlSelectByCode($dataCreate['codigo']));

        if (!empty($codigoModel)) {
            return  "Ya existe" . $dataCreate['codigo'];
        }

        if ($dataCreate['codigo'] == "" || $dataCreate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataCreate['descripcion'] == "" || $dataCreate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesMarcas->sqlInsert($dataCreate['codigo'], $dataCreate['descripcion']));
        return "Creo";
    }

    public function updateMarcas($id, $dataUpdate)
    {
        $marcaModel = $this->repository->sqlFunction($this->constantesMarcas->sqlSelectById($id));
        $codigoModel = $this->repository->sqlFunction($this->constantesMarcas->sqlSelectByCode($dataUpdate['codigo']));

        if (!empty($codigoModel) && $codigoModel[0]->codigo != $dataUpdate['codigo']) {
            return  " Ya existe el codigo " . $dataUpdate['codigo'];
        }

        if (empty($marcaModel)) {
            return "No existe";
        }

        if ($dataUpdate['codigo'] == "" || $dataUpdate['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($dataUpdate['descripcion'] == "" || $dataUpdate['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->repository->sqlFunction($this->constantesMarcas->sqlUpdate($id, $dataUpdate['codigo'], $dataUpdate['descripcion']));
        $unidadModel = $this->repository->sqlFunction($this->constantesMarcas->sqlSelectById($id));
        return ($unidadModel[0]->codigo == $dataUpdate['codigo'] &&
            $unidadModel[0]->descripcion == $dataUpdate['descripcion']) ? "Actualizo" : "No actualizo";
    }

    public function deleteMarcas($id)
    {
        $this->repository->sqlFunction($this->constantesMarcas->sqlDelete($id));
        $unidadModel = $this->repository->sqlFunction($this->constantesMarcas->sqlSelectById($id));
        return (empty($unidadModel)) ? "elimino" : "no elimino";
    }

    public function importacionMarcasTns($dsn)
    {

        try {
            $codigos = $this->obtenerCodigoMarcasBD();
            $codigosMapeados = $this->mapearCodigo($codigos);
            $codigosString = implode(",", $codigosMapeados);
            $sqlQuery = "SELECT CODMARCA codigo , DESMARCA descripcion FROM MARCA WHERE CODMARCA NOT IN ($codigosString)";
            $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);

            $this->repository->createInfo($this->tablaMarca, $dataMapeada);
            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Marca", "Creo");
        } catch (\Throwable $th) {
            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Marca", "No creo");
            return "Importacion de Marcas de inventario fallada";
            // throw new Exception("Hubo un error " . $th->getMessage());
        }
    }
    private function obtenerCodigoMarcasBD()
    {
        $codigosMarcaDB =  $this->repository->sqlFunction("SELECT codigo FROM $this->tablaMarca");
        return array_column($codigosMarcaDB, "codigo");
    }
    private function mapearCodigo($codigosMarcas)
    {
        foreach ($codigosMarcas as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosMarcas;
    }
}