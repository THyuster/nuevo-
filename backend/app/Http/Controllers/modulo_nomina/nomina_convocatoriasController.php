<?php

namespace App\Http\Controllers\modulo_nomina;

use App\Data\Dtos\Convocatorias\Convocatoria\Response\CargosAndConvocatoriaResponseDTO;
use App\Data\Dtos\Convocatorias\Convocatoria\Response\CargoWithConvocatoriasDTO;
use App\Data\Dtos\Convocatorias\Convocatoria\Response\ConvocatoriaViewResponseDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriaBySolicitudEmpleoDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasCreacionRequestDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasCreateDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasUpdateDTO;
use App\Data\Dtos\Response\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\NominaConvocatoriasCrearPorSolicitudEmpleoRequest;
use App\Http\Requests\NominaRequest\NominaConvocatoriasCreacionRequest as NominaConvocatoriasRequest;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloNomina\IServiceNominaConvocatorias;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaConvocatoria\INominaConvocatoriaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class nomina_convocatoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected IServiceNominaConvocatorias $_serviceNominaConvocatorias;
    protected INominaConvocatoriaRepository $_convocatoriaRespository;
    public function __construct(IServiceNominaConvocatorias $_serviceNominaConvocatorias, INominaConvocatoriaRepository $iNominaConvocatoriaRepository)
    {
        $this->_serviceNominaConvocatorias = $_serviceNominaConvocatorias;
        $this->_convocatoriaRespository = $iNominaConvocatoriaRepository;
        $this->middleware('auth:api', ['except' => ['getListConvocatorias']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NominaConvocatoriasRequest $nominaConvocatoriasRequest)
    {
        $convocatoriaCreateRequestDto = ConvocatoriasCreacionRequestDTO::fromArray($nominaConvocatoriasRequest->all());
        return $this->_serviceNominaConvocatorias->create($convocatoriaCreateRequestDto);
    }

    public function aceptarConvocatoriaSolicitud(NominaConvocatoriasCrearPorSolicitudEmpleoRequest $nominaConvocatoriasCrearPorSolicitudEmpleoRequest)
    {
        $convocatoriaBySolicitudEmpleoDTO = ConvocatoriaBySolicitudEmpleoDTO::fromArray($nominaConvocatoriasCrearPorSolicitudEmpleoRequest->toArray());

        return $this->_serviceNominaConvocatorias->createConvoctariaBySolicitudEmpleo($convocatoriaBySolicitudEmpleoDTO);
    }

    public function rejectConvocatoriaBySolicitud(string $id)
    {
        return $this->_serviceNominaConvocatorias->rejectConvocatoriaBySolicitud($id);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return $this->_serviceNominaConvocatorias->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NominaConvocatoriasRequest $nominaConvocatoriasRequest, string $id)
    {
        $convocatoriaCreateDto = ConvocatoriasUpdateDTO::fromArray($nominaConvocatoriasRequest->all());
        return $this->_serviceNominaConvocatorias->update($id, $convocatoriaCreateDto);
    }

    public function getListConvocatorias(Request $request)
    {
        return $this->_serviceNominaConvocatorias->getListConvocatoria($request);
    }
    /**
     * Recupera todas las convocatorias y las transforma en objetos DTO.
     *
     * Este método obtiene una lista de convocatorias del repositorio, transforma cada convocatoria 
     * en un objeto `CargoWithConvocatoriasDTO` y devuelve el resultado como una respuesta JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllConvocatorias()
    {

        // Obtiene todas las convocatorias utilizando el repositorio
        $convocatorias = $this->_convocatoriaRespository->all();

        // Convierte el array a una colección y usa el método map para transformar cada convocatoria
        // en un objeto CargoWithConvocatoriasDTO
        $convocatorias = Collection::make($convocatorias)
            ->map(fn($con) => new CargoWithConvocatoriasDTO($con))
            ->toArray();

        // Devuelve las convocatorias transformadas como una respuesta JSON
        return response()->json(new ResponseDTO("Convocatorias Traidas", $convocatorias));

    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     *
     * Este método llama al servicio `delete` para eliminar un recurso basado en el ID
     * proporcionado. Luego, devuelve una respuesta JSON con el contenido del objeto `ResponseDTO`
     * y el código de estado HTTP correspondiente.
     *
     * @param string $id El ID del recurso que se desea eliminar. Debe ser una cadena que representa
     *                   el identificador único del recurso.
     * @return \Illuminate\Http\JsonResponse Una respuesta JSON que contiene el mensaje del objeto
     *                                       `ResponseDTO` y el código de estado HTTP asociado.
     *
     * @throws \Exception Lanza una excepción si ocurre un error durante el proceso de eliminación
     *                    o si el servicio de eliminación no maneja correctamente el ID proporcionado.
     */
    public function destroy(string $id)
    {
        $responseDTO = $this->_serviceNominaConvocatorias->delete($id);
        return response()->json($responseDTO, $responseDTO->code);
    }
}
