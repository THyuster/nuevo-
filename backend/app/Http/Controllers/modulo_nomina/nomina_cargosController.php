<?php

namespace App\Http\Controllers\modulo_nomina;

use App\Http\Controllers\Controller;
use App\Http\Requests\NominaCargosRequest;
use App\Models\NominaModels\nomina_cargos;
use App\Utils\TransfersData\ModuloNomina\IServiceCargosNomina;
use Illuminate\Http\Request;

class nomina_cargosController extends Controller
{
    private IServiceCargosNomina $_servicesCargosNomina;

    public function __construct(IServiceCargosNomina $iServicesCargosNomina)
    {
        $this->_servicesCargosNomina = $iServicesCargosNomina;
    }
    public function crear(NominaCargosRequest $request)
    {
        $entidadCargo = $request->all();
        return $this->_servicesCargosNomina->crearCargo($entidadCargo)->responses();
    }

    public function obtener(Request $request)
    {
        return $this->_servicesCargosNomina->getCargo();
    }

    public function actualizar(string $id, NominaCargosRequest $request)
    {
        $entidadCargo = $request->all();
        return $this->_servicesCargosNomina->actualizarCargo($id, $entidadCargo)->responses();
    }

    public function eliminar(string $id)
    {
        return $this->_servicesCargosNomina->eliminarCargo($id)->responses();
    }

    public function filterCargos(Request $request)
    {
        $nombreCargo = $request->input("nombre");
        $codigoCargo = $request->input("codigo");

        return $this->_servicesCargosNomina->filterCargo($nombreCargo, $codigoCargo);

    }


}
