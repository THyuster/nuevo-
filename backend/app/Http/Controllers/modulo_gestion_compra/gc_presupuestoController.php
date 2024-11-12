<?php

namespace App\Http\Controllers\modulo_gestion_compra;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloGestionCompra\IServicioPresupuesto;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class gc_presupuestoController extends Controller
{
    private IServicioPresupuesto $servicioPresupuesto;

    public function __construct(IServicioPresupuesto $servicioPresupuesto)
    {
        $this->servicioPresupuesto = $servicioPresupuesto;
    }
    public function obtenerPresupuestos(): Response
    {
        return $this->servicioPresupuesto->obtenerPresupuestos();
    }


    public function obtenerPresupuestosPorId(string $id)
    {
        return $this->servicioPresupuesto->obtenerPresupuestosPorId($id);
    }

    public function crearPresupuestos(Request $presupuestoNuevo): Response
    {
        $validator = Validator::make($presupuestoNuevo->all(), $this->getValidationRules(), [
            'required' => 'el campo :attribute es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->servicioPresupuesto->crearPresupuestos($presupuestoNuevo->all());
    }

    public function actualizarPresupuestos(string $id, Request $request): Response
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [
            'required' => 'el campo :attribute es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->servicioPresupuesto->actualizarPresupuestos($id, $request->all());
    }


    public function eliminarPresupuestos(string $id): Response
    {
        return $this->servicioPresupuesto->eliminarPresupuestos($id);
    }

    public function actualizarEstadoPresupuestos(string $id): Response
    {
        return $this->servicioPresupuesto->actualizarEstadoPresupuestos($id);
    }
    private function getValidationRules()
    {
        return [
            '*' => 'prohibited',
            'nombre_presupuesto' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',

            'fecha_inicio' => 'required|date|date_format:Y-m-d',
            'fecha_fin' => 'required|date|date_format:Y-m-d|after_or_equal:fecha_inicio',
            'estado' => 'required|boolean',

            'detalles' => 'required|array',
            'detalles.*.id_centro_trabajo' => 'required|integer',
            'detalles.*.id_grupo_articulo' => 'nullable|integer',
            'detalles.*.id_activos_fijos_grupos_equipos' => 'nullable|integer',
            'detalles.*.costo_unitario' => 'required|numeric|min:0',
            'detalles.*.comentarios' => 'nullable|string|max:1000',
        ];
    }
}
