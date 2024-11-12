<?php
namespace App\Utils\TransfersData\ModuloNomina;

use Illuminate\Http\Request;

interface IServicesTipoContrato
{
    public function crearTipoContrato(array $request);
    public function actualizarTipoContrato(int $id, array $data);
    public function eliminarTipoContrato(int $id);
}