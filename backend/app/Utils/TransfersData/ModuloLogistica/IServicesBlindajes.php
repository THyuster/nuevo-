<?php
namespace App\Utils\TransfersData\ModuloLogistica;

use Illuminate\Http\Request;

interface IServicesBlindajes
{
    public function crearBlindajes(array $request);
    public function actualizarBlindajes(int $id, array $data);
    public function eliminarBlindajes(int $id);
}