<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Services;
use App\Data\Dtos\Response\ResponseDTO;
use App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request\SagrilaftEmpleadoRelUrlCreateDTO;
use App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request\SagrilaftValidacionEmpleadosRecursosDTO;
use App\Utils\FileManager;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Repository\IEmpleadosRepository;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\ISagrilaftEmpleadoRecursosRepository;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\ISagrilaftEmpleadoUrlRelacionRepository;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\IRepositoryUrl;
use Symfony\Component\HttpFoundation\Response;

class SagrilaftEmpleadoService implements ISagrilaftEmpleadoService
{

    protected ISagrilaftEmpleadoUrlRelacionRepository $empleadoUrlRelacionRepository;
    protected IRepositoryUrl $repositoryUrl;
    protected IEmpleadosRepository $empleadoRepository;
    protected ISagrilaftEmpleadoRecursosRepository $empleadoRecursoRepository;

    public function __construct(
        IRepositoryUrl $iRepositoryUrl,
        ISagrilaftEmpleadoUrlRelacionRepository $iSagrilaftEmpleadoUrlRelacionRepository,
        IEmpleadosRepository $iEmpleadosRepository,
        ISagrilaftEmpleadoRecursosRepository $iSagrilaftEmpleadoRecursosRepository,
    ) {
        $this->repositoryUrl = $iRepositoryUrl;
        $this->empleadoRepository = $iEmpleadosRepository;
        $this->empleadoUrlRelacionRepository = $iSagrilaftEmpleadoUrlRelacionRepository;
        $this->empleadoRecursoRepository = $iSagrilaftEmpleadoRecursosRepository;
    }

    public function create(SagrilaftEmpleadoRelUrlCreateDTO $sagrilaftEmpleadoRelUrlCreateDTO): ResponseDTO
    {
        // Crea una instancia del gestor de archivos
        $fileManager = new FileManager();

        // Verifica si el empleado existe
        if (!$this->empleadoRepository->existByIdEmpleado($sagrilaftEmpleadoRelUrlCreateDTO->empleadoId)) {
            return new ResponseDTO('Empleado No Encontrado', $sagrilaftEmpleadoRelUrlCreateDTO, Response::HTTP_NOT_FOUND);
        }

        // Obtiene la identificación del empleado
        $identificacionEmpleado = $this->empleadoRepository->getIdentificacionEmpleadoById($sagrilaftEmpleadoRelUrlCreateDTO->empleadoId);

        // Verifica si la URL existe
        if (!$this->repositoryUrl->existById($sagrilaftEmpleadoRelUrlCreateDTO->sagrilaftUrlId)) {
            return new ResponseDTO('URL No Encontrada', $sagrilaftEmpleadoRelUrlCreateDTO, Response::HTTP_NOT_FOUND);
        }

        // Normaliza el nombre de la empresa
        $nombreEmpresa = MyFunctions::normalizeFolderName(RepositoryDynamicsCrud::findNameCompanie());

        // Inicializa una lista para almacenar los DTO de recursos del empleado
        $listSagrilaftEmpleadoRecursosDTO = [];

        // Almacena los recursos del empleado
        try {
            $listSagrilaftEmpleadoRecursosDTO = $this->storeResources($sagrilaftEmpleadoRelUrlCreateDTO->resources, $fileManager, $nombreEmpresa, $identificacionEmpleado);
        } catch (\Exception $e) {
            throw new \Exception("Error al almacenar los recursos: " . $e->getMessage());
        }

        // Inicializa variable para almacenar los modelos obtenidos
        $sagrilaftEmpleadoRelUrlDTO = null;

        // Verifica si la relación entre empleado y URL ya existe
        if ($this->empleadoUrlRelacionRepository->existByEmpleadoIdAndUrlID($sagrilaftEmpleadoRelUrlCreateDTO->empleadoId, $sagrilaftEmpleadoRelUrlCreateDTO->sagrilaftUrlId)) {
            $sagrilaftEmpleadoRelUrlDTO = $this->empleadoUrlRelacionRepository->getByEmpleadoIdAndUrlID($sagrilaftEmpleadoRelUrlCreateDTO->empleadoId, $sagrilaftEmpleadoRelUrlCreateDTO->sagrilaftUrlId);

            // Actualiza la relación existente
            $this->updateEmpleadoUrlRelacion($sagrilaftEmpleadoRelUrlDTO, $sagrilaftEmpleadoRelUrlCreateDTO);
            $this->empleadoRecursoRepository->crearRegistros($listSagrilaftEmpleadoRecursosDTO);
            array_push($sagrilaftEmpleadoRelUrlDTO->resources, ...$listSagrilaftEmpleadoRecursosDTO);

            return new ResponseDTO("Validación Modificada", $sagrilaftEmpleadoRelUrlDTO, Response::HTTP_OK);
        } else {
            // Crea una nueva relación
            $sagrilaftEmpleadoRelUrlDTO = $this->empleadoUrlRelacionRepository->create($sagrilaftEmpleadoRelUrlCreateDTO->toArray());
            $this->empleadoRecursoRepository->crearRegistros($listSagrilaftEmpleadoRecursosDTO);
            array_push($sagrilaftEmpleadoRelUrlDTO->resources, ...$listSagrilaftEmpleadoRecursosDTO);

            return new ResponseDTO("Validación Creada Con Éxito", $sagrilaftEmpleadoRelUrlDTO, Response::HTTP_CREATED);
        }
    }

