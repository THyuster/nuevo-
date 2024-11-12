<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Services\Urls;
use App\Custom\Http\Request;
use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Data\Dtos\Response\ResponseDTO;
use App\Data\Dtos\Sagrilaft\Validacion\Url\Request\SagrilaftUrlCreateDTO;
use App\Data\Dtos\Sagrilaft\Validacion\Url\Request\SagrilaftUrlRequestCreateDTO;
use App\Data\Dtos\Sagrilaft\Validacion\Url\Request\sagrilaftUrlTipoValidacionRelacionDTO;
use App\Data\Dtos\Sagrilaft\Validacion\Url\Response\SagrilaftUrl;
use App\Models\Sagrilaft\SagrilaftUrls;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\ISagrilaftEmpleadoUrlRelacionRepository;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\IRepositoryUrl;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\IRepositoryUrlRelacion;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\RelacionUrlTipoValidacionRelacion\ISagrilaftUrlTipoValidacionRelacionRepository;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\TipoValidaciones\ISagrilaftTipoValidacionRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Symfony\Component\HttpFoundation\Response;

class ServiceSagrilaftUrl implements IServiceSagrilaftUrl
{
    protected IRepositoryUrl $repositoryUrl;
    protected IRepositoryUrlRelacion $repositoryUrlRelacion;
    protected ISagrilaftTipoValidacionRepository $sagrilaftTipoValidacionRepository;
    protected ISagrilaftUrlTipoValidacionRelacionRepository $sagrilaftUrlTipoValidacionRelacion;
    protected ISagrilaftEmpleadoUrlRelacionRepository $sagrilaftEmpleadoUrlRelacionRepository;
    public function __construct(
        IRepositoryUrl $iRepositoryUrl,
        IRepositoryUrlRelacion $iRepositoryUrlRelacion,
        ISagrilaftTipoValidacionRepository $iSagrilaftTipoValidacionRepository,
        ISagrilaftUrlTipoValidacionRelacionRepository $iSagrilaftUrlTipoValidacionRelacionRepository,
        ISagrilaftEmpleadoUrlRelacionRepository $iSagrilaftEmpleadoUrlRelacionRepository,
    ) {
        $this->repositoryUrl = $iRepositoryUrl;
        $this->repositoryUrlRelacion = $iRepositoryUrlRelacion;
        $this->sagrilaftTipoValidacionRepository = $iSagrilaftTipoValidacionRepository;
        $this->sagrilaftUrlTipoValidacionRelacion = $iSagrilaftUrlTipoValidacionRelacionRepository;
        $this->sagrilaftEmpleadoUrlRelacionRepository = $iSagrilaftEmpleadoUrlRelacionRepository;
    }
    public function create(SagrilaftUrlRequestCreateDTO $sagrilaftUrlRequestCreateDTO)
    {
        // Verifica si el tipo de validación existe
        if (!$this->sagrilaftTipoValidacionRepository->existById($sagrilaftUrlRequestCreateDTO->tipoValidacion)) {
            return new ResponseDTO('Tipo de Validación No Existe', $sagrilaftUrlRequestCreateDTO, Response::HTTP_NOT_FOUND);
        }

        // Crea la URL en la base de datos
        $sagrilaftUrlDTO = $this->repositoryUrl->create($sagrilaftUrlRequestCreateDTO->toArray());

        // Convierte las URLs a un array para la inserción
        $sagrilaftUrlRel = array_map(function (SagrilaftUrlCreateDTO $datos) use ($sagrilaftUrlDTO) {
            // Asigna el ID de la URL recién creada a cada relación
            $datos->sagrilaftUrlId = $sagrilaftUrlDTO->sagrilafUrlId;
            return $datos->toArray();
        }, $sagrilaftUrlRequestCreateDTO->urls);

        // Crea las relaciones de tipo de validación
        $this->repositoryUrlRelacion->insertarRegistros($sagrilaftUrlRel);

        // Crea el DTO para la relación entre URL y tipo de validación
        $sagrilaftUrlTipoValidacionRelacionDTO = new SagrilaftUrlTipoValidacionRelacionDTO();
        $sagrilaftUrlTipoValidacionRelacionDTO->urlId = $sagrilaftUrlDTO->sagrilafUrlId;
        $sagrilaftUrlTipoValidacionRelacionDTO->tipoValidacionId = $sagrilaftUrlRequestCreateDTO->tipoValidacion;

        // Inserta la relación en la base de datos
        $this->sagrilaftUrlTipoValidacionRelacion->create($sagrilaftUrlTipoValidacionRelacionDTO->toArray());

        // Obtiene la URL recién creada con sus relaciones
        $sagrilaftUrlDTO = $this->repositoryUrl->getById($sagrilaftUrlDTO->sagrilafUrlId);

        return new ResponseDTO('Registro de URLs exitoso', $sagrilaftUrlDTO, Response::HTTP_CREATED);
    }

    public function getTable()
    {
        $datatableDTO = new DatatableResponseDTO();
        $connection = RepositoryDynamicsCrud::findConectionDB();

        // Crea una instancia del modelo SagrilaftUrls y establece la consulta
        $sagrilafUrlQuery = SagrilaftUrls::on($connection)->with(['urls','tipoValidaciones']);

        // Captura la solicitud actual
        $request = Request::capture();

        // Obtiene los nombres de las columnas de la tabla
        $columns = $sagrilafUrlQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing((new SagrilaftUrls())->getTable());

        // Establece el total de registros
        $datatableDTO->recordsTotal = $sagrilafUrlQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        // Paginación y búsqueda
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        // Aplica búsqueda
        if ($search) {
            $sagrilafUrlQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        // Aplica filtros de columnas
        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $sagrilafUrlQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        // Establece el total de registros filtrados
        $datatableDTO->recordsFiltered = $sagrilafUrlQuery->count();

        // Aplica ordenamientos
        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $sagrilafUrlQuery->orderBy($columnName, $direction);
                }
            }
        }

        // Aplica paginación
        if ($length != -1) {
            $sagrilafUrlQuery->offset($start)->limit($length);
        }

        // Obtiene los datos y los transforma en DTOs
        $datatableDTO->data = $sagrilafUrlQuery->get()->transform(function ($sagrilaftUrls) {
            return new SagrilaftUrl($sagrilaftUrls);
        });

        return $datatableDTO;
    }

    public function delete($id): ResponseDTO
    {
        // Verifica si la URL está siendo utilizada en algún empleado
        if ($this->sagrilaftEmpleadoUrlRelacionRepository->existByUrlId($id)) {
            return new ResponseDTO('Esta URL está siendo usada en un empleado', false, Response::HTTP_CONFLICT);
        }

        // Intenta eliminar la URL
        if ($this->repositoryUrl->deleteById($id)) {
            // Elimina los registros relacionados con la URL
            $this->repositoryUrlRelacion->eliminarRegistrosByUrlId($id);
            return new ResponseDTO('Registro eliminado', true);
        }
 
        return new ResponseDTO('Registro No Encontrado', false, Response::HTTP_NOT_FOUND);

    }

}
