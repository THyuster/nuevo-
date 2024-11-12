<?php

namespace App\Utils\TransfersData\ModuloActivosFijos;
use App\Data\Dtos\ActivosFijos\Equipos\Request\EquiposRequestCreateDTO;

interface IEquiposServices
{
    /**
     * Obtiene una respuesta formateada para un datatable.
     *
     * Este método construye una respuesta para un datatable que incluye la cantidad total de registros,
     * la cantidad de registros filtrados, y los datos solicitados con paginación, búsqueda y ordenación
     * aplicadas según la solicitud HTTP. La respuesta está encapsulada en un objeto `DatatableResponseDTO`.
     *
     * @return \App\Data\Dtos\Datatable\DatatableResponseDTO Un objeto que contiene los datos del datatable, incluyendo:
     *                              - `recordsTotal`: Total de registros disponibles.
     *                              - `recordsFiltered`: Total de registros después de aplicar filtros.
     *                              - `draw`: Número de dibujo (para manejo de solicitudes de datatable).
     *                              - `data`: Datos de los registros filtrados y ordenados.
     */
    public function getDatatableResponse();
    /**
     * Crea un nuevo equipo utilizando los datos proporcionados en el DTO.
     *
     * Este método realiza varias validaciones antes de crear el equipo:
     * - Verifica si el código del equipo ya está registrado.
     * - Valida la existencia de terceros, grupo de equipo, marca, combustible y centro de trabajo.
     * - Maneja la subida de una imagen asociada al equipo.
     * - Finalmente, crea el equipo en la base de datos y devuelve un objeto `ResponseDTO` con el resultado de la operación.
     *
     * @param EquiposRequestCreateDTO $equiposRequestCreateDTO DTO con los datos necesarios para la creación del equipo.
     * @return \App\Data\Dtos\Response\ResponseDTO Un objeto `ResponseDTO` con el estado de la operación, mensaje, y datos asociados.
     */
    public function create(EquiposRequestCreateDTO $equiposRequestCreateDTO);
    /**
     * Actualiza un equipo existente con los datos proporcionados en el DTO.
     *
     * Este método realiza varias validaciones antes de actualizar el equipo:
     * - Verifica si el equipo existe.
     * - Valida la existencia de terceros y del grupo de equipo.
     * - Comprueba la unicidad del código del equipo.
     * - Maneja la subida de una imagen asociada al equipo.
     * - Finalmente, actualiza el equipo en la base de datos y devuelve un objeto `ResponseDTO` con el resultado de la operación.
     *
     * @param mixed $id Identificador del equipo a actualizar.
     * @param EquiposRequestCreateDTO $equiposRequestCreateDTO DTO con los datos necesarios para la actualización del equipo.
     * @return \App\Data\Dtos\Response\ResponseDTO Un objeto `ResponseDTO` con el estado de la operación, mensaje, y datos asociados.
     */
    public function update($id, EquiposRequestCreateDTO $equiposRequestCreateDTO);
    public function delete($id);
    public function toggleEquipoStatusById($id);
    /**
     * Busca equipos fijos en base a un filtro aplicado a múltiples campos.
     *
     * Este método utiliza un filtro de búsqueda para encontrar equipos fijos en la base de datos
     * que coincidan parcialmente con el término de búsqueda en los campos especificados. Los campos
     * en los que se realiza la búsqueda incluyen `codigo`, `descripcion`, `serial_interno`, y `serial_equipo`.
     *
     * @param string $filter El término de búsqueda que se aplicará a los campos especificados.
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     *         Una colección de resultados que coinciden con el filtro, que puede ser un array de modelos
     *         o una instancia de `Collection` si se encuentran varios registros.
     */
    public function searchEquiposByFilter($filter);
    /**
     * Recupera los detalles del equipo y su grupo asociado por ID.
     *
     * Este método obtiene los detalles de un equipo fijo a partir de su ID, utilizando almacenamiento en caché
     * para mejorar el rendimiento y reducir las consultas a la base de datos. Primero, se recupera la información
     * del equipo y luego se obtiene la descripción del grupo al que pertenece el equipo. Los resultados se
     * almacenan en caché para optimizar el tiempo de respuesta en futuras solicitudes.
     *
     * @param int $id El ID del equipo cuyo detalle se desea recuperar.
     * @return \App\Data\Dtos\ActivosFijos\Equipos\Responses\EquipoResponseDTO Un objeto `EquipoResponseDTO` que contiene la información del equipo y la descripción del grupo.
     */
    public function retrieveEquipoDetailsById($id);
}
