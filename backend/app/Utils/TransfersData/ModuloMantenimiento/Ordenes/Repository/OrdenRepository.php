<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Ordenes\Repository;
use App\Models\modulo_mantenimiento\Ordenes;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;

class OrdenRepository implements IOrdenRepository
{
    public function create(array $datos, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            return Ordenes::on($connection)->create($datos);
        } catch (Exception $e) {
            throw new \RuntimeException('Error al crear el registro: ' . $e->getMessage());
        }
    }
    public function updateById($id, array $datos, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        try {
            $registro = Ordenes::on($connection)->find($id);
            if (!$registro) {
                throw new \RuntimeException('Registro no encontrado.');
            }
            return $registro->update($datos);
        } catch (Exception $e) {
            // Manejar la excepción (e.g., registrar el error, volver a lanzar la excepción, etc.)
            throw new \RuntimeException('Error al actualizar el registro: ' . $e->getMessage());
        }

        // return Ordenes::on($connection)->find($id)->update($datos);
    }
    public function deleteById($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            $registro = Ordenes::on($connection)->find($id);
            if (!$registro) {
                throw new \RuntimeException('Registro no encontrado.');
            }
            return $registro->delete();
        } catch (Exception $e) {
            throw new \RuntimeException('Error al eliminar el registro: ' . $e->getMessage());
        }
    }

    public function getByIdSolicitud($idSolicitud, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            $registro = Ordenes::on($connection)->where('solicitud_id', $idSolicitud)->first();
            return $registro;
        } catch (Exception $e) {
            throw new \RuntimeException('Error al buscar el registro: ' . $e->getMessage());
        }
    }
}
