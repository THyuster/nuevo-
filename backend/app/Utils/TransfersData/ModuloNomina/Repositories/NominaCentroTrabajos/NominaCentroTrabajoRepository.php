<?php

namespace App\Utils\TransfersData\ModuloNomina\Repositories\NominaCentroTrabajos;
use App\Models\modulo_nomina\nomina_centros_trabajo;
use App\Utils\Repository\RepositoryDynamicsCrud;

class NominaCentroTrabajoRepository implements INominaCentroTrabajoRepository
{

    public function existById($id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return nomina_centros_trabajo::on($connection)->where('id', $id)->exists();
    }
}
