<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\RelacionUrlTipoValidacionRelacion;
use App\Models\Sagrilaft\SagrilaftUrlTipoValidacionRelacion;
use App\Utils\Repository\RepositoryDynamicsCrud;

class SagrilaftUrlTipoValidacionRelacionRepository implements ISagrilaftUrlTipoValidacionRelacionRepository
{

    public function create(array $datos, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta crear la relación de tipo de validación en la base de datos.
        try {
            $tipoValidacionRelacion = SagrilaftUrlTipoValidacionRelacion::on($connection)->create($datos);
            return $tipoValidacionRelacion;
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada.
            throw new \Exception('Error al crear la relación de tipo de validación: ' . $e->getMessage());
        }
    }
}
