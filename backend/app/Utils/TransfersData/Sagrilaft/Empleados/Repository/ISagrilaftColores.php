<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Repository;

interface ISagrilaftColores
{
    public function create(array $datos);

    public function getById($id);
    public function getAll();
}