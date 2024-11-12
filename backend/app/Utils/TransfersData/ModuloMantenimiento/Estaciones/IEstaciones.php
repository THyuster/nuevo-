<?php
namespace App\Utils\TransfersData\ModuloMantenimiento\Estaciones;

interface IEstaciones
{
    public function getIMantenimientoEstaciones();
    public function addIMantenimientoEstaciones($estaciones);
    public function removeIMantenimientoEstaciones($id);
    public function updateIMantenimientoEstaciones($id,$estaciones);

    public function EstadoIMantenimientoEstaciones($id);
}