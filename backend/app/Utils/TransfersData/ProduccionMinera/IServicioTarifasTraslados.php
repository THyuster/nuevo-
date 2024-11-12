<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Dotenv\Util\Str;

interface IServicioTarifasTraslados
{
    public function obtenerTarifasTraslados();
    public function obtenerTarifaTrasladoId(String $id);

    public function crearTarifaTraslado(array $data);
    public function actualizarTarifaTraslado(String $id, array $data);

    public function eliminarTarifaTraslado(String $id);

    public function actualizarEstadoTarifaTraslado(String $id);
}
