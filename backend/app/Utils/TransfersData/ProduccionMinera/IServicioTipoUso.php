<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Dotenv\Util\Str;

interface IServicioTipoUso
{
    public function obtenerTiposUso();
    public function obtenerTiposUsoPorId(String $id);
}
