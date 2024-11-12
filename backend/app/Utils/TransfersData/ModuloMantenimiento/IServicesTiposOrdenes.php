<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

interface IServicesTiposOrdenes
{
    public function crearTipoOrden($entidadTiposSolicitudes);
    public function actualizarTipoOrden(int $id, $entidadTiposSolicitudes): string;
    public function eliminarTipoOrden(int $id): string;
    public function getTipoOrden();
    public function actualizarEstado(int $id);
}