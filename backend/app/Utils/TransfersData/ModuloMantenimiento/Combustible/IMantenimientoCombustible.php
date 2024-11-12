<?php
namespace App\Utils\TransfersData\ModuloMantenimiento\Combustible;

interface IMantenimientoCombustible
{
    public function getIMantenimientoCombustible();
    public function addIMantenimientoCombustible($contabilidadEntidad);
    public function removeIMantenimientoCombustible($id);
    public function updateIMantenimientoCombustible($id,$contabilidad);
}