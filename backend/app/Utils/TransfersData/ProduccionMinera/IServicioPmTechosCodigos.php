<?php

namespace App\Utils\TransfersData\ProduccionMinera;

interface IServicioPmTechosCodigos
{
    public function obtenerPmTechosCodigos();
    public function validarTechoCodigo(String $id);
    public function crearPmTechosCodigo(array $entidadPmTechosCodigo);
    public function actualizarPmTechosCodigo(String $id, array $entidadPmTechosCodigo);
    public function eliminarPmTechosCodigo(String $id);
    public function actualizarEstadoPmTechosCodigo(String $id);
}
