<?php

namespace App\Http\Controllers\modulo_activos_fijos;

use App\Data\Dtos\ActivosFijos\Equipos\Request\EquiposRequestCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivosFijos\Equipos\EquipoRequestCreate;
use App\Utils\TransfersData\ModuloActivosFijos\IEquiposServices;
use Illuminate\Http\Request;

class activos_fijos_equiposController extends Controller
{
    private IEquiposServices $_equipoServices;

    public function __construct(IEquiposServices $iEquiposServices)
    {
        $this->_equipoServices = $iEquiposServices;
    }

    /**
     * Crea un nuevo equipo con los datos proporcionados en la solicitud.
     *
     * Este método recibe una solicitud para crear un nuevo equipo, convierte los datos de la solicitud a un DTO,
     * y luego llama al servicio correspondiente para realizar la creación. Finalmente, devuelve una respuesta JSON
     * con el resultado de la operación.
     *
     * @param EquipoRequestCreate $equipoRequestCreate La solicitud HTTP que contiene los datos para la creación del equipo.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que incluye el resultado de la operación.
     */
    public function create(EquipoRequestCreate $equipoRequestCreate)
    {
        $activoFijoRequestDTO = new EquiposRequestCreateDTO($equipoRequestCreate);

        if ($equipoRequestCreate->hasFile("ruta_imagen")) {
            $activoFijoRequestDTO->ruta_imagen = $equipoRequestCreate->file("ruta_imagen");
        }

        $responseDTO = $this->_equipoServices->create($activoFijoRequestDTO);

        return response()->json($responseDTO, $responseDTO->code);
    }

    /**
     * Recupera y devuelve los datos formateados para un datatable.
     *
     * Este método obtiene la respuesta formateada para un datatable a través del servicio correspondiente
     * y devuelve la respuesta en formato JSON. Los datos incluyen información como el total de registros,
     * el número de registros filtrados, y los datos solicitados con paginación, búsqueda y ordenación aplicadas.
     *
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene los datos formateados para el datatable.
     */
    public function retrieveDatatableData()
    {
        $datatableDTO = $this->_equipoServices->getDatatableResponse();
        return response()->json($datatableDTO);
    }

    /**
     * Obtiene los activos fijos filtrados según la solicitud.
     *
     * Este método recibe una solicitud HTTP que puede contener un filtro para buscar activos fijos.
     * Si se proporciona un filtro, se busca en los datos de los equipos fijos usando el servicio correspondiente.
     * La respuesta se devuelve en formato JSON.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene el filtro de búsqueda.
     * @return \Illuminate\Http\JsonResponse La respuesta en formato JSON que contiene los resultados de la búsqueda.
     */
    public function fetchActivosFijosByFilter(Request $request)
    {
        $filter = $request->input('filter', null);

        if (!$filter) {
            return response()->json();
        }

        $collection = $this->_equipoServices->searchEquiposByFilter($filter);

        return response()->json($collection);
    }
    /**
     * Actualiza un equipo existente con los datos proporcionados en el DTO.
     *
     * Este método toma el ID del equipo y los datos de la solicitud para actualizar el equipo correspondiente.
     * Luego, utiliza el servicio para realizar la actualización y devolver una respuesta adecuada.
     *
     * @param EquipoRequestCreate $equipoRequestCreate La solicitud HTTP que contiene los datos para la actualización.
     * @param string $id El identificador del equipo a actualizar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con el resultado de la operación.
     */
    public function update(EquipoRequestCreate $equipoRequestCreate, string $id)
    {
        $activoFijoRequestDTO = new EquiposRequestCreateDTO($equipoRequestCreate);

        if ($equipoRequestCreate->hasFile("ruta_imagen")) {
            $activoFijoRequestDTO->ruta_imagen = $equipoRequestCreate->file("ruta_imagen");
        }

        $responseDTO = $this->_equipoServices->update($id, $activoFijoRequestDTO);

        return response()->json($responseDTO, $responseDTO->code, [
            "accept" => "application/json",
            "content-type" => "application/json"
        ]);
    }
    /**
     * Obtiene los detalles de un equipo por su ID y devuelve la información en formato JSON.
     *
     * Este método utiliza el servicio de equipos para recuperar los detalles completos de un equipo basado
     * en su ID. Luego, devuelve la información en formato JSON, adecuada para su uso en una API.
     *
     * @param int $id El ID del equipo cuya información se desea recuperar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene los detalles del equipo.
     */
    public function getEquipoDetailsById($id)
    {
        $equipoResponseDTO = $this->_equipoServices->retrieveEquipoDetailsById($id);
        return response()->json($equipoResponseDTO);
    }

    public function destroy($id)
    {
        return $this->_equipoServices->delete($id);
    }
    /**
     * Actualiza el estado de un equipo basado en su ID.
     *
     * Este método delega la actualización del estado de un equipo al servicio correspondiente.
     * Llama a la función `toggleEquipoStatusById` del servicio para alternar el estado del equipo
     * identificado por el ID proporcionado. Retorna el resultado de la operación de actualización.
     *
     * @param mixed $id El ID del equipo cuyo estado se desea actualizar.
     * @return bool|int|mixed|\Illuminate\Http\JsonResponse El resultado de la operación de actualización, que puede incluir:
     *         - Un valor booleano si se trata de una operación simple.
     *         - Un entero o valor mixto dependiendo de la implementación del servicio.
     *         - Una respuesta JSON si el servicio devuelve una respuesta JSON.
     */
    public function updateEquipoStatus($id)
    {
        return $this->_equipoServices->toggleEquipoStatusById($id);
    }
}
