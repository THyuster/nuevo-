<?php

namespace App\Http\Controllers\modulo_nomina\Postulantes;

use App\Data\Dtos\Convocatorias\Postulantes\PostulanteRequestDTO;
use App\Data\Dtos\Convocatorias\Postulantes\Request\ConvocatoriaCambioEstadoPostulanteDTO;
use App\Data\Dtos\Response\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\NominaRequest\NominaConvocatoriaCambioEstadoPostulanteRequest;
use App\Http\Requests\NominaRequest\NominaPostulantesRequestCreate;
use App\Utils\TransfersData\ModuloNomina\Postulaciones\Services\IServicePostulaciones;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class postulanteController extends Controller
{
    protected IServicePostulaciones $_servicePostulaciones;
    public function __construct(IServicePostulaciones $iServicePostulaciones)
    {
        $this->_servicePostulaciones = $iServicePostulaciones;
    }

    /**
     * Creación de una postulación
     * @param \App\Http\Requests\NominaRequest\NominaPostulantesRequestCreate $nominaPostulantesRequestCreate Objeto de solicitud que contiene los datos necesarios para crear una nueva postulación.
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que indica el resultado de la operación de creación de la postulación.
     */
    public function store(NominaPostulantesRequestCreate $nominaPostulantesRequestCreate)
    {
        $empresaId = $nominaPostulantesRequestCreate->query('empId', null); // Esto obtiene el valor de empId=28 de la URL

        $usuario = auth()->user();
        $postulanteDTO = new PostulanteRequestDTO($nominaPostulantesRequestCreate->all());

        if ($usuario) {
            $responseDTO = $this->_servicePostulaciones->create($postulanteDTO);
            return response()->json($responseDTO, $responseDTO->code);
        }

        if (!$empresaId) {
            return response()->json(new ResponseDTO(
                "Se ha mandado la empresa para la postulación",
                false,
                Response::HTTP_NOT_ACCEPTABLE
            ), Response::HTTP_NOT_ACCEPTABLE);
        }

        $responseDTO = $this->_servicePostulaciones->create($postulanteDTO, $empresaId);
        return response()->json($responseDTO, $responseDTO->code);
    }
    /**
     * Cambia el estado de la postulación de un postulante en una convocatoria.
     *
     * @param \App\Http\Requests\NominaRequest\NominaConvocatoriaCambioEstadoPostulanteRequest $request Objeto de solicitud que contiene los datos necesarios para cambiar el estado del postulante.
     * @param string $id El identificador del postulante cuyo estado se desea cambiar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que indica el resultado de la operación.
     */
    public function statu(NominaConvocatoriaCambioEstadoPostulanteRequest $nominaConvocatoriaCambioEstadoPostulanteRequest, string $id)
    {
        //code
        $convocatoriaCambioEstadoPostulanteDTO = new ConvocatoriaCambioEstadoPostulanteDTO($nominaConvocatoriaCambioEstadoPostulanteRequest->all());
        $responseDTO = $this->_servicePostulaciones->changeStatuConvocatoriaPostulacionRelacion($id, $convocatoriaCambioEstadoPostulanteDTO);
        return response()->json($responseDTO, $responseDTO->code);
    }

    /**
     * Obtiene los postulantes asociados a una convocatoria específica.
     *
     * @param string $convocatoriaId El identificador de la convocatoria cuyos postulantes se desean recuperar.
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que contiene los datos de los postulantes asociados con la convocatoria especificada.
     */
    public function show(string $convocatoriaId, Request $request)
    {
        $estadoPostulante = $request->input('estado', null);
        // return $estadoPostulante;
        if ($estadoPostulante !== null && $estadoPostulante != "all") {
            if ($estadoPostulante === 'true' || $estadoPostulante === 'false') {
                $estadoPostulante = filter_var($estadoPostulante, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            } else {
                $responseDTO = new ResponseDTO('Error: El estado del postulante debe ser "true" o "false".', null, Response::HTTP_NOT_FOUND);
                return response()->json($responseDTO, $responseDTO->code);
            }
        }

        // return $estadoPostulante;
        $responseDTO = $this->_servicePostulaciones->getPostulantesByIdConvocatoria($convocatoriaId, $estadoPostulante);

        return response()->json($responseDTO, $responseDTO->code);
    }
    /**
     * Obtiene la información de un postulante por su identificador.
     *
     * @param string $id El identificador del postulante cuya información se desea recuperar.
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que contiene los datos del postulante.
     */
    public function postulante(string $id)
    {
        $responseDTO = $this->_servicePostulaciones->getPostulanteByID($id);
        return response()->json($responseDTO, $responseDTO->code);
    }

}
