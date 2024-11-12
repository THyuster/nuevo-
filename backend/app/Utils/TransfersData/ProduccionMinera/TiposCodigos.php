<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoCodigo;
use Illuminate\Http\Request;

class TiposCodigos  implements IServicioTipoCodigo
{
    private String $tablaTiposCodigos;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaTiposCodigos = tablas::getTablaClientePmTiposCodigos();
    }
    public function obtenerTiposCodigos()
    {
        try {
            $sql = "SELECT * FROM $this->tablaTiposCodigos";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaTipos = array_map(function ($codigo) {
                $codigo->id = base64_encode($this->encriptarKey($codigo->id));
                return $codigo;
            }, $resultadosDb);
            $respuestaTipos;
            return  response()->json(["datos" => $respuestaTipos], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function crearTipoCodigo(array $entidadTipoCodigo)
    {
        try {
            $this->repositoryDynamicsCrud->createInfo($this->tablaTiposCodigos, $entidadTipoCodigo);
            return  response()->json(["datos" => "Creado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function actualizarTipoCodigo(String $id, array $entidadTipoCodigo)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $this->repositoryDynamicsCrud->updateInfo($this->tablaTiposCodigos, $entidadTipoCodigo, $id);
            return  response()->json(["datos" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }
    public function eliminarTipoCodigo(String $id)
    {
        try {
            $id = $this->desEncriptarKey(base64_decode($id));
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaTiposCodigos, $id);
            return  response()->json(["datos" => "Registro eliminado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], $th->getCode());
        }
    }

    public function obtenerCodigoPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaTiposCodigos WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    public function validarTipoCodigoPorId(String $id)
    {
        $tipoCodigoDb = $this->obtenerCodigoPorId($id);
        if (count($tipoCodigoDb) == 0) {
            return response()->json(["Error" => "El tipo de codigo no existe"], 404);
        }
        return null;
    }
    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }

    private function desEncriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}
