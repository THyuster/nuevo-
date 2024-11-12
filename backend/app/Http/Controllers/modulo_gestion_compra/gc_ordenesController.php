<?php

namespace App\Http\Controllers\modulo_gestion_compra;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloGestionCompra\IServicioOrdenes;
use App\Utils\TransfersData\ModuloGestionCompra\IServicioPresupuesto;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class gc_ordenesController extends Controller
{
    private IServicioOrdenes $servicioOrdenes;





    public function __construct(IServicioOrdenes $servicioOrdenes)
    {
        $this->servicioOrdenes = $servicioOrdenes;
    }
    public function obtenerOrdenes(): Response
    {
        return $this->servicioOrdenes->obtenerOrdenes();
    }


    public function obtenerOrdenesPorId(string $id)
    {
        return $this->servicioOrdenes->obtenerOrdenesPorId($id);
    }

    public function crearOrdenes(Request $presupuestoNuevo): Response
    {
        // $validator = Validator::make($presupuestoNuevo->all(), $this->getValidationRules(), [
        //     'required' => 'el campo :attribute es obligatorio.',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 400);
        // }
        return $this->servicioOrdenes->crearOrdenes($presupuestoNuevo->all());
    }

    public function actualizarOrdenes(string $id, Request $request): Response
    {
        return $this->servicioOrdenes->actualizarOrdenes($id, $request->all());
    }


    public function eliminarOrdenes(string $id): Response
    {
        return $this->servicioOrdenes->eliminarOrdenes($id);
    }

    public function actualizarEstadoOrdenes(string $id): Response
    {
        return $this->servicioOrdenes->actualizarEstadoOrdenes($id);
    }
    private function getValidationRules()
    {
        return [
            '*' => 'prohibited',
            'nombre_presupuesto' => 'required|string',
            'descripcion' => 'nullable|string',
            'valor_tope' => 'nullable|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'estado' => 'required|boolean',
            'fecha_creacion' => 'nullable|date',
            'fecha_modificacion' => 'nullable|date',
            'id_centro_trabajo' => 'required|integer',
            'detalle_id' => 'nullable|integer',
            'id_grupo_articulo' => 'required|integer',
            'cantidad' => 'nullable|integer',
            'costo_unitario' => 'nullable|numeric',
            'comentarios' => 'nullable|string',
            'subtotal' => 'nullable|numeric',
        ];
    }
}
