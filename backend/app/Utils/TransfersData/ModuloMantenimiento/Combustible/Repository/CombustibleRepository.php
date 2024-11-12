<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Combustible\Repository;
use App\Models\modulo_logistica\combustible;
use App\Utils\Repository\RepositoryDynamicsCrud;

class CombustibleRepository implements ICombustibleRepository
{
    
    public function existById($id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();

        return combustible::on($connection)->where('id', $id)->exists();
    }
}
