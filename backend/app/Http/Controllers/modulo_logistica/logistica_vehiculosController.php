<?php

namespace App\Http\Controllers\modulo_logistica;

use App\Data\Dtos\Logistica\Vehiculos\Request\VehiculosRequestCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Logistica_Vehiculos\Vehiculos\VehiculosRequestCreate;
use App\Utils\Constantes\ModuloLogistica\CVehiculos;
use App\Utils\FileManager;
use App\Utils\Repository\RepositoryDynamicsCrud;

use App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\IServicesVehiculos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class logistica_vehiculosController extends Controller
{
    private CVehiculos $_cVehiculos;
    private RepositoryDynamicsCrud $_repository;
    private IServicesVehiculos $_servicesVehiculos;

    public function __construct(IServicesVehiculos $iServicesVehiculos, CVehiculos $cVehiculos, RepositoryDynamicsCrud $repository)
    {
        $this->_cVehiculos = $cVehiculos;
        $this->_repository = $repository;
        $this->_servicesVehiculos = $iServicesVehiculos;
    }
    /**
     * Muestra la lista de vehículos.
     * 
     * Este método llama al servicio `getVehiculos` para obtener los datos de vehículos
     * y devolverlos en una respuesta JSON. La respuesta incluye la información filtrada,
     * ordenada y paginada según los parámetros de la solicitud.
     *
     * @return JsonResponse La respuesta en formato JSON que contiene los datos de los vehículos.
     */
    public function show(): JsonResponse
    {
        // Llama al método `getVehiculos` del servicio y devuelve la respuesta JSON
        return $this->_servicesVehiculos->getVehiculos();
    }
    /**
     * Obtiene vehículos y propietarios basados en la placa.
     * 
     * Este método captura el parámetro 'placa' de la solicitud, lo sanitiza para evitar inyecciones de código,
     * y luego llama al servicio para obtener los datos correspondientes a esa placa.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene el parámetro 'placa'.
     * @return \Illuminate\Http\JsonResponse La respuesta en formato JSON con los datos de vehículos y propietarios.
     */
    public function getSSR(Request $request): JsonResponse
    {
        // Capturar el parámetro 'placa' de la solicitud
        $placa = $request->input('placa', '');

        // Sanitizar el valor de 'placa' para prevenir inyecciones de código
        $placa = htmlspecialchars($placa, ENT_QUOTES, 'utf-8');

        // Llamar al método del servicio para obtener datos basados en la placa
        return $this->_servicesVehiculos->obtenerVehiculosYPropietariosPorPlaca($placa);
    }

    // function entidades(): array
    // {
    //     return array(
    //         "entidad_blindaje" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("logistica_blindajes")),
    //         "entidad_tercero" => $this->_repository->sqlFunction($this->_cVehiculos->sqlTerceros()),
    //         "entidad_marca" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("inventarios_marcas")),
    //         "entidad_grupo_vehiculo" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("logistica_grupos_vehiculos")),
    //         "entidad_clases" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("logistica_clases")),
    //         "entidad_contratos" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("logistica_tipo_contrato")),
    //         "entidad_combustible" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("logistica_combustibles")),
    //         "entidad_ejes" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("logistica_ejes")),
    //         "entidad_trailer" => $this->_repository->sqlFunction($this->_cVehiculos->sqlFuncion("logistica_trailers"))
    //     );
    // }
    /**
     * Crea un nuevo registro de vehículo.
     *
     * @param \App\Http\Requests\Logistica_Vehiculos\Vehiculos\VehiculosRequestCreate $vehiculosRequestCreate Solicitud con los datos del vehículo.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la creación o un error.
     * @throws \Exception Si ocurre un error al procesar la solicitud o al crear el vehículo.
     */
    public function create(VehiculosRequestCreate $vehiculosRequestCreate): JsonResponse
    {
        try {
            // Crear una instancia de FileManager
            $fileManager = new FileManager();

            // Convertir los datos de la solicitud en un DTO
            $vehiculoRequestCreateDTO = new VehiculosRequestCreateDTO($vehiculosRequestCreate->all());

            $pathImage = null;

            // Verificar si se ha subido una imagen
            if ($vehiculosRequestCreate->hasFile('ruta_imagen')) {
                // Guardar la imagen y obtener la ruta
                $pathImage = $fileManager->pushImagen($vehiculosRequestCreate, "perfiles_vehiculos");
            }

            // Asignar la ruta de la imagen al DTO
            $vehiculoRequestCreateDTO->rutaImagen = $pathImage;

            // Crear el vehículo usando el servicio y devolver la respuesta
            $resultado = $this->_servicesVehiculos->crearVehiculo($vehiculoRequestCreateDTO);

            return response()->json($resultado, 201); // Código 201 Created
        } catch (\Exception $e) {
            // Manejar excepciones y devolver una respuesta de error
            return response()->json(['error' => 'Ocurrió un error al crear el vehículo: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Actualiza un registro de vehículo.
     *
     * @param mixed $id Identificador del vehículo a actualizar.
     * @param \App\Http\Requests\Logistica_Vehiculos\Vehiculos\VehiculosRequestCreate $vehiculosRequestCreate Solicitud con los datos del vehículo.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la actualización.
     */
    public function update($id, VehiculosRequestCreate $vehiculosRequestCreate)
    {
        // Crear una instancia de FileManager
        $fileManager = new FileManager();

        // Convertir los datos de la solicitud en un DTO
        $vehiculoRequestCreateDTO = new VehiculosRequestCreateDTO($vehiculosRequestCreate->all());

        $pathImage = null;

        // Verificar si se ha subido una imagen
        if ($vehiculosRequestCreate->hasFile('ruta_imagen')) {
            // Guardar la imagen y obtener la ruta
            $pathImage = $fileManager->pushImagen($vehiculosRequestCreate, "perfiles_vehiculos");
        }

        // Asignar la ruta de la imagen al DTO
        $vehiculoRequestCreateDTO->rutaImagen = $pathImage;

        // Actualizar el vehículo y devolver la respuesta
        return $this->_servicesVehiculos->actualizarVehiculo($id, $vehiculoRequestCreateDTO);
    }
    /**
     * Obtiene la información de un vehículo por su placa.
     *
     * @param string $placa La placa del vehículo.
     * @return \Illuminate\Http\JsonResponse La respuesta en formato JSON con los datos del vehículo o un error.
     */
    public function GetVehiculoByPlaca(string $placa)
    {
        return $this->_servicesVehiculos->GetVehiculoByPlaca($placa);
    }
    /**
     * Elimina un vehículo basado en el identificador proporcionado.
     * 
     * Este método llama al servicio para eliminar el vehículo con el identificador especificado
     * y devuelve una respuesta en formato JSON que indica el resultado de la operación.
     *
     * @param int $id El identificador del vehículo a eliminar.
     * @return \Illuminate\Http\JsonResponse La respuesta en formato JSON que indica el éxito o el fallo de la operación.
     */
    public function destroy(int $id)
    {
        return $this->_servicesVehiculos->eliminarVehiculo($id);
    }
    /**
     * Cambia el estado de un vehículo basado en el identificador proporcionado.
     * 
     * Este método llama al servicio para cambiar el estado del vehículo con el identificador especificado
     * y devuelve una respuesta en formato JSON que incluye la información del estado del vehículo.
     *
     * @param int $id El identificador del vehículo cuyo estado se desea obtener.
     * @return \Illuminate\Http\JsonResponse La respuesta en formato JSON con el estado del vehículo.
     */
    public function estado(int $id)
    {
        return $this->_servicesVehiculos->estadoVehiculo($id);
    }

    public function getTypesVehicles()
    {
        return $this->_repository->sqlFunction("SELECT id, descripcion FROM tipos_vehiculos");
    }
}
