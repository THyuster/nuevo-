<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use Symfony\Component\HttpFoundation\Response;



interface IvariablesGlobales
{
    public function listarVariableGlobal(): array;
    public function crearVariableGlobal(array $entidad);
    public function actualizarVariableGlobal($id, array $entidad);
    public function eliminarVariableGlobal($id): Response;
}
