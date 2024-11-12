<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoCodigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\String_;

class pm_tiposCodigosController extends Controller
{
    private IServicioTipoCodigo $iServicioTipoCodigo;
    public function __construct(IServicioTipoCodigo  $iServicioTipoCodigo)
    {
        $this->iServicioTipoCodigo = $iServicioTipoCodigo;
    }
    public function obtener()
    {
        return $this->iServicioTipoCodigo->obtenerTiposCodigos();
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
        return $this->iServicioTipoCodigo->crearTipoCodigo($request->all());
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
        return $this->iServicioTipoCodigo->actualizarTipoCodigo($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioTipoCodigo->eliminarTipoCodigo($id);
    }
    private function reglasValidacion()
    {
        return
            [
                'codigo' => 'required|string',
                'descripcion' => 'required|string'
            ];
    }
}