    /**
     * Almacena los recursos del empleado.
     *
     * @param array $resources
     * @param FileManager $fileManager
     * @param string $nombreEmpresa
     * @param string $identificacionEmpleado
     * @return array
     */
    private function storeResources(array $resources, FileManager $fileManager, string $nombreEmpresa, string $identificacionEmpleado): array
    {
        $listSagrilaftEmpleadoRecursosDTO = [];

        $listSagrilaftEmpleadoRecursosDTO = array_map(function ($resource) use ($fileManager, $nombreEmpresa, $identificacionEmpleado) {
            if ($resource instanceof \Illuminate\Http\UploadedFile) {
                $path = $fileManager->pushImag($resource, "$nombreEmpresa/sagrilaft/validacion/empleado/{$identificacionEmpleado}");
                $sagrilaftValidacionEmpleadosRecursosDTO = new SagrilaftValidacionEmpleadosRecursosDTO();
                $sagrilaftValidacionEmpleadosRecursosDTO->path = $path; // Asigna la ruta del recurso
                return $sagrilaftValidacionEmpleadosRecursosDTO;
            }
            return null; // Retorna null si no es un UploadedFile
        }, $resources);

        // Filtra los elementos nulos del array
        $listSagrilaftEmpleadoRecursosDTO = array_filter($listSagrilaftEmpleadoRecursosDTO);

        return $listSagrilaftEmpleadoRecursosDTO;
    }

    /**
     * Actualiza la relación existente entre empleado y URL.
     *
     * @param $sagrilaftEmpleadoRelUrlDTO
     * @param SagrilaftEmpleadoRelUrlCreateDTO $sagrilaftEmpleadoRelUrlCreateDTO
     */
    private function updateEmpleadoUrlRelacion($sagrilaftEmpleadoRelUrlDTO, SagrilaftEmpleadoRelUrlCreateDTO $sagrilaftEmpleadoRelUrlCreateDTO)
    {
        $sagrilaftEmpleadoRelUrlDTO->color = $sagrilaftEmpleadoRelUrlCreateDTO->color;
        $sagrilaftEmpleadoRelUrlDTO->estado = $sagrilaftEmpleadoRelUrlCreateDTO->estado;
        $sagrilaftEmpleadoRelUrlDTO->descripcion = $sagrilaftEmpleadoRelUrlCreateDTO->descripcion;

        $this->empleadoUrlRelacionRepository->updateById($sagrilaftEmpleadoRelUrlDTO->empleadoRelUrlId, $sagrilaftEmpleadoRelUrlCreateDTO->toArray());
    }
}
