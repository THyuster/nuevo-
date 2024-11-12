<?php

namespace App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\Repository;
use App\Models\modulo_logistica\logistica_marcas;
use App\Utils\Repository\RepositoryDynamicsCrud;

class MarcasRepository implements IMarcasRepository
{
    
    public function existById($id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return logistica_marcas::on($connection)->where('id',$id)->exists();
    }
}
