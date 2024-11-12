<?php
namespace App\Utils\TransfersData\ModuloLogistica;

use Illuminate\Http\Request;

interface IServicesEjes
{
    public function crearEjes(array $request);
    public function actualizarEjes(int $id, array $data);
    public function eliminarEjes(int $id);
}