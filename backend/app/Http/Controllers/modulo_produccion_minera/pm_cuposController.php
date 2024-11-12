<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmCupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_cuposController extends Controller
{
    private IServicioPmCupos $iServicioPmCupos;
    public function __construct(IServicioPmCupos $iServicioPmCupos)
    {
        $this->iServicioPmCupos = $iServicioPmCupos;
    }
    public function obtener()
    {
        return $this->iServicioPmCupos->obtenerPmCupos();
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
        return $this->iServicioPmCupos->crearPmCupo($request->all());
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
        return $this->iServicioPmCupos->actualizarPmCupo($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmCupos->eliminarPmCupo($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->iServicioPmCupos->actualizarEstadoPmCupo($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'fecha_inicio' => 'required|date_format:Y-m-d',
                'fecha_fin' => 'required|date_format:Y-m-d',
                'valor' => 'required|numeric',
                'pm_codigo_id' => 'required|string',
            ];
    }
}
