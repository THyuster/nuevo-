<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Utils\Constantes\ModuloMantenimiento\CItemsDiagnostico;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ServicesItemsDiagnostico implements IServicesItemsDiagnostico
{


    private RepositoryDynamicsCrud $_repository;
    private ServicesTiposOrdenes $_cTiposOrdenes;

    private $nombreTabla = "mantenimiento_items_diagnostico", $sqlItemsDiagnostico, $date;
    private $nombreTablaMantenimientoOrdenes = "mantenimiento_tipos_ordenes";


    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->_repository = $repositoryDynamicsCrud;
        $this->_cTiposOrdenes = new ServicesTiposOrdenes;
        $this->sqlItemsDiagnostico = new CItemsDiagnostico;
        $this->date = date("Y-m-d H:i:s");
    }
    public function obtenerTodosItemsDiagnostico()
    {
        $response = $this->_repository->sqlFunction($this->sqlItemsDiagnostico->sqlObtenerTodosLosItems());
        return $this->mappearItems(json_decode(json_encode($response), true));
    }
    public function obtenerTodosItemsDiagnosticoConRespuesta()
    {
        $response = $this->_repository->sqlFunction($this->sqlItemsDiagnostico->sqlObtenerTodosLosItemsConRespuesta());
        return $this->mappearItems(json_decode(json_encode($response), true));
    }
    public function obtenerItemsTipoOrden(int $asigActaId, $idActa)
    {
        $response = $this->_repository->sqlFunction($this->sqlItemsDiagnostico->sqlItemsTipoOrden($asigActaId, $idActa));
        return $this->mappearItems(json_decode(json_encode($response), true));
    }

    private function mappearItems($datos)
    {
        return array_map(function ($item) {
            $item['id'] = EncryptionFunction::StaticEncriptacion($item["id"]);
            return $item;
        }, $datos);
    }

    public function buscarItemsDiagnostico(int $id)
    {
        $sql = "SELECT * FROM $this->nombreTabla WHERE id = " . "$id";
        return $this->buscarRegistro($sql, "Item no encontrado");
    }
    public function crearItemsDiagnostico($entidadTiposItemsDiagnosticos)
    {
        try {
            $tipoOrdenId = htmlspecialchars($entidadTiposItemsDiagnosticos["tipo_orden_id"], ENT_QUOTES, 'utf-8');
            $tipoClasificacion = htmlspecialchars($entidadTiposItemsDiagnosticos["tipo_clasificacion"], ENT_QUOTES, 'utf-8');
            $descripcion = htmlspecialchars($entidadTiposItemsDiagnosticos["descripcion"], ENT_QUOTES, 'utf-8');
            $estado = 1;

            $sqlSearchTipoRespuesta = "SELECT tipo_respuesta FROM erp_mant_respuestas WHERE id = '$tipoClasificacion'";
            $tipoRespuesta = $this->_repository->sqlFunction($sqlSearchTipoRespuesta);

            if (empty($tipoRespuesta)) {
                throw new Exception("No encontrado el tipo de clasificación", Response::HTTP_NOT_FOUND);
            }

            $tipoRespuesta = $tipoRespuesta[0]->tipo_respuesta;

            $sqlSearchTipoOrdenCodigo = "SELECT codigo FROM mantenimiento_tipos_ordenes WHERE id = '$tipoOrdenId'";
            $tipoCodigo = $this->_repository->sqlFunction($sqlSearchTipoOrdenCodigo);

            if (empty($tipoCodigo)) {
                throw new Exception("No encontrado el tipo de orden", Response::HTTP_NOT_FOUND);
            }

            $tipoCodigo = $tipoCodigo[0]->codigo;

            $entidad["descripcion"] = $descripcion;
            $entidad["tipo_clasificacion"] = $tipoRespuesta;
            $entidad["tipo_orden_id"] = $tipoCodigo;
            $entidad["estado"] = $estado;

            return $this->_repository->createInfo($this->nombreTabla, $entidad);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function actualizarItemsDiagnostico($entidadTipoItemsDiagnosticos)
    {
        try {
            $id = $this->desencriptarKey($entidadTipoItemsDiagnosticos["id"]);

            $tipoOrdenId = htmlspecialchars($entidadTipoItemsDiagnosticos["tipo_orden_id"], ENT_QUOTES, 'utf-8');
            $tipoClasificacion = htmlspecialchars($entidadTipoItemsDiagnosticos["tipo_clasificacion"], ENT_QUOTES, 'utf-8');
            $descripcion = htmlspecialchars($entidadTipoItemsDiagnosticos["descripcion"], ENT_QUOTES, 'utf-8');

            $sqlSearchTipoRespuesta = "SELECT tipo_respuesta FROM erp_mant_respuestas WHERE id = '$tipoClasificacion'";
            $tipoRespuesta = $this->_repository->sqlFunction($sqlSearchTipoRespuesta);

            if (empty($tipoRespuesta)) {
                throw new Exception("No encontrado el tipo de clasificación", Response::HTTP_NOT_FOUND);
            }

            $tipoRespuesta = $tipoRespuesta[0]->tipo_respuesta;

            $sqlSearchTipoOrdenCodigo = "SELECT codigo FROM mantenimiento_tipos_ordenes WHERE id = '$tipoOrdenId'";
            $tipoCodigo = $this->_repository->sqlFunction($sqlSearchTipoOrdenCodigo);

            if (empty($tipoCodigo)) {
                throw new Exception("No encontrado el tipo de orden", Response::HTTP_NOT_FOUND);
            }

            $tipoCodigo = $tipoCodigo[0]->codigo;

            $entidad["descripcion"] = $descripcion;
            $entidad["tipo_clasificacion"] = $tipoRespuesta;
            $entidad["tipo_orden_id"] = $tipoCodigo;


            return $this->_repository->updateInfo($this->nombreTabla, $entidad, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function actualizarEstadoItem($entidadTipoItemsDiagnosticos)
    {
        try {  
            $id = $this->desencriptarKey($entidadTipoItemsDiagnosticos["id"]);
            $item = $this->buscarItemsDiagnostico($id);
            $estado = array('estado' => $item[0]->estado ? 0 : 1);
            return $this->_repository->updateInfo($this->nombreTabla, $estado, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function eliminarItemsDiagnostico($entidadTipoItemsDiagnosticos)
    {
        try {

            $id = $this->desencriptarKey($entidadTipoItemsDiagnosticos["id"]);
            $this->buscarItemsDiagnostico($id);
            return $this->_repository->deleteInfoAllOrById($this->nombreTabla, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function buscarCodigoItem(string $codigo, int $id = null)
    {
        $sql = ($id) ?
            "SELECT * FROM $this->nombreTabla WHERE codigo = '$codigo' AND id !=$id"
            : "SELECT * FROM $this->nombreTabla WHERE codigo = '$codigo'";
        $response = $this->_repository->sqlFunction($sql);
        if ($response) {
            throw new Exception("Codigo ya disponible");
        }
        return $response;
    }

    private function buscarRegistro($sql, $mensajeError)
    {

        $response = $this->_repository->sqlFunction($sql);
        if (!$response) {
            throw new Exception($mensajeError);
        }
        return $response;
    }

    private function desencriptarKey(string $id)
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}