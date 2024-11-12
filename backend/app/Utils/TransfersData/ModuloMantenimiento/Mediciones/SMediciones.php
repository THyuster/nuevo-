<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Mediciones;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Models\modulo_mantenimiento\mantenimiento_mediciones_view;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloMantenimiento\Combustible\CCombustible;
use App\Utils\Constantes\ModuloMantenimiento\Mediciones\CMediciones;
use App\Utils\Constantes\ModuloNomina\CCentroTrabajo;
use App\Utils\Encryption\EncryptionFunction;
use Illuminate\Contracts\Database\Query\Builder;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\FilterValidation;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloMantenimiento\Combustible\IMantenimientoCombustible;
use App\Utils\TransfersData\ModuloMantenimiento\Horometros\IMantenimientoHorometros;
use App\Utils\TransfersData\ModuloMantenimiento\Kilometros\IMantenimientoKilometros;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class SMediciones extends RepositoryDynamicsCrud implements IMediciones
{
    private IMantenimientoCombustible $icombustible;
    private IMantenimientoHorometros $ihorometros;
    private IMantenimientoKilometros $iKilometros;
    private CCentroTrabajo $cCentroTrabajo;
    private CMediciones $cMediciones;
    private $tablaCMantenimientoHkc;
    private $tablaCMantenimientoKilomentrosLeftJoin;
    private $tablaCMantenimientoHoromentrosInnerJoin;
    private $tablaCMantenimientoCombustibleInnerJoin;
    private $tablaCcentrosTrabajos;
    private $tablaCEstacionesServicios;
    private $tablaCLogisticaCombustibles;

    public function __construct(IMantenimientoCombustible $ic, IMantenimientoHorometros $ih, IMantenimientoKilometros $ik, CMediciones $cm, CCentroTrabajo $ct)
    {
        $this->icombustible = $ic;
        $this->ihorometros = $ih;
        $this->iKilometros = $ik;
        $this->cMediciones = $cm;
        $this->cCentroTrabajo = $ct;
        $this->tablaCMantenimientoHkc = tablas::getTablaClienteMantenimientoRelacionHKC();
        $this->tablaCMantenimientoKilomentrosLeftJoin = tablas::getTablaClienteMantenimientoKilometros();
        $this->tablaCMantenimientoHoromentrosInnerJoin = tablas::getTablaClienteMantenimientoHorometros();
        $this->tablaCMantenimientoCombustibleInnerJoin = tablas::getTablaClienteMantenimientoCombustible();
        $this->tablaCcentrosTrabajos = tablas::getTablaClienteNominaCentrosTrabajos();
        $this->tablaCEstacionesServicios = tablas::getTablaClienteMantenimientoEstacionesServicio();
        $this->tablaCLogisticaCombustibles = tablas::getTablaClienteLogisticaCombustibles();
    }

    public function getMediciones()
    {

        $connection = RepositoryDynamicsCrud::findConectionDB();
        $mantenimientoMedicionesView = new mantenimiento_mediciones_view();
        $mantenimientoMedicionesViewQuery = mantenimiento_mediciones_view::on($connection);
        $datatableDTO = new DatatableResponseDTO();

        $request = Request::capture();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $mantenimientoMedicionesViewQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($mantenimientoMedicionesView->getTable());

        $datatableDTO->recordsTotal = $mantenimientoMedicionesViewQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $mantenimientoMedicionesViewQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $mantenimientoMedicionesViewQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $mantenimientoMedicionesViewQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $mantenimientoMedicionesViewQuery->orderBy($columnName, $direction);
                }
            }
        }
        // $mantenimientoMedicionesViewQuery->where('usuario_id', '=', $idUsuario);

        if ($length != -1) {
            $mantenimientoMedicionesViewQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $mantenimientoMedicionesViewQuery->get();
        return response()->json($datatableDTO);
        // $campos = [
        //     "placa_vehiculo",
        //     "codigo_equipo",
        //     "fecha_creacion",
        //     "observaciones",
        //     "centro_trabajo",
        //     "proveedor",
        //     "tipo_combustible",
        //     "costo_por_unidad",
        //     "cantidad_combustible",
        //     "total",
        //     "id"
        // ];

        // $columns = [];

        // for ($i = 0; $i < sizeof($campos); $i++) {
        //     $columns[] = [
        //         'db' => $campos[$i],
        //         'dt' => $i,
        //     ];
        // }

        // $request = Request::capture();

        // $query = $this->searchMedicion();
        // $totalRecords = $query->count();

        // if ($request->has('search') && $request->input('search.value')) {
        //     $searchValue = $request->input('search.value');

        //     $query->where(function ($q) use ($campos, $searchValue) {
        //         foreach ($campos as $campo) {
        //             $q->orWhere($campo, 'LIKE', "%$searchValue%");
        //         }
        //     });
        // }

        // $filteredRecords = $query->count();

        // // return ;
        // foreach ($request->input('order') as $order) {
        //     $columnIndex = $order['column'];
        //     $columnName = $columns[$columnIndex]['db'];
        //     $direction = $order['dir'];
        //     $query->orderBy($columnName, $direction);
        // }


        // $start = $request->input('start', 0);
        // $length = $request->input('length', 10);

        // if ($length != -1) {
        //     $query->offset($start)->limit($length);
        // }

        // $data = $query->get();

        // $response = [
        //     "draw" => intval($request->input('draw', 1)),
        //     "recordsTotal" => $totalRecords,
        //     "recordsFiltered" => $filteredRecords,
        //     "data" => $data->toArray(),
        // ];

        // return json_encode($response);
    }

    private function searchMedicion()
    {
        $campos = [
            "placa_vehiculo",
            "codigo_equipo",
            "fecha_creacion",
            "observaciones",
            "centro_trabajo",
            "proveedor",
            "tipo_combustible",
            "costo_por_unidad",
            "cantidad_combustible",
            "total",
            "id"
        ];
        $query = $this->sqlSSR("mantenimiento_mediciones_view", $campos);
        return $query;
    }

    public function addMediciones($mediciones)
    {
        $idUnique = Uuid::uuid4()->toString();
        $validacion = null;
        $option = null;
        $entidadMedicion = null;
        $posicion = 0;

        $this->ValidacionLlegada($mediciones);

        $keyEquipoId = "equipo_id";
        $keyVehiculoId = "vehiculo_id";
        $tablaActivosFijos = "activos_fijos_equipos";
        $tablaLogisticaVehiculos = "logistica_vehiculos";

        $id = (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] !== null) ? $mediciones[$keyEquipoId] : $mediciones[$keyVehiculoId];
        $table = (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] !== null) ? $tablaActivosFijos : $tablaLogisticaVehiculos;
        $option = (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] !== null) ? 1 : 2;

        $campoWhere = $table == $tablaActivosFijos ? "codigo" : "placa";
        $validacion = $this->sqlFunction("SELECT * FROM $table WHERE  $campoWhere = '$id'");

        if (empty($validacion)) {
            throw new Exception(__("messages.notDataFoundMessages"), Response::HTTP_NOT_FOUND);
        }

        $atributo = (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] !== null) ? $keyEquipoId :  $keyVehiculoId;
        $entidadMedicion[$atributo] = $validacion[$posicion]->id;

        $keyCentroTrabajo = "centro_trabajo";
        $entidadMedicion[$keyCentroTrabajo] = (array_key_exists($keyCentroTrabajo, $mediciones) && $mediciones[$keyCentroTrabajo] !== null) ? $mediciones[$keyCentroTrabajo] : null;

        $centros = $this->sqlFunction($this->cCentroTrabajo->sqlSelectById($mediciones[$keyCentroTrabajo]));

        if (empty($centros)) {
            throw new Exception(__("messages.nonExistentWorkCenterError"), Response::HTTP_NOT_FOUND);
        }

        $keyFechaRegistro = "fecha_registro";
        $mediciones[$keyFechaRegistro] = (array_key_exists($keyFechaRegistro, $mediciones)) ? $mediciones[$keyFechaRegistro] : null;

        if (!FilterValidation::esFechaValida($mediciones[$keyFechaRegistro])) {
            throw new Exception("Fecha no valida", 1);
        }

        $keyCombustible = "combustible";
        $keyHoromentros = "horometros";
        $keyKilometros = "kilometros";

        $combustible = (array_key_exists($keyCombustible, $mediciones)) ? $mediciones[$keyCombustible] : null;
        $horomentros = (array_key_exists($keyHoromentros, $mediciones)) ? $mediciones[$keyHoromentros] : null;
        $kilometros = (array_key_exists($keyKilometros, $mediciones)) ? $mediciones[$keyKilometros] : null;

        $keySubsidio = "subsidio";
        $combustible[$keySubsidio] = (array_key_exists($keySubsidio, $mediciones) && $mediciones[$keySubsidio]) ? $mediciones[$keySubsidio] : $posicion;

        if ($option == 1 && $combustible == null && $horomentros == null || $option == 1 && $this->ValidarCampos($combustible) && $this->ValidarCampos($horomentros)) {
            throw new Exception(__("messages.missingInformationError"), Response::HTTP_CONFLICT);
        }

        if ($option == 2 && $combustible == null && $horomentros == null && $kilometros == null || $option == 2 && $this->ValidarCampos($combustible) && $this->ValidarCampos($horomentros) && $this->ValidarCampos($kilometros)) {
            throw new Exception(__("messages.missingInformationError"), Response::HTTP_CONFLICT);
        }

        $keyId = "id";
        $keyKilometroId = "kilometro_id";
        $keyCombustibleId = "combustible_id";
        $keyHorometrosId = "horometro_id";

        if ($option == 2 && !$this->ValidarCampos($kilometros)) {
            $kilometros[$keyId] = $idUnique;
            $this->iKilometros->addIMantenimientoKilometros($kilometros);
            $entidadMedicion[$keyKilometroId] = $kilometros[$keyId];
        }

        if (!$this->ValidarCampos($horomentros)) {
            $horomentros[$keyId] = $idUnique;
            $this->ihorometros->addIMantenimientoHorometros($horomentros);

            $entidadMedicion[$keyHorometrosId] = $horomentros[$keyId];
        }

        if (!$this->ValidarCampos($combustible)) {
            $keyUnidad = "unidad";
            $keyTipoCombustible = "tipo_combustible";
            $keyProveedor = "proveedor";

            $combustible[$keyId] = $idUnique;
            $combustible[$keyUnidad] = intval($combustible[$keyUnidad]);
            $combustible[$keyTipoCombustible] = intval($combustible[$keyTipoCombustible]);
            $combustible[$keyProveedor] = intval(EncryptionFunction::StaticDesencriptacion($combustible[$keyProveedor]));

            $this->icombustible->addIMantenimientoCombustible($combustible);
            $entidadMedicion[$keyCombustibleId] = $idUnique;
        }

        $keyObservaciones = "observaciones";
        $entidadMedicion[$keyObservaciones] = (array_key_exists($keyObservaciones, $mediciones) && $mediciones[$keyObservaciones] !== null) ? $mediciones[$keyObservaciones] : null;

        $entidadMedicion["user_id"] = Auth::user()->id;
        $entidadMedicion[$keyFechaRegistro] = $mediciones[$keyFechaRegistro];

        $status = $this->sqlFunction($this->cMediciones->sqlInsert($entidadMedicion));

        return $status;
    }
    public function removeMediciones($id)
    {
        $idRelacion = $id;
        $posicion = 0;
        $entidadRelacionHkc = $this->sqlFunction("SELECT equipo_id,vehiculo_id,combustible_id,kilometro_id,horometro_id FROM $this->tablaCMantenimientoHkc WHERE id = '$idRelacion'");

        $equipoId = $entidadRelacionHkc[$posicion]->equipo_id;
        $vehiculoId = $entidadRelacionHkc[$posicion]->vehiculo_id;

        if (empty($entidadRelacionHkc)) {
            throw new Exception(__("messages.notDataFoundMessages"), Response::HTTP_NOT_FOUND);
        }

        if (($equipoId !== null && $vehiculoId !== null) || ($equipoId == null && $vehiculoId == null)) {
            throw new Exception(__("messages.internalError"), 1);
        }

        $optionRelacion = ($equipoId !== null) ? 1 : 2;

        $table = ($optionRelacion == 1) ? "activos_fijos_equipos" : "logistica_vehiculos";
        $idRelacion = ($optionRelacion == 1) ? $equipoId : $vehiculoId;

        $validacion = $this->sqlFunction("SELECT * FROM $table WHERE id = '$idRelacion'");

        if (empty($validacion)) {
            $mensaje = ($optionRelacion == 1) ? "El equipo no existe" : "El vehiculo no exite";
            throw new Exception($mensaje, 1);
        }

        $combustibleId = $entidadRelacionHkc[$posicion]->combustible_id;
        $kilometrosId = $entidadRelacionHkc[$posicion]->kilometro_id;
        $horomentrosId = $entidadRelacionHkc[$posicion]->horometro_id;

        $Combustible = $combustibleId !== null ? true : false;
        $Kilometro = $kilometrosId !== null ? true : false;
        $Horometro = $horomentrosId !== null ? true : false;

        if ($Kilometro) {
            $this->iKilometros->removeIMantenimientoKilometros($kilometrosId);
        }
        if ($Horometro) {
            $this->ihorometros->removeIMantenimientoHorometros($horomentrosId);
        }
        if ($Combustible) {
            $this->icombustible->removeIMantenimientoCombustible($combustibleId);
        }

        return $this->sqlFunction($this->cMediciones->sqlDelete($id));
    }
    public function updateMediciones($id, $mediciones)
    {

        $posicion = 0;
        $idRelacion = $id;
        $medicionesEntidad = null;
        $idUnique = uniqid();

        $this->ValidacionLlegada($mediciones);

        $entidadRelacionHkc = $this->sqlFunction("SELECT * FROM $this->tablaCMantenimientoHkc WHERE id = '$idRelacion'");

        if (empty($entidadRelacionHkc)) {
            throw new Exception(__("messages.notFoundMessages"), Response::HTTP_NOT_FOUND);
        }

        $equipoId = $entidadRelacionHkc[$posicion]->equipo_id;
        $vehiculoId = $entidadRelacionHkc[$posicion]->vehiculo_id;

        if (($equipoId !== null && $vehiculoId !== null) || ($equipoId == null && $vehiculoId == null)) {
            return response(__("messages.internalError"), Response::HTTP_BAD_REQUEST);
        }

        $keyEquipoId = "equipo_id";
        $keyVehiculoId = "vehiculo_id";

        $optionRelacion = ($equipoId !== null) ? 1 : 2;
        $atributoRelacion = ($optionRelacion === 1) ? $keyEquipoId : $keyVehiculoId;
        $medicionesEntidad[$atributoRelacion] = ($equipoId !== null) ? $equipoId : $vehiculoId;

        $keyCombustibleId = "combustible_id";
        $keyHorometrosId = "horometro_id";
        $keyKilometroId = "kilometro_id";

        $combustibleId = $entidadRelacionHkc[$posicion]->combustible_id;
        $kilometrosId = $entidadRelacionHkc[$posicion]->kilometro_id;
        $horomentrosId = $entidadRelacionHkc[$posicion]->horometro_id;

        $medicionesEntidad[$keyCombustibleId] = ($combustibleId !== null) ? $combustibleId : null;
        $medicionesEntidad[$keyHorometrosId] = ($horomentrosId !== null) ? $horomentrosId : null;

        if ($optionRelacion === 2) {
            $medicionesEntidad[$keyKilometroId] = ($kilometrosId !== null) ? $kilometrosId : null;
        }

        $tablaActivosFijos = "activos_fijos_equipos";

        $keyFechaRegistro = "fecha_registro";
        $medicionesEntidad[$keyFechaRegistro] = (array_key_exists($keyFechaRegistro, $mediciones)) ? $mediciones[$keyFechaRegistro] : null;

        $id = (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] !== null) ? $mediciones[$keyEquipoId] : $mediciones[$keyVehiculoId];
        $table = (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] !== null) ? $tablaActivosFijos : "logistica_vehiculos";
        $option = (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] !== null) ? 1 : 2;

        if ($option !== $optionRelacion) {
            return response(__("messages.invalidActionMessage"), Response::HTTP_CONFLICT);
        }

        $campoWhere = $table == $tablaActivosFijos ? "codigo" : "placa";
        $validacion = $this->sqlFunction("SELECT * FROM $table WHERE  $campoWhere = '$id' ");

        if (empty($validacion)) {
            throw new Exception(__("messages.notDataFoundMessages"), Response::HTTP_NOT_FOUND);
        }

        $keyCentroTrabajo = "centro_trabajo";
        $medicionesEntidad[$keyCentroTrabajo] = (array_key_exists($keyCentroTrabajo, $mediciones) && $mediciones[$keyCentroTrabajo] !== null) ? $mediciones[$keyCentroTrabajo] : null;

        $centros = $this->sqlFunction($this->cCentroTrabajo->sqlSelectById($mediciones[$keyCentroTrabajo]));

        if (empty($centros)) {
            return response(__("messages.nonExistentWorkCenterError"), Response::HTTP_NOT_FOUND);
        }

        $keyCombustible = "combustible";
        $keyHoromentros = "horometros";
        $keyKilometros = "kilometros";

        $combustible = (array_key_exists($keyCombustible, $mediciones)) ? $mediciones[$keyCombustible] : null;
        $horomentros = (array_key_exists($keyHoromentros, $mediciones)) ? $mediciones[$keyHoromentros] : null;
        $kilometros = (array_key_exists($keyKilometros, $mediciones)) ? $mediciones[$keyKilometros] : null;

        $keySubsidio = "subsidio";
        $combustible[$keySubsidio] = (array_key_exists($keySubsidio, $mediciones)) ? $mediciones[$keySubsidio] : $posicion;
        // return $combustible[$keySubsidio];

        if ($option == 1 && $combustible == null && $horomentros == null || $option == 1 && $this->ValidarCampos($combustible) && $this->ValidarCampos($horomentros)) {
            return response(__("messages.missingInformationError"), Response::HTTP_NO_CONTENT);
        }

        if ($option == 2 && $combustible == null && $horomentros == null && $kilometros == null || $option == 2 && $this->ValidarCampos($combustible) && $this->ValidarCampos($horomentros) && $this->ValidarCampos($kilometros)) {
            return response(__("messages.missingInformationError"), Response::HTTP_NO_CONTENT);
        }

        $keyId = "id";
        if ($option == 2 && !$this->ValidarCampos($kilometros)) {

            if ($medicionesEntidad[$keyKilometroId] === null) {
                $kilometros[$keyId] = $idUnique;
                $this->iKilometros->addIMantenimientoKilometros($kilometros);
                $medicionesEntidad[$keyKilometroId] = $kilometros[$keyId];
            }

            $this->iKilometros->updateIMantenimientoKilometros($medicionesEntidad[$keyKilometroId], $kilometros);
        }

        if (!$this->ValidarCampos($horomentros)) {

            if ($medicionesEntidad[$keyHorometrosId] === null) {
                $horomentros[$keyId] = $idUnique;
                $this->ihorometros->addIMantenimientoHorometros($horomentros);
                $medicionesEntidad[$keyHorometrosId] = $horomentros[$keyId];
            }
            $this->ihorometros->updateIMantenimientoHorometros($medicionesEntidad[$keyHorometrosId], $horomentros);
        }

        if (!$this->ValidarCampos($combustible)) {
            $keyUnidad = "unidad";
            $keyTipoCombustible = "tipo_combustible";
            $keyProveedor = "proveedor";

            $combustible[$keyUnidad] = intval($combustible[$keyUnidad]);
            $combustible[$keyTipoCombustible] = intval($combustible[$keyTipoCombustible]);
            $combustible[$keyProveedor] = intval(EncryptionFunction::StaticDesencriptacion($combustible[$keyProveedor]));

            if ($medicionesEntidad[$keyCombustibleId] === null) {
                $combustible[$keyId] = $idUnique;
                $this->icombustible->addIMantenimientoCombustible($combustible);
                $medicionesEntidad[$keyCombustibleId] = $combustible[$keyId];
            }

            $this->icombustible->updateIMantenimientoCombustible($medicionesEntidad[$keyCombustibleId], $combustible);
        }

        $keyObservaciones = "observaciones";
        $medicionesEntidad[$keyObservaciones] = (array_key_exists($keyObservaciones, $mediciones) && $mediciones[$keyObservaciones] !== null) ? $mediciones[$keyObservaciones] : null;

        $estado = $this->sqlFunction($this->cMediciones->sqlUpdate($idRelacion, $medicionesEntidad));

        return response($estado, Response::HTTP_OK);
    }

    public function getMedicionById($id)
    {
        $data = [];

        $relacionHkc = $this->sqlFunction($this->cMediciones->sqlSelectById($id));
        $posicion = 0;

        if (!empty($relacionHkc)) {
            $relacionHkc = json_decode(json_encode($relacionHkc), true);
            $idCombustible = $relacionHkc[$posicion]['combustible_id'];
            $idHorometros = $relacionHkc[$posicion]['horometro_id'];
            $idKilometros = $relacionHkc[$posicion]['kilometro_id'];

            $_CCombustibles = new CCombustible();

            $combustibles = $this->sqlFunction($_CCombustibles->sqlSelectId($idCombustible));
            $horometros = $this->sqlFunction("SELECT * FROM mantenimiento_horometros WHERE id = '$idHorometros'");
            $kilometros = $this->sqlFunction("SELECT * FROM mantenimiento_kilometros WHERE id = '$idKilometros'");

            $combustibles = json_decode(json_encode($combustibles), true);
            $horometros = json_decode(json_encode($horometros), true);
            $kilometros = json_decode(json_encode($kilometros), true);

            $data = array_map(function ($relacion) use ($combustibles, $horometros, $kilometros, $posicion) {
                $data = [
                    'id' => $relacion['id'],
                    'equipo_id' => $relacion['codigo_equipo'],
                    'vehiculo_id' => $relacion['placa_vehiculo'],
                    'observaciones' => $relacion['observaciones'],
                    'centro_trabajo' => $relacion['centro_trabajo'],
                    'fecha_registro' => $relacion['fecha_registro'],
                    'cantidad_combustible' => null,
                    'costo_por_unidad' => null,
                    'proveedor' => null,
                    'unidad' => null,
                    'subsidio' => null,
                    'costo_total' => null,
                    'valor_horometro' => null,
                    'valor_kilometros' => null,
                    'proveedor_nombre' => null,
                ];

                if (!empty($combustibles)) {
                    $data['cantidad_combustible'] = $combustibles[$posicion]['cantidad_combustible'];
                    $data['costo_por_unidad'] = $combustibles[$posicion]['costo_por_unidad'];
                    $data['tipo_combustible'] = $combustibles[$posicion]['tipo_combustible'];
                    $data['proveedor'] = EncryptionFunction::StaticEncriptacion($combustibles[$posicion]['proveedor']);
                    $data['unidad'] = $combustibles[$posicion]['unidad'];
                    $data['subsidio'] = $combustibles[$posicion]['subsidio'] == 1;
                    $data['proveedor_nombre'] = $combustibles[$posicion]['proveedor_nombre'];
                    $data['costo_total'] = $combustibles[$posicion]['costo_por_unidad'] * $combustibles[$posicion]['cantidad_combustible'];
                }

                $data['valor_horometro'] = !empty($horometros) ? $horometros[$posicion]['valor_horometro'] : null;
                $data['valor_kilometros'] = !empty($kilometros) ? $kilometros[$posicion]['valor_kilometros'] : null;

                unset($data['kilometro_id'], $data['horometro_id'], $data['combustible_id']);

                return $data;
            }, $relacionHkc);
        }

        return json_encode($data[$posicion] ?? []);
    }

    private function ValidarCampos($campos): bool
    {
        if ($campos === null) {
            return true;
        }

        $contador = 0;
        foreach ($campos as $atributo => $valor) {
            if ($valor == null) {
                $contador++;
            }
        }
        return $contador == count($campos);
    }

    private function ValidacionLlegada($mediciones)
    {
        $keyEquipoId = "equipo_id";
        $keyVehiculoId = "vehiculo_id";

        if (array_key_exists($keyEquipoId, $mediciones) && $mediciones[$keyEquipoId] == null) {
            throw new Exception(__("messages.selectTeamError"), Response::HTTP_CONFLICT);
        }

        if (array_key_exists($keyVehiculoId, $mediciones) && $mediciones[$keyVehiculoId] == null) {
            throw new Exception(__("messages.selectVehicleError"), Response::HTTP_CONFLICT);
        }

        if (array_key_exists($keyVehiculoId, $mediciones) && array_key_exists($keyEquipoId, $mediciones)) {
            if ($mediciones[$keyEquipoId] !== null && $mediciones[$keyVehiculoId] !== null) {
                throw new Exception(__("messages.selectVehicleOrTeamError"), Response::HTTP_CONFLICT);
            }
        }

        if (!array_key_exists($keyVehiculoId, $mediciones) && !array_key_exists($keyEquipoId, $mediciones)) {
            throw new Exception(__("messages.chooseVehicleOrTeamError"), Response::HTTP_CONFLICT);
        }
    }
}
