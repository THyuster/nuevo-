<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPatios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_patiosController extends Controller
{

    private IServicioPatios $servicioPatios;
    public function __construct(IServicioPatios $servicioPatios)
    {
        $this->servicioPatios = $servicioPatios;
    }

    public function obtener()
    {
        return $this->servicioPatios->obtenerPatios();
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
        return $this->servicioPatios->crearPatio($request->all());
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
        return $this->servicioPatios->actualizarPatio($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->servicioPatios->eliminarPatio($id);
    }
    public function actualizarEstado(String $id)
    {
        return $this->servicioPatios->actualizarEstadoPatio($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'centro_trabajo_id' => 'required|integer',
                'tipo_patio_id' => 'required|string',
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
                'propio' => 'required|boolean',
                'tipo_uso_id' => 'required|string',
            ];
    }
}
