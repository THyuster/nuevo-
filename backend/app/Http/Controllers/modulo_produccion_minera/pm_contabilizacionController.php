<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmContabilizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_contabilizacionController extends Controller
{
    private IServicioPmContabilizacion $iservicioPmContabilizacion;
    public function __construct(IServicioPmContabilizacion $iservicioPmContabilizacion)
    {
        $this->iservicioPmContabilizacion = $iservicioPmContabilizacion;
    }
    public function obtener()
    {
        return $this->iservicioPmContabilizacion->obtenerPmContabilizaciones();
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
        return $this->iservicioPmContabilizacion->crearPmContabilizacion($request->all());
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
        return $this->iservicioPmContabilizacion->actualizarPmContabilizacion($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iservicioPmContabilizacion->eliminarPmContabilizacion($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'cuenta_db_material_id' => 'required|string',
                'cuenta_cr_material_id' => 'required|string',
                'cuenta_db_flete_id' => 'required|string',
                'cuenta_cr_flete_id' => 'required|string',
                'pm_calidad_id' => 'required|string',
                'pm_tipo_movimiento_id' => 'required|string',
            ];
    }
}
