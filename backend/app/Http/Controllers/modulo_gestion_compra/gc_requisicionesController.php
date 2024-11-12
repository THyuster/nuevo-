<?php

namespace App\Http\Controllers\modulo_gestion_compra;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\ModuloGestionCompra\IServicioRequisiciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class gc_requisicionesController extends Controller
{
    private IServicioRequisiciones $servicioRequisiciones;

    public function __construct(IServicioRequisiciones $servicioRequisiciones)
    {
        $this->servicioRequisiciones = $servicioRequisiciones;
    }


    public function obtenerRequisiciones(): Response
    {
        return $this->servicioRequisiciones->obtenerRequisiciones();
    }
    public function obtenerArticulosYEquipos(): Response
    {
        return $this->servicioRequisiciones->obtenerArticulosEquipos();
    }
    public function obtenerRequisicionesPorId(string $id)
    {
        return $this->servicioRequisiciones->obtenerRequisicionesPorId($id);
    }

    public function crearRequisiciones(Request $request): Response
    {
          $rules = $this->reglasValidacion();

        $validator = Validator::make( $rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->servicioRequisiciones->crearRequisiciones($request->all());
    }
    public function actualizarRequisiciones(string $id, Request $request): Response
    {
        
          $rules = $this->reglasValidacion();

          $validator = Validator::make( $rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->servicioRequisiciones->actualizarRequisiciones($id, $request->all());
    }

    public function eliminarRequisiciones(string $id): Response
    {
        return $this->servicioRequisiciones->eliminarRequisiciones($id);
    }

    public function actualizarEstadoRequisiciones(string $id): Response
    {
        return $this->servicioRequisiciones->actualizarEstadoRequisiciones($id);
    }

    public function obtenerReglasValidacion()
    {
        return [
            'descripcion' => 'required',
            'id_centro_trabajo' => 'required',
            'id_usuario' => 'required',
            'urgencia' => 'required',
            'estado' => 'required',
            'proyecto' => 'nullable',
            'fecha_creacion' => 'required',
            'detalles' => 'required',
            'detalles.*.id_articulo' => 'required',
            'detalles.*.id_activo_fijo_equipo' => 'required',
            'detalles.*.cantidad' => 'required',
            'detalles.*.cantidad_autorizada' => 'required',
            'detalles.*.cantidad_comprada' => 'required',
            'detalles.*.costo_estimado' => 'required',
            'detalles.*.total_estimado' => 'required',
            'detalles.*.comentarios' => 'required',
            // 'detalles.*.ruta_imagen' => 'required',
        ];
    }
}