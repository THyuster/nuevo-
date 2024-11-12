<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Data\Dtos\Solicitudes\Request\RequestCreateSolicitudDTO;
use Illuminate\Http\Request;

interface IServicesSolicitudes
{
    /**
     * Crea una nueva solicitud a partir de los datos proporcionados.
     *
     * Este método valida los datos de entrada, maneja la subida de imágenes y crea una nueva solicitud
     * en la base de datos. Si se proporciona una imagen, se intenta almacenar en una ubicación específica.
     * La función también valida que solo se haya seleccionado un tipo de entidad (equipo o vehículo) y que
     * al menos uno de ellos esté presente.
     *
     * @param \App\Data\Dtos\Solicitudes\Request\RequestCreateSolicitudDTO $requestCreateSolicitudDTO
     *   Un objeto DTO (Data Transfer Object) que contiene los datos necesarios para crear la solicitud.
     *
     * @throws \Exception
     *   Lanza una excepción si se detectan conflictos en los datos de entrada, como la selección de
     *   ambos tipos de entidad (equipo y vehículo) o ninguno de ellos.
     *
     * @return \App\Models\modulo_mantenimiento\mantenimiento_solicitudes
     *   Retorna el objeto creado de tipo `mantenimiento_solicitudes` si la creación es exitosa.
     *   Si hay un problema al subir la imagen, retorna un mensaje de error.
     */
    public function crearSolicitud(RequestCreateSolicitudDTO $requestCreateSolicitudDTO);
    public function actualizarSolicitud(RequestCreateSolicitudDTO $requestCreateSolicitudDTO, $id);
    public function eliminarSolicitud(int $id);
    /**
     * Recupera y procesa datos para una DataTable en respuesta a una solicitud AJAX.
     *
     * Este método es responsable de obtener, filtrar, ordenar y paginar
     * datos desde una vista en la base de datos y formatearlos para su uso en una DataTable.
     * También incluye funcionalidad para aplicar filtros y ordenamientos específicos del usuario
     * basados en los parámetros de la solicitud.
     *
     * @return \App\Data\Dtos\Datatable\DatatableResponseDTO
     *   Una instancia de DatatableResponseDTO que contiene los datos necesarios para la DataTable.
     *   - recordsTotal: Número total de registros disponibles en la base de datos.
     *   - draw: Contador de la solicitud (draw) para la DataTable.
     *   - recordsFiltered: Número de registros que coincidesn con los criterios de filtro.
     *   - data: Array de registros transformados adecuados para la visualización en la DataTable.
     */
    public function getSolicitudesDatatable();
    public function getCamposSelectores();
    public function getTerceros();
    // public function getSolicitudID(int $id);
    public function getSolicitudById($id);
    public function actualizarEstadoSolicitud($id, $estado);
    public function solicitudFirmar($id, Request $request);

}
