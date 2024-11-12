<?php
namespace App\Utils\Constantes\ModuloContabilidad;

class SqlThirdParty{
    

    public function getSqlFindThirdParty($description){
        return "SELECT * FROM  contabilidad_tipos_terceros WHERE descripcion = '$description' ";
    }
    public function getSqlFindThirdPartyByCode($codigo){
        return "SELECT * FROM  contabilidad_tipos_terceros WHERE codigo = '$codigo' ";
    }

    public function getSqlDataRelationsTypesThirds($id){
        return 
        "SELECT
        contabilidad_tipos_terceros.id as idTiposTerceros,
        contabilidad_relacion_tipos_terceros.id as idRelacionTerceros,
        contabilidad_tipos_terceros.codigo,
        contabilidad_tipos_terceros.descripcion
        FROM contabilidad_tipos_terceros INNER JOIN contabilidad_relacion_tipos_terceros
        WHERE contabilidad_tipos_terceros.id= '$id'
        AND contabilidad_relacion_tipos_terceros.tipo_tercero_id = '$id'";
    }

   
    
}