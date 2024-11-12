<?php
namespace App\Utils\TransfersData\ModuloMantenimiento\Horometros;

interface IMantenimientoHorometros
{
    public function getIMantenimientoHorometros();
    public function addIMantenimientoHorometros($contabilidadEntidad);
    public function removeIMantenimientoHorometros($id);
    public function updateIMantenimientoHorometros($id,$contabilidad);
}