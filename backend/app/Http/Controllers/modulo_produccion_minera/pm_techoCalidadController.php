<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTechosCalidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_techoCalidadController extends Controller
{
    private IServicioPmTechosCalidades $iServicioPmTechosCalidades;
    public function __construct(IServicioPmTechosCalidades $iServicioPmTechosCalidades)
    {
        $this->iServicioPmTechosCalidades = $iServicioPmTechosCalidades;
    }
    public function obtener()
    {
        return $this->iServicioPmTechosCalidades->obtenerPmTechosCalidades();
    }
    public function crear(Request $request)
    {
        $rules = $this->reglasValidacion();
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->iServicioPmTechosCalidades->crearPmTechoCalidad($request->all());
    }
    public function actualizar(String $id, Request $request)
    {
        $rules = $this->reglasValidacion();
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->iServicioPmTechosCalidades->actualizarPmTechoCalidad($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmTechosCalidades->eliminarPmTechoCalidad($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->iServicioPmTechosCalidades->actualizarEstadoPmTechoCalidad($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'fecha_inicio' => 'required|date_format:Y-m-d',
                'fecha_fin' => 'required|date_format:Y-m-d',
                'valor' => 'required|numeric',
                'pm_tipo_calidad_id' => 'required|string',
            ];
    }
}
