<?php

namespace App\Utils\TransfersData\ProduccionMinera;


use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class TiposPatios  implements IServicioTipoPatios
{
    private String $tablaTiposPatios;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->tablaTiposPatios = tablas::getTablaClientePmTiposPatios();
    }
    public function obtenerTiposPatios()
    {
        try {
            $sql = "SELECT * FROM $this->tablaTiposPatios";
            $resultadosDb = $this->repositoryDynamicsCrud->sqlFunction($sql);
            $respuestaTipos = array_map(function ($codigo) {
                $codigo->id = base64_encode($this->encriptarKey($codigo->id));
                return $codigo;
            }, $resultadosDb);
            $respuestaTipos;
            return  response()->json(["datos" => $respuestaTipos], 200);
        } catch (\Throwable $th) {
            return response()->json(["Error al tratar de ejecutar la solicitud" => $th->getMessage()], 400);
        }
    }


    public function obtenerPatioPorId(String $id)
    {
        $sql = "SELECT * FROM $this->tablaTiposPatios WHERE id = '$id'";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
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
