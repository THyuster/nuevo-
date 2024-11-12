<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioTarifasTraslados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_tarifasTrasladosController extends Controller
{
    private IServicioTarifasTraslados $iServicioTarifasTraslados;

    public function __construct(IServicioTarifasTraslados $iServicioTarifasTraslados)
    {
        $this->iServicioTarifasTraslados = $iServicioTarifasTraslados;
    }
    public function obtener()
    {
        return $this->iServicioTarifasTraslados->obtenerTarifasTraslados();
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
        return $this->iServicioTarifasTraslados->crearTarifaTraslado($request->all());
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
        return $this->iServicioTarifasTraslados->actualizarTarifaTraslado($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioTarifasTraslados->eliminarTarifaTraslado($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->iServicioTarifasTraslados->actualizarEstadoTarifaTraslado($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'patio_origen_id' => 'required|string',
                'patio_destino_id' => 'required|string',
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
            ];
    }
}
