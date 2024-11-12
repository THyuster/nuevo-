<?php

namespace App\Http\Controllers\modulo_sagrilaft;

use App\Data\Dtos\Sagrilaft\Validacion\Url\Request\SagrilaftUrlRequestCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sagrilaft\Url\RequestCreateSagrilaftUrl;
use App\Utils\TransfersData\Sagrilaft\Urls\Services\Urls\IServiceSagrilaftUrl;
use Illuminate\Http\Request;

class sagrilaftUrlController extends Controller
{

    protected IServiceSagrilaftUrl $serviceSagrilaftUrl;
    public function __construct(IServiceSagrilaftUrl $iServiceSagrilaftUrl)
    {
        $this->serviceSagrilaftUrl = $iServiceSagrilaftUrl;
    }

    /**
     * Almacena un nuevo recurso en almacenamiento.
     *
     * Este método crea una nueva URL a partir de los datos del request
     * y devuelve una respuesta JSON con el resultado de la operación.
     *
     * @param \App\Http\Requests\Sagrilaft\Url\RequestCreateSagrilaftUrl $requestCreateSagrilaftUrl
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la creación.
     */
    public function store(RequestCreateSagrilaftUrl $requestCreateSagrilaftUrl)
    {
        // Convierte el request a un DTO.
        $requestCreateSagrilaftUrlDTO = new SagrilaftUrlRequestCreateDTO($requestCreateSagrilaftUrl);

        // Llama al servicio para crear la URL.
        $responseDTO = $this->serviceSagrilaftUrl->create($requestCreateSagrilaftUrlDTO);

        // Devuelve la respuesta como JSON con el código de estado correspondiente.
        return response()->json($responseDTO, $responseDTO->code);
    }

    /**
     * Muestra todos los recursos especificados.
     *
     * Este método obtiene una lista de URLs almacenadas y devuelve
     * una respuesta JSON con la información.
     *
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con la lista de URLs.
     */
    public function show()
    {
        // Obtiene la tabla de URLs desde el servicio.
        $responseDTO = $this->serviceSagrilaftUrl->getTable();

        // Devuelve la respuesta como JSON.
        return response()->json($responseDTO);
    }
    /**
     * Elimina un registro por su ID y devuelve una respuesta JSON.
     *
     * @param mixed $id El ID del registro a eliminar.
     * @return \Illuminate\Http\JsonResponse La respuesta en formato JSON.
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        // Llama al servicio para eliminar el registro
        $responseDTO = $this->serviceSagrilaftUrl->delete($id);

        // Retorna la respuesta en formato JSON con el código correspondiente
        return response()->json($responseDTO, $responseDTO->code);
    }
}
