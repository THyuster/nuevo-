<?php

namespace App\Utils\TransfersData\ModuloGestionCompra;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\GestionCompras\SqlPresupuestos;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServicioPresupuesto implements IServicioPresupuesto
{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    private string $tablaPresupuesto, $tablaPresupuestoDetalle, $tablaPresupuestoDetalleRelacion, $tablaUsuario, $tablaCentroTrabajo,
        $tablaGrupoArticulo, $tablaActivosFijosGruposEquipos;
    private string $idPresupuesto, $valorTotalDelPresupuesto;
    private SqlPresupuestos $sqlPresupuestosConRelacion;

    private array $eliminarDetallesGrupoA, $eliminarDetallesGrupoE, $gruposArticulosDb = [], $gruposEquiposDb = [];

    private string $date;
    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud();
        $this->tablaUsuario = tablas::getTablaAppUser();
        $this->tablaCentroTrabajo = tablas::getTablaClienteNominaCentrosTrabajos();
        $this->tablaGrupoArticulo = tablas::getTablaClienteInventarioGrupoArticulos();
        $this->tablaActivosFijosGruposEquipos = tablas::getTablaClienteActivoFijosGrupoEquipo();
        $this->tablaPresupuesto = tablas::getTablaClienteGcPresupuesto();
        $this->tablaPresupuestoDetalle = tablas::getTablaClienteGcDetallePresupuesto();
        $this->tablaPresupuestoDetalleRelacion = tablas::getTablaClienteGcDetallePresupuestoRelacion();
        $this->date = now()->format('Y-m-d H:i:s');
        $this->sqlPresupuestosConRelacion = new SqlPresupuestos();
    }
    public function obtenerPresupuestos(): Response
    {
        $sql = $this->sqlPresupuestosConRelacion->obtenerPresupuestoConRelaciones();
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        $nuevosPresupuestos = [];
        foreach ($response as $data) {
            $presupuesto = $this->mapearPresupuesto($data, $nuevosPresupuestos);
            $this->agregarDetalle($presupuesto, $data);
        }

        return response()->json($nuevosPresupuestos, 200);
    }

    private function mapearPresupuesto($data, array &$nuevosPresupuestos): object
    {
        $idPresupuesto = base64_encode($this->encriptarKey($data->idPresupuesto));
        $presupuestoEncontrado = collect($nuevosPresupuestos)->firstWhere('idPresupuesto', $idPresupuesto);
        if (!$presupuestoEncontrado) {
            $arrayPresupuesto = json_decode(json_encode($data), true);
            $presupuesto = (object) [
                "idPresupuesto" => $idPresupuesto,
                "nombre_presupuesto" => $arrayPresupuesto["nombre_presupuesto"],
                "descripcion" => $arrayPresupuesto["descripcion"],
                "valor_tope" => $arrayPresupuesto["valor_tope"],
                "fecha_inicio" => $arrayPresupuesto["fecha_inicio"],
                "fecha_fin" => $arrayPresupuesto["fecha_fin"],
                "estado" => $arrayPresupuesto["estado"],
                "fecha_creacion" => $arrayPresupuesto['fecha_creacion'],
                "fecha_modificacion" => $arrayPresupuesto['fecha_modificacion'],
            ];
            $idDetalleEncriptado = base64_encode($this->encriptarKey(id: $data->id_detalle));
            $presupuesto->detalles[] = [
                "id" => $idDetalleEncriptado,
                "costo_unitario" => $data->costo_unitario,
                "comentarios" => $data->comentarios,
                "fecha_creacion" => $data->fecha_creacion,
                "fecha_modificacion" => $data->fecha_modificacion,
                "id_centro_trabajo" => [
                    "id" => $data->idCentroTrabajo,
                    "descripcion" => "$data->codigoCentroTrabajo - $data->descripcionCentroTrabajo",
                ],
                "id_grupo_articulo" => [
                    "id" => $data->idGrupoArticulo ?? "",
                    "descripcion" => " $data->codigoGrupoArticulo - $data->descripcionGrupoArticulo",
                ],
                "id_activos_fijos_grupos_equipos" => [
                    "id" => $data->idActivoFijo,
                    "descripcion" => " $data->codigoActivoFijo - $data->descripcionActivoFijo",
                ]
            ];
            $nuevosPresupuestos[] = $presupuesto;
            $presupuestoEncontrado = $presupuesto;
        }
        return $presupuestoEncontrado;
    }

    private function agregarDetalle(object $presupuestoEncontrado, object $data)
    {
        $idDetalleEncriptado = base64_encode($this->encriptarKey(id: $data->id_detalle));
        $detallesEcontrados = collect($presupuestoEncontrado->detalles)->firstWhere('id', $idDetalleEncriptado);
        if (!$detallesEcontrados) {
            $presupuestoEncontrado->detalles[] = [
                "id" => $idDetalleEncriptado,
                "costo_unitario" => $data->costo_unitario,
                "comentarios" => $data->comentarios,
                "fecha_creacion" => $data->fecha_creacion,
                "fecha_modificacion" => $data->fecha_modificacion,
                "id_centro_trabajo" => [
                    "id" => $data->idCentroTrabajo,
                    "descripcion" => "$data->codigoCentroTrabajo - $data->descripcionCentroTrabajo",
                ],
                "id_grupo_articulo" => [
                    "id" => $data->idGrupoArticulo,
                    "descripcion" => " $data->codigoGrupoArticulo - $data->descripcionGrupoArticulo",
                ],
                "id_activos_fijos_grupos_equipos" => [
                    "id" => $data->idActivoFijo,
                    "descripcion" => " $data->codigoActivoFijo - $data->descripcionActivoFijo",
                ]
            ];
        }
    }
    public function obtenerPresupuestosPorId(string $id)
    {
        return $this->validarDatoPorId($id, $this->tablaPresupuesto, "Presupuesto");
    }

    public function crearPresupuestos(array $presupuestoNuevo): Response
    {
        try {
            $this->validarFechas($presupuestoNuevo["fecha_inicio"], $presupuestoNuevo["fecha_fin"]);
            $this->validarFks($presupuestoNuevo['detalles']);
            // $this->validarParejasFksUnicas($presupuestoNuevo['detalles']);

            $valorAcrear = true;

            $presupuestoNuevo = $this->mapperPresupuesto($presupuestoNuevo, $valorAcrear);
            $columnaCostoUnitario = array_column($presupuestoNuevo['detalles'], 'costo_unitario');
            $presupuestoNuevo["presupuesto"]["valor_tope"] = array_sum($columnaCostoUnitario);

            $this->idPresupuesto = $this->repositoryDynamicsCrud->getRecordId($this->tablaPresupuesto, $presupuestoNuevo["presupuesto"]);

            $idsDetalles = array_map(
                fn($detalle) => $this->repositoryDynamicsCrud->getRecordId($this->tablaPresupuestoDetalle, $detalle),
                $presupuestoNuevo['detalles']
            );
            $relacion = $this->obtenerRelacion($idsDetalles);
            $this->repositoryDynamicsCrud->createInfo($this->tablaPresupuestoDetalleRelacion, $relacion);
            return response()->json("Registro creado exitosamente", 200);
        } catch (\Throwable $th) {
            throw $th;
            // return response()->json($th->getMessage(), 400);
        }
    }



    public function actualizarPresupuestos(string $id, array $actualizarPresupuesto): Response
    {
        try {
            $id = $this->desencriptarKey(base64_decode($id));
            $presupuestoExistente = $this->validarDatoPorId($id, $this->tablaPresupuesto, "Presupuesto");
            if ($presupuestoExistente) {
                return $presupuestoExistente;
            }

            $response = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->tablaPresupuesto WHERE id = '$id'");

            $sql = "SELECT id FROM $this->tablaPresupuesto gcp WHERE gcp.id > '$id'";
            $presupuestosDespues = $this->repositoryDynamicsCrud->sqlFunction($sql);
            if (count($presupuestosDespues) > 0) {
                unset(
                    $actualizarPresupuesto["fecha_inicio"],
                    $actualizarPresupuesto["fecha_fin"]
                );
            } else {
                $actualizarPresupuesto["fecha_inicio"] = $response[0]->fecha_inicio;
                $actualizarPresupuesto["fecha_fin"] = $response[0]->fecha_fin;
            }
            $this->idPresupuesto = $id;
            $detallesPresupuesto = $actualizarPresupuesto['detalles'];
            $this->validarFks($detallesPresupuesto);

            $sql = $this->sqlPresupuestosConRelacion->ssqlObtenerDetallesRelacionadosAlPresupuesto($id);
            $DbIdsDetalles = $this->repositoryDynamicsCrud->sqlFunction($sql);


            $detallesSinRequisiciones = $this->obtenerDetallesSinRequisiciones($id, $detallesPresupuesto);
            if ($detallesSinRequisiciones) {
                $this->actualizarDetallesExistentes($detallesSinRequisiciones);
            }

            if (count($this->eliminarDetallesGrupoA) > 0 || count($this->eliminarDetallesGrupoE) > 0) {
                $this->eliminarDetallesNoExistentes();
            }
            $columnaCostoUnitario = array_column($detallesSinRequisiciones, 'costo_unitario');
            $detallesNuevosParaCrear = array_map(function ($detalle) {
                if (isset($detalle['id'])) {
                    return null;
                }
                return $detalle;
            }, $detallesSinRequisiciones);
            $valorAcrear = false;
            $actualizarPresupuesto['detalles'] = array_filter($detallesNuevosParaCrear);

            $presupuestoNuevo = $this->mapperPresupuesto($actualizarPresupuesto, $valorAcrear);

            $presupuestoNuevo["presupuesto"]["valor_tope"] = array_sum($columnaCostoUnitario);

            $this->repositoryDynamicsCrud->updateInfo($this->tablaPresupuesto, $presupuestoNuevo["presupuesto"], $id);

            $idsDetalles = array_map(
                fn($detalle) => $this->repositoryDynamicsCrud->getRecordId($this->tablaPresupuestoDetalle, $detalle),
                $presupuestoNuevo['detalles']
            );
            $relacion = $this->obtenerRelacion($idsDetalles);
            $this->repositoryDynamicsCrud->createInfo($this->tablaPresupuestoDetalleRelacion, $relacion);
            $message = !$detallesSinRequisiciones ? "Hay detalles que no se actualizaron porque pertenecen a una requisicion" : "Registro actualizado exitosamente";
            return response()->json($message, status: 200);
        } catch (\Throwable $th) {
            throw new \Exception($th);
        }
    }
    private function actualizarDetallesExistentes(array $detallesPresupuesto): void
    {
        foreach ($detallesPresupuesto as $detalle) {
            if (isset($detalle['id'])) {
                $this->repositoryDynamicsCrud->updateInfo(tablas::getTablaClienteGcDetallePresupuesto(), $detalle, $detalle['id']);
            }
        }
    }
    private function obtenerDetallesSinRequisiciones(string $idPresupuesto, array $detalles): array
    {
        $sql = $this->sqlPresupuestosConRelacion->sqlObtenerDetallesConRequiciones($idPresupuesto);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        $grupoArticulosPresupuestoRequisiciones = [];
        $grupoEquiposPresupuestoRequisiciones = [];

        // $gruposArticulosDb = [];
        // $gruposEquiposDb = [];

        $gruposArticulosCliente = array_column($detalles, 'id_grupo_articulo');
        $gruposEquiposCliente = array_column($detalles, 'id_activos_fijos_grupos_equipos');


        foreach ($response as $detalle) {
            if (isset($detalle->idGrupoArticulo)) {
                $grupoArticulosPresupuestoRequisiciones[] = $detalle;
                $this->gruposArticulosDb[] = $detalle->idGrupoArticulo;
                // id del grupo articulo
                continue;
            }
            $this->gruposEquiposDb[] = $detalle->idGrupoEquipo;
            // id del grupo equipo
            $grupoEquiposPresupuestoRequisiciones[] = $detalle;
        }
        $this->eliminarDetallesGrupoA = array_diff($this->gruposArticulosDb, $gruposArticulosCliente);
        $this->eliminarDetallesGrupoE = array_diff($this->gruposEquiposDb, $gruposEquiposCliente);


        $detallesParaCrearOactualizar = [];

        foreach ($detalles as $detalle) {
            if (isset($detalle["id"])) {
                $detalle["id"] = $this->desencriptarKey(base64_decode($detalle["id"]));
            }

            if (isset($detalle['id_activos_fijos_grupos_equipos'])) {
                $idGrupoEquipo = $detalle['id_activos_fijos_grupos_equipos'];
                $grupoEquipoUtilizado = array_search($idGrupoEquipo, $this->gruposEquiposDb);
                if ($grupoEquipoUtilizado === false) {
                    $detallesParaCrearOactualizar[] = $detalle;
                    continue;
                }
                $costoAntiguoDetalle = $grupoEquiposPresupuestoRequisiciones[$grupoEquipoUtilizado]->costoPresupuesto;
                if ($detalle['costo_unitario'] >= $costoAntiguoDetalle) {
                    $detallesParaCrearOactualizar[] = $detalle;
                }
            } else {
                $idGrupoArticulo = $detalle['id_grupo_articulo'];
                $grupoGrupoUtilizado = array_search($idGrupoArticulo, $this->gruposArticulosDb);

                if ($grupoGrupoUtilizado === false) {
                    $detallesParaCrearOactualizar[] = $detalle;
                    continue;
                }
                $costoAntiguoDetalle = $grupoArticulosPresupuestoRequisiciones[$grupoGrupoUtilizado]->costoPresupuesto;
                if ($detalle['costo_unitario'] >= $costoAntiguoDetalle) {
                    $detallesParaCrearOactualizar[] = $detalle;
                }
            }
        }

        return $detallesParaCrearOactualizar;
    }
    private function eliminarDetallesNoExistentes(): void
    {
        $detallesGrupoArticulosString = implode(",", $this->eliminarDetallesGrupoA ?: [0]);
        $detallesGrupoEquiposString = implode(",", $this->eliminarDetallesGrupoE ?: [0]);

        $sql = $this->sqlPresupuestosConRelacion->sqlObtenerGruposAsociadosARequisiciones(
            $this->idPresupuesto,
            $detallesGrupoArticulosString,
            $detallesGrupoEquiposString
        );

        $grupoArticulosOEquiposUtilizados = $this->repositoryDynamicsCrud->sqlFunction($sql);


        $idsGruposArticulos = array_filter(array_column($grupoArticulosOEquiposUtilizados, 'idGrupoArticulos'));
        $idsGruposEquipos = array_filter(array_column($grupoArticulosOEquiposUtilizados, 'idGrupoEquipos'));

        $idsGrupoArticulosUtilizados = explode(',', $detallesGrupoArticulosString);
        $idsGrupoEquipoUtilizados = explode(',', $detallesGrupoEquiposString);

        $grupoArticulosSinUtilizar = array_diff($idsGrupoArticulosUtilizados, $idsGruposArticulos);
        $grupoEquiposSinUtilizar = array_diff($idsGrupoEquipoUtilizados, $idsGruposEquipos);


        $grupoArticulosSinUtilizarString = implode(',', $grupoArticulosSinUtilizar ?: [0]);
        $grupoEquiposSinUtilizarString = implode(',', $grupoEquiposSinUtilizar ?: [0]);

        $sqlEliminarDetalles = "DELETE $this->tablaPresupuestoDetalleRelacion,  $this->tablaPresupuestoDetalle 
        FROM $this->tablaPresupuestoDetalleRelacion
        LEFT JOIN $this->tablaPresupuestoDetalle  ON $this->tablaPresupuestoDetalleRelacion.id_detalle = $this->tablaPresupuestoDetalle.id
        WHERE 
        $this->tablaPresupuestoDetalleRelacion.id_presupuesto = '$this->idPresupuesto' AND
        id_grupo_articulo IN ($grupoArticulosSinUtilizarString) OR 
        id_activos_fijos_grupos_equipos IN ($grupoEquiposSinUtilizarString)";

        $this->repositoryDynamicsCrud->sqlFunction($sqlEliminarDetalles);
    }

    public function eliminarPresupuestos(string $id): Response
    {
        $id = $this->desencriptarKey(base64_decode($id));
        $presupuestoExistente = $this->validarDatoPorId($id, $this->tablaPresupuesto, "Presupuesto");
        if ($presupuestoExistente) {
            return $presupuestoExistente;
        }
        $sql = $this->sqlPresupuestosConRelacion->sqlEliminarPresupuestoPorId($id);
        $this->repositoryDynamicsCrud->sqlFunction($sql);

        return response()->json("Presupuesto eliminado", 200);
    }

    public function actualizarEstadoPresupuestos(string $id): Response
    {
        return response()->json("", 200);
    }


    private function validarFks(array $detalles)
    {
        $this->validarParejasUnicas($detalles);
    }

    private function validarParejasUnicas(array $detalles): void
    {
        $parejasUnicas = [];

        foreach ($detalles as $detalle) {
            $idCentroTrabajo = $detalle["id_centro_trabajo"];
            $idActivoFijo = $detalle["id_activos_fijos_grupos_equipos"] ?? null;
            $idGrupoArticulo = $detalle["id_grupo_articulo"] ?? null;

            if ($idActivoFijo) {
                $mensageError = "No se puede repetir el centro de trabajo con el grupo de equipo";
                $this->verificarDuplicado($parejasUnicas, $idCentroTrabajo, $idActivoFijo, 'id_activos_fijos_grupos_equipos', $mensageError);
            }

            if ($idGrupoArticulo) {
                $mensageError = "No se puede repetir el centro de trabajo con el grupo de artículo";
                $this->verificarDuplicado($parejasUnicas, $idCentroTrabajo, $idGrupoArticulo, 'id_grupo_articulo', $mensageError);
            }

            $parejasUnicas[] = $detalle;
        }
    }

    private function verificarDuplicado(array $parejasUnicas, $idCentroTrabajo, $idCampo, $campoClave, $mensajeError): void
    {
        foreach ($parejasUnicas as $parejaUnica) {
            if (isset($parejaUnica[$campoClave]) && $parejaUnica[$campoClave] == $idCampo && $parejaUnica['id_centro_trabajo'] == $idCentroTrabajo) {
                throw new \Exception($mensajeError, 404);
            }
        }
        // if (isset($parejaUnica['id_activos_fijos_grupos_equipos'])) {
        //     if ($validarActivoFijo && $idActivoFijo == $parejaUnica['id_activos_fijos_grupos_equipos'] && $idCentroTrabajo == $parejaUnica['id_centro_trabajo']) {
        //         throw new \Exception("No se puede repetir el centro trabajo con el activo fijo", 404);

        //     }
        // }

        // if (isset($parejaUnica['id_grupo_articulo'])) {
        //     if ($validarGrupoArticulo && $idGrupoArticulo == $parejaUnica['id_grupo_articulo'] && $idCentroTrabajo == $parejaUnica['id_centro_trabajo']) {
        //         throw new \Exception("No se puede repetir el centro trabajo con el grupo articulo", 404);
        //     }
        // }
    }

    private function validarIdsUnicosBaseDeDatos(string $tabla, bool $activoFijo, $id, $idCentroTrabajo): void
    {
        $sql = "SELECT * FROM $tabla WHERE id_centro_trabajo = '$idCentroTrabajo' ";
        $datoRepetido = false;
        if ($activoFijo) {
            $sql .= " AND id_activos_fijos_grupos_equipos = '$id' ";
            $datoRepetido = true;
        } else {
            $sql .= " AND id_grupo_articulo = '$id'";
        }
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (count($response) > 0) {
            $message = $datoRepetido ? "Activo fijo" : "Grupo articulo";
            throw new \Exception("Ya hay un $message  relacionado con el centro de trabajo", 404);
        }
    }

    private function validarFechas($fechaInicio, $fechaFin, $registroEditado = false)
    {
        $fechaInicio = strtotime($fechaInicio);
        $fechaFin = strtotime($fechaFin);
        if ($fechaFin < $fechaInicio) {
            throw new \Exception("La fecha final no puede ser antes a la fecha de inicial", 404);
        }

        $sql = $this->sqlPresupuestosConRelacion->sqlObtenerUltimaFechaFin();
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        $fechaFinDb = strtotime($response[0]->nueva_fecha_fin);
        if (($fechaFinDb) && $fechaInicio != $fechaFinDb) {
            $fechaFinDb = date('Y-m-d', $fechaFinDb);
            $mensaje = ($registroEditado) ? "La fecha ya se esta utilizando en otro presupuesto" : "La fecha de inicio tiene que ser continua a la  del ultimo presupuesto : $fechaFinDb";
            throw new \Exception($mensaje, 404);
        }
    }

    private function validarDatoPorId(string $id, string $tabla, $nombreValidacion)
    {
        $response = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $tabla WHERE id = '$id'");

        if (count($response) == 0) {
            return response()->json("$nombreValidacion no encontrado", 404);
        }
        return null;
    }
    private function mapperPresupuesto(array $presupuestoNuevo, bool $registroParaCrear): array
    {

        $presupuesto = [
            'presupuesto' => [
                'id_usuario' => Auth::user()->id,
                'nombre_presupuesto' => $presupuestoNuevo["nombre_presupuesto"],
                'descripcion' => $presupuestoNuevo["descripcion"],

                'estado' => $presupuestoNuevo["estado"],
                'valor_tope' => null,
                'fecha_creacion' => $registroParaCrear ? $this->date : ($presupuestoNuevo["fecha_creacion"] ?? null),
                'fecha_modificacion' => $registroParaCrear ? null : $this->date,
            ],
            'detalles' => array_map(function ($detalle) use ($registroParaCrear, $presupuestoNuevo) {
                $nuevosDetalles = [
                    'id_grupo_articulo' => $detalle["id_grupo_articulo"] ?? null,
                    'id_activos_fijos_grupos_equipos' => $detalle["id_activos_fijos_grupos_equipos"] ?? null,
                    'id_centro_trabajo' => $detalle["id_centro_trabajo"],
                    'costo_unitario' => $detalle["costo_unitario"],
                    'comentarios' => $detalle["comentarios"],
                ];
                if ($registroParaCrear) {
                    $nuevosDetalles["fecha_creacion"] = $this->date;
                } else {
                    $nuevosDetalles["fecha_modificacion"] = $this->date;
                }


                return $nuevosDetalles;
            }, $presupuestoNuevo["detalles"])
        ];
        if (isset($presupuestoNuevo['fecha_inicio']) && isset($presupuestoNuevo['fecha_fin'])) {
            $presupuesto['presupuesto']['fecha_inicio'] = $presupuestoNuevo['fecha_inicio'];
            $presupuesto['presupuesto']['fecha_fin'] = $presupuestoNuevo['fecha_fin'];
        }
        return $presupuesto;
    }

    private function obtenerRelacion(array $detalles): array
    {
        return array_map(fn($detalleId) => [
            'id_presupuesto' => $this->idPresupuesto,
            'id_detalle' => $detalleId
        ], $detalles);
    }

    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}
