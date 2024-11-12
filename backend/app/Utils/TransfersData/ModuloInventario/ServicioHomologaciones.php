<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Repository\RepositoryDynamicsCrud;

use App\Utils\Constantes\ModuloInventario\ConstantesHomologaciones;
use App\Utils\MyFunctions;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ServicioHomologaciones implements IServicioHomologaciones
{

    private $repositoryDynamicsCrud, $date, $nameDataBase, $myFunctions;

    protected $sqlHomologacion, $tablaLogImportaciones, $serviceLogImportaciones, $tablaMantHomolArticulos, $tablaInvArticulos;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");


        $this->sqlHomologacion = new ConstantesHomologaciones;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;

        $this->myFunctions = new MyFunctions;
        $this->serviceLogImportaciones = new LogImportaciones;
        $this->nameDataBase = tablas::getTablaClienteInventarioHomologaciones();
        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
        $this->tablaMantHomolArticulos = tablas::getTablaClienteMantenimientoRelacionHomoArticulos();
        $this->tablaInvArticulos = tablas::getTablaErpInventarioArticulos();
    }


    public function obtenerHomologaciones()
    {
        try {
            $sql = "
            SELECT mh.id , mh.codigo, mh.descripcion, mh.listar, ia.id idArticulo ,ia.codigo codigoArticulo, ia.descripcion descripcionArticulo, mrah.articulo_principal articuloPrincipal 
            FROM mantenimiento_homologaciones mh 
            LEFT JOIN mantenimiento_relacion_homologaciones_articulos mrah ON (mh.id = mrah.id_homologacion ) 
            LEFT JOIN inventarios_articulos2 ia ON mrah.id_articulo = ia.id 
            ORDER BY 
                CASE 
                    WHEN mrah.id_homologacion IS NOT NULL THEN 0 ELSE 1 
                END,
                CASE
                WHEN mrah.articulo_principal = true  THEN 0 ELSE 1 
                END, 
            mh.id
            ";
            $respuesta =   $this->repositoryDynamicsCrud->sqlFunction($sql);
            $homologacionRelacion = [];

            foreach ($respuesta as  $homologacionActual) {
                $idActual = $homologacionActual->id;
                $encotrado = collect($homologacionRelacion)->firstWhere('id', $idActual);

                if (!$encotrado) {
                    $arrayHomologacion = json_decode(json_encode($homologacionActual), true);
                    $homologacion = (object) $arrayHomologacion;
                    $homologacion->articulosSecudarios = [];
                    $homologacionRelacion[] = $homologacion;
                    $encotrado = $homologacion;
                }

                $encontrarSecundarios = collect($encotrado->articulosSecudarios)->first(function ($homologacion) use ($homologacionActual) {
                    return ($homologacion["id"] == $homologacionActual->idArticulo);
                });

                if ((!$encontrarSecundarios) && $homologacionActual->articuloPrincipal == 0) {
                    $encotrado->articulosSecudarios[] = [
                        "id" => $homologacionActual->idArticulo,
                        "codigo" => $homologacionActual->codigoArticulo,
                        "descripcion" => $homologacionActual->descripcionArticulo
                    ];
                }
                unset($encotrado->articuloPrincipal);
            }
            $sql2 = "SELECT a.id AS id, a.codigo AS codigo, a.descripcion AS descripcion FROM inventarios_articulos2 a LEFT JOIN mantenimiento_relacion_homologaciones_articulos m ON a.id = m.id_articulo WHERE m.id_articulo IS NULL";
            $articulosNoUsados =   $this->repositoryDynamicsCrud->sqlFunction($sql2);
            return ["homologaciones" => $homologacionRelacion, "articulosNoUsados" => $articulosNoUsados];
        } catch (\Throwable $error) {
            throw $error;
        }
    }
    public function create($nuevaHomologacion)
    {
        try {


            $this->buscarCodigo($nuevaHomologacion['codigo']);

            $articuloIdPrincipal =  $nuevaHomologacion['articuloPrincipal'];
            $articulos = $this->prepararArticulos($nuevaHomologacion); //pilas que aca modificamos el valor de a entidad

            $idHomologacion =  $this->repositoryDynamicsCrud->getRecordId($this->nameDataBase, $nuevaHomologacion);
            $insertarArticulos = $this->mapearArticulos($articulos, $idHomologacion, $articuloIdPrincipal);

            return $this->repositoryDynamicsCrud->createInfo($this->tablaMantHomolArticulos, $insertarArticulos);
        } catch (\Throwable $error) {
            throw $error;
        }
    }


    public function update($id, $nuevaHomologacion)
    {
        try {

            $this->buscarHomologacion($id);
            $this->buscarCodigo($nuevaHomologacion['codigo'], $id);

            $articuloIdPrincipal =  $nuevaHomologacion['articuloPrincipal'];
            $articulos = $this->prepararArticulos($nuevaHomologacion, $id);
            $insertarArticulos = $this->actualizarRelacionArticulos($id, $articulos, $articuloIdPrincipal);

            $this->repositoryDynamicsCrud->createInfo($this->tablaMantHomolArticulos, $insertarArticulos);
            $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $nuevaHomologacion, $id);
            return  response()->json(json_encode("Registro actualizado exitosamente"), Response::HTTP_ACCEPTED);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function delete($id)
    {
        try {
            $this->buscarHomologacion($id);

            $sql = "DELETE FROM $this->tablaMantHomolArticulos WHERE id_homologacion = '$id'";
            $this->repositoryDynamicsCrud->sqlFunction($sql);
            return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function statusUpdate($id)
    {
        try {

            $homologacion = $this->buscarHomologacion($id);
            $newStatus = array('estado' => !$homologacion[0]->estado);
            return $this->repositoryDynamicsCrud->updateInfo($this->nameDataBase, $newStatus, $id);
        } catch (\Throwable $error) {
            return $this->returnError($error);
        }
    }


    public function buscarHomologacion($id)
    {

        $sql = $this->sqlHomologacion->obtenerHomologacion($id);
        $getClient = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (empty($getClient)) {
            throw new \Exception(__('messages.recordNotExist'), 404);
        }
        return $getClient;
    }

    public function buscarCodigo($data, $id = null)
    {

        $sql = ($id)
            ? $this->sqlHomologacion->obtenerCodigoDiferenteId($id, $data)
            : $this->sqlHomologacion->obtenerCodigo($data);
        $codigoExistente = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($codigoExistente) {
            throw new Exception(__('messages.existingCode'));
        }
    }


    private function prepararArticulos(&$nuevaHomologacion, $idRegristro = null)
    {
        $articulos = $nuevaHomologacion['articulos'];
        array_push($articulos, $nuevaHomologacion['articuloPrincipal']);
        $this->validarArticulos($articulos);
        $idsArticulosString = implode(",", $articulos);
        $sql = "";
        if ($idRegristro) {
            $sql = $this->sqlHomologacion->obtenerArticulosHomologadosConId($idsArticulosString, $idRegristro);
        } else {
            $sql = $this->sqlHomologacion->obtenerArticulosHomologados($idsArticulosString);
        }

        $respuestaDb = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if ($respuestaDb) {
            $articulosMapeados =  array_map(function ($articulo) {
                return ["descripcion" => "$articulo->codigo -  $articulo->descripcion"];
            }, $respuestaDb);
            $idsArticulosString = implode(",", array_column($articulosMapeados, "descripcion"));

            throw new Exception("Hay articulos que ya se encuentran homologados. -> $idsArticulosString");
        }
        unset($nuevaHomologacion['articulos'], $nuevaHomologacion['articuloPrincipal']);
        return $articulos;
    }


    private function mapearArticulos($articulos, $idHomologacion, $articuloPrincipal)
    {
        return array_map(function ($articuloId) use ($idHomologacion, $articuloPrincipal) {
            return [
                "id_homologacion" => $idHomologacion,
                "id_articulo" => $articuloId,
                "articulo_principal" => ($articuloId == $articuloPrincipal) ? true : false
            ];
        }, $articulos);
    }

    private function actualizarRelacionArticulos($id, $articulos, $articuloPrincipal)
    {
        $sql = "SELECT * FROM $this->tablaMantHomolArticulos WHERE id_homologacion = '$id'";
        $relacionDb = $this->repositoryDynamicsCrud->sqlFunction($sql);

        $eliminarArticulos = array_diff(array_column($relacionDb, "id_articulo"), $articulos);
        if (!empty($eliminarArticulos)) {
            $eliminarArticulosString = implode(",", $eliminarArticulos);
            $sqlEliminar = "DELETE FROM $this->tablaMantHomolArticulos WHERE id_homologacion = '$id' AND id_articulo IN ($eliminarArticulosString)";
            $this->repositoryDynamicsCrud->sqlFunction($sqlEliminar);
        }

        $añadirArticulos =  array_diff($articulos, array_column($relacionDb, "id_articulo"));
        $insertarArticulos = $this->mapearArticulos($añadirArticulos, $id, $articuloPrincipal);
        return $insertarArticulos;
    }

    public function importacionHomologacionTns($dsn)
    {

        try {
            $sqlQuery = "SELECT CODIGO codigo , DESCRIPCION descripcion FROM CODIGOSUNIDADES";
            $dataMapeada =  $this->myFunctions->getDataOdbc($sqlQuery, $dsn);
            $this->repositoryDynamicsCrud->createInfo($this->nameDataBase, $dataMapeada);

            return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Homologaciones", "Creó");
        } catch (\Throwable $th) {

            $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 0, "Homologaciones", "No creó");
            return "Importacion de departamento de unidades fallada";
        }
    }

    private function validarArticulos(array $articulosId)
    {
        $articulosString = implode(",", $articulosId);
        $sql = "SELECT id FROM $this->tablaInvArticulos WHERE id IN ($articulosString)";
        $articulsoDb =  $this->repositoryDynamicsCrud->sqlFunction($sql);
        $articulosEncode = json_decode(json_encode($articulsoDb), true);
        $idNoValidados = array_diff($articulosId, array_column($articulosEncode, "id"));
        if ($idNoValidados) {
            throw new Exception("Articulos no existestes por favor revisar: " . implode(",", $idNoValidados));
        }
    }

    private function returnError($error)
    {
        return [
            'error' => $error->getMessage(),
            'status' => $error->getCode()
        ];
    }
}