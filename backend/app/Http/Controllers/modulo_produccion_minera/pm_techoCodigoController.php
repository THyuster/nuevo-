<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTechosCodigos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_techoCodigoController extends Controller
{
    private IServicioPmTechosCodigos $iServicioPmTechosCodigos;
    public function __construct(IServicioPmTechosCodigos $iServicioPmTechosCodigos)
    {
        $this->iServicioPmTechosCodigos = $iServicioPmTechosCodigos;
    }
    public function obtener()
    {
        return $this->iServicioPmTechosCodigos->obtenerPmTechosCodigos();
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
        return $this->iServicioPmTechosCodigos->crearPmTechosCodigo($request->all());
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
        return $this->iServicioPmTechosCodigos->actualizarPmTechosCodigo($id, $request->all());
    }
    public function actualizarEstado(String $id)
    {

        return $this->iServicioPmTechosCodigos->actualizarEstadoPmTechosCodigo($id);
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmTechosCodigos->eliminarPmTechosCodigo($id);
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
