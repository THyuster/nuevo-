<?php

namespace App\Utils\TransfersData\ModuloActivosFijos;

use App\Data\Dtos\ActivosFijos\Equipos\Request\EquiposRequestCreateDTO;
use App\Data\Dtos\ActivosFijos\Equipos\Responses\EquipoResponseDTO;
use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Data\Dtos\Response\ResponseDTO;
use App\Models\modulo_activos_fijos\activos_fijos_vista_erp;
use App\Models\modulo_contabilidad\contabilidad_terceros;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\FileManager;
use App\Utils\ResponseHandler;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\Equipos\IEquiposRepository;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\GruposEquipos\IGruposEquiposRepository;
use App\Utils\TransfersData\ModuloInventario\Repositories\Unidades\IUnidadesRepository;
use App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\Repository\IMarcasRepository;
use App\Utils\TransfersData\ModuloMantenimiento\Combustible\Repository\ICombustibleRepository;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaCentroTrabajos\INominaCentroTrabajoRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class EquiposServices extends RepositoryDynamicsCrud implements IEquiposServices
{
    protected IEquiposRepository $_equipoRepository;
    protected IGruposEquiposRepository $_gruposEquiposRepository;
    protected IMarcasRepository $_marcasRepository;
    protected ICombustibleRepository $_combustibleRepository;
    protected INominaCentroTrabajoRepository $_nominaCentroTrabajoRepository;
    protected IUnidadesRepository $_unidadesRepository;
    protected FileManager $fileManager;

    public function __construct(
        FileManager $fManager,
        IEquiposRepository $iEquiposRepository,
        IGruposEquiposRepository $iGruposEquiposRepository,
        IMarcasRepository $iMarcasRepository,
        ICombustibleRepository $iCombustibleRepository,
        INominaCentroTrabajoRepository $iNominaCentroTrabajoRepository,
        IUnidadesRepository $iUnidadesRepository
    ) {
        $this->fileManager = $fManager;
        $this->_equipoRepository = $iEquiposRepository;
        $this->_gruposEquiposRepository = $iGruposEquiposRepository;
        $this->_marcasRepository = $iMarcasRepository;
        $this->_combustibleRepository = $iCombustibleRepository;
        $this->_nominaCentroTrabajoRepository = $iNominaCentroTrabajoRepository;
        $this->_unidadesRepository = $iUnidadesRepository;
    }

    public function getDatatableResponse()
    {

        $request = HttpRequest::capture();
        $datatableDTO = new DatatableResponseDTO();
        $equiposVista = new activos_fijos_vista_erp();

        $query = $this->_equipoRepository->getQueryBuild();
        $columns = $query->getConnection()->getSchemaBuilder()->getColumnListing($equiposVista->getTable());

        $datatableDTO->recordsTotal = $query->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $query->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);
      
        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $query->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $query->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $query->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $query->offset($start)->limit($length);
        }

        $datatableDTO->data = $query->get();
        return $datatableDTO;
    }

    public function searchEquiposByFilter($filter)
    {
        $campos = ["codigo", "descripcion", "serial_interno", "serial_equipo"];

        $activoFijoEquipo = $this->_equipoRepository->findEquiposFijosByLikeQuery($campos, $filter);

        return $activoFijoEquipo;
    }

    public function create(EquiposRequestCreateDTO $equiposRequestCreateDTO)
    {
        $imageFile = $equiposRequestCreateDTO->ruta_imagen;

        $equiposRequestCreateDTO->ruta_imagen = null;

        $empresaName = MyFunctions::normalizeFolderName($this->findNameCompanie());
        $codigoNormalizado = MyFunctions::normalizeFolderName($equiposRequestCreateDTO->codigo);

        if ($this->_equipoRepository->existByCodigo($equiposRequestCreateDTO->codigo)) {
            return new ResponseDTO(
                "El código ya fue registrado",
                false,
                Response::HTTP_CONFLICT
            );
        }

        $terceros = [
            $equiposRequestCreateDTO->proveedorId,
            $equiposRequestCreateDTO->ingenieroId,
            $equiposRequestCreateDTO->jefe_mantenimiento_id,
            $equiposRequestCreateDTO->operador_id,
            $equiposRequestCreateDTO->administradorId
        ];

        foreach ($terceros as $tercero) {
            if ($tercero) {
                $this->validateThirdPartyExists($tercero);
            }
        }

        $activoFijoGrupoEquipo = $this->_gruposEquiposRepository->getGrupoEquipoByDescripcion($equiposRequestCreateDTO->grupo_equipo_id);

        if (!$activoFijoGrupoEquipo) {
            return new ResponseDTO("No se encontro el grupo equipo seleccionado", false, Response::HTTP_NOT_FOUND);
        }

        if (!$this->_marcasRepository->existById($equiposRequestCreateDTO->marcaId)) {
            return new ResponseDTO("La marca seleccionada no fue encontrada", $equiposRequestCreateDTO->marcaId, Response::HTTP_NOT_FOUND);
        }

        if ($equiposRequestCreateDTO->combustible && !$this->_combustibleRepository->existById($equiposRequestCreateDTO->combustible)) {
            return new ResponseDTO("No se encontro el combustible seleccionado", $equiposRequestCreateDTO->combustible, Response::HTTP_NOT_FOUND);
        }

        if (!$this->_nominaCentroTrabajoRepository->existById($equiposRequestCreateDTO->upm)) {
            return new ResponseDTO("No se encontro el centro de trabajo seleccionado", $equiposRequestCreateDTO->upm, Response::HTTP_NOT_FOUND);
        }

        if ($equiposRequestCreateDTO->inventario_unidad_id && !$this->_unidadesRepository->existById($equiposRequestCreateDTO->inventario_unidad_id)) {
            return new ResponseDTO("La unidad seleccionada no existe", $equiposRequestCreateDTO->inventario_unidad_id, Response::HTTP_NOT_FOUND);
        }

        $equiposRequestCreateDTO->grupo_equipo_id = $activoFijoGrupoEquipo->id;

        if ($imageFile && $imageFile instanceof UploadedFile) {
            $equiposRequestCreateDTO->ruta_imagen = $this->fileManager
                ->pushImag($imageFile, "$empresaName/activos_fijos/equipo/$codigoNormalizado", "");
        }

        $activosFijosEquipos = $this->_equipoRepository->create($equiposRequestCreateDTO->toArray());
        $equiposResponseDTO = new EquipoResponseDTO($activosFijosEquipos);

        return new ResponseDTO("Equipo Creado Exitosamente", $equiposResponseDTO);

    }
    public function update($id, EquiposRequestCreateDTO $equiposRequestCreateDTO)
    {

        $empresaName = MyFunctions::normalizeFolderName($this->findNameCompanie());
        $codigoNormalizado = MyFunctions::normalizeFolderName($equiposRequestCreateDTO->codigo);

        $imageFile = $equiposRequestCreateDTO->ruta_imagen;
        $equiposRequestCreateDTO->ruta_imagen = null;

        if ($this->_equipoRepository->checkCodigoUniquenessIgnoringId($equiposRequestCreateDTO->codigo, $id)) {
            return new ResponseDTO("El código que intenta registrar esta en uso.", $equiposRequestCreateDTO->codigo, Response::HTTP_CONFLICT);
        }

        $activoFijoEquipo = $this->_equipoRepository->findById($id);

        if (!$activoFijoEquipo) {
            return new ResponseDTO("No se encontro el equipo", false, Response::HTTP_NOT_FOUND);
        }

        $equipoResponseDTO = new EquipoResponseDTO($activoFijoEquipo);

        $terceros = [
            $equiposRequestCreateDTO->proveedorId,
            $equiposRequestCreateDTO->ingenieroId,
            $equiposRequestCreateDTO->jefe_mantenimiento_id,
            $equiposRequestCreateDTO->operador_id,
            $equiposRequestCreateDTO->administradorId
        ];

        $activoFijoGrupoEquipo = $this->_gruposEquiposRepository->getGrupoEquipoByDescripcion($equiposRequestCreateDTO->grupo_equipo_id);

        if (!$activoFijoGrupoEquipo) {
            return new ResponseDTO("No se encontro grupo equipo", $equiposRequestCreateDTO->grupo_equipo_id, Response::HTTP_NOT_FOUND);
        }

        $equiposRequestCreateDTO->grupo_equipo_id = $activoFijoGrupoEquipo->id;

        foreach ($terceros as $tercero) {
            if ($tercero) {
                $this->validateThirdPartyExists($tercero);
            }
        }

        if (!$this->_marcasRepository->existById($equiposRequestCreateDTO->marcaId)) {
            return new ResponseDTO("La marca seleccionada no fue encontrada", $equiposRequestCreateDTO->marcaId, Response::HTTP_NOT_FOUND);
        }

        if ($equiposRequestCreateDTO->combustible && !$this->_combustibleRepository->existById($equiposRequestCreateDTO->combustible)) {
            return new ResponseDTO("No se encontro el combustible seleccionado", $equiposRequestCreateDTO->combustible, Response::HTTP_NOT_FOUND);
        }

        if (!$this->_nominaCentroTrabajoRepository->existById($equiposRequestCreateDTO->upm)) {
            return new ResponseDTO("No se encontro el centro de trabajo seleccionado", $equiposRequestCreateDTO->upm, Response::HTTP_NOT_FOUND);
        }

        if ($equiposRequestCreateDTO->inventario_unidad_id && !$this->_unidadesRepository->existById($equiposRequestCreateDTO->inventario_unidad_id)) {
            return new ResponseDTO("La unidad seleccionada no existe", $equiposRequestCreateDTO->inventario_unidad_id, Response::HTTP_NOT_FOUND);
        }



        $imagenPath = $equipoResponseDTO->ruta_imagen;

        if ($imageFile && $imageFile instanceof UploadedFile) {

            if ($imagenPath) {
                $this->fileManager->deleteImage($imagenPath);
            }

            $imagenPath = $this->fileManager->pushImag(
                $imageFile,
                "$empresaName/activos_fijos/equipo/$codigoNormalizado"
            );
        }

        $equiposRequestCreateDTO->ruta_imagen = $imagenPath;

        $response = $this->_equipoRepository->update($id, $equiposRequestCreateDTO->toArray());

        $activoFijoEquipoCacheKey = "activo_fijo_equipo_{$id}_{$empresaName}";

        Cache::forget($activoFijoEquipoCacheKey);

        return new ResponseDTO("Equipo Actualizado exitosamente", $response);

    }
    public function delete($id)
    {
        $responseHandler = new ResponseHandler();

        $activoFijo = $this->_equipoRepository->findById($id);

        if (!$activoFijo) {
            return $responseHandler
                ->setMessage('Equipo no encontrado')
                ->setStatus(Response::HTTP_NOT_FOUND)
                ->responses();
        }

        $equipoResponseDTO = new EquipoResponseDTO($activoFijo);

        if ($equipoResponseDTO->ruta_imagen) {
            $this->fileManager->deleteImage($equipoResponseDTO->ruta_imagen);
        }

        $response = $this->_equipoRepository->delete($equipoResponseDTO->id);

        return $responseHandler->setData($response)
            ->setMessage('Equipo Eliminado')
            ->responses();

    }

    public function toggleEquipoStatusById($id)
    {
        $responseHandler = new ResponseHandler();

        $activoFijo = $this->_equipoRepository->findById($id);

        if (!$activoFijo) {
            return $responseHandler
                ->setMessage('Equipo no encontrado')
                ->setStatus(Response::HTTP_NOT_FOUND)
                ->responses();
        }

        $equipoResponseDTO = new EquipoResponseDTO($activoFijo);

        return $this->_equipoRepository->update($equipoResponseDTO->id, ["estado" => !$equipoResponseDTO->estado]);

    }
    /**
     * Valida si un tercero con el ID proporcionado existe en la base de datos.
     *
     * Este método verifica la existencia de un tercero en la base de datos utilizando el ID proporcionado.
     * Si el tercero no se encuentra, se lanza una excepción con un mensaje de error y un código de estado HTTP 404.
     *
     * @param mixed $id El ID del tercero que se desea verificar.
     * @throws \Exception Lanza una excepción si el tercero no existe, con un mensaje de error y código de estado 404.
     * @return void
     */
    private function validateThirdPartyExists($id)
    {
        // Obtiene la conexión a la base de datos
        $connection = RepositoryDynamicsCrud::findConectionDB();

        // Busca el tercero en la base de datos utilizando la conexión y el ID proporcionado
        $tercero = contabilidad_terceros::on($connection)->where('identificacion', $id)->exists();

        // Si el tercero no se encuentra, lanza una excepción con un mensaje de error y código de estado 404
        if (!$tercero) {
            throw new Exception("Tercero no existente con identificacion $id", Response::HTTP_NOT_FOUND);
        }
    }

    public function retrieveEquipoDetailsById($id)
    {
        $connection = MyFunctions::normalizeFolderName($this->findNameCompanie());

        $activoFijoEquipoCacheKey = "activo_fijo_equipo_{$id}_{$connection}";

        $activoFijoEquipo = Cache::remember(
            $activoFijoEquipoCacheKey,
            120,
            function () use ($id) {
                return $this->_equipoRepository->findById($id);
            }
        );

        $equipoResponseDTO = new EquipoResponseDTO($activoFijoEquipo);
        $grupoEquipoDescripcionCacheKey = "grupo_equipo_descripcion_{$equipoResponseDTO->grupo_equipo_id}_{$connection}";

        $grupoEquipoDescripcion = Cache::remember(
            $grupoEquipoDescripcionCacheKey,
            120,
            function () use ($equipoResponseDTO) {
                return $this->_gruposEquiposRepository->findById($equipoResponseDTO->grupo_equipo_id);
            }
        );

        $equipoResponseDTO->grupo_equipo_id = $grupoEquipoDescripcion->descripcion;

        return $equipoResponseDTO;
    }
}
