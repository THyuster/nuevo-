<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\TipoValidaciones;
use App\Models\Sagrilaft\SagrilaftUrlTipoValidacion;
use App\Utils\Repository\RepositoryDynamicsCrud;

class SagrilaftTipoValidacionRepository implements ISagrilaftTipoValidacionRepository
{

    public function create(array $datos, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta crear el tipo de validación en la base de datos.
        try {
            return SagrilaftUrlTipoValidacion::on($connection)->create($datos);
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada.
            throw new \Exception('Error al crear el tipo de validación: ' . $e->getMessage());
        }
    }

    public function existById($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta verificar si el tipo de validación existe.
        try {
            return SagrilaftUrlTipoValidacion::on($connection)->where('id', $id)->exists();
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada.
            throw new \Exception('Error al buscar el tipo de validación: ' . $e->getMessage());
        }
    }

    public function getAll($connection = null)
    {
        // Obtiene la conexión a la base de datos. Si no se proporciona, usa la conexión por defecto.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta recuperar los tipos de validación desde la base de datos.
        try {
            return SagrilaftUrlTipoValidacion::on($connection)->get();
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada.
            throw new \Exception('Error al buscar los tipos de validación: ' . $e->getMessage());
        }
    }
}

