<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories;
use App\Models\Sagrilaft\SagrilaftUrlRelacion;
use App\Utils\Repository\RepositoryDynamicsCrud;

class RepositoryUrlRelacion implements IRepositoryUrlRelacion
{
    public function insertarRegistros(array $datos, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        $now = now(); // Obtiene la fecha y hora actual

        // Agrega las marcas de tiempo a cada registro
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);

        // Intenta insertar los registros en la base de datos
        try {
            return SagrilaftUrlRelacion::on($connection)->insert($datos);
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada si es necesario.
            throw new \Exception('Error al crear los registros de la relacion de URLs: ' . $e->getMessage());
        }
    }

    public function eliminarRegistrosByUrlId($id, $connection = null): int
    {
        // Obtiene la conexión a la base de datos si no se proporciona.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta eliminar los registros por ID de URL
        try {
            return SagrilaftUrlRelacion::on($connection)
                ->where('sagrilaftUrlId', $id)
                ->delete();
        } catch (\Exception $e) {
            // Lanza una excepción personalizada si ocurre un error
            throw new \Exception('Error al eliminar registros por ID de URL: ' . $e->getMessage());
        }
    }
}
