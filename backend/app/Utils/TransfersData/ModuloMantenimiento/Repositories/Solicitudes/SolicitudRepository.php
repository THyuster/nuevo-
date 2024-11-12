<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Repositories\Solicitudes;
use App\Models\modulo_mantenimiento\mantenimiento_solicitudes as solicitud;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class SolicitudRepository implements ISolicitudRepository
{

    public function create(array $datos, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            return solicitud::on($connection)->create($datos);
        } catch (Exception $e) {
            // Manejar la excepción (e.g., registrar el error, volver a lanzar la excepción, etc.)
            throw new \RuntimeException('Error al crear el registro: ' . $e->getMessage());
        }
    }


    public function updateById($id, array $datos, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            $registro = solicitud::on($connection)->find($id);
            if (!$registro) {
                throw new \RuntimeException('Registro no encontrado.');
            }
            return $registro->update($datos);
        } catch (Exception $e) {
            // Manejar la excepción (e.g., registrar el error, volver a lanzar la excepción, etc.)
            throw new \RuntimeException('Error al actualizar el registro: ' . $e->getMessage());
        }
    }


    public function deleteById($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            $registro = solicitud::on($connection)->find($id);
            if (!$registro) {
                throw new \RuntimeException('Registro no encontrado.');
            }
            return $registro->delete();
        } catch (Exception $e) {
            // Manejar la excepción (e.g., registrar el error, volver a lanzar la excepción, etc.)
            throw new \RuntimeException('Error al eliminar el registro: ' . $e->getMessage());
        }
    }


    public function getById($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            $registro = solicitud::on($connection)->find($id);
            if (!$registro) {
                throw new \RuntimeException('Registro no encontrado.');
            }
            return $registro;
        } catch (Exception $e) {
            // Manejar la excepción (e.g., registrar el error, volver a lanzar la excepción, etc.)
            throw new \RuntimeException('Error al obtener el registro: ' . $e->getMessage());
        }
    }


    public function existById($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            $registro = solicitud::on($connection)->find($id);
            return $registro ? $registro->exists() : false;
        } catch (Exception $e) {
            // Manejar la excepción (e.g., registrar el error, volver a lanzar la excepción, etc.)
            throw new \RuntimeException('Error al verificar la existencia del registro: ' . $e->getMessage());
        }
    }

    public function obtenerSolicitudConDetalles($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        $solicitud = Solicitud::on($connection)->with([
            'estado:id,nombre',
            'tercero:id,identificacion,nombre1,nombre2,apellido1,apellido2,movil',
            'centroTrabajo:id,descripcion',
            'prioridad:id,nombre',
            'tipoSolicitud:id,descripcion',
            'equipo:codigo,codigo',  // Usualmente código es único, puede que solo necesites esto.
            'vehiculo:placa,placa',  // Lo mismo para placa
            'usuario:id,name,email'
        ])->where('id_solicitud', $id)
            ->first();

        return $solicitud;
    }

    public function getBySolicitudId(string $solicitudId, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        try {
            //code...
            $registro = solicitud::on($connection)->where('id_solicitud', $solicitudId)->first();
            
            if (!$registro) {
                throw new \RuntimeException('Registro no encontrado.');
            }
            
            return $registro;
        } catch (Exception $e) {
            // Manejar la excepción (e.g., registrar el error, volver a lanzar la excepción, etc.)
            throw new \RuntimeException('Error al obtener el registro: ' . $e->getMessage());
        }
    }
}

