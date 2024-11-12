<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmCodigos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class pm_codigosController extends Controller
{
    private IServicioPmCodigos $iServicioPmCodigos;
    public function __construct(IServicioPmCodigos $iServicioPmCodigos)
    {
        $this->iServicioPmCodigos = $iServicioPmCodigos;
    }
    public function obtener()
    {
        return $this->iServicioPmCodigos->obtenerPmCodigos();
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
        return $this->iServicioPmCodigos->crearPmCodigo($request->all());
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
        return $this->iServicioPmCodigos->actualizarPmCodigo($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmCodigos->eliminarPmCodigo($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'codigo' => 'required|string',
                'descripcion' => 'required|string',
                'observaciones' => 'nullable|string',
                'titulo_minero' => 'nullable|string',
                'manto' => 'nullable|string',
                'mina_propia' => 'required|boolean',
                'material_especial' => 'required|boolean',
                'no_causar_material' => 'required|boolean',
                'no_causar_flete' => 'required|boolean',
                'estado' => 'required|boolean',
                'pm_tipo_codigo_id' => 'required|string',
                'pm_patio_id' => 'required|string',
                'pm_tipo_regalia_id' => 'required|string',
                'pm_zona_id' => 'required|string',
                'contabilidad_tercero_id' => 'required|integer',
                'comercializador_user_id' => 'required|integer',
            ];
    }
}
