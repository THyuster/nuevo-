<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTipoRegalia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_TipoRegaliaController extends Controller
{
    private IServicioPmTipoRegalia $iServicioPmTipoRegalia;
    public function __construct(IServicioPmTipoRegalia $iServicioPmTipoRegalia)
    {
        $this->iServicioPmTipoRegalia = $iServicioPmTipoRegalia;
    }
    public function obtener()
    {
        return $this->iServicioPmTipoRegalia->obtenerPmTipoRegalia();
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
        return $this->iServicioPmTipoRegalia->crearPmTipoRegalia($request->all());
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
        return $this->iServicioPmTipoRegalia->actualizarPmTipoRegalia($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmTipoRegalia->eliminarPmTipoRegalia($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->iServicioPmTipoRegalia->actualizarEstadoTipoRegalia($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
                'pm_calidad_id' => 'required|string',
            ];
    }
}
