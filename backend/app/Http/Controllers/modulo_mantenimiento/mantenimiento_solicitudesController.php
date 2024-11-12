<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Data\Dtos\Solicitudes\Request\RequestCreateSolicitudDTO;
use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesSolicitudes;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class mantenimiento_solicitudesController extends Controller
{

    private IServicesSolicitudes $_servicesSolicitudes;

    public function __construct(IServicesSolicitudes $_servicesSolicitudes)
    {
        $this->_servicesSolicitudes = $_servicesSolicitudes;
    }

    public function create(Request $request)
    {

        $requestCreateSolicitudDTO = new RequestCreateSolicitudDTO($request);

        return response()->json([
            "mensaje" => $this->_servicesSolicitudes->crearSolicitud($requestCreateSolicitudDTO)
        ], Response::HTTP_CREATED);

    }

    public function show()
    {
        $datataTableDTO = $this->_servicesSolicitudes->getSolicitudesDatatable();
        return response()->json($datataTableDTO, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $requestCreateSolicitudDTO = new RequestCreateSolicitudDTO($request);

        return response()->json([
            "mensaje" =>
                $this->_servicesSolicitudes->actualizarSolicitud($requestCreateSolicitudDTO, $id)
        ], Response::HTTP_OK);

    }

    public function destroy($id)
    {
        return response()->json([
            "mensaje" =>
                $this->_servicesSolicitudes->eliminarSolicitud($id)
        ], Response::HTTP_OK);
    }

    public function terceros()
    {
        return [
            "entidad_tercero" => $this->_servicesSolicitudes->getTerceros()
        ];
    }

    public function firmarSolicitud(Request $request, $id)
    {
        return $this->_servicesSolicitudes->solicitudFirmar($id, $request);
    }

    public function searchId($id)
    {
        return $this->_servicesSolicitudes->getSolicitudById($id);
    }
}
