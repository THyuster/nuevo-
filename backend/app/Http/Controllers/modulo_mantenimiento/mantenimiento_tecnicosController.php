<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloMantenimiento\CTecnicos;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesTecnicos;
use Illuminate\Http\Request;


class mantenimiento_tecnicosController extends Controller
{

    private IServicesTecnicos $_servicesTecnicos;
    private CTecnicos $_cTecnicos;

    public function __construct(IServicesTecnicos $IServicesTecnicos, CTecnicos $cTecnicos)
    {
        $this->_servicesTecnicos = $IServicesTecnicos;
        $this->_cTecnicos = $cTecnicos;
    }

    public function index()
    {

    }

    public function GetTecnicosSSR(Request $request)
    {
        $filter = $request->input("filter");
        $filter = filter_var($filter, FILTER_SANITIZE_STRING);
        return $this->_servicesTecnicos->GetTecnicosSSR($filter);
    }

    public function create(Request $request)
    {
        $request->validate($this->_cTecnicos->rules, $this->_cTecnicos->mensajes);
        return response()->json([
            "mensaje" => $this->_servicesTecnicos->crearTecnicos($request)
        ]);
    }

    public function show()
    {
        return $this->_servicesTecnicos->getTecnicosAll();
    }

    public function update(Request $request, int $id)
    {

    }

    public function destroy(string $id)
    {
        return response()->json([
            "mensaje" =>
                $this->_servicesTecnicos->eliminarTecnicos($id)
        ]);
    }



    public function estado(int $id)
    {
        // return "hola";
        return response()->json([
            "mensaje" => $this->_servicesTecnicos->estadoTecnicos($id),
        ]);
    }

    public function GetTecnicosSSRByIdOrden(Request $request){
        $id = $request->input("id_orden");
        return $this->_servicesTecnicos->GetTecnicosSSRByIdOrden($id);

    }
}
