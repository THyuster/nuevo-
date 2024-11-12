<?php

namespace App\Utils\Constantes\ModuloLogistica;

final class CBlindajes
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlbuscarBlindajePorId($id)
    {
        return "SELECT id FROM  logistica_blindajes  WHERE  id =$id ";
    }
    public function sqlbuscarCodigoPorId($codigo, $id)
    {
        return "SELECT id FROM  logistica_blindajes  WHERE codigo ='$codigo' AND id !=$id ";
    }
    public function sqlbuscarCodigo($codigo)
    {
        return "SELECT id FROM  logistica_blindajes  WHERE codigo = '$codigo'";
    }

}