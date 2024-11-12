<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioPmTipoRegalia
{
    public function obtenerPmTipoRegalia();
    public function obtenerPmTipoRegaliaPorId(String $id);
    public function crearPmTipoRegalia(array $entidadPmTipoRegalia);
    public function actualizarPmTipoRegalia(String $id, array $entidadPmTipoRegalia);
    public function eliminarPmTipoRegalia(String $id);
    public function validarTipoRegalia(string $idTipoRegalia);
    public function actualizarEstadoTipoRegalia(string $idTipoRegalia);
}
