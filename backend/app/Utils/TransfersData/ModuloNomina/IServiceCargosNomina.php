<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Utils\ResponseHandler;
use Illuminate\Http\Request;

interface IServiceCargosNomina
{
    public function crearCargo(array $entidadCargo): ResponseHandler;
    public function actualizarCargo(string $id, $entidadCargo): ResponseHandler;
    public function eliminarCargo(string $id): ResponseHandler;
    public function getCargo();
    public function filterCargo($nombre,$codigo);

}
