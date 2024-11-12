<?php

namespace App\Http\Controllers\modulo_nomina;

use App\Http\Controllers\Controller;
use App\Http\Requests\NominaRequest\NominaSolicitudEmpleoRequest;
use App\Utils\TransfersData\ModuloNomina\IServiceNominaSolicitudEmpleo;
use Illuminate\Http\Request;

class nomina_solicitud_empleoController extends Controller
{
    protected IServiceNominaSolicitudEmpleo $_serviceNominaSolicitudEmpleo;

    public function __construct(IServiceNominaSolicitudEmpleo $iServiceNominaSolicitudEmpleo)
    {
        $this->_serviceNominaSolicitudEmpleo = $iServiceNominaSolicitudEmpleo;
    }


    public function store(NominaSolicitudEmpleoRequest $request)
    {
        $entidadSolicitudEmpleo = $request->all();
        return $this->_serviceNominaSolicitudEmpleo->createSolicitudEmpleo($entidadSolicitudEmpleo)->responses();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return $this->_serviceNominaSolicitudEmpleo->getSolicitudEmpleoAll();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, NominaSolicitudEmpleoRequest $request)
    {
        return $this->_serviceNominaSolicitudEmpleo->updateSolicitudEmpleo($id,$request->all())->responses();
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->_serviceNominaSolicitudEmpleo->destroySolicitudEmpleo($id)->responses();
    }

    public function getSolicitudEmpleoById($id){
        return $this->_serviceNominaSolicitudEmpleo->getSolicitudEmpleoById($id)->responses();
    }
    public function getSolicitudEmpleoList(Request $request){
        return $this->_serviceNominaSolicitudEmpleo->getSolicitudEmpleoList($request)->responses();
    }
}
