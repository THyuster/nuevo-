<?php

namespace App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\Repository;

use App\Data\Dtos\Logistica\Vehiculos\Responses\VehiculosResponseDTO;
use App\Models\modulo_logistica\logistica_vehiculos as LogisticaVehiculos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Contracts\Database\Query\Builder;
// use Illuminate\Contracts\Database\Eloquent\Builder;

class RepositoryVehiculo extends RepositoryDynamicsCrud implements IRepositoryVehiculo
{
    /**
     * Crea un nuevo registro de vehículo.
     * 
     * @param array $vehiculo Datos del vehículo
     * @return VehiculosResponseDTO
     */
    public function create(array $vehiculo): VehiculosResponseDTO
    {
        $connection = $this->findConectionDB(); // Renombrado para seguir convenciones
        $logisticaVehiculos = LogisticaVehiculos::on($connection)->create($vehiculo);
        return new VehiculosResponseDTO($logisticaVehiculos);
    }

    /**
     * Verifica si un vehículo con una placa específica existe.
     * 
     * @param string $placa Placa del vehículo
     * @return bool
     */
    public function vehiculoExistsByPlaca(string $placa): bool
    {
        $connection = $this->findConectionDB();
        return LogisticaVehiculos::on($connection)->where('placa', $placa)->exists();
    }

    /**
     * Obtiene un vehículo por su ID.
     * 
     * @param int $vehiculoId ID del vehículo
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getVehiculoById(int $vehiculoId): ?LogisticaVehiculos
    {
        $connection = $this->findConectionDB();
        return LogisticaVehiculos::on($connection)->find($vehiculoId);
    }

    /**
     * Verifica si una placa ya existe para un vehículo diferente.
     * 
     * @param int $vehiculoId ID del vehículo
     * @param string $placa Placa del vehículo
     * @return bool
     */
    public function placaExistsById(int $vehiculoId, string $placa): bool
    {
        $connection = $this->findConectionDB();
        return LogisticaVehiculos::on($connection)
            ->where('id', '<>', $vehiculoId)
            ->where('placa', $placa)
            ->exists();
    }

    /**
     * Actualiza los datos de un vehículo existente.
     * 
     * @param int $vehiculoId ID del vehículo
     * @param array $datos Datos a actualizar
     * @return bool
     */
    public function update(int $vehiculoId, array $datos): bool
    {
        $connection = $this->findConectionDB();
        $vehiculo = LogisticaVehiculos::on($connection)->find($vehiculoId);
        return $vehiculo ? $vehiculo->update($datos) : false;
    }

    /**
     * Obtiene una colección de vehículos por su placa.
     * 
     * @param string $placa Placa del vehículo
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVehiculosByPlaca(string $placa): \Illuminate\Database\Eloquent\Collection
    {
        $connection = $this->findConectionDB();
        return LogisticaVehiculos::on($connection)->where('placa', $placa)->get();
    }
    /**
     * Elimina un vehículo por su ID.
     *
     * @param int $vehiculoId ID del vehículo a eliminar
     * @return bool Retorna true si la eliminación fue exitosa, false si el vehículo no se encuentra
     */
    public function deleteById(int $vehiculoId): bool
    {
        $connection = $this->findConectionDB(); // Obtiene la conexión a la base de datos
        $vehiculo = LogisticaVehiculos::on($connection)->find($vehiculoId); // Busca el vehículo por ID
        return $vehiculo ? $vehiculo->delete() : false;
    }
    /**
     * Obtiene vehículos y terceros asociados a una placa específica.
     *
     * @param string $placa Placa para buscar en vehículos y terceros
     * @return array Lista de vehículos con información relevante
     */
    public function obtenerVehiculosYPropietariosPorPlaca($placa)
    {

        $connection = $this->findConectionDB(); // Obtiene la conexión a la base de datos
        $placa = "%$placa%";

        return \DB::connection($connection)
            ->table('logistica_vehiculos as lv')
            ->join('contabilidad_terceros as ct', 'ct.identificacion', '=', 'lv.tercero_propietario_id')
            ->where(function (Builder $query) use ($placa) {
                $query->where('lv.placa', 'like', $placa)
                    ->orWhere('ct.identificacion', 'like', $placa)
                    ->orWhere('ct.nombre_completo', 'like', $placa);
            })
            ->select('lv.placa', 'ct.identificacion', 'ct.nombre_completo')
            ->get()
            ->toArray();
    }
}
