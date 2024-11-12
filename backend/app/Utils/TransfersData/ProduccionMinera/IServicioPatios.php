<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioPatios
{
    public function obtenerPatios();
    public function obtenerPatioPorId(String $id);

    public function crearPatio(array $data);
    public function actualizarPatio(String $id, array $data);

    public function eliminarPatio(String $id);
    public function validarPatioPorId(String $id);

    public function actualizarEstadoPatio(String $id);
}
