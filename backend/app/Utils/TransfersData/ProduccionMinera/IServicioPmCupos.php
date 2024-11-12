<?php

namespace App\Utils\TransfersData\ProduccionMinera;

interface IServicioPmCupos
{
    public function obtenerPmCupos();
    public function obtenerPmCupoPorId(String $id);
    public function crearPmCupo(array $entidadPmCupos);
    public function actualizarPmCupo(String $id, array $entidadPmCupos);
    public function eliminarPmCupo(String $id);
    public function actualizarEstadoPmCupo(String $id);
}
