<?php

namespace App\Utils\TransfersData\ModuloGestionCompra;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\GestionCompras\SqlRequisiciones;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TypesAdministrators;
use App\Utils\TypesCharges;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ServicioRequisiciones implements IServicioRequisiciones
{
    private string $tablaRequisicion = "", $tablaRequisicionDetalle = "", $tablaArticulos = "", $tablaEquipos = "";
    private string $tablaRequisicionDetalleRelacion = "";
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private SqlRequisiciones $sqlRequisiciones;

    private int $saldoTotalRequisicion = 0;

    private string $date;

    public function __construct()
    {

        $this->tablaRequisicion = tablas::getTablaClienteGcRequisiciones();
        $this->tablaRequisicionDetalle = tablas::getTablaClienteGcDetalleRequisiciones();
        $this->tablaRequisicionDetalleRelacion = tablas::getTablaClienteGcDetalleRequisicionesRelacion();

        $this->tablaArticulos = tablas::getTablaErpInventarioArticulos();
        $this->tablaEquipos = tablas::getTablaClienteActivosFijosEquipos();

        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud();
        $this->sqlRequisiciones = new SqlRequisiciones();
        $this->date = date('Y-m-d');

    }
    public function obtenerRequisiciones(): Response
    {
        $presupuestoCerrado = $this->validarPresupuesto();
        $sql = $this->sqlRequisiciones->obtenerRequisiciones();
        $requisiciones = $this->repositoryDynamicsCrud->sqlFunction($sql);

        $nuevasRequisiciones = [];

        foreach ($requisiciones as $requisicionActual) {
            // $idRequisicion = base64_encode($this->encriptarKey($requisicionActual->idRequisicion));
            $idRequisicion = $requisicionActual->idRequisicion;
            $requisicionEncontrada = collect($nuevasRequisiciones)->firstWhere('id', $idRequisicion);
            if (!$requisicionEncontrada) {
                $nuevaRequisicion = json_decode(json_encode($requisicionActual), true);
                $nuevaRequisicion = (object) [
                    'id' => $idRequisicion,
                    'estadoPresupuestoCerrado' => $nuevaRequisicion['estadoPresupuestoCerrado'],
                    'urgencia' => $nuevaRequisicion['urgenciaRequisicion'],
                    'estado' => $nuevaRequisicion['estadoRequisicion'],
                    'comentarios' => $nuevaRequisicion['comentariosRequisicion'],
                    'proyecto' => $nuevaRequisicion['proyectoRequisicion'],
                    'fechaCreacionRequisicion' => $nuevaRequisicion['fechaCreacionRequisicion'],
                    'nombrePresupuesto' => $nuevaRequisicion['nombrePresupuesto'],
                    'descripcion' => $nuevaRequisicion['descripcionRequisicion'],
                    'usuario' => $nuevaRequisicion['usuario'],
                    'idPresupuesto' => [
                        "id" => $nuevaRequisicion['idPresupuesto'],
                        "descripcion" => $nuevaRequisicion['nombrePresupuesto']
                    ],
                    'idCentroTrabajo' => (object) [
                        "id" => $nuevaRequisicion['idCentroTrabajo'],
                        'descripcion' => $nuevaRequisicion['nominaCentroTrabajo'],
                    ],
                ];
                $nuevaRequisicion->detalles = [];
                $nuevasRequisiciones[] = $nuevaRequisicion;
                $requisicionEncontrada = $nuevaRequisicion;
            }
            $detalleEncontrado = collect($requisicionEncontrada->detalles)->firstWhere('idDetalle', $requisicionActual->idDetalle);
            if (!$detalleEncontrado) {
                // $idDetalleEncriptado = base64_encode($this->encriptarKey($requisicionActual->idDetalle));
                $idDetalleEncriptado = $requisicionActual->idDetalle;
                $detalle = (object) [
                    'id' => $idDetalleEncriptado,
                    "id_articulo" => (object) [
                        "id" => $requisicionActual->idArticulo,
                        "descripcion" => $requisicionActual->descripcionArticulo,
                        "grupo" => $requisicionActual->id_grupo_articulo,
                    ],
                    "id_activo_fijo_equipo" => (object) [
                        "id" => $requisicionActual->idEquipoFijo,
                        "descripcion" => $requisicionActual->descripcionEquipoFijo,
                        "grupo" => $requisicionActual->id_grupo_equipo,
                    ],
                    'cantidad' => $requisicionActual->cantidad,
                    'cantidad_autorizada' => $requisicionActual->cantidadAutorizada,
                    'cantidad_comprada' => $requisicionActual->cantidadComprada,
                    'costo_estimado' => $requisicionActual->costoEstimado,
                    'total_estimado' => $requisicionActual->totalEstimado,
                    'comentarios' => $requisicionActual->comentarios,
                    'ruta_imagen' => $requisicionActual->imagenUrl
                ];
                $requisicionEncontrada->detalles[] = $detalle;
            }
        }
        $datos = [
            "requisiciones" => $nuevasRequisiciones,
            "presupuestoCerrado" => $presupuestoCerrado
        ];
        return new Response(json_encode($datos), 200);
    }
    public function obtenerRequisicionesPorId(string $id)
    {
        $requisiciones = "";
        return new Response(json_encode($requisiciones), 200);
    }

    public function crearRequisiciones(array $requisicionNueva): Response
    {
        try {
            // dump($requisicionNueva);

            if(isset($requisicionNueva['id_presupuesto'])){
                $requisicionNueva['id_presupuesto'] = $this->desencriptarKey(base64_decode($requisicionNueva['id_presupuesto']));
            }
            $this->validarFks($requisicionNueva);
            $presupuestoCerrado = $this->validarPresupuesto();

            if ($presupuestoCerrado) {
                $this->presupuestoCerrado($requisicionNueva);
            }

            $datelles = $this->mappearCantidadDetalles($requisicionNueva['detalles']);
            unset($requisicionNueva['detalles']);
            $requisicionNueva['estado'] = 'Nueva';

            $requisicionNueva['estado_presupuesto_cerrado'] = $presupuestoCerrado;
            $requisicionNueva['id_usuario'] = Auth::user()->id;
            $idsDetallesRequisiciones = array_map(
                callback: fn($detalle): int =>
                $this->repositoryDynamicsCrud->getRecordId($this->tablaRequisicionDetalle, $detalle),
                array: $datelles
            );
            // dump($requisicionNueva);
            $idRequsicionCreada = $this->repositoryDynamicsCrud->getRecordId($this->tablaRequisicion, $requisicionNueva);
            $dataRelaciones = [];
            foreach ($idsDetallesRequisiciones as $idDetalle) {
                $dataRelaciones[] = [
                    'id_requisicion' => $idRequsicionCreada,
                    'id_detalle' => $idDetalle
                ];
            }
            $this->repositoryDynamicsCrud->createInfo($this->tablaRequisicionDetalleRelacion, $dataRelaciones);
            return new Response("Registro creado exitosamente", Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    private function presupuestoCerrado(array $requisicionNueva)
    {
        $idPresupuestoExistente = $requisicionNueva['id_presupuesto'] ?? false;
        $idCentroTrabajoExistente = $requisicionNueva['id_centro_trabajo'] ?? false;
        if (!$idPresupuestoExistente || !$idCentroTrabajoExistente) {
            $datosFaltante = !$idPresupuestoExistente ? "presupuesto" : "centro de trabajo";
            throw new Exception(json_encode("El presupuesto esta cerrado por lo tanto se necesita el $datosFaltante"), 200);
        }
        $sql = $this->sqlRequisiciones->obtenerDetallesPresupuestos($idCentroTrabajoExistente, $idPresupuestoExistente);
        $detallesPresupuestos = $this->repositoryDynamicsCrud->sqlFunction($sql);

        // los articulos asociados a un grupo articulos
        // activos dijos asociados a un grupo de activos fijos
        $detallesRequisiciones = $requisicionNueva['detalles'];
        foreach ($detallesRequisiciones as $detalle) {
            $this->buscarArticuloActivoFijo($detallesPresupuestos, $detalle, );

        }
        return $this->validarSaldosDetalles($detallesRequisiciones, $detallesPresupuestos, $requisicionNueva['fecha_creacion']);

    }
    private function buscarArticuloActivoFijo($detallesPresupuestos, $detalleRequisicion)
    {
        $datoExistente = isset($detalleRequisicion['id_articulo']) ? 'id_articulo' : 'id_activo_fijo_equipo';

        $articuloOActivoFijoExistente = $detalleRequisicion[$datoExistente];
        $idEncontrado = array_search($articuloOActivoFijoExistente, array_column($detallesPresupuestos, $datoExistente));

        if ($idEncontrado === false) {
            throw new Exception(("Hay articulos o equipos que no estan asociados a los grupos seleccionados en el presupuesto"), 200);
        }
    }

    private function validarSaldosDetalles(array $detallesRequisiciones, array $detallesPresupuestos, string $fechaRequisicion): Response|null
    {


        $idsArticulos = array_filter(array_column($detallesPresupuestos, 'id_articulo'));

        $idsActivosFijos = array_filter(array_column($detallesPresupuestos, 'id_activo_fijo'));
        $rangoPresupuesto = $this->consultaPresupuesto($fechaRequisicion);

        if (empty($rangoPresupuesto)) {
            throw Response(json_encode("No se encontro presupuesto para la fecha: $fechaRequisicion"), 200);
        }
        $idsArticulos = !empty($idsArticulos) ? implode(",", $idsArticulos) : 0;
        $idsActivosFijos = (!empty($idsActivosFijos)) ? implode(",", $idsActivosFijos) : 0;

        $sql = $this->sqlRequisiciones->obtenerValoresPresupuesto($rangoPresupuesto[0]->id, $idsArticulos, $idsActivosFijos);
        $costosPresupuestoDetalles = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (!$costosPresupuestoDetalles) {
            throw new Exception("No se encontro detalles del presupuesto", 200);

        }

        $articulosDb = [];
        $activosFijosDb = [];
        foreach ($costosPresupuestoDetalles as $item) {
            if ($item->articulo) {
                array_push($articulosDb, $item);
            } else {
                array_push($activosFijosDb, $item);
            }
        }

        $saldoTotal = 0;

        foreach ($detallesRequisiciones as $item) {

            $cantidad = $item['cantidad_comprada'];
            $precioUnitario = $item['costo_estimado'];

            $saldo = $cantidad * $precioUnitario;
            $posicionDetallePresupuesto = 0;
            $costoDetalle = 0;
            $descripcionDetalle = "";
            if (isset($item['id_articulo'])) {
                $posicionDetallePresupuesto = array_search($item['id_articulo'], array_column($articulosDb, 'idArticulo'));
                $costoDetalle = $articulosDb[$posicionDetallePresupuesto]->costoPresupuestado;
                $descripcionDetalle = $articulosDb[$posicionDetallePresupuesto]->articulo;
            } else {
                $posicionDetallePresupuesto = array_search($item['id_activo_fijo_equipo'], array_column($activosFijosDb, 'idActivoFijo'));
                $costoDetalle = $activosFijosDb[$posicionDetallePresupuesto]->costoPresupuestado;
                $descripcionDetalle = $activosFijosDb[$posicionDetallePresupuesto]->equipo;
            }
            $saldoTotal += $saldo;
            if ($saldo < 0 || $saldo > $costoDetalle) {
                throw new Exception("El $descripcionDetalle no tiene saldo suficiente", Response::HTTP_BAD_REQUEST);
            }

        }

        $valorTotalPresupuesto = $rangoPresupuesto[0]->valor_tope;
        if ($saldoTotal > $valorTotalPresupuesto) {
            throw Response("El saldo total supera el valor tope del presupuesto", Response::HTTP_BAD_REQUEST);
        }
        return null;
    }


    private function consultaPresupuesto($fechaPresupuesto): array
    {

        $sql = $this->sqlRequisiciones->obtenerPresupuestoDeFechaDeRequisicion($fechaPresupuesto);
        return $this->repositoryDynamicsCrud->sqlFunction(sql: $sql);
    }

    private function validarFks($requisicionNueva): void
    {
        $idsArticulos = array_filter(array_column($requisicionNueva['detalles'], 'id_articulo'));
        $idsActivosFijos = array_filter(array_column($requisicionNueva['detalles'], 'id_activo_fijo_equipo'));


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

    private function mappearCantidadDetalles($detalles): array
    {
        return array_map(function ($detalle) {
            $detalle['cantidad_autorizada'] = $detalle['cantidad'];
            return $detalle;
        }, $detalles);
    }

    public function actualizarRequisiciones(string $idRequisicion, array $requisicionEditado): Response
    {
        try {
            
            if (isset($requisicionEditado['id_presupuesto'])) {
                $requisicionEditado['id_presupuesto'] = $this->desencriptarKey(base64_decode($requisicionEditado['id_presupuesto']));
            }


            $this->validarFks($requisicionEditado);

            if ($this->validarPresupuesto()) {
                $this->presupuestoCerrado($requisicionEditado);
            }
            $detallesRequicionCliente = $requisicionEditado['detalles'];
            $detallesDb = $this->obtenerDetallesRequisicionDb($idRequisicion);
            $this->validarDetallesNuevos($detallesRequicionCliente, $detallesDb);
            $this->eliminarDetallesObsoletos($detallesRequicionCliente, $detallesDb);

            $modificarCantidad = $this->permitirModificarCantidadAutorizada();
            $detalleRelacion = $this->procesarDetalles($detallesRequicionCliente, $idRequisicion, $modificarCantidad);


            unset($requisicionEditado['detalles']);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaRequisicion, $requisicionEditado, $idRequisicion);
            $this->repositoryDynamicsCrud->createInfo($this->tablaRequisicionDetalleRelacion, $detalleRelacion);
            return new Response("Requisiciones actualizadas", 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    private function obtenerDetallesRequisicionDb(string $idRequisicion): array
    {
        $sql = $this->sqlRequisiciones->sqlObtenerDetallesRequisicones($idRequisicion);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        return array_column($response, 'id');
    }
    private function validarDetallesNuevos(array $detallesCliente, array $detallesDb): void
    {
        $idsDetallesCliente = array_column($detallesCliente, 'id');
        $idsDetallesNuevos = array_diff($idsDetallesCliente, $detallesDb);

        if (!empty($idsDetallesNuevos)) {
            throw new Exception("Detalles no existentes", Response::HTTP_BAD_REQUEST);
        }
    }
    private function eliminarDetallesObsoletos(array $detallesCliente, array $detallesDb): void
    {
        $idsDetallesCliente = array_column($detallesCliente, 'id');
        $idsDetallesEliminados = array_diff($detallesDb, $idsDetallesCliente);

        if (!empty($idsDetallesEliminados)) {
            $idsEliminadosString = implode(",", $idsDetallesEliminados);
            $sqlEliminar = $this->sqlRequisiciones->sqEliminarDetalles($idsEliminadosString);
            $this->repositoryDynamicsCrud->sqlFunction($sqlEliminar);
        }
    }

    private function procesarDetalles(array $detallesCliente, string $idRequisicion, bool $modificarCantidad): array
    {
        $detalleRelacion = [];

        $saldoTotal = 0;
        foreach ($detallesCliente as $detalle) {
            if (isset($detalle['id'])) {
                $saldoTotal += $detalle['cantidad'] * $detalle['cantidad_autorizada'];
                $this->actualizarDetalle($detalle, $modificarCantidad);
                continue;
            }
            $idDetalle = $this->repositoryDynamicsCrud->getRecordId($this->tablaRequisicionDetalle, $detalle);
            $detalleRelacion[] = [
                'id_requisicion' => $idRequisicion,
                'id_detalle' => $idDetalle
            ];
        }
        $this->saldoTotalRequisicion = $saldoTotal;
        return $detalleRelacion;
    }
    private function actualizarDetalle(array $detalle, bool $modificarCantidad): void
    {
        if (!$modificarCantidad) {
            unset($detalle['cantidad_autorizada']);
        }

        $this->repositoryDynamicsCrud->updateInfo($this->tablaRequisicionDetalle, $detalle, $detalle['id']);
    }



    public function eliminarRequisiciones(string $idRequisicion): Response
    {
        try {
            // $idRequisicion = $this->desencriptarKey(base64_decode($idRequisicion));
            $requisiciones = $this->sqlRequisiciones->sqlEliminarRequisicion($idRequisicion);
            $response = $this->repositoryDynamicsCrud->sqlFunction($requisiciones);
            return new Response($response, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function actualizarEstadoRequisiciones(string $idRequisicion): Response
    {
        $idRequisicion = $this->desencriptarKey($idRequisicion);
        $requisiciones = "";
        return new Response(json_encode($requisiciones), 200);
    }
    private function validarPresupuesto(): bool
    {
        $codigoVariableGlobal = 'GCPC001';
        $sql = "SELECT * FROM configuracion_variables_globales cvg
        LEFT JOIN  respuesta_variables_glb rvg ON rvg.id_variable_global = cvg.id
        WHERE cvg.codigo = '$codigoVariableGlobal'";
    
        $data = $this->repositoryDynamicsCrud->sqlFunction($sql);
        $valor = strtoupper($data[0]->valor);
        return $valor == "SI";
    }

    private function validarAutorizacion(): bool
    {
        $codigoVariableGlobal = 'GCRA001';
        $sql = "SELECT * FROM configuracion_variables_globales cvg
        LEFT JOIN  respuesta_variables_glb rvg ON rvg.id_variable_global = cvg.id
        WHERE cvg.codigo = '$codigoVariableGlobal'";
        $data = $this->repositoryDynamicsCrud->sqlFunction($sql);
        $valor = strtoupper($data[0]->valor);
        return $valor == "SI";
    }

    private function permitirModificarCantidadAutorizada(): bool
    {
        $user = Auth::user();
        $usuarioValido = $user->tipo_administrador == TypesAdministrators::USER || $user->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR;
        $esValida = $this->validarAutorizacion();
        return $esValida && $usuarioValido;

    }

    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }

    public function obtenerArticulosEquipos(): Response
    {
        $sqlArtculos = $this->sqlRequisiciones->sqlObtenerArticulosConGrupos();
        $articulos = $this->repositoryDynamicsCrud->sqlFunction($sqlArtculos);

        $sqlEquipos = $this->sqlRequisiciones->sqlObtenerEquiposConGrupos();
        $equipos = $this->repositoryDynamicsCrud->sqlFunction($sqlEquipos);

        $articulosAsociados = [];
        $equiposAsociados = [];

        foreach ($articulos as $articulo) {
            $grupoArticuloEncontrado = collect($articulosAsociados)->firstWhere('id', $articulo->idGrupoArticulo);
            if (!$grupoArticuloEncontrado) {
                $nuevoGrupoArticulo = (object) [
                    'id' => $articulo->idGrupoArticulo,
                    'descripcion' => $articulo->descripcionArticulo,
                    'articulos' => []
                ];
                $articulosAsociados[] = $nuevoGrupoArticulo;
                $grupoArticuloEncontrado = $nuevoGrupoArticulo;
            }
            $articuloEncontrado = collect($grupoArticuloEncontrado->articulos)->firstWhere('id', $articulo->idArticulo);
            if (!$articuloEncontrado) {
                $grupoArticuloEncontrado->articulos[] = [
                    'id' => $articulo->idArticulo,
                    'descripcion' => $articulo->descripcionArticulo
                ];
            }
        }

        foreach ($equipos as $equipo) {
            $grupoEquipoEncontrado = collect($equiposAsociados)->firstWhere('id', $equipo->idGrupoEquipo);
            if (!$grupoEquipoEncontrado) {
                $nuevoGrupoEquipo = (object) [
                    'id' => $equipo->idGrupoEquipo,
                    'descripcion' => $equipo->descripcionGrupoEquipo,
                    'equipos' => []
                ];
                $equiposAsociados[] = $nuevoGrupoEquipo;
                $grupoEquipoEncontrado = $nuevoGrupoEquipo;
            }
            $equipoEncontrado = collect($grupoEquipoEncontrado->equipos)->firstWhere('id', $equipo->idActivoFijo);
            if (!$equipoEncontrado) {
                $grupoEquipoEncontrado->equipos[] = [
                    'id' => $equipo->idActivoFijo,
                    'descripcion' => $equipo->descripcionActivoFijo
                ];
            }

        }
        $datos = [
            "grupoArticulos" => $articulosAsociados,
            "gruposEquipos" => $equiposAsociados
        ];

        return new Response(json_encode($datos), 200);
    }
}