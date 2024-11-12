<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioPmContabilizacion
{
    public function obtenerPmContabilizaciones();
    public function obtenerPmContabilizacionPorId(String $id);
    public function crearPmContabilizacion(array $entidadPmCalidades);
    public function actualizarPmContabilizacion(String $id, array $entidadPmCalidades);
    public function eliminarPmContabilizacion(String $id);
}
