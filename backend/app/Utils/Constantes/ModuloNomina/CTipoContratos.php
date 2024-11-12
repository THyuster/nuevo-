<?php

namespace App\Utils\Constantes\ModuloNomina;

final class CTipoContratos
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlbuscarContratoPorId($id)
    {
        return "SELECT id FROM  logistica_tipo_contrato  WHERE  id =$id ";
    }
    public function sqlbuscarCodigoPorId($codigo, $id)
    {
        return "SELECT id FROM  logistica_tipo_contrato  WHERE codigo = '$codigo' AND id !=$id ";
    }
    public function sqlbuscarCodigo($codigo)
    {
        return "SELECT id FROM  logistica_tipo_contrato  WHERE codigo = '$codigo'";
    }

}