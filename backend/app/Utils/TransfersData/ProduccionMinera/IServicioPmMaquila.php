<?php

namespace App\Utils\TransfersData\ProduccionMinera;


interface IServicioPmMaquila
{
    public function obtenerMaquilas();
    public function validarMaquila(String $id);
    public function crearMaquila(array $entidadMaquila);
    public function actualizarMaquila(String $id, array $entidadMaquila);
    public function eliminarMaquila(String $id);
}
