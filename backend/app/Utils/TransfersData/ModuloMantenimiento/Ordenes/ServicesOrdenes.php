<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Ordenes;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Data\Dtos\Ordenes\Request\OrdenCreateDTO;
use App\Data\Dtos\Ordenes\Request\RequestOrdenCreateDTO;
use App\Data\Dtos\Ordenes\Request\Tecnicos\TecnicosDTO;
use App\Data\Dtos\Solicitudes\Request\RequestCreateSolicitudDTO;
use App\Data\Dtos\Solicitudes\Response\SolicitudDTO;
use App\Models\modulo_mantenimiento\mantenimiento_ordenes_view;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloMantenimiento\CSolicitudes;
use App\Utils\Constantes\ModuloMantenimiento\Ordenes\COrdenes;
use App\Utils\Constantes\ModuloMantenimiento\Ordenes\COrdenesTecnicos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesSolicitudes;
use App\Utils\TransfersData\ModuloMantenimiento\Ordenes\Repository\IOrdenRepository;
use App\Utils\TransfersData\ModuloMantenimiento\Repositories\Solicitudes\ISolicitudRepository;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServicesOrdenes extends RepositoryDynamicsCrud implements IServicesOrdenes
{
    protected IServicesSolicitudes $_solicitudes;
    protected CSolicitudes $_cSolicitudes;
    protected COrdenes $_COrdenes;
    protected COrdenesTecnicos $_CTecnicosOrden;

    protected ISolicitudRepository $solicitudRepository;
    protected IOrdenRepository $ordenRepository;

    public function __construct(
        IServicesSolicitudes $iServicesSolicitudes,
        CSolicitudes $cSolicitudes,
        COrdenes $cOrdenes,
        COrdenesTecnicos $cOrdenesTecnicos,
        ISolicitudRepository $iSolicitudRepository,
        IOrdenRepository $iOrdenRepository,
    ) {
        $this->_solicitudes = $iServicesSolicitudes;
        $this->_cSolicitudes = $cSolicitudes;
        $this->_COrdenes = $cOrdenes;
        $this->_CTecnicosOrden = $cOrdenesTecnicos;
        $this->solicitudRepository = $iSolicitudRepository;
        $this->ordenRepository = $iOrdenRepository;
    }

    public function crearOrdenes(RequestOrdenCreateDTO $requestOrdenCreateDTO)
    {
        $usuario = Auth::user();
        $idUsuario = $usuario->id;
        $tipoCargo = $usuario->tipo_cargo;

        if ($tipoCargo != 2) {
            throw new Exception("No puede realizar esto", Response::HTTP_UNAUTHORIZED);
        }

        $requestOrdenCreateDTO->solicitud->origen = 1;
        $requestOrdenCreateDTO->solicitud->estadoId = 2;

        $solicitudDTO = new SolicitudDTO($this->_solicitudes->crearSolicitud($requestOrdenCreateDTO->solicitud));

        $ordenCreateDTO = new OrdenCreateDTO();
        $ordenCreateDTO->idSolicitud = $solicitudDTO->idSolicitud;
        $ordenCreateDTO->idOrden = $solicitudDTO->idSolicitud;
        $ordenCreateDTO->idUsuario = $idUsuario;

        $this->ordenRepository->create($ordenCreateDTO->toArray());

        $this->CrearTecnicosxAsignacionActas($requestOrdenCreateDTO->tecnicos, $ordenCreateDTO->idOrden);

        return true;
    }
    public function asignarOrdenes(RequestOrdenCreateDTO $requestOrdenCreateDTO, $id)
    {
        $usuario = Auth::user();
        $tipoCargo = $usuario->tipo_cargo;

        if ($tipoCargo != 2) {
            throw new Exception("No puede realizar esto", Response::HTTP_UNAUTHORIZED);
        }

        $tablaOrdenes = tablas::getTablaClienteMantenimientoOrdenes();
        $tablaOrdenesTecnicos = tablas::getTablaClienteOrdenesTecnicos();

        $keySolicitudId = "solicitud_id";

        if (sizeof($requestOrdenCreateDTO->tecnicos) < 0) {
            throw new Exception("Sin Tecnicos para la orden", Response::HTTP_NOT_FOUND);
        }

        $solicitudDTO = new SolicitudDTO($this->solicitudRepository->getBySolicitudId($id));

        $orden = $this->solicitudRepository->getBySolicitudId($solicitudDTO->idSolicitud);
        // $verificacionSolicitudEnOrden = $this->sqlFunction("SELECT * FROM $tablaOrdenes WHERE $keySolicitudId = '$id'");

        $ordenId = null;

        if (!$orden) {

            $ordenCreateDTO = new OrdenCreateDTO();

            $ordenCreateDTO->idOrden = $solicitudDTO->idSolicitud;
            $ordenCreateDTO->idUsuario = $usuario->id;
            $ordenCreateDTO->idSolicitud = $solicitudDTO->idSolicitud;

            $this->ordenRepository->create($ordenCreateDTO->toArray());
            $ordenId = $solicitudDTO->idSolicitud;
        } else {
            $ordenId = $orden->id_orden;
        }

        $tecnicosEnOrdenes = $this->sqlFunction("SELECT * FROM $tablaOrdenesTecnicos WHERE orden_id = '$ordenId'");

        if (empty($tecnicosEnOrdenes)) {
            $attributes = [
                "estado_id" => 2,
            ];
            $this->solicitudRepository->updateById($solicitudDTO->id, $attributes);
        }

        $requestOrdenCreateDTO->tecnicos = array_map(function (TecnicosDTO $tecnicoDTO) use ($solicitudDTO) {
            $tecnicoDTO->ordenId = $solicitudDTO->idSolicitud;
            return $tecnicoDTO;
        }, $requestOrdenCreateDTO->tecnicos);

        return $this->CrearTecnicosxAsignacionActas($requestOrdenCreateDTO->tecnicos, $ordenId, $tecnicosEnOrdenes);
    }

    public function eliminarOrdenes($id)
    {
        $idOrden = $id;

        $tabalCAsigActas = tablas::getTablaClienteMantenimientoAsigActas();
        $tabalCMactas = tablas::getTablaClienteMantenimientoActas();
        $tabalCMActasDiagnostico = tablas::getTablaClienteMantenimientoActasDiagnostico();
        $tablaCMantenimientoSolicitudes = tablas::getTablaClienteMantenimientoSolicitudes();
        $tablaCMantenimientoOrdenes = tablas::getTablaClienteMantenimientoOrdenes();

        $validacion = $this->sqlFunction("SELECT * FROM $tabalCAsigActas mac 
        INNER JOIN $tabalCMactas ma ON mac.id = ma.asig_acta_id WHERE mac.orden_id= '$idOrden'");

        $ordenExist = $this->sqlFunction("SELECT id FROM $tablaCMantenimientoOrdenes WHERE id_orden = '$idOrden'");

        if (empty($ordenExist))
            return;

        if (empty($validacion)) {
            $solicitud = $this->sqlFunction("SELECT solicitud_id FROM $tablaCMantenimientoOrdenes WHERE id_orden = '$idOrden'");
            $idSolicitud = (!empty($solicitud)) ? $solicitud[0]->solicitud_id : null;

            if ($idSolicitud != null) {
                $this->sqlFunction("DELETE FROM $tablaCMantenimientoSolicitudes WHERE id_solicitud ='$idSolicitud' AND origen = '1'");
            }
            $this->sqlFunction("DELETE FROM $tabalCAsigActas WHERE orden_id = '$idOrden'");
            $this->sqlFunction($this->_COrdenes->sqlDeleteAsignacionXacta($idOrden));
            $this->sqlFunction($this->_COrdenes->sqlDelete($idOrden));
            return true;
        }

        throw new Exception("Esta orden tiene un diagnostico, imposible eliminar", 1);
    }

    public function getOrdenesAll()
    {

        $datatableDTO = new DatatableResponseDTO();

        $usuario = Auth::user();

        if (!$this->isAuthorized($usuario)) {
            response()->json($datatableDTO);
        }

        $connection = RepositoryDynamicsCrud::findConectionDB();
        $mantenimientoOrdenesView = new mantenimiento_ordenes_view();
        $mantenimientoOrdenesViewQuery = mantenimiento_ordenes_view::on($connection);

        $request = Request::capture();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $mantenimientoOrdenesViewQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($mantenimientoOrdenesView->getTable());

        $datatableDTO->recordsTotal = $mantenimientoOrdenesViewQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $mantenimientoOrdenesViewQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $mantenimientoOrdenesViewQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $mantenimientoOrdenesViewQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $mantenimientoOrdenesViewQuery->orderBy($columnName, $direction);
                }
            }
        }
        // $mantenimientoOrdenesViewQuery->where('usuario_id', '=', $idUsuario);

        if ($length != -1) {
            $mantenimientoOrdenesViewQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $mantenimientoOrdenesViewQuery->get();
        return response()->json($datatableDTO);
    }
    private function isAuthorized($usuario)
    {
        $tipoCargo = $usuario->tipo_cargo;
        $tipoAdministrador = $usuario->tipo_administrador;

        return ($tipoCargo == 2 && $tipoAdministrador == 4) || ($tipoAdministrador == 3 && $tipoCargo == 2);
    }

    /**
     * Summary of CrearTecnicosxAsignacionActas
     * @param array<\App\Data\Dtos\Ordenes\Request\Tecnicos\TecnicosDTO> $entidadTecnicos
     * @param mixed $idOrden
     * @param mixed $tecnicosEnOrdenes
     * @return array|bool|string
     */
    private function CrearTecnicosxAsignacionActas(array $entidadTecnicos, $idOrden, $tecnicosEnOrdenes = [])
    {
        $tablaCMtipoSolicitudes = tablas::getTablaClienteMantenimientoTipoSolicitud();
        $tablaAUser = tablas::getTablaAppUser();
        $tabalCactas = tablas::getTablaClienteMantenimientoAsigActas();
        $tecnicosCreados = [];

        $keyTipoOrdenId = "tipo_orden_id";
        $keyTecnicoId = "tecnico_id";
        $keyOrdenId = "orden_id";

        foreach ($entidadTecnicos as $orden) {

            $tecnicoId = $this->getTecnicoIdByEmail($orden->tecnicoId, $tablaAUser);
            $orden->tecnicoId = $tecnicoId;

            $actasCreadas = $this->sqlFunction("SELECT id FROM $tabalCactas WHERE $keyOrdenId = '{$orden->ordenId}' AND $keyTipoOrdenId = '{$orden->tipoOrdenId}' limit 1");

            $posicion = array_search($tecnicoId, array_column($tecnicosEnOrdenes, $keyTecnicoId));

            if ($tecnicoId) {
                array_push($tecnicosCreados, $orden->toArray());
            }

            if ($tecnicoId && $posicion == "") {
                $tipoOrden = $this->getTipoOrdenByCodigo($orden->tipoOrdenId, $tablaCMtipoSolicitudes);

                if (!empty($tipoOrden)) {
                    $this->sqlFunction($this->_CTecnicosOrden->sqlInsert($orden->toArray()));

                    if (empty($actasCreadas)) {
                        $asignacionActa[$keyOrdenId] = $orden->ordenId;
                        $asignacionActa[$keyTipoOrdenId] = $orden->tipoOrdenId;
                        $this->sqlFunction($this->_COrdenes->sqlAsignacionActaInMantenimientoActas($asignacionActa));
                    }
                }
            }
        }

        return $this->eliminarTecnicosNoEnLista($tecnicosCreados, $tecnicosEnOrdenes);
    }

    private function eliminarTecnicosNoEnLista($tecnicosCreados, $tecnicosEnOrdenes)
    {
        $keyTecnicoId = "tecnico_id";
        $keyOrdenId = "orden_id";
        $keyTipoOrdenId = "tipo_orden_id";

        $tecnicosNoEnLista = array_udiff($tecnicosEnOrdenes, $tecnicosCreados, function ($a, $b) {
            $keyTecnicoId = "tecnico_id";
            return $a[$keyTecnicoId] - $b[$keyTecnicoId];
        });

        $tablaOrdenesTecnicos = tablas::getTablaClienteOrdenesTecnicos();
        $tabalCAsigActas = tablas::getTablaClienteMantenimientoAsigActas();
        $tabalCMactas = tablas::getTablaClienteMantenimientoActas();
        $tabalCMActasDiagnostico = tablas::getTablaClienteMantenimientoActasDiagnostico();

        if (!empty($tecnicosNoEnLista)) {
            foreach ($tecnicosNoEnLista as $tecnico) {
                $idOrden = $tecnico[$keyOrdenId];
                $tecnicoId = intval($tecnico[$keyTecnicoId]);
                $idTipoOrden = $tecnico[$keyTipoOrdenId];

                $validacion = $this->sqlFunction("SELECT * FROM $tabalCAsigActas mac 
                INNER JOIN $tabalCMactas ma ON mac.id = ma.asig_acta_id 
                INNER JOIN $tabalCMActasDiagnostico mad ON ma.id = mad.acta_id 
                WHERE mac.$keyOrdenId= '$idOrden' AND mac.$keyTipoOrdenId = '$idTipoOrden'");

                if (empty($validacion)) {
                    $this->sqlFunction("DELETE FROM $tablaOrdenesTecnicos WHERE $keyOrdenId = '$idOrden' AND $keyTecnicoId = '$tecnicoId'");
                    $tecnicosConOrdenes = $this->sqlFunction("SELECT * FROM $tablaOrdenesTecnicos WHERE $keyOrdenId = '$idOrden' AND $keyTipoOrdenId ='$idTipoOrden'");
                    if (empty($tecnicosConOrdenes)) {
                        return $this->sqlFunction("DELETE FROM $tabalCAsigActas WHERE $keyOrdenId = '$idOrden' AND $keyTipoOrdenId ='$idTipoOrden'");
                    }
                }
                ;
            }
        }
    }

    private function getTecnicoIdByEmail($email, $tablaAUser)
    {
        $comprobacion = $this->sqlFunction("SELECT * FROM $tablaAUser WHERE email = '$email'");
        return (!empty($comprobacion)) ? $comprobacion[0]->id : null;
    }

    private function getTipoOrdenByCodigo($codigo, $tablaCMtipoSolicitudes)
    {
        return $this->sqlFunction("SELECT * FROM $tablaCMtipoSolicitudes WHERE codigo = '$codigo'");
    }
}
