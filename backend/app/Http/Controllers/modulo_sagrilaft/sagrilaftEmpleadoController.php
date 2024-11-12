<?php

namespace App\Http\Controllers\modulo_sagrilaft;

use App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request\SagrilaftEmpleadoRelUrlCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sagrilaft\Empleado\SagrilaftRequestEmpleadoRelUrlCreate;
use App\Utils\TransfersData\Sagrilaft\Empleados\Services\ISagrilaftEmpleadoService;
use Illuminate\Http\Request;

class sagrilaftEmpleadoController extends Controller
{
    protected ISagrilaftEmpleadoService $empleadoService;

    /**
     * Constructor del controlador.
     *
     * @param ISagrilaftEmpleadoService $iSagrilaftEmpleadoService Servicio para manejar la lógica de empleados.
     */
    public function __construct(ISagrilaftEmpleadoService $iSagrilaftEmpleadoService)
    {
        $this->empleadoService = $iSagrilaftEmpleadoService;
    }

    /**
     * Almacena una nueva relación entre empleado y URL.
     *
     * @param SagrilaftRequestEmpleadoRelUrlCreate $sagrilaftRequestEmpleadoRelUrlCreate Solicitud que contiene los datos.
     * @return mixed|\Illuminate\Http\JsonResponse Respuesta en formato JSON con el resultado de la operación.
     */
    public function store(SagrilaftRequestEmpleadoRelUrlCreate $sagrilaftRequestEmpleadoRelUrlCreate)
    {
        // Convierte la solicitud a un DTO
        $sagrilaftEmpleadoRelUrlCreateDTO = new SagrilaftEmpleadoRelUrlCreateDTO($sagrilaftRequestEmpleadoRelUrlCreate);

        // Llama al servicio para crear la relación
        $responseDTO = $this->empleadoService->create($sagrilaftEmpleadoRelUrlCreateDTO);

        // Retorna la respuesta en formato JSON
        return response()->json($responseDTO, $responseDTO->code);
    }

}
