<?php

namespace App\Utils\Constantes\ModuloMantenimiento;


final class CTiposOrdenes
{

    public function sqlSelectById(string $id): string
    {
        return "SELECT * FROM mantenimiento_tipos_ordenes WHERE id = '$id'";
    }
}
