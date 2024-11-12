<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Dotenv\Util\Str;

interface IServicioBodega
{
    public function obtenerBodegas();
    public function obtenerBodegasPorId(String $id);

    public function crearBodegas(array $data);
    public function actualizarBodegas(String $id, array $data);

    public function eliminarBodegas(String $id);

    public function actualizarEstadoBodegas(String $id);
}
