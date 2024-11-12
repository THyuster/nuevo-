<?php


namespace App\Utils\TransfersData\ModuloMantenimiento;

use Illuminate\Http\Request;

interface IServicesEntregaDirectas
{
    public function obtenerTodosEntregaDirecta();
    public function crearEntregaDirecta(array $entidadTiposEntregaDirecta);
    public function actualizarEntregaDirecta(String $id, array $entidadTiposEntregaDirecta);
    public function eliminarEntregaDirecta(String $id);
}
