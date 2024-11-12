<?php

namespace App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Data\Dtos\Logistica\Vehiculos\Request\VehiculosRequestCreateDTO;
use App\Data\Dtos\Logistica\Vehiculos\Responses\VehiculosResponseDTO;
use App\Models\modulo_contabilidad\contabilidad_terceros;
use App\Models\modulo_logistica\logistica_marcas;
use App\Models\modulos_logistica\logistica_vehiculos_view;
use App\Utils\FileManager;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\Repository\IRepositoryVehiculo;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesVehiculos extends RepositoryDynamicsCrud implements IServicesVehiculos
{
    private FileManager $_fileManager;
    protected IRepositoryVehiculo $_repositoryVehiculo;
    /**
     * Constructor for the class.
     *
     * @param \App\Utils\FileManager $fileManager
     * @param \App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\Repository\IRepositoryVehiculo $iRepositoryVehiculo
     */
    public function __construct(FileManager $fileManager, IRepositoryVehiculo $iRepositoryVehiculo)
    {
        // Initialize the file manager
        $this->_fileManager = $fileManager;
        // Initialize the vehicle repository
        $this->_repositoryVehiculo = $iRepositoryVehiculo;
    }

    /**
     * Crea un nuevo vehículo en el sistema.
     *
     * @param \App\Data\Dtos\Logistica\Vehiculos\Request\VehiculosRequestCreateDTO $vehiculosRequestCreateDTO Datos para la creación del vehiculo
     * @throws \Exception Si ocurre un error al crear el vehículo o validar datos
     * @return \Illuminate\Http\JsonResponse
     */
    public function crearVehiculo(VehiculosRequestCreateDTO $vehiculosRequestCreateDTO)
    {
        try {

            $connection = $this->findConectionDB();

            $terceros = [
                $vehiculosRequestCreateDTO->terceroPropietarioId,
                $vehiculosRequestCreateDTO->terceroConductorId
            ];

            // Verifica si el vehículo ya existe por placa
            if ($this->_repositoryVehiculo->vehiculoExistsByPlaca($vehiculosRequestCreateDTO->placa)) {
                return response()->json([
                    'error' => 'Vehículo ya registrado'
                ], Response::HTTP_CONFLICT);
            }

            // Verifica si la marca del vehículo es válida
            if (!logistica_marcas::on($connection)->find($vehiculosRequestCreateDTO->marcaId)->exists()) {
                return response()->json([
                    'error' => 'La marca seleccionada no es válida'
                ], Response::HTTP_BAD_REQUEST);
            }

            // Valida los terceros (propietario y conductor)
            $this->validateTerceros($terceros, $connection);

            // Crea el vehículo y obtiene la respuesta DTO
            $logisticaVehiculosDTO = $this->_repositoryVehiculo->create($vehiculosRequestCreateDTO->toArray());

            // Retorna la respuesta en formato JSON
            return response()->json($logisticaVehiculosDTO, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Actualiza un vehículo en el sistema.
     *
     * @param int $id ID del vehículo a actualizar
     * @param \App\Data\Dtos\Logistica\Vehiculos\Request\VehiculosRequestCreateDTO $vehiculosRequestCreateDTO Datos para la actualización del vehículo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception Si ocurre un error durante la actualización o validación
     */
    public function actualizarVehiculo(int $id, VehiculosRequestCreateDTO $vehiculosRequestCreateDTO)
    {
        $connection = $this->findConectionDB();

        // Obtiene el vehículo actual por ID
        $vehiculo = $this->_repositoryVehiculo->getVehiculoById($id);

        if (!$vehiculo) {
            return response()->json([
                'error' => 'El vehículo no existe'
            ], Response::HTTP_NOT_FOUND);
            // throw new Exception("Este vehiculo no existe", Response::HTTP_NOT_FOUND);
        }

        $vehiculoDTO = new VehiculosResponseDTO($vehiculo);

        // Maneja la actualización de la imagen del vehículo
        if ($vehiculosRequestCreateDTO->rutaImagen) {
            if ($vehiculoDTO->ruta_imagen) {
                $this->_fileManager->deleteImage($vehiculoDTO->ruta_imagen);
            }
        } else {
            $vehiculosRequestCreateDTO->rutaImagen = $vehiculoDTO->ruta_imagen;
        }

        $terceros = [
            $vehiculosRequestCreateDTO->terceroPropietarioId,
            $vehiculosRequestCreateDTO->terceroConductorId
        ];

        // Verifica la existencia de la placa
        if ($this->_repositoryVehiculo->placaExistsById($vehiculoDTO->id, $vehiculosRequestCreateDTO->placa)) {
            return response()->json([
                'error' => 'La placa que está intentando registrar está en uso'
            ], Response::HTTP_CONFLICT);
            // throw new Exception("La placa que esta intentado registrar esta en uso", Response::HTTP_CONFLICT);
        }

        // Verifica la existencia de la marca
        if (!logistica_marcas::on($connection)->find($vehiculosRequestCreateDTO->marcaId)) {
            return response()->json([
                'error' => 'La marca seleccionada no fue encontrada'
            ], Response::HTTP_NOT_FOUND);
        }

        // Valida los terceros
        $this->validateTerceros($terceros, $connection);

        // Actualiza el vehículo
        $this->_repositoryVehiculo->update($vehiculoDTO->id, $vehiculosRequestCreateDTO->toArray());

        // return response()->json(true);
        return response()->json([
            'success' => true
        ], Response::HTTP_OK);
    }
    /**
     * Obtiene vehículos por placa.
     *
     * @param string $placa Placa del vehículo para la búsqueda
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVehiculoByPlaca(string $placa): JsonResponse
    {
        // Obtiene los vehículos que coinciden con la placa proporcionada
        $logisticaVehiculos = $this->_repositoryVehiculo->getVehiculosByPlaca($placa);

        // Mapea los resultados a DTOs
        $logisticaVehiculosDTO = $logisticaVehiculos->map(function ($logisticaVehiculo) {
            return new VehiculosResponseDTO($logisticaVehiculo);
        });

        // Retorna la respuesta en formato JSON
        return response()->json($logisticaVehiculosDTO);
    }
    /**
     * Elimina un vehículo por su ID.
     *
     * @param int $id ID del vehículo a eliminar 
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception Si ocurre un error durante la eliminación
     */
    public function eliminarVehiculo(int $id): JsonResponse
    {
        try {
            // Obtiene el vehículo por ID
            $logisticaVehiculo = $this->_repositoryVehiculo->getVehiculoById($id);

            if (!$logisticaVehiculo) {
                return response()->json([
                    'error' => 'Vehículo no encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            $vehiculoDTO = new VehiculosResponseDTO($logisticaVehiculo);

            // Elimina la imagen asociada, si existe
            if ($vehiculoDTO->ruta_imagen) {
                $this->_fileManager->deleteImage($vehiculoDTO->ruta_imagen);
            }

            // Elimina el vehículo de la base de datos
            $this->_repositoryVehiculo->deleteById($id);

            return response()->json([
                'success' => 'Vehículo eliminado exitosamente'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            // Maneja cualquier error y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Cambia el estado de un vehículo por su ID.
     *
     * @param int $id ID del vehículo cuyo estado se va a actualizar
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception Si ocurre un error durante la actualización
     */
    public function estadoVehiculo(int $id): JsonResponse
    {
        try {
            // Obtiene el vehículo por ID
            $logisticaVehiculo = $this->_repositoryVehiculo->getVehiculoById($id);

            if (!$logisticaVehiculo) {
                return response()->json([
                    'error' => 'Vehículo no encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            $vehiculoDTO = new VehiculosResponseDTO($logisticaVehiculo);

            // Cambia el estado del vehículo
            $nuevoEstado = !$vehiculoDTO->estado;
            $this->_repositoryVehiculo->update($id, ['estado' => $nuevoEstado]);

            return response()->json([
                'success' => 'Estado del vehículo actualizado exitosamente',
                'nuevo_estado' => $nuevoEstado
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            // Maneja cualquier error y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Obtiene los vehículos con soporte para búsqueda, ordenación y paginación.
     * @return JsonResponse La respuesta en formato JSON que contiene los datos de la tabla,
     *                       el número total de registros y el número de registros filtrados.
     */
    public function getVehiculos()
    {
        $connection = RepositoryDynamicsCrud::findConectionDB();
        $logisticaVehiculos = new logistica_vehiculos_view();
        $datatableResponseDTO = new DatatableResponseDTO();

        $logisticaVehiculosView = logistica_vehiculos_view::on($connection);
        
        $request = Request::capture();

        $columns = $logisticaVehiculosView->getConnection()
        ->getSchemaBuilder()
        ->getColumnListing($logisticaVehiculos->getTable());
       
        $draw = intval($request->input('draw', 1));
        $searchValue = $request->input('search.value', '');

        $datatableResponseDTO->draw = $draw;
        $datatableResponseDTO->recordsTotal = $logisticaVehiculosView->count();

        if ($searchValue) {
            $logisticaVehiculosView->where(function (Builder $q) use ($searchValue, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%$searchValue%");
                }
            });
        }
         // Filtros personalizados por columna
         $columnFilters = $request->input('columnFilters', []);
         $columnsFilters = $request->input('columns', []);
 
         foreach ($columnFilters as $index => $filter) {
             if (!empty($filter) && isset($columns[$index])) {
                 $logisticaVehiculosView->where($columnsFilters[$index]["data"], 'like', "%$filter%");
             }
         }

        $datatableResponseDTO->recordsFiltered = $logisticaVehiculosView->count();

        if ($request->input('order')) {
            # code...
            foreach ($request->input('order') as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                
                if ($columnName) {
                    $logisticaVehiculosView->orderBy($columnName, $direction);
                }
            }
        }


        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        if ($length != -1) {
            $logisticaVehiculosView->offset($start)->limit($length);
        }

        $datatableResponseDTO->data = $logisticaVehiculosView->get();

        return response()->json($datatableResponseDTO);
    }
    /**
     * Obtiene vehículos y propietarios asociados a una placa específica.
     *
     * @param string $placa Placa para buscar en vehículos y propietarios
     * @return JsonResponse
     */
    public function obtenerVehiculosYPropietariosPorPlaca(string $placa): JsonResponse
    {
        if (empty($placa)) {
            return response()->json([], Response::HTTP_OK);
        }

        // Obtiene detalles del vehículo y propietarios
        $vehiculoDetalle = $this->_repositoryVehiculo->obtenerVehiculosYPropietariosPorPlaca($placa);

        return response()->json($vehiculoDetalle, Response::HTTP_OK);
    }
    /**
     * Valida la existencia de terceros en la base de datos.
     *
     * @param array $terceros Lista de identificaciones de terceros a validar
     * @param mixed $connection Conexión a la base de datos
     * @throws \Exception Si algún tercero no existe en la base de datos
     * @return void
     */
    private function validateTerceros(array $terceros, $connection): void
    {
        // Filtra los terceros no vacíos
        $tercerosValidos = array_filter($terceros);

        if (empty($tercerosValidos)) {
            return; // No hay terceros para validar
        }

        // Obtén los identificadores válidos de terceros desde la base de datos
        $tercerosExistentes = contabilidad_terceros::on($connection)
            ->whereIn('identificacion', $tercerosValidos)
            ->pluck('identificacion')
            ->toArray();

        // Encuentra los identificadores de terceros que no están en la base de datos
        $tercerosInvalidos = array_diff($tercerosValidos, $tercerosExistentes);

        if (!empty($tercerosInvalidos)) {
            $tercerosInvalidosLista = implode(', ', $tercerosInvalidos);
            throw new Exception(
                "Los siguientes terceros no existen: $tercerosInvalidosLista",
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
