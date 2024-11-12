<?php
namespace App\Utils\TransfersData\ModuloMantenimiento\Kilometros;

interface IMantenimientoKilometros
{
    public function getIMantenimientoKilometros();
    public function addIMantenimientoKilometros($contabilidadEntidad);
    public function removeIMantenimientoKilometros($id);
    public function updateIMantenimientoKilometros($id,$contabilidad);
}