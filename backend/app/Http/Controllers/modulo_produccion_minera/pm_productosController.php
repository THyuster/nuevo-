<?php

namespace App\Http\Controllers\modulo_produccion_minera;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmProductos;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoCodigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\String_;

class pm_productosController extends Controller
{
    private IServicioPmProductos $iServicioPmProductos;
    public function __construct(IServicioPmProductos $iServicioPmProductos)
    {
        $this->iServicioPmProductos = $iServicioPmProductos;
    }
    public function obtener()
    {
        return $this->iServicioPmProductos->obtenerProduto();
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
        return $this->iServicioPmProductos->crearProduto($request->all());
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
        return $this->iServicioPmProductos->actualizarProduto($id, $request->all());
    }

    public function eliminar(String $id)
    {
        return $this->iServicioPmProductos->eliminarProduto($id);
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
