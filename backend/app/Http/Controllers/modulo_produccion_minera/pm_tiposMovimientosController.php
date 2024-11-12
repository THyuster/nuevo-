<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoMovimientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_tiposMovimientosController extends Controller
{
    private IServicioTipoMovimientos $iServicioTipoMovimiento;
    public function __construct(IServicioTipoMovimientos  $iServicioTipoMovimiento)
    {
        $this->iServicioTipoMovimiento = $iServicioTipoMovimiento;
    }
    public function obtener()
    {
        return $this->iServicioTipoMovimiento->obtenerTipoMovimientos();
    }
    public function crear(Request $request)
    {
        $rules = $this->reglasValidacion();

        $validator = Validator::make($rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->iServicioTipoMovimiento->crearTiposMovimiento($request->all());
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
        return $this->iServicioTipoMovimiento->actualizarTiposMovimiento($id, $request->all());
    }
    public function eliminar(String $id)
    {
        return $this->iServicioTipoMovimiento->elimininarTipoMovimiento($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->iServicioTipoMovimiento->actualizarEstadoTipoMovimiento($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
                'tipo_codigo_salida_id' => 'required|string',
                'tipo_codigo_llegada_id' => 'required|string',
                'tipo_patio_salida_id' => 'required|string',
                'tipo_patio_llegada_id' => 'required|istringnt',
            ];
    }
}
