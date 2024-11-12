<?php
namespace App\Utils\Constantes\ModuloContabilidad;

class SqlTypesIdentifications{
    
    public function sqlGetTypesIdentificationByDescripcion($descripcion){
        return "SELECT * FROM contabilidad_tipos_identificaciones WHERE contabilidad_tipos_identificaciones.descripcion = '$descripcion'";
    }
    public function sqlGetTypesIdentificationByCode($code){
        return "SELECT * FROM contabilidad_tipos_identificaciones WHERE codigo = '$code'";
    }
    public function  sqlGetTypesIdentificationByDescripcionAndDiferentsId($id, $descripcion){
        return "SELECT * FROM contabilidad_tipos_identificaciones WHERE contabilidad_tipos_identificaciones.descripcion= '$descripcion' AND contabilidad_tipos_identificaciones.id !='$id'";
    }
    public function  sqlGetTypesIdentificationByCodigoAndId($id, $codigo){
        return "SELECT * FROM contabilidad_tipos_identificaciones WHERE contabilidad_tipos_identificaciones.codigo= '$codigo' AND contabilidad_tipos_identificaciones.id !='$id'";
    }

    public function  queryIdentificationsByCodeAndId($id, $codigo){
        return "SELECT * FROM contabilidad_tipos_identificaciones WHERE contabilidad_tipos_identificaciones.codigo= '$codigo' AND contabilidad_tipos_identificaciones.id != '$id'";
    }

   
}