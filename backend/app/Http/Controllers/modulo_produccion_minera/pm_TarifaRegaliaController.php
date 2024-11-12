<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTarifaRegalia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_TarifaRegaliaController extends Controller
{
    private IServicioPmTarifaRegalia $iServicioPmTarifaRegalia;
    public function __construct(IServicioPmTarifaRegalia $iServicioPmTarifaRegalia)
    {
        $this->iServicioPmTarifaRegalia = $iServicioPmTarifaRegalia;
    }
    public function obtener()
    {
        return $this->iServicioPmTarifaRegalia->obtenerPmTarifaRegalia();
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
        return $this->iServicioPmTarifaRegalia->crearPmTarifaRegalia($request->all());
    }
    public function actualizar(String $id, Request $request)
    {
        $rules = $this->reglasValidacion();

        $validator = Validator::make($rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->iServicioPmTarifaRegalia->actualizarPmTarifaRegalia($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmTarifaRegalia->eliminarPmTarifaRegalia($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->iServicioPmTarifaRegalia->actualizarEstadoPmTarifaRegalia($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'fecha_inicio' => 'required|string',
                'fecha_fin' => 'required|string',
                'pm_tipo_regalia_id' => 'required|string',
            ];
    }
}
