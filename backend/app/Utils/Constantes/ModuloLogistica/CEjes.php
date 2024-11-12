<?php

namespace App\Utils\Constantes\ModuloLogistica;

final class CEjes
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlbuscarContratoPorId($id)
    {
        return "SELECT id FROM  logistica_ejes  WHERE  id =$id ";
    }
    public function sqlbuscarCodigoPorId($codigo, $id)
    {
        return "SELECT id FROM  logistica_ejes  WHERE codigo = '$codigo' AND id !=$id ";
    }
    public function sqlbuscarCodigo($codigo)
    {
        return "SELECT id FROM  logistica_ejes  WHERE codigo = '$codigo'";
    }

}