<?php
namespace App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos;

use App\Data\Dtos\Logistica\Vehiculos\Request\VehiculosRequestCreateDTO;
use Illuminate\Http\JsonResponse;

interface IServicesVehiculos
{
    /**
     * Crea un nuevo vehículo en el sistema.
     *
     * @param \App\Data\Dtos\Logistica\Vehiculos\Request\VehiculosRequestCreateDTO $vehiculosRequestCreateDTO Datos para la creación del vehiculo
     * @throws \Exception Si ocurre un error al crear el vehículo o validar datos
     * @return \Illuminate\Http\JsonResponse
     */
    public function crearVehiculo(VehiculosRequestCreateDTO $vehiculosRequestCreateDTO);
    /**
     * Actualiza un vehículo en el sistema.
     *
     * @param int $id ID del vehículo a actualizar
     * @param \App\Data\Dtos\Logistica\Vehiculos\Request\VehiculosRequestCreateDTO $vehiculosRequestCreateDTO Datos para la actualización del vehículo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception Si ocurre un error durante la actualización o validación
     */
    public function actualizarVehiculo(int $id, VehiculosRequestCreateDTO $vehiculosRequestCreateDTO);
    /**
     * Elimina un vehículo por su ID.
     *
     * @param int $id ID del vehículo a eliminar 
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception Si ocurre un error durante la eliminación
     */
    public function eliminarVehiculo(int $id);
    /**
     * Cambia el estado de un vehículo por su ID.
     *
     * @param int $id ID del vehículo cuyo estado se va a actualizar
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception Si ocurre un error durante la actualización
     */
    public function estadoVehiculo(int $id);
    /**
     * Obtiene los vehículos con soporte para búsqueda, ordenación y paginación.
     * @return JsonResponse La respuesta en formato JSON que contiene los datos de la tabla,
     *                       el número total de registros y el número de registros filtrados.
     */
    public function getVehiculos();
    /**
     * Obtiene vehículos por placa.
     *
     * @param string $placa Placa del vehículo para la búsqueda
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetVehiculoByPlaca(string $placa);
    /**
     * Obtiene vehículos y propietarios asociados a una placa específica.
     *
     * @param string $placa Placa para buscar en vehículos y propietarios
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerVehiculosYPropietariosPorPlaca(string $placa): JsonResponse;
}