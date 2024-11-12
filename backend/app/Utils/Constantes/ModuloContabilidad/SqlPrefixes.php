<?php
namespace App\Utils\Constantes\ModuloContabilidad;


class SqlPrefixes {
    public function getPrexisByCode ($code){
        return "SELECT * FROM contabilidad_prefijos WHERE contabilidad_prefijos.codigo = '$code'";
    }

    public function getPrefixed ($id){
        return "SELECT * FROM contabilidad_prefijos WHERE contabilidad_prefijos.id = '$id'";
    }
    public function getPrexisByCodeDiferent ($id, $code){
        return "SELECT * FROM contabilidad_prefijos WHERE contabilidad_prefijos.codigo = '$code'
        AND contabilidad_prefijos.id != '$id'
        ";
    }
}