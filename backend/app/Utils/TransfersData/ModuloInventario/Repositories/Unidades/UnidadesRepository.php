<?php

namespace App\Utils\TransfersData\ModuloInventario\Repositories\Unidades;
use App\Models\modulo_inventarios\inventarios_unidades;
use App\Utils\Repository\RepositoryDynamicsCrud;

class UnidadesRepository implements IUnidadesRepository
{
    public function existById($id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return inventarios_unidades::on($connection)->where('id', $id)->exists();
    }
}
