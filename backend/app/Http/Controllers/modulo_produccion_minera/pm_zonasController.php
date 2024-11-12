<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmZonas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_zonasController extends Controller
{
    private IServicioPmZonas $iServicioPmZonas;
    public function __construct(IServicioPmZonas $iServicioPmZonas)
    {
        $this->iServicioPmZonas = $iServicioPmZonas;
    }
    public function obtener()
    {
        return $this->iServicioPmZonas->obtenerZonas();
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
        return $this->iServicioPmZonas->crearZona($request->all());
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
        return $this->iServicioPmZonas->actualizarZona($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmZonas->eliminarZona($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
            ];
    }
}
