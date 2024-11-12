<?php
namespace App\Utils\TransfersData\moduloContabilidad\PlanUnicoCuentas;

use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;


class ServicioCuentaAuxiliares implements IServicioCuentaAuxiliares{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    public function __construct(){
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud();
    }
    public function obtenerCuentasAuxiliares(){
        $sql = "SELECT * FROM  contabilidad_puc5_auxiliares";
        $response =  $this->repositoryDynamicsCrud->sqlFunction($sql);
        return array_map(function($cuenta ){
             $cuenta->id= base64_encode($this->encriptarKey( $cuenta->id ));
             return $cuenta;
        }, $response );
    }

    
    public function buscarCuentaAuxiliarPorId(String $id){
        $sql = "SELECT * FROM  contabilidad_puc5_auxiliares WHERE id = '$id'";
        $response =  $this->repositoryDynamicsCrud->sqlFunction($sql);
        if(!$response){
            throw new \Exception("Cuenta Auxiliar no encontrada");
        }
        return $response;
       
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