<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Ordenes\Repository;

interface IOrdenRepository
{
    public function create(array $datos, $connection = null);
    public function updateById($id, array $datos, $connection = null);
    public function deleteById($id, $connection = null);
    public function getByIdSolicitud($idSolicitud, $connection = null);

}
