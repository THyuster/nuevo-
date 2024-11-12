<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioBodega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_bodegasController extends Controller
{

    private IServicioBodega $servicioBodega;

    public function __construct(IServicioBodega $servicioBodega)
    {
        $this->servicioBodega = $servicioBodega;
    }
    public function obtener()
    {
        return $this->servicioBodega->obtenerBodegas();
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
        return $this->servicioBodega->crearBodegas($request->all());
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
        return $this->servicioBodega->actualizarBodegas($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->servicioBodega->eliminarBodegas($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->servicioBodega->actualizarEstadoBodegas($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'patio_id' => 'required|string',
                'inventario_bodega_id' => 'required|integer',
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
            ];
    }
}
