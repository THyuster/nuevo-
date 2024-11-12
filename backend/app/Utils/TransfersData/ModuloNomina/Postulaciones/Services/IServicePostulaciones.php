<?php

namespace App\Utils\TransfersData\ModuloNomina\Postulaciones\Services;

use App\Data\Dtos\Convocatorias\Postulantes\PostulanteRequestDTO;
use App\Data\Dtos\Convocatorias\Postulantes\Request\ConvocatoriaCambioEstadoPostulanteDTO;
use App\Data\Dtos\Response\ResponseDTO;
use Illuminate\Http\JsonResponse;

interface IServicePostulaciones
{
    /**
     * Servicio para crear una nueva postulación.
     *
     * Este método crea una nueva postulación utilizando los datos proporcionados en el
     * objeto `PostulanteRequestDTO`. Opcionalmente, se puede especificar un ID de empresa
     * si la postulación está asociada a una empresa específica.
     *
     * @param \App\Data\Dtos\Convocatorias\Postulantes\PostulanteRequestDTO $postulanteRequestDTO
     *        El objeto que contiene la información necesaria para crear la postulación.
     * @param int|null $empresaId (Opcional) El identificador de la empresa asociada con la postulación.
     * @return ResponseDTO .
     */
    public function create(
        PostulanteRequestDTO $postulanteRequestDTO,
        $empresaId = null
    );
    /**
     * Cambia el estado de la relación entre una convocatoria y un postulante.
     *
     * Este método actualiza el estado de la relación entre una convocatoria y un postulante
     * especificado por el ID de la relación. El nuevo estado se pasa a través del objeto
     * `ConvocatoriaCambioEstadoPostulanteDTO`.
     *
     * @param string $convocatoriaRelacionPostulanteId El identificador único de la relación
     *                                                  entre la convocatoria y el postulante.
     * @param ConvocatoriaCambioEstadoPostulanteDTO $convocatoriaCambioEstadoPostulanteDTO Un objeto
     *                                                                                     que contiene la información sobre el nuevo estado
     *                                                                                     de la relación.
     * @return ResponseDTO
     */
    public function changeStatuConvocatoriaPostulacionRelacion(
        string $convocatoriaRelacionPostulanteId,
        ConvocatoriaCambioEstadoPostulanteDTO $convocatoriaCambioEstadoPostulanteDTO
    ): ResponseDTO;

    /**
     * Obtiene los postulantes asociados a una convocatoria específica.
     * 
     * Este método recupera una lista de postulantes para una convocatoria dada, con la opción de filtrar por el estado del postulante. Los datos recuperados son transformados en objetos `ResponsePostulante` antes de ser devueltos en un objeto `ResponseDTO`.
     * 
     * @param string $idConvocatoria El identificador único de la convocatoria para la que se desean obtener los postulantes.
     * @param  $estadoPostulante El estado del postulante para filtrar los resultados. Si se pasa `null`, no se aplicará filtro por estado.
     * 
     * @return ResponseDTO Un objeto que encapsula la respuesta con un mensaje de éxito y los datos de los postulantes obtenidos. El objeto contiene:
     *         - Un mensaje indicando que los datos fueron traídos exitosamente.
     *         - Una colección de objetos `ResponsePostulante` con la información de los postulantes asociados a la convocatoria.
     */
    public function getPostulantesByIdConvocatoria(string $idConvocatoria, $estadoPostulante = null);
    /**
     * Obtiene los detalles de un postulante a partir de su identificador.
     * 
     * Este método recupera la información de un postulante específico utilizando su identificador único. La información del postulante se transforma en un objeto `ResponsePostulanteConvocatoria` antes de ser devuelta en un objeto `ResponseDTO`.
     * 
     * @param mixed $idPostulante El identificador del postulante para el cual se desea obtener la información. El tipo puede variar según la implementación (e.g., entero, cadena).
     * 
     * @return ResponseDTO Un objeto que encapsula la respuesta con un mensaje de éxito y los datos del postulante obtenidos. El objeto contiene:
     *         - Un mensaje indicando que los datos fueron traídos exitosamente.
     *         - Un objeto `ResponsePostulanteConvocatoria` con la información detallada del postulante.
     */
    public function getPostulanteByID($idPostulante);
}
