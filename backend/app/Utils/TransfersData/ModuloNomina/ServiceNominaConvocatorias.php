<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Data\Dtos\Convocatorias\ConvocatoriaBySolicitudEmpleoDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriaDatatableDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriaResponseListaDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasCreacionRequestDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasCreateDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasUpdateDTO;
use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Data\Dtos\Response\ResponseDTO;
use App\Models\NominaModels\nomina_cargos;
use App\Models\NominaModels\NominaConvocatorias;
use App\Models\NominaModels\NominaConvocatoriasView;
use App\Models\NominaModels\NominaSolicitudesEmpleo;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaConvocatoria\INominaConvocatoriaRepository;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ServiceNominaConvocatorias extends RepositoryDynamicsCrud implements IServiceNominaConvocatorias
{

    protected INominaConvocatoriaRepository $_convocatoriaRepository;
    public function __construct(INominaConvocatoriaRepository $iNominaConvocatoriaRepository)
    {
        $this->_convocatoriaRepository = $iNominaConvocatoriaRepository;
    }

    /**
     * Metodo para inactivar o activar convocatoria
     * @param string $nominaConvocatoriaId
     * Id de la convocotaria a actualizar
     * @return JsonResponse
     * Respondera un JsonResponse
     */
    public function active(string $nominaConvocatoriaId): JsonResponse
    {
        $responseHandler = new ResponseHandler();
        try {
            $connection = $this->findConectionDB();

            $convocatoria = NominaConvocatorias::on($connection)->find($nominaConvocatoriaId);

            if (!$convocatoria) {
                throw new Exception("Convocatoria no encontrada", Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $convocatoria->activa = $convocatoria->activa != true;

            $convocatoria = $convocatoria->save();
            return $responseHandler->setData(true)->setMessage("Estado Actualizado")->responses();

        } catch (\Throwable $th) {
            return $responseHandler->handleException($th);
        } catch (Exception $e) {
            return $responseHandler->handleException($e);
        } catch (QueryException $qe) {
            return $responseHandler->handleException($qe);
        }

    }

    /**
     * @param ConvocatoriasCreateDTO $convocatoriaCreateRequestDto
     * DTO de convocatorias para crear
     * @return JsonResponse
     */
    public function create(ConvocatoriasCreacionRequestDTO $convocatoriaCreateRequestDto): JsonResponse
    {
        $responseHandler = new ResponseHandler();
        try {
            //code...
            $connection = $this->findConectionDB();

            $nominaCargo = nomina_cargos::on($connection)->where('nomina_cargo_id', $convocatoriaCreateRequestDto->nomina_cargo_id)->exists();

            if ($convocatoriaCreateRequestDto->numero_puestos == 0 || $convocatoriaCreateRequestDto->numero_puestos == null) {
                throw new Exception("Se necesita el número de puesto para esta convocatoria", Response::HTTP_NOT_FOUND);
            }

            if (!$nominaCargo) {
                throw new Exception("La solicitud no a sido encontrado", Response::HTTP_NOT_FOUND);
            }

            $convocotaria = NominaConvocatorias::on($connection)->create($convocatoriaCreateRequestDto->toArray());
            return $responseHandler->setData($convocotaria)->setMessage("Convocatoria Creada")->responses();

        } catch (Throwable $th) {
            return $responseHandler->handleException($th);
        } catch (Exception $e) {
            return $responseHandler->handleException($e);
        } catch (QueryException $qe) {
            return $responseHandler->handleException($qe);
        }

    }

    public function delete(string $nominaConvocatoriaId)
    {
        try {
            // Verificar si la convocatoria existe antes de intentar eliminarla
            if (!$this->_convocatoriaRepository->existByIdConvocatoria($nominaConvocatoriaId)) {
                // La convocatoria no fue encontrada
                return new ResponseDTO('Convocatoria no encontrada', [], Response::HTTP_NOT_FOUND);
            }

            // Intentar eliminar la convocatoria
            $deleted = $this->_convocatoriaRepository->delete($nominaConvocatoriaId);

            if ($deleted) {
                // La convocatoria fue eliminada con éxito
                return new ResponseDTO('Convocatoria eliminada', [], Response::HTTP_OK);
            } else {
                // La eliminación falló por alguna razón inesperada
                return new ResponseDTO('No se pudo eliminar la convocatoria', [], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Throwable $th) {
            // Capturar cualquier excepción inesperada y devolver un mensaje de error adecuado
            $code = $th->getCode();

            // Asignar el código de error HTTP interno si el código de excepción no es válido
            if ($code < 100 || $code >= 600) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            return new ResponseDTO($th->getMessage(), [], $code);
        }
    }

    public function get()
    {
        $request = Request::capture();
        $connection = RepositoryDynamicsCrud::findConectionDB();

        $nominaConvocatoriaView = new NominaConvocatoriasView();
        $nominaConvocatoriaViewQuery = NominaConvocatoriasView::on($connection);

        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $nominaConvocatoriaViewQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($nominaConvocatoriaView->getTable());

        $datatableDTO->recordsTotal = $nominaConvocatoriaViewQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);
        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        if ($search) {
            $nominaConvocatoriaViewQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $nominaConvocatoriaViewQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $nominaConvocatoriaViewQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $nominaConvocatoriaViewQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $nominaConvocatoriaViewQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $nominaConvocatoriaViewQuery->get();
        return response()->json($datatableDTO);

    }

    /**
     * Metodo para actualizar una convocatoria
     * @param string $nominaConvocatoriaId
     * Id de la convocatoria
     * @param ConvocatoriasUpdateDTO $convocatoriasUpdateDTO
     * DTO para actualizar convocatoria
     * @return JsonResponse
     * Responde una JsonResponse
     */
    public function update(string $nominaConvocatoriaId, ConvocatoriasUpdateDTO $convocatoriasUpdateDTO): JsonResponse
    {
        $connection = $this->findConectionDB();
        $responseHandler = new ResponseHandler();
        try {

            $convocatoriaModel = NominaConvocatorias::on($connection)->find($nominaConvocatoriaId);

            $nominaCargo = nomina_cargos::on($connection)->where('nomina_cargo_id', $convocatoriasUpdateDTO->nomina_cargo_id)->exists();

            if ($convocatoriasUpdateDTO->numero_puestos == 0 || $convocatoriasUpdateDTO->numero_puestos == null) {
                throw new Exception("Se necesita el número de puesto para esta convocatoria", Response::HTTP_NOT_FOUND);
            }

            if (!$nominaCargo) {
                throw new Exception("El cargo no existe", Response::HTTP_NOT_FOUND);
            }

            $convocatoriaModel->update($convocatoriasUpdateDTO->toArray());

            return $responseHandler->setData($convocatoriaModel)->setMessage("Datos Actualizados")->responses();

        } catch (\Throwable $th) {
            return $responseHandler->handleException($th);
        } catch (Exception $e) {
            return $responseHandler->handleException($e);
        } catch (QueryException $qe) {
            return $responseHandler->handleException($qe);
        }
    }
    /**
     *
     * @param string $id
     */
    public function getNominaConvocatoriaId(string $id)
    {
        try {
            $connection = $this->findConectionDB();
            $convocatoria = NominaConvocatorias::on($connection)->find($id)->toArray();
            return new ResponseHandler("Datos Traidos", $convocatoria, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return new ResponseHandler($e->getMessage(), [], $e->getCode());
        } catch (QueryException $qe) {
            return new ResponseHandler($qe->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getListConvocatoria(Request $request): JsonResponse
    {
        $responseHandler = new ResponseHandler();
        try {
            $perPage = $request->input('pagination', 10);
            $empresaId = $request->input('empresa');

            if ($empresaId == null) {
                return $responseHandler->setData([])->setMessage("Empresa no encontrada")
                    ->setStatus(Response::HTTP_NOT_FOUND)->responses();
            }

            $conecction = $this->getConnectioByIdEmpresa($empresaId);

            if ($conecction == null) {
                return $responseHandler->setData([])->setMessage("Empresa no encontrada")
                    ->setStatus(Response::HTTP_NOT_FOUND)->responses();
            }

            $convocatoria = \DB::connection($conecction)->table("nomina_convocatorias_view")->paginate($perPage);
            $convocatoria->getCollection()->transform(function ($item) {
                return ConvocatoriaResponseListaDTO::fromModel($item);
            });
            return $responseHandler->setData($convocatoria)->setMessage("Datos Obtenidos")->responses();
        } catch (\Throwable $th) {
            return $responseHandler->handleException($th);
        } catch (Exception $e) {
            return $responseHandler->handleException($e);
        } catch (QueryException $qe) {
            return $responseHandler->handleException($qe);
        }
    }
    public function activeConvocatoria(array $convocatoria)
    {
        try {
            //code...
            $connection = $this->findConectionDB();
            $convocatoria = new NominaConvocatorias($convocatoria);

            if ($convocatoria->nomina_solicitudes_empleo_id) {
                $solicitudEmpleo = NominaSolicitudesEmpleo::on($connection)
                    ->find($convocatoria->nomina_solicitudes_empleo_id)->first();
                if (!$solicitudEmpleo) {
                    throw new Exception("La solicitud no a sido encontrado", Response::HTTP_NOT_FOUND);
                }
            }

            $convocatoria = $convocatoria->setConnection($connection)->save();

            return new ResponseHandler("Creado Correctamente", $convocatoria, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return new ResponseHandler($e->getMessage(), [], $e->getCode());
        } catch (QueryException $qe) {
            return new ResponseHandler($qe->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     *
     * @param ConvocatoriaBySolicitudEmpleoDTO $convocatoriaBySolicitudEmpleoDTO
     * DTO de datos para crear convocatoria por solicitud de empleo
     * @return JsonResponse
     */
    public function createConvoctariaBySolicitudEmpleo(ConvocatoriaBySolicitudEmpleoDTO $convocatoriaBySolicitudEmpleoDTO): JsonResponse
    {
        $responseHandle = new ResponseHandler();
        try {

            // Obtener la conexión de la base de datos
            $connection = $this->findConectionDB();

            // Buscar la solicitud de empleo
            $solicitudEmpleo = NominaSolicitudesEmpleo::on($connection)
                ->find($convocatoriaBySolicitudEmpleoDTO->nomina_solicitudes_empleo_id);

            // Comprobar si la solicitud de empleo existe
            if (!$solicitudEmpleo) {
                throw new Exception("No existe la solicitud", Response::HTTP_NOT_FOUND);
            }

            // Comprobar si la solicitud de empleo ya fue aprobada
            if ($solicitudEmpleo->aprobada !== null) {
                throw new Exception("Esta solicitud ya fue respondida", Response::HTTP_CONFLICT);
            }

            // Crear un DTO de convocatoria y asignar el ID del cargo
            $convocatoriaDTO = ConvocatoriasCreateDTO::fromArray($convocatoriaBySolicitudEmpleoDTO->toArray());
            $convocatoriaDTO->nomina_cargo_id = $solicitudEmpleo->nomina_cargo_id;

            // Marcar la solicitud de empleo como aprobada y guardar los cambios
            $solicitudEmpleo->aprobada = 1;
            $solicitudEmpleo->save();

            // Crear y guardar la convocatoria
            $convocatoria = new NominaConvocatorias($convocatoriaDTO->toArray());
            $convocatoria->setConnection($connection)->save();

            // Responder con un mensaje de éxito
            return $responseHandle->setMessage("Solicitud aprobada")->setData(true)->responses();

        } catch (\Throwable $th) {
            return $responseHandle->handleException($th);
        } catch (Exception $e) {
            return $responseHandle->handleException($e);
        } catch (QueryException $qe) {
            return $responseHandle->handleException($qe);
        }
    }

    /**
     * @param string $solicitudEmpleoId
     * Id de la solicitud de empleo
     * @return JsonResponse
     */
    public function rejectConvocatoriaBySolicitud($solicitudEmpleoId): JsonResponse
    {
        $responseHandle = new ResponseHandler();

        try {
            // Obtener la conexión de la base de datos
            $connection = $this->findConectionDB();

            // Buscar la solicitud de empleo por su ID
            $solicitudEmpleo = NominaSolicitudesEmpleo::on($connection)->find($solicitudEmpleoId);

            // Comprobar si la solicitud de empleo existe
            if (!$solicitudEmpleo) {
                throw new Exception("No existe la solicitud", Response::HTTP_NOT_FOUND);
            }

            // Comprobar si la solicitud de empleo ya ha sido respondida
            if ($solicitudEmpleo->aprobada !== null) {
                throw new Exception("Esta solicitud ya ha sido respondida", Response::HTTP_CONFLICT);
            }

            // Marcar la solicitud de empleo como no aprobada y guardar los cambios
            $solicitudEmpleo->aprobada = 0;
            $solicitudEmpleo->save();

            // Retornar un mensaje de éxito
            return $responseHandle->setMessage("Creado Correctamente")->setData(true)->responses();

        } catch (\Throwable $th) {
            return $responseHandle->handleException($th);
        } catch (Exception $e) {
            return $responseHandle->handleException($e);
        } catch (QueryException $qe) {
            return $responseHandle->handleException($qe);
        }
    }

}
