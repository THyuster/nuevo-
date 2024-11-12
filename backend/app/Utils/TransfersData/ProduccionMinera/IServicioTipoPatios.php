<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Dotenv\Util\Str;

interface IServicioTipoPatios
{
    public function obtenerTiposPatios();
    public function obtenerPatioPorId(String $id);
}
