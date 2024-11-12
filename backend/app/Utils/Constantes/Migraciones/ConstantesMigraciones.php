<?php
namespace App\Utils\Constantes\Migraciones;

class ConstantesMigraciones {

    public function insertMigracion( $tabla, $campo , $atributo , $accion , $script_db ) {
        return "INSERT INTO `erp_migraciones` (`tabla`, `campo` , `atributo`, `accion` , `script_db`) 
        VALUES ( '$tabla' , '$campo' , '$atributo', '$accion', '$script_db')";
    }

    public function getMigracion( $id ) {
        return "SELECT * FROM erp_migraciones WHERE id = '$id'";
    }

    public function updateMigracion($tabla,$campo,$atributo,$accion,$script_db,$id){
        return "UPDATE `erp_migraciones` SET tabla = '$tabla',
        campo = '$campo' , atributo = '$atributo' , accion = '$accion'  , script_db = '$script_db' WHERE id = '$id' ";
    }

    function deleteMigracion($id){
       return "DELETE FROM erp_migraciones WHERE `id` = '$id' ";
    }

    public function updateSqlMigracionEstado($status,$id){
        return "UPDATE erp_migraciones SET estado = $status WHERE id = $id";
    }

  

}