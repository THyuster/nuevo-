<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\iservicioGranulometria;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmGranulometrias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_granulometriaController extends Controller
{
    private IServicioPmGranulometrias $iservicioGranulometria;
    public function __construct(IServicioPmGranulometrias $iservicioGranulometria)
    {
        $this->iservicioGranulometria = $iservicioGranulometria;
    }
    public function obtener()
    {

        return $this->iservicioGranulometria->obtenerPmGranulometrias();
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
        return $this->iservicioGranulometria->crearPmGranulometria($request->all());
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
        return $this->iservicioGranulometria->actualizarPmGranulometria($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iservicioGranulometria->eliminarPmGranulometria($id);
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
