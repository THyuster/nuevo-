<?php

namespace App\Utils\TransfersData\ModuloNomina;

interface IServiceEntidadesNomina
{
    public function buscarCodigoEntidad(string $codigo, int $id);
    public function crearEntidad(array $entidadEntidad);
    public function actualizarEntidad(string $id, array $entidadEntidad);
    public function eliminarEntidad(string $id);
    public function obtenerEntidad(int $id);
    public function obtenerTodasEntidades();
}
