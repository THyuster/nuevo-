<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Repository;
use App\Models\Sagrilaft\SagrilaftEmpleadoRecursos;
use App\Utils\Repository\RepositoryDynamicsCrud;

class SagrilaftEmpleadoRecursosRepository implements ISagrilaftEmpleadoRecursosRepository
{
    public function crearRegistros(array $datos, $connection = null)
    {
        // Obtiene la conexión a la base de datos, o la predeterminada si no se proporciona
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        try {
            // Obtiene la fecha y hora actual
            $now = now();

            // Agrega las marcas de tiempo a cada registro
            $datos = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    // Asigna las marcas de tiempo 'created_at' y 'updated_at'
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $datos);

            // Realiza la inserción de los registros en la base de datos
            return SagrilaftEmpleadoRecursos::on($connection)->insert($datos);
        } catch (\Exception $th) {
            // Lanza una excepción si ocurre un error durante la inserción
            throw new \Exception("Error al crear los recursos de la validación empleado");
        }
    }
}
