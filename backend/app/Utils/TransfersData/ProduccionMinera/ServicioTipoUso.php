<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioTipoUso implements IServicioTipoUso
{
    private String  $tablaUso;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;


    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {

        $this->tablaUso = tablas::getTablaClientePmTipoUso();
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
    }

    public function obtenerTiposUso()
    {
        $query = "SELECT * FROM $this->tablaUso";
        $tiposUsoDb =  $this->repositoryDynamicsCrud->sqlFunction($query);
        return array_map(function ($tipo) {
            $tipo->id = base64_encode($this->encriptarKey($tipo->id));
            return $tipo;
        }, $tiposUsoDb);
    }
    public function obtenerTiposUsoPorId(String $id)
    {
        $query = "SELECT * FROM $this->tablaUso WHERE id = '$id'";
        return  $this->repositoryDynamicsCrud->sqlFunction($query);
    }


    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}
