<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesActas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class mantenimiento_actasController extends Controller
{
    private IServicesActas $_servicesActas;


    public function __construct(IServicesActas $iServicesActas)
    {
        $this->_servicesActas = $iServicesActas;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [
            'required' => 'el campo :attribute es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return $this->_servicesActas->crearActas($request);
    }

    public function show()
    {
        return $this->_servicesActas->obtenerTodosActas();
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), $this->getValidationRules(), [
            'required' => 'el campo :attribute es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return $this->_servicesActas->actualizarActas($id, $request);
    }


    public function obtenerCentro(Request $request)
    {
        $this->validate($request, [
            'ordenId' => 'required|int',
            'tipoOrden' => 'required|int',
        ]);
        return $this->_servicesActas->obtenerCentroTrabajo($request->all());
    }
    public function obtenerEV(Request $request)
    {
        $this->validate($request, [
            'ordenId' => 'required|int',
            'tipoOrden' => 'required|int',
        ]);
        return $this->_servicesActas->obtenerVehiculoOEquipo($request->all());
    }
    public function tecnicosOrden(String $ordenId)
    {

        return $this->_servicesActas->tecnicosAsociadasOrden($ordenId);
    }

    private function getValidationRules()
    {
        return [
            'asig_acta_id' => 'required|numeric',
            'fecha' => 'required|date',

            'tipo_mantenimiento' => 'required|in:Preventivo,Correctivo',
            'kilometraje' => 'required|numeric',
            'horometro' => 'required|numeric',

            'observacion' => 'required|string',
            'articulos' => 'sometimes|array',
            'articulos.*.idArticulo' => 'required_with:articulos|numeric',

            'articulos.*.cantidad' => 'required_with:articulos|numeric',
            // 'articulos.*.valor_unidad' => 'required_with:articulos|numeric',
            'horasExtras' => 'nullable|array',
            'horasExtras.*.tecnicoId' => 'required_with:horasExtras|numeric',
            'horasExtras.*.fecha_inicio' => 'required_with:horasExtras|date',
            'horasExtras.*.fecha_fin' => 'required_with:horasExtras|date',
        ];
    }
}
