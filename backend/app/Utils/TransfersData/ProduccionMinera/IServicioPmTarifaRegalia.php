<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioPmTarifaRegalia
{
    public function obtenerPmTarifaRegalia();
    public function obtenerPmTarifaRegaliaPorId(String $id);
    public function crearPmTarifaRegalia(array $entidadPmTarifaRegalia);
    public function actualizarPmTarifaRegalia(String $id, array $entidadPmTarifaRegalia);
    public function eliminarPmTarifaRegalia(String $id);
    public function actualizarEstadoPmTarifaRegalia(String $id);
}
