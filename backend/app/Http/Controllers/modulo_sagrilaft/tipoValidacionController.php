<?php

namespace App\Http\Controllers\modulo_sagrilaft;

use App\Data\Dtos\Sagrilaft\Validacion\TiposValidacion\Response\TipoValidacionDTO;
use App\Data\Dtos\Sagrilaft\Validacion\Url\Response\TipoValidacion;
use App\Http\Controllers\Controller;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\TipoValidaciones\ISagrilaftTipoValidacionRepository;
use Illuminate\Http\Request;

class tipoValidacionController extends Controller
{

    protected ISagrilaftTipoValidacionRepository $sagrilaftTipoValidacionRepository;
    public function __construct(ISagrilaftTipoValidacionRepository $iSagrilaftTipoValidacionRepository)
    {
        $this->sagrilaftTipoValidacionRepository = $iSagrilaftTipoValidacionRepository;
    }

    /**
     * Muestra todos los tipos de validación.
     *
     * Este método recupera todos los tipos de validación y los transforma
     * en instancias de TipoValidacionDTO antes de devolverlos como respuesta JSON.
     *
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con los tipos de validación.
     */
    public function show()
    {
        // Obtiene todos los tipos de validación desde el repositorio.
        $datos = $this->sagrilaftTipoValidacionRepository->getAll();

        // Transforma cada tipo de validación a su correspondiente DTO.
        $datos = $datos->transform(function ($data) {
            return new TipoValidacionDTO($data);
        })->toArray();

        // Devuelve la respuesta como JSON.
        return response()->json($datos);
    }
}
