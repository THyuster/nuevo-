<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioTipoMovimientos
{
    public function obtenerTipoMovimientos();
    public function crearTiposMovimiento(array $request);
    public function actualizarTiposMovimiento(String $id, array $request);
    public function elimininarTipoMovimiento(String $id);
    public function validarTipoMovimientoId(String $id);
    public function actualizarEstadoTipoMovimiento(String $id);
}
