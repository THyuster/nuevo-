<?php

namespace App\Http\Controllers\modulo_mantenimiento;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesEntregaDirectas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class mantenimiento_entregasDirectasController extends Controller
{

    private IServicesEntregaDirectas $iServicesEntregaDirectas;

    public function __construct(IServicesEntregaDirectas $iServicesEntregaDirectas)
    {
        $this->iServicesEntregaDirectas = $iServicesEntregaDirectas;
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
        return $this->iServicesEntregaDirectas->crearEntregaDirecta($request->all());
    }

    public function actualizar(Request $request)
    {
        $id =  $request->query('entrega');
        $rules = $this->reglasValidacion();

        $validator = Validator::make($request->except('entrega'), $rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->iServicesEntregaDirectas->actualizarEntregaDirecta($id, $request->except('entrega'));
    }

    public function eliminar(Request $request)
    {

        return $this->iServicesEntregaDirectas->eliminarEntregaDirecta($request->query('entrega'));
    }
    public function obtener()
    {
        return $this->iServicesEntregaDirectas->obtenerTodosEntregaDirecta();
    }

    private function reglasValidacion()
    {
        return
            [
                // '*' => 'prohibited',
                'centroTrabajoId' => 'required|integer',
                'fecha' => 'required',
                'observaciones',
                'usuarioRecibe' => 'required|string',
                'articulosEntregas' => 'required|array',
                'articulosEntregas.*.articuloId' => 'required_with:articulosEntregas|numeric',
                'articulosEntregas.*.cantidad' => 'required_with:articulosEntregas|numeric',

            ];
    }
}
