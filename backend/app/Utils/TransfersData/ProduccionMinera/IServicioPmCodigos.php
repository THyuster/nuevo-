<?php

namespace App\Utils\TransfersData\ProduccionMinera;

interface IServicioPmCodigos
{
    public function obtenerPmCodigos();
    public function validarCodigoPorId(String $id);
    public function crearPmCodigo(array $entidadPmCodigo);
    public function actualizarPmCodigo(String $id, array $entidadPmCodigo);
    public function eliminarPmCodigo(String $id);
}
