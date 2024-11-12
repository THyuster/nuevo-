<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Utils\ResponseHandler;
use Illuminate\Http\Request;

interface IServiceNominaSolicitudEmpleo
{
    public function createSolicitudEmpleo(array $entidadSolicitudEmpleo): ResponseHandler;
    public function updateSolicitudEmpleo($id, array $entidadSolicitudEmpleo): ResponseHandler;
    public function destroySolicitudEmpleo($id): ResponseHandler;
    public function getSolicitudEmpleoAll();
    public function getSolicitudEmpleoById($id);
    public function getSolicitudEmpleoList(Request $request);
}
