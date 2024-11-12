<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Jobs\ProcesarCorreo;
use App\Mail\SolicitudEmpleoCreada;
use App\Models\NominaModels\NominaSolicitudesEmpleo;
use App\Models\NominaModels\NominaSolicitudesEmpleoView;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaConvocatoria\INominaConvocatoriaRepository;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesNominaSolicitudEmpleo implements IServiceNominaSolicitudEmpleo
{
    protected RepositoryDynamicsCrud $_repositoryDynamicsCrud;
    protected INominaConvocatoriaRepository $_convocatoriaRespository;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, INominaConvocatoriaRepository $iNominaConvocatoriaRepository)
    {
        $this->_repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->_convocatoriaRespository = $iNominaConvocatoriaRepository;
    }
    /**
     *
     * @param array $entidadSolicitudEmpleo
     * @return ResponseHandler
     */
    public function createSolicitudEmpleo(array $entidadSolicitudEmpleo): ResponseHandler
    {

        try {
            //code...
            $nominaSolicitudEmpleoModel = new NominaSolicitudesEmpleo($entidadSolicitudEmpleo);
            $connection = $this->_repositoryDynamicsCrud->findConectionDB();
            $nominaSolicitudEmpleoModel->setConnection($connection);

            $nominaCentroTrabajoId = $nominaSolicitudEmpleoModel->nomina_centro_trabajo_id;

            $sql = "SELECT 1 FROM nomina_centros_trabajos WHERE id = '$nominaCentroTrabajoId'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Centro de trabajo no encontrado", Response::HTTP_NOT_FOUND);
            }

            $nominaCargoId = $nominaSolicitudEmpleoModel->nomina_cargo_id;
            $sql = "SELECT 1 FROM nomina_cargos WHERE nomina_cargo_id = '$nominaCargoId'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Cargo no encontrado", Response::HTTP_NOT_FOUND);
            }

            $userid = $nominaSolicitudEmpleoModel->user_id;
            $sql = "SELECT * FROM users WHERE id = '$userid'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Usuario no encontrado", Response::HTTP_NOT_FOUND);
            }
            $nombreUsuario = $validacion[0]->name;
            $emailUsuario = $validacion[0]->email;
            // throw new Exception($nombreUsuario, 500);
            $estadoPrioridadId = $nominaSolicitudEmpleoModel->estado_prioridad_id;
            $sql = "SELECT 1 FROM estados_prioridad WHERE estado_prioridad_id  = '$estadoPrioridadId'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Prioridad no encontrada", Response::HTTP_NOT_FOUND);
            }

            $response = $nominaSolicitudEmpleoModel->save();

            $mail = new SolicitudEmpleoCreada($nombreUsuario);
            ProcesarCorreo::dispatch($emailUsuario, $mail);

            return new ResponseHandler("Solicitud Creada", $response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return new ResponseHandler($e->getMessage(), [], $e->getCode());
        } catch (QueryException $queryException) {
            return new ResponseHandler($queryException->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     *
     * @param mixed $id
     * @return ResponseHandler
     */
    public function destroySolicitudEmpleo($id): ResponseHandler
    {

        try {
            //code...
            $connection = $this->_repositoryDynamicsCrud->findConectionDB();

            if ($this->_convocatoriaRespository->convocatoriaAprobadaBySolicitudEmpleoId($id)) {
                throw new Exception("Esta solicitud fue aprobado por lo que no se permite su eliminación", Response::HTTP_CONFLICT);
            }

            $nominaSolicitudEmpleo = NominaSolicitudesEmpleo::on($connection)->find($id);

            if (!$nominaSolicitudEmpleo) {
                throw new Exception("Solicitud no encontrada", Response::HTTP_NOT_FOUND);
            }

            $response = $nominaSolicitudEmpleo->delete();

            return new ResponseHandler("Eliminación exitosa", $response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            $code = $th->getCode();

            // Asignar el código de error HTTP interno si el código de excepción no es válido
            if ($code < 100 || $code >= 600) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            return new ResponseHandler($th->getMessage(), [], $code);
        } catch (Exception $e) {
            $code = $e->getCode();

            // Asignar el código de error HTTP interno si el código de excepción no es válido
            if ($code < 100 || $code >= 600) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            return new ResponseHandler($e->getMessage(), [], $code);
        } catch (QueryException $queryException) {
            $code = $e->getCode();

            // Asignar el código de error HTTP interno si el código de excepción no es válido
            if ($code < 100 || $code >= 600) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            }
            return new ResponseHandler($queryException->getMessage(), [], $code);
        }

    }

    public function getSolicitudEmpleoAll()
    {
        $request = Request::capture();
        $connection = RepositoryDynamicsCrud::findConectionDB();

        $nominaSolicituEmpleoView = new NominaSolicitudesEmpleoView();
        $nominaSolicituEmpleoViewQuery = NominaSolicitudesEmpleoView::on($connection);

        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $nominaSolicituEmpleoViewQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($nominaSolicituEmpleoView->getTable());

        $datatableDTO->recordsTotal = $nominaSolicituEmpleoViewQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $nominaSolicituEmpleoViewQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $nominaSolicituEmpleoViewQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $nominaSolicituEmpleoViewQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $nominaSolicituEmpleoViewQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $nominaSolicituEmpleoViewQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $nominaSolicituEmpleoViewQuery->get();
        return response()->json($datatableDTO);

    }

    /**
     *
     * @param mixed $id
     * @param array $entidadSolicitudEmpleo
     * @return ResponseHandler
     */
    public function updateSolicitudEmpleo($id, array $entidadSolicitudEmpleo): ResponseHandler
    {
        try {
            //code...
            $connection = $this->_repositoryDynamicsCrud->findConectionDB();
            $nominaSolicitudEmpleo = NominaSolicitudesEmpleo::on($connection)->find($id);
            $nominaSolicitudEmpleoModel = new NominaSolicitudesEmpleo($entidadSolicitudEmpleo);

            if ($nominaSolicitudEmpleo->aprobada != null) {
                throw new Exception("Esta solicitud ya fue respondida, no la puede editar", Response::HTTP_CONFLICT);
            }

            if (!$nominaSolicitudEmpleoModel) {
                throw new Exception("No se encontro la solicitud", Response::HTTP_NOT_FOUND);
            }

            $nominaCentroTrabajoId = $nominaSolicitudEmpleoModel->nomina_centro_trabajo_id;

            $sql = "SELECT 1 FROM nomina_centros_trabajos WHERE id = '$nominaCentroTrabajoId'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Centro de trabajo no encontrado", Response::HTTP_NOT_FOUND);
            }

            $nominaCargoId = $nominaSolicitudEmpleoModel->nomina_cargo_id;
            $sql = "SELECT 1 FROM nomina_cargos WHERE nomina_cargo_id = '$nominaCargoId'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Cargo no encontrado", Response::HTTP_NOT_FOUND);
            }

            $userid = $nominaSolicitudEmpleoModel->user_id;
            $sql = "SELECT 1 FROM users WHERE id = '$userid'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Usuario no encontrado", Response::HTTP_NOT_FOUND);
            }

            $estadoPrioridadId = $nominaSolicitudEmpleoModel->estado_prioridad_id;
            $sql = "SELECT 1 FROM estados_prioridad WHERE estado_prioridad_id  = '$estadoPrioridadId'";
            $validacion = $this->_repositoryDynamicsCrud->sqlFunction($sql);

            if (empty($validacion)) {
                throw new Exception("Prioridad no encontrada", Response::HTTP_NOT_FOUND);
            }

            $response = $nominaSolicitudEmpleo->update($nominaSolicitudEmpleoModel->toArray());


            return new ResponseHandler("Solicitud Creada", $response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return new ResponseHandler($e->getMessage(), [], $e->getCode());
        } catch (QueryException $queryException) {
            return new ResponseHandler($queryException->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     *
     * @param mixed $id
     */
    public function getSolicitudEmpleoById($id)
    {
        try {
            //code...
            $connection = $this->_repositoryDynamicsCrud->findConectionDB();
            $nominaSolicitudEmpleo = NominaSolicitudesEmpleoView::on($connection)->get()->find($id)->first();
            return new ResponseHandler("Datos Traidos", $nominaSolicitudEmpleo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return new ResponseHandler($e->getMessage(), [], $e->getCode());
        } catch (QueryException $queryException) {
            return new ResponseHandler($queryException->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     *
     * @param Request $request
     */
    public function getSolicitudEmpleoList(Request $request)
    {
        try {
            //code...
            $campos = ["nomina_solicitudes_empleo_id", "nombre_cargo", "nombre_centro_trabajo", "observacion_solicitud", "numero_puestos"];

            $connection = $this->_repositoryDynamicsCrud->findConectionDB();
            $perPage = $request->input('pagination', 10);
            $nominaSolicitudEmpleo = NominaSolicitudesEmpleoView::on($connection)->where("aprobada", null)->paginate($perPage, $campos);
            return new ResponseHandler("Datos Traidos", $nominaSolicitudEmpleo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return new ResponseHandler($e->getMessage(), [], $e->getCode());
        } catch (QueryException $queryException) {
            return new ResponseHandler($queryException->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
