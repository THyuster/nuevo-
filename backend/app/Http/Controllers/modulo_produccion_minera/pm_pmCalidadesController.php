<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmCalidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_pmCalidadesController extends Controller
{
    private IServicioPmCalidades $iServicioPmCalidades;
    public function __construct(IServicioPmCalidades $iServicioPmCalidades)
    {
        $this->iServicioPmCalidades = $iServicioPmCalidades;
    }
    public function obtener()
    {
        return $this->iServicioPmCalidades->obtenerPmCalidades();
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
        return $this->iServicioPmCalidades->crearPmCalidad($request->all());
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
        return $this->iServicioPmCalidades->actualizarPmCalidad($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmCalidades->eliminarPmCalidad($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
                'pm_producto_id' => 'required|string',
            ];
    }
}
