<?php

namespace App\Http\Controllers\modulo_nomina\empleados;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Empleados\IEmpleadoServices;
use Illuminate\Http\Request;

class empleadosController extends Controller
{
    protected IEmpleadoServices $empleadoService;
    public function __construct(IEmpleadoServices $iEmpleadoServices)
    {
        $this->empleadoService = $iEmpleadoServices;
    }
    public function show()
    {

        $responseDTO = $this->empleadoService->getEmpleadosPagination();

        return response()->json($responseDTO,$responseDTO->code);
    }


}
