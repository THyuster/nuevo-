<?php

namespace App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\Repository;

use App\Data\Dtos\Logistica\Vehiculos\Responses\VehiculosResponseDTO;
use App\Models\modulo_logistica\logistica_vehiculos as LogisticaVehiculos;

interface IRepositoryVehiculo
{
    /**
     * Crea un nuevo registro de vehículo.
     * 
     * @param array $vehiculo Datos del vehículo
     * @return \App\Data\Dtos\Logistica\Vehiculos\Responses\VehiculosResponseDTO
     */
    public function create(array $vehiculo): VehiculosResponseDTO;
    /**
     * Verifica si un vehículo con una placa específica existe.
     * 
     * @param string $placa Placa del vehículo
     * @return bool
     */
    public function vehiculoExistsByPlaca(string $placa): bool;
    /**
     * Obtiene un vehículo por su ID.
     * 
     * @param int $vehiculoId ID del vehículo
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getVehiculoById(int $vehiculoId): ?LogisticaVehiculos;
    /**
     * Verifica si una placa ya existe para un vehículo diferente.
     * 
     * @param int $vehiculoId ID del vehículo
     * @param string $placa Placa del vehículo
     * @return bool
     */
    public function placaExistsById(int $vehiculoId, string $placa): bool;
    /**
     * Actualiza los datos de un vehículo existente.
     * 
     * @param int $vehiculoId ID del vehículo
     * @param array $datos Datos a actualizar
     * @return bool
     */
    public function update(int $vehiculoId, array $datos): bool;
    /**
     * Obtiene una colección de vehículos por su placa.
     * 
     * @param string $placa Placa del vehículo
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVehiculosByPlaca(string $placa): \Illuminate\Database\Eloquent\Collection;
    /**
     * Elimina un vehículo por su ID.
     *
     * @param int $vehiculoId ID del vehículo a eliminar
     * @return bool Retorna true si la eliminación fue exitosa, false si el vehículo no se encuentra
     */
    public function deleteById(int $vehiculoId): bool;
    /**
     * Obtiene vehículos y terceros asociados a una placa específica.
     *
     * @param string $placa Placa para buscar en vehículos y terceros
     * @return array Lista de vehículos con información relevante
     */
    public function obtenerVehiculosYPropietariosPorPlaca($placa);
}
