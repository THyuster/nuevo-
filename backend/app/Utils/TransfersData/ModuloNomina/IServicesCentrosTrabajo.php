<?php

namespace App\Utils\TransfersData\ModuloNomina;

interface IServicesCentrosTrabajo
{
    public function crearCentroTrabajo($entidadTiposSolicitudes);
    public function actualizarCentroTrabajo(int $id, $entidadTiposSolicitudes);
    public function eliminarCentroTrabajo(int $id): string;
    public function estadoCentroTrabajo(int $id): string;
    public function getCentroTrabajo();
}
