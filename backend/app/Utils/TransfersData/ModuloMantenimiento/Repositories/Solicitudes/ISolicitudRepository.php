<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Repositories\Solicitudes;
use App\Models\modulo_mantenimiento\mantenimiento_solicitudes as solicitud;

interface ISolicitudRepository
{
    /**
     * Crea un nuevo registro `solicitud`.
     *
     * @param array $datos Los datos para el nuevo registro.
     * @param string|null $connection La conexión de base de datos (opcional).
     * @return solicitud El modelo creado.
     * @throws \RuntimeException Si ocurre un error al crear el registro.
     */
    public function create(array $datos, $connection = null);
    /**
     * Actualiza un registro `solicitud` existente.
     *
     * @param int $id El ID del registro a actualizar.
     * @param array $datos Los datos actualizados.
     * @param string|null $connection La conexión de base de datos (opcional).
     * @return bool Verdadero si la actualización fue exitosa, falso de lo contrario.
     * @throws \RuntimeException Si ocurre un error al actualizar el registro o si no se encuentra el registro.
     */
    public function updateById($id, array $datos, $connection = null);
    /**
     * Obtiene un registro `solicitud` por su ID.
     *
     * @param int $id El ID del registro a obtener.
     * @param string|null $connection La conexión de base de datos (opcional).
     * @return \Illuminate\Database\Eloquent\Model|null El modelo encontrado o null si no se encuentra.
     * @throws \RuntimeException Si ocurre un error al obtener el registro.
     */
    public function getById($id, $connection = null);
    /**
     * Elimina un registro `solicitud` por su ID.
     *
     * @param int $id El ID del registro a eliminar.
     * @param string|null $connection La conexión de base de datos (opcional).
     * @return bool Verdadero si la eliminación fue exitosa, falso de lo contrario.
     * @throws \RuntimeException Si ocurre un error al eliminar el registro o si no se encuentra el registro.
     */
    public function deleteById($id, $connection = null);
    /**
     * Verifica si un registro `solicitud` existe por su ID.
     *
     * @param int $id El ID del registro a verificar.
     * @param string|null $connection La conexión de base de datos (opcional).
     * @return bool Verdadero si el registro existe, falso de lo contrario.
     * @throws \RuntimeException Si ocurre un error al verificar la existencia del registro.
     */
    public function existById($id, $connection = null);
    /**
     * Obtiene una solicitud con detalles adicionales a partir del ID proporcionado.
     *
     * Este método consulta la base de datos para recuperar una solicitud utilizando el ID
     * proporcionado. Incluye datos relacionados, tales como el estado, tercero, centro de trabajo,
     * prioridad, tipo de solicitud, equipo, vehículo y usuario asociado. La consulta se realiza
     * en la conexión de base de datos especificada o en la conexión por defecto si no se especifica.
     *
     * @param mixed $id El ID de la solicitud que se desea obtener. Este valor se utiliza para filtrar
     *                  la consulta y buscar la solicitud específica.
     * @param mixed $connection (Opcional) La conexión de base de datos que se debe usar para la consulta.
     *                          Si no se proporciona, se utilizará la conexión por defecto.
     *
     * @return \Illuminate\Database\Eloquent\Model|null Retorna un modelo de `Solicitud` con los datos
     *                                                   solicitados o `null` si no se encuentra la
     *                                                   solicitud con el ID proporcionado.
     */
    public function obtenerSolicitudConDetalles($id, $connection = null);

    public function getBySolicitudId(string $solicitudId);

}
