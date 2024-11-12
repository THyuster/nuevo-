<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioPmZonas
{
    public function obtenerZonas();
    public function obteneZonaPorId(String $id);
    public function validarZona(String $id);
    public function crearZona(array $entidadZona);
    public function actualizarZona(String $id, array $entidadZona);
    public function eliminarZona(String $id);
}
