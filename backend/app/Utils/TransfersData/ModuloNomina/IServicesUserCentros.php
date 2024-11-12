<?php

namespace App\Utils\TransfersData\ModuloNomina;

interface IServicesUserCentros
{
    public function crearUserCentro($entidadTiposSolicitudes);
    public function actualizarUserCentro(int $id, $entidadTiposSolicitudes);
    public function eliminarUserCentro(int $id);
    public function estadoUserCentro(string $id);
    public function getUserCentro();
}
