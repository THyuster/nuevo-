<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use Illuminate\Http\Request;

interface IServicioPmCalidades
{
    public function obtenerPmCalidades();
    public function obtenerPmCalidadPorId(String $id);
    public function crearPmCalidad(array $entidadPmCalidades);
    public function actualizarPmCalidad(String $id, array $entidadPmCalidades);
    public function eliminarPmCalidad(String $id);
}
