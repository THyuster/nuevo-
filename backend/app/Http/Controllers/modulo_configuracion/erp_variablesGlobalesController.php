<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;

use App\Utils\TransfersData\ModuloConfiguracion\IvariablesGlobales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class erp_variablesGlobalesController extends Controller
{
    protected IvariablesGlobales $servicesVariableGlobales;

    public function __construct(IvariablesGlobales $variablesGlobales)
    {
        $this->servicesVariableGlobales =  $variablesGlobales;
    }



    public function listar()
    {
        return $this->servicesVariableGlobales->listarVariableGlobal();
    }
    public function crear(Request $request)
    {
        $rules = $this->reglasValidacion();

        $validator = Validator::make($request->except('entrega'), $rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->servicesVariableGlobales->crearVariableGlobal($request->all());
    }
    public function actualizar(Request $request)
    {
        $id = $request->query('variableGlobal');
        return $this->servicesVariableGlobales->actualizarVariableGlobal($id, $request->except('variableGlobal'));
    }
    public function eliminar(Request $request)
    {
        return $this->servicesVariableGlobales->eliminarVariableGlobal($request->query('variableGlobal'));
    }
    private function reglasValidacion()
    {
        return
            [
                'tipo' => 'required|string',
                'nombre' => 'required|string',
                'valor' => 'required|string',
                'tipo_respuesta' => 'required|int',
                'modulo_id' => 'required|int',
            ];
    }
}
