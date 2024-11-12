<?php
namespace App\Utils\Constantes\ModuloContabilidad;


class SqlReceipt {
    public function getReceiptByCode ($code){
        return "SELECT * FROM contabilidad_tipos_comprobantes WHERE contabilidad_tipos_comprobantes.codigo = '$code'";
    }

    public function getReceipt ($id){
        return "SELECT * FROM contabilidad_tipos_comprobantes WHERE contabilidad_tipos_comprobantes.id = '$id'";
    }
    public function getReceiptByCodeDiferent ($id, $code){
        return "SELECT * FROM contabilidad_tipos_comprobantes WHERE contabilidad_tipos_comprobantes.codigo = '$code'
        AND contabilidad_tipos_comprobantes.id != '$id'
        ";
    }
}