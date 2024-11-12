<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Repository;
use App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Response\SagrilaftEmpleadoRelUrlDTO;
use App\Models\Sagrilaft\SagrilaftEmpleadoUrlRelacion;
use App\Utils\Repository\RepositoryDynamicsCrud;

class SagrilaftEmpleadoUrlRelacionRepository implements ISagrilaftEmpleadoUrlRelacionRepository
{
    public function existByUrlId($id, $connection = null)
    {
        // Obtiene la conexión a la base de datos si no se proporciona.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta verificar si el registro existe.
        try {
            return SagrilaftEmpleadoUrlRelacion::on($connection)->where('url_id', $id)->exists();
        } catch (\Exception $e) {
            // Lanza una excepción personalizada si ocurre un error.
            throw new \Exception('Error al buscar el empleado url: ' . $e->getMessage());
        }
    }

    public function create(array $datos, $connection = null)
    {
        // Obtiene la conexión a la base de datos. Si no se proporciona, usa la conexión por defecto.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta crear la relacion del empleado y la url en la base de datos y devuelve una nueva instancia de SagrilaftEmpleadoUrlRelacion.
        try {
            $empleadoUrlRelacion = SagrilaftEmpleadoUrlRelacion::on($connection)->create($datos);
            // return new SagrilaftUrl($url);
            return new SagrilaftEmpleadoRelUrlDTO($empleadoUrlRelacion);
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada si es necesario.
            throw new \Exception('Error al crear la URL: ' . $e->getMessage());
        }
    }

    public function existByEmpleadoIdAndUrlID($empleadoId, $urlId, $connection = null)
    {
        // Obtiene la conexión a la base de datos si no se proporciona.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta verificar si el registro existe.
        try {
            return SagrilaftEmpleadoUrlRelacion::on($connection)
                ->where('url_id', $urlId)
                ->where('empleado_id', $empleadoId)
                ->exists();
        } catch (\Exception $e) {
            // Lanza una excepción personalizada si ocurre un error.
            throw new \Exception('Error al buscar la validación del empleado por url: ' . $e->getMessage());
        }
    }

    public function getByEmpleadoIdAndUrlID($empleadoId, $urlId, $connection = null)
    {
        // Obtiene la conexión a la base de datos si no se proporciona.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta obtener los registros de relación.
        try {
            return new SagrilaftEmpleadoRelUrlDTO(SagrilaftEmpleadoUrlRelacion::on($connection)
                ->where('empleado_id', $empleadoId)
                ->where('url_id', $urlId)
                ->with(['resources'])
                ->first());
        } catch (\Exception $e) {
            // Lanza una excepción personalizada si ocurre un error.
            throw new \Exception('Error al obtener las relaciones del empleado: ' . $e->getMessage());
        }
    }

    public function updateById($id, array $data, $connection = null)
    {
        // Obtiene la conexión a la base de datos si no se proporciona.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta actualizar el registro.
        try {
            $relation = SagrilaftEmpleadoUrlRelacion::on($connection)->find($id);

            if (!$relation) {
                throw new \Exception('Relación no encontrada.');
            }

            return $relation->update($data);
        } catch (\Exception $e) {
            // Lanza una excepción personalizada si ocurre un error.
            throw new \Exception('Error al actualizar la relación del empleado por ID: ' . $e->getMessage());
        }
    }
}
