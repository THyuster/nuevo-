<?php

// interface cl
namespace App\Utils\TransfersData\ModuloMantenimiento;

interface IServicesTiposSolicitudes
{
    public function crearTipoSolicitud($entidadTiposSolicitudes);
    public function actualizarTipoSolicitud(int $id, $entidadTiposSolicitudes): string;
    public function eliminarTipoSolicitud(int $id): string;
    // public function estadoTipoSolicitud(int $id): string;
    public function getTipoSolicitud();
}