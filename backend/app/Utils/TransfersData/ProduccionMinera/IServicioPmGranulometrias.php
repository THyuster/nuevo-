<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioPmGranulometrias
{
    public function obtenerPmGranulometrias();
    public function obtenerPmGranulometriaPorId(String $id);
    public function crearPmGranulometria(array $entidadPmGranulometrias);
    public function actualizarPmGranulometria(String $id, array $entidadPmGranulometrias);
    public function eliminarPmGranulometria(String $id);
}
