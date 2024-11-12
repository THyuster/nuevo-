<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Repository;

interface ISagrilaftEmpleadoUrlRelacionRepository
{
    /**
     * Verifica si existe un registro por el ID de URL.
     *
     * @param mixed $id El ID de URL a verificar.
     * @param mixed|null $connection La conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error durante la búsqueda.
     * @return bool Retorna verdadero si existe el registro, falso en caso contrario.
     */
    public function existByUrlId($id, $connection = null);
    /**
     * Crea una nueva relación de URL para un empleado en la base de datos.
     *
     * Este método utiliza Eloquent para insertar un nuevo registro en la tabla
     * SagrilaftEmpleadoUrlRelacion. Si ocurre un error durante la creación,
     * se lanzará una excepción con un mensaje descriptivo.
     *
     * @param array $datos Los datos del empleado y su URL que se van a insertar.
     * @param mixed $connection La conexión a la base de datos a utilizar.
     *                          Si no se proporciona, se utiliza la conexión por defecto.
     * 
     * @throws \Exception Si ocurre un error durante la creación de la URL.
     * 
     * @return \App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Response\SagrilaftEmpleadoRelUrlDTO
     * Devuelve la instancia del modelo SagrilaftEmpleadoRelUrlDTO creado.
     */
    public function create(array $datos, $connection = null);
    /**
     * Verifica si existe una relación entre un empleado y una URL en la base de datos.
     *
     * @param string $empleadoId ID del empleado.
     * @param string $urlId ID de la URL.
     * @param string|null $connection (opcional) Nombre de la conexión a la base de datos.
     *                                 Si no se proporciona, se utiliza la conexión predeterminada.
     * @return bool Retorna true si la relación existe, false en caso contrario.
     * @throws \Exception Si ocurre un error durante la búsqueda en la base de datos.
     */
    public function existByEmpleadoIdAndUrlID($empleadoId, $urlId, $connection = null);

    /**
     * Obtiene la relación entre un empleado y sus URLs.
     *
     * @param string $empleadoId ID del empleado.
     * @param string $urlId ID de la url.
     * @param string|null $connection (opcional) Nombre de la conexión a la base de datos.
     *                                 Si no se proporciona, se utiliza la conexión predeterminada.
     * @return \App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Response\SagrilaftEmpleadoRelUrlDTO Retorna un SagrilaftEmpleadoRelUrlDTO.
     * @throws \Exception Si ocurre un error durante la búsqueda en la base de datos.
     */
    public function getByEmpleadoIdAndUrlID($empleadoId, $urlId, $connection = null);
    /**
     * Actualiza una relación entre un empleado y una URL por su ID.
     *
     * @param string $id ID de la relación a actualizar.
     * @param array $data Datos que se utilizarán para la actualización.
     * @param string|null $connection (opcional) Nombre de la conexión a la base de datos.
     *                                 Si no se proporciona, se utiliza la conexión predeterminada.
     * @return bool Retorna true si la actualización fue exitosa, false en caso contrario.
     * @throws \Exception Si ocurre un error durante la actualización en la base de datos.
     */
    public function updateById($id, array $data, $connection = null);

}

