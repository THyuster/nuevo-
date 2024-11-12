<?php

namespace App\Utils\Constantes\ModuloLogistica;

final class CCombustiblesLogistica
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlGetCombustibles()
    {
        return "SELECT * FROM  logistica_combustibles";
    }

    public function sqlGetCombustibleById($id)
    {
        return "SELECT * FROM  logistica_combustibles  WHERE  id ='$id'";
    }

}