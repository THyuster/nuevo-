<?php

namespace App\Utils\TransfersData\ModuloGestionCompra;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\GestionCompras\SqlOrdenes;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServicioOrdenes implements IServicioOrdenes
{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    private string $tablaArticulos, $tablaEquipos, $tablaPresupuesto, $tablaOrdenes, $tablaOrdenesDetalles, $tablaDetalleRelacion;
    private string $tipoTablaOrden;
    private string $date;

    private SqlOrdenes $sqlOrdenes;
    public function __construct()
    {

        $this->tablaOrdenes = tablas::getTablaClienteGcOrdenes();
        $this->tablaOrdenesDetalles = tablas::getTablaClienteGcDetalleOrdenes();
        $this->tablaDetalleRelacion = tablas::getTablaClienteGcDetalleOrdenesRelacion();
        $this->tipoTablaOrden = tablas::getTablaErpTipoOrdenes();

        $this->tablaPresupuesto = tablas::getTablaClienteGcPresupuesto();
        $this->tablaArticulos = tablas::getTablaErpInventarioArticulos();
        $this->tablaEquipos = tablas::getTablaClienteActivosFijosEquipos();

        $this->sqlOrdenes = new SqlOrdenes();


        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud();
        $this->date = date('Y-m-d');
    }
    public function obtenerOrdenes(): Response
    {
        $sql = $this->sqlOrdenes->sqlObtenerOrdenes();
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        $nuevasOrdenes = [];
        foreach ($response as $ordenActual) {
            $idOrden = $ordenActual->id;
            $ordenEncontrada = collect($nuevasOrdenes)->firstWhere('id', $idOrden);
            if (!$ordenEncontrada) {
                $ordenArray = (object) $ordenActual;
                $ordenArray->detalles = [];
                $nuevasOrdenes[] = $ordenArray;
                $ordenEncontrada = $ordenArray;
            }
            $idDetalle = $ordenActual->idDetale;
            $detallesEncontrados = collect($ordenEncontrada->detalles)->firstWhere('id_orden', $idDetalle);
            if (!$detallesEncontrados) {
                $ordenEncontrada->detalles[] = (object) [
                    "id" => $ordenActual->idDetale,
                    "id_articulo" => [
                        "id" => $ordenActual->idArticulo,
                        "descripcion" => $ordenActual->descripcionArticulo
                    ],
                    "id_activo_fijo" => [
                        "id" => $ordenActual->idEquipo,
                        "descripcion" => $ordenActual->descripcionEquipo
                    ],
                    "descripcion_equipo" => $ordenActual->descripcionEquipo,
                    "id_centro_trabajo" => $ordenActual->idCentroTrabajo,
                    "cantidad" => $ordenActual->cantidad,
                    "precio_unitario" => $ordenActual->precio_unitario,
                    "total" => $ordenActual->total,
                    "fecha_entrega_estimada" => $ordenActual->fecha_entrega_estimada,
                    "ruta_imagen" => $ordenActual->ruta_imagen,
                ];

            }
        }

        return response()->json($nuevasOrdenes, 200);
    }
    public function obtenerOrdenesPorId(string $id)
    {
        return $this->validarDatoPorId($id, $this->tablaOrdenes, "Presupuesto");
    }

    public function crearOrdenes(array $nuevaOrden): Response
    {
        try {
            $tipoOrden = $this->validarTipoOrden($nuevaOrden['id_tipo_orden']);
            $this->validarFks($nuevaOrden['detalles']);
            $ordenMapeada = $this->mappearOrden($nuevaOrden);
            $idOrden = $this->repositoryDynamicsCrud->getRecordId($this->tablaOrdenes, $ordenMapeada["orden"]);
            $idsDetallesRelacion = array_map(
                function ($detalle) use ($idOrden): array {
                    $idDetalle = $this->repositoryDynamicsCrud->getRecordId($this->tablaOrdenesDetalles, $detalle);
                    return [
                        "id_orden" => $idOrden,
                        "id_detalle" => $idDetalle
                    ];
                },
                $ordenMapeada["detalles"]
            );
            $this->repositoryDynamicsCrud->createInfo($this->tablaDetalleRelacion, $idsDetallesRelacion);

            return Response()->json($nuevaOrden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    public function actualizarOrdenes(string $id, array $actualizarPresupuesto): Response
    {
        try {
            $tipoOrden = $this->validarTipoOrden($actualizarPresupuesto['id_tipo_orden']);
            $this->validarFks($actualizarPresupuesto['detalles']);
            $idsEliminar = $this->validarDetalles($id, $actualizarPresupuesto["detalles"]);
            $ordenMapeada = $this->mappearOrden(ordenNueva: $actualizarPresupuesto);

            $idsEliminarString = implode(",", $idsEliminar);
            $sqlEliminarDetalles = $this->sqlOrdenes->sqlEliminarOrdenesConDetallesPorId($idsEliminarString);
            $this->repositoryDynamicsCrud->sqlFunction($sqlEliminarDetalles);


            $idsDetallesRelacion = [];

            foreach ($ordenMapeada["detalles"] as $detalle) {
                $idDetalle = isset($detalle["detalle_id"]) ?? false;
                unset($detalle["detalle_id"]);
                if ($idDetalle) {
                    $this->repositoryDynamicsCrud->updateInfo($this->tablaOrdenesDetalles, $detalle, $idDetalle);
                    continue;
                }
                $idDetalle = $this->repositoryDynamicsCrud->getRecordId($this->tablaOrdenesDetalles, $detalle);
                $idsDetallesRelacion[] = [
                    "id_orden" => $id,
                    "id_detalle" => $idDetalle
                ];
            }

            $this->repositoryDynamicsCrud->updateInfo($this->tablaOrdenes, $ordenMapeada["orden"], $id);
            $this->repositoryDynamicsCrud->createInfo($this->tablaDetalleRelacion, $idsDetallesRelacion);

            return Response()->json("Registro actualizado", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    private function validarDetalles(string $idOrden, array $detallesCliente)
    {
        $sqldetallesOrdenes = $this->sqlOrdenes->sqlObtenerDetallesOrdenesPorId($idOrden);
        $detallesOrdenesDb = $this->repositoryDynamicsCrud->sqlFunction($sqldetallesOrdenes);
        $idsDetallesOrdenesDb = array_column($detallesOrdenesDb, 'idDetalle');
        $idsDetallesCliente = array_column($detallesCliente, 'detalle_id');

        $idsEliminar = array_diff($idsDetallesOrdenesDb, $idsDetallesCliente);
        $idsnuevos = array_diff($idsDetallesCliente, $idsDetallesOrdenesDb);
        if ($idsnuevos) {
            throw Response("Detalles no validos", Response::HTTP_BAD_REQUEST);
        }
        return empty($idsEliminar) ?? [0];
    }

    public function eliminarOrdenes(string $id): Response
    {
        $sql = $this->sqlOrdenes->sqlEliminarOrdenesConDetallesPorId($id);
        $this->repositoryDynamicsCrud->sqlFunction($sql);
        return response()->json("Registro eliminado", 200);
    }

    public function actualizarEstadoOrdenes(string $id): Response
    {
        return response()->json("", 200);
    }

    private function validarTipoOrden(string $id)
    {
        $sql = "SELECT * FROM $this->tipoTablaOrden WHERE '$id'";
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw Response("No se encontro el tipo de orden ", Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    private function validarFks($ordenDetalles): void
    {
        $idsArticulos = array_column($ordenDetalles, 'id_articulo');
        $idsActivosFijos = array_column($ordenDetalles, 'id_activo_fijo_equipo');


        if ($idsArticulos) {
            $this->filtrarFks($idsArticulos, 'Articulos', tabla: $this->tablaArticulos);
        }
        if ($idsActivosFijos) {
            $this->filtrarFks($idsActivosFijos, 'Equipos', tabla: $this->tablaEquipos);
        }
    }

    private function filtrarFks(array $ids, string $fkValidando, $tabla): Response|null
    {
        $idsFiltrados = array_filter($ids);
        if (empty($idsFiltrados)) {
            throw new Exception(("No se encontraron $fkValidando"), Response::HTTP_BAD_REQUEST);
        }

        if (count($ids) != count($idsFiltrados)) {
            throw new Exception(("$fkValidando repetidos"), Response::HTTP_BAD_REQUEST);

        }
        $idsFiltradosString = implode(",", $idsFiltrados);
        $sql = "SELECT * FROM $tabla WHERE id IN ($idsFiltradosString)";

        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (count($response) != count($idsFiltrados)) {
            throw new Exception(("No existentes $fkValidando"), Response::HTTP_BAD_REQUEST);
        }
        return null;
    }

    private function validarDatoPorId(string $id, string $tabla, $nombreValidacion)
    {
        $response = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $tabla WHERE id = '$id'");

        if (count($response) == 0) {
            return response()->json("$nombreValidacion no encontrado", 404);
        }
        return null;
    }
    private function mappearOrden(array $ordenNueva)
    {
        $orden["orden"] = [
            'id_usuario' => Auth::user()->id,
            'id_presupuesto' => $ordenNueva["id_presupuesto"],
            'id_tipo_orden' => $ordenNueva["id_tipo_orden"],
            'descripcion' => $ordenNueva["descripcion"],
            'estado' => $ordenNueva["estado"],
        ];
        $orden["detalles"] = array_map(fn($detalle) => [

            'detalle_id' => $detalle['detalle_id'] ?? null,
            'id_articulo' => $detalle['id_articulo'] ?? null,
            'id_activo_fijo' => $detalle['id_activo_fijo'] ?? null,
            'cantidad' => $detalle['cantidad'] ?? null,
            'precio_unitario' => $detalle["precio_unitario"],
            // 'total' => $detalle["total"],
            'fecha_entrega_estimada' => $detalle["fecha_entrega_estimada"],
            'fecha_creacion' => $this->date,
            'fecha_modificacion' => $this->date,
            'ruta_imagen' => $detalle["ruta_imagen"],
            'id_centro_trabajo' => $detalle["id_centro_trabajo"],

        ], $ordenNueva["detalles"]);

        return $orden;
    }

    // private function obtenerRelacion()
    // {
    //     return [
    //         "id_presupuesto" => $this->idPresupuesto,
    //         "id_detalle" => $this->idDetallePresupuesto
    //     ];
    // }
}
