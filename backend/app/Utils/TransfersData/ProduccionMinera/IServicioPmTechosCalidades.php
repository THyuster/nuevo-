<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Illuminate\Http\Request;

interface IServicioPmTechosCalidades
{
    public function obtenerPmTechosCalidades();
    public function obtenerPmTechoCalidadPorId(String $id);
    public function crearPmTechoCalidad(array $entidadPmCalidades);
    public function actualizarPmTechoCalidad(String $id, array $entidadPmCalidades);
    public function eliminarPmTechoCalidad(String $id);
    public function actualizarEstadoPmTechoCalidad(String $id);
}
