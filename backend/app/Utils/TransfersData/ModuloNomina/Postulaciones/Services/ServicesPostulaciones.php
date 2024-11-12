<?php

namespace App\Utils\TransfersData\ModuloNomina\Postulaciones\Services;

use App\Custom\Http\Request;
use App\Data\Dtos\Convocatorias\BlanckListDTOs\BlacklistRequestCreateDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriaPostulanteRelacionDTO;
use App\Data\Dtos\Convocatorias\Postulantes\PostulanteCreateDTO;
use App\Data\Dtos\Convocatorias\Postulantes\PostulanteRequestDTO;
use App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes\RelacionPostulacionComplementariosDTO;
use App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes\RelacionPostulacionRelacionAcademiaDTO;
use App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes\RelacionPostulacionRelacionExperienciaLaboralDTO;
use App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes\RelacionPostulacionRelacionFamiliaresDTO;
use App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes\RelacionPostulacionRelacionPersonalesDTO;
use App\Data\Dtos\Convocatorias\Postulantes\RelacionesPostulantes\RelacionPostulanteConvocatoriaDTO;
use App\Data\Dtos\Convocatorias\Postulantes\Request\ConvocatoriaCambioEstadoPostulanteDTO;
use App\Data\Dtos\Convocatorias\Postulantes\Responses\Convocatorias\PostulanteConvocatoriaDTO;
use App\Data\Dtos\Convocatorias\Postulantes\Responses\PostulanteRelacionesDTO;
use App\Data\Dtos\Convocatorias\Postulantes\Responses\PostulanteResponseDTO;
use App\Data\Dtos\Convocatorias\Postulantes\Responses\ResponsePostulanteConvocatoria;
use App\Data\Dtos\Empleados\Requests\Empleado\EmpleadoCreateDTO;
use App\Data\Dtos\Empleados\Requests\RelacionesEmpleados\REmpleadoAcademiaCreateDTO;
use App\Data\Dtos\Empleados\Requests\RelacionesEmpleados\REmpleadoComplementarioCreateDTO;
use App\Data\Dtos\Empleados\Requests\RelacionesEmpleados\REmpleadoExperienciaLaboralCreateDTO;
use App\Data\Dtos\Empleados\Requests\RelacionesEmpleados\REmpleadoFamiliarCreateDTO;
use App\Data\Dtos\Empleados\Requests\RelacionesEmpleados\REmpleadoPersonalCreateDTO;
use App\Data\Dtos\Response\ResponseDTO;
use App\Jobs\ProcesarCorreo;
use App\Mail\ContactFormMail;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\moduloContabilidad\Repositories\TiposIdentificaciones\ITipoIdentificacionRepository;
use App\Utils\TransfersData\ModuloNomina\Blacklist\Repository\IRepositoryBlacklist;
use App\Utils\TransfersData\ModuloNomina\Postulaciones\Repository\Postulantes\IRepositoryPostulacion;
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Repository\IEmpleadosRepository;
use Symfony\Component\HttpFoundation\Response;

class ServicesPostulaciones implements IServicePostulaciones
{
    protected IRepositoryPostulacion $_repositoryPostulacion;
    protected IRepositoryBlacklist $_repositoryBlacklist;
    protected IEmpleadosRepository $_empleadoRepository;
    protected ITipoIdentificacionRepository $_tipoIdentificacionRepository;

    public function __construct(
        IRepositoryPostulacion $iRepositoryPostulacion,
        IRepositoryBlacklist $iRepositoryBlacklist,
        IEmpleadosRepository $iEmpleadosRepository,
        ITipoIdentificacionRepository $iTipoIdentificacionRepository
    ) {
        $this->_repositoryPostulacion = $iRepositoryPostulacion;
        $this->_repositoryBlacklist = $iRepositoryBlacklist;
        $this->_empleadoRepository = $iEmpleadosRepository;
        $this->_tipoIdentificacionRepository = $iTipoIdentificacionRepository;
    }

    public function create(PostulanteRequestDTO $postulanteRequestDTO, $empresaId = null)
    {
        $usuario = auth()->user();
        $connection = null;

        if (!$usuario && $empresaId) {
            $connection = RepositoryDynamicsCrud::getConnectioByIdEmpresa($empresaId);
            if ($connection == "app") {
                return new ResponseDTO(
                    "La empresa no fue encontrada.",
                    $empresaId,
                    Response::HTTP_NOT_FOUND
                );
            }
        }

        $postulanteDTO = new PostulanteCreateDTO($postulanteRequestDTO);

        if (MyFunctions::calcularEdad($postulanteDTO->fechaNacimiento) < 16) {
            return new ResponseDTO(
                "La edad requerida para el puesto es 16 años.",
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }


        if ($this->_repositoryPostulacion->closedCall($postulanteDTO->nominaConvocatoriaId, $connection) && !$usuario) {
            return new ResponseDTO(
                "La convocatoria está cerrada.",
                $postulanteDTO->nominaConvocatoriaId,
                Response::HTTP_CONFLICT
            );
        }



        if ($this->_repositoryBlacklist->userInBlacklistByIdentificacion($postulanteDTO->identificacion, $connection)) {
            return new ResponseDTO(
                "El postulante con la identificación proporcionada está registrado en la blacklist.",
                $postulanteDTO->identificacion,
                Response::HTTP_CONFLICT
            );
        }

        if (!$this->_tipoIdentificacionRepository->tipoIdentificacionExistePorId($postulanteDTO->tipoIdentificacion, $connection)) {
            # code...
            return new ResponseDTO(
                "El tipo de identificación con el ID proporcionado no existe en el sistema. Por favor, verifique el ID o agregue el tipo de identificación requerido.",
                $postulanteDTO->identificacion,
                Response::HTTP_CONFLICT
            );
        }

        if ($this->_repositoryPostulacion->userInConvocatoria($postulanteDTO->identificacion, $postulanteDTO->nominaConvocatoriaId, $connection)) {
            return new ResponseDTO(
                "El usuario ya se encuentra inscrito en la convocatoria",
                $postulanteDTO->nominaConvocatoriaId,
                Response::HTTP_CONFLICT
            );
        }

        $convocatoriaPostulante = new RelacionPostulanteConvocatoriaDTO(
            $postulanteRequestDTO->nominaConvocatoriaId,
            $postulanteRequestDTO->nominaConvocatoriaPostulanteId
        );

        $relacionesFamiliares = $this->createRelacion(
            $postulanteRequestDTO->postulanteRelacionFamiliares,
            $postulanteRequestDTO->nominaConvocatoriaPostulanteId,
            RelacionPostulacionRelacionFamiliaresDTO::class
        );

        $relacionPersonales = $this->createRelacion(
            $postulanteRequestDTO->postulanteRelacionesPersonales,
            $postulanteRequestDTO->nominaConvocatoriaPostulanteId,
            RelacionPostulacionRelacionPersonalesDTO::class
        );

        $relacionComplementarios = $this->createRelacion(
            $postulanteRequestDTO->postulanteComplementario,
            $postulanteRequestDTO->nominaConvocatoriaPostulanteId,
            RelacionPostulacionComplementariosDTO::class
        );

        $relacionLaboral = $this->createRelacion(
            $postulanteRequestDTO->postulanteExperienciaLaboral,
            $postulanteRequestDTO->nominaConvocatoriaPostulanteId,
            RelacionPostulacionRelacionExperienciaLaboralDTO::class
        );

        $relacionAcademica = $this->createRelacion(
            $postulanteRequestDTO->postulanteAcademia,
            $postulanteRequestDTO->nominaConvocatoriaPostulanteId,
            RelacionPostulacionRelacionAcademiaDTO::class
        );



        $this->_repositoryPostulacion->createPostulacionFamiliares($postulanteRequestDTO->postulanteRelacionFamiliares, $connection);
        $this->_repositoryPostulacion->createPostulacionPersonales($postulanteRequestDTO->postulanteRelacionesPersonales, $connection);
        $this->_repositoryPostulacion->createPostulanteComplementarios($postulanteRequestDTO->postulanteComplementario, $connection);
        $this->_repositoryPostulacion->createPostulanteAcademia($postulanteRequestDTO->postulanteAcademia, $connection);
        $this->_repositoryPostulacion->createExperienciaLaboral($postulanteRequestDTO->postulanteExperienciaLaboral, $connection);



        $this->_repositoryPostulacion->createPostulacionRelacionAcademia($relacionAcademica, $connection);
        $this->_repositoryPostulacion->createPostulacionesRelacionComplementarios($relacionComplementarios, $connection);
        $this->_repositoryPostulacion->createPostulacionRelacionFamiliares($relacionesFamiliares, $connection);
        $this->_repositoryPostulacion->createPostulacionRelacionPersonales($relacionPersonales, $connection);
        $this->_repositoryPostulacion->createPostulacionRelacionesExperienciaLaborales($relacionLaboral, $connection);

        $this->_repositoryPostulacion->createConvocatoriaRelacionPostulante($convocatoriaPostulante->toArray(), $connection);

        $postulante = $this->_repositoryPostulacion->create($postulanteDTO->toArray(), $connection);
        $postulanteResponseDTO = new PostulanteResponseDTO($postulante);

        $contactMail = new ContactFormMail(
            $postulanteResponseDTO->nombreCompleto,
            "Se ha postulado correctamente a la vacante espere noticias :*"
        );

        ProcesarCorreo::dispatch($postulanteDTO->email, $contactMail);

        $mensajes = [
            "El postulante ha sido registrado exitosamente.",
            "Se ha enviado un correo de confirmación."
        ];

        return new ResponseDTO(
            $mensajes,
            $postulanteRequestDTO,
            Response::HTTP_CREATED
        );
    }

    public function changeStatuConvocatoriaPostulacionRelacion(string $convocatoriaRelacionPostulanteId, ConvocatoriaCambioEstadoPostulanteDTO $convocatoriaCambioEstadoPostulanteDTO): ResponseDTO
    {
        //code...
        $convocatoriaRelacionPostulante = $this->_repositoryPostulacion
            ->getConvocatoriaRelacionPostulanteById($convocatoriaRelacionPostulanteId);

        $estado = $convocatoriaCambioEstadoPostulanteDTO->estado;

        if (!$convocatoriaRelacionPostulante) {
            return new ResponseDTO(
                "No se encontró al postulante.",
                [],
                Response::HTTP_NOT_FOUND
            );
        }

        $convocatoriaPostulanteRelacionDTO = new ConvocatoriaPostulanteRelacionDTO($convocatoriaRelacionPostulante->toArray());
        $postulanteResponseDTO = $this->_repositoryPostulacion->getPostulante($convocatoriaPostulanteRelacionDTO->postulante_id);


        if ($convocatoriaPostulanteRelacionDTO->estado != "Nuevo") {
            return new ResponseDTO(
                "El usuario ya ha recibido una respuesta a su postulación.",
                $postulanteResponseDTO,
                Response::HTTP_CONFLICT
            );
        }

        if ($this->_repositoryBlacklist->userInBlacklistByIdentificacion($postulanteResponseDTO->identificacion)) {
            # code...
            return new ResponseDTO(
                "El postulante con la identificación proporcionada está registrado en la blacklist.",
                $postulanteResponseDTO->identificacion,
                Response::HTTP_CONFLICT
            );
        }

        $convocatoriaPostulanteRelacionDTO->estado = $estado ? 'Aprobado' : 'Rechazado';
        /**
         * codigo faltante aceptado y rechazado
         */
        if (!$estado) {
            # code...
            $nominaBlackListDTO = new BlacklistRequestCreateDTO();

            $nominaBlackListDTO->identificacion = $postulanteResponseDTO->identificacion;

            $nominaBlackListDTO->nombres = MyFunctions::concatenarYLimpiar([
                $postulanteResponseDTO->nombre1 ?? null,
                $postulanteResponseDTO->nombre2 ?? null
            ]);

            $nominaBlackListDTO->apellidos = MyFunctions::concatenarYLimpiar([
                $postulanteResponseDTO->apellido1 ?? null,
                $postulanteResponseDTO->apellido2 ?? null
            ]);

            $nominaBlackListDTO->observaciones = $convocatoriaCambioEstadoPostulanteDTO->motivoRechazo;

            $this->_repositoryBlacklist->create($nominaBlackListDTO->toArray());
        } else {

            $postulante = $this->_repositoryPostulacion
                ->getPostulanteByID($convocatoriaPostulanteRelacionDTO->postulante_id);

            $postulanteDTO = new PostulanteRelacionesDTO($postulante->first());
            $empleadoCreateDTO = EmpleadoCreateDTO::createFromModel($postulanteDTO);

            $empleadoCreateDTO->convocatoriaRelId = $postulanteDTO->nomina_convocatoria_id;
            $empleadoCreateDTO->empleadoId = $postulanteDTO->nomina_convocatoria_postulante_id;
            /**
             * @var array<REmpleadoFamiliarCreateDTO>
             */
            $REmpleadoFamiliarCreateDTO = $this->createRelacion($postulanteDTO->familiares ?? [], $empleadoCreateDTO->empleadoId, REmpleadoFamiliarCreateDTO::class);
            /**
             * @var array<REmpleadoPersonalCreateDTO>
             */
            $REmpleadoPersonalCreateDTO = $this->createRelacion($postulanteDTO->personales ?? [], $empleadoCreateDTO->empleadoId, REmpleadoPersonalCreateDTO::class);
            /**
             * @var array<REmpleadoComplementarioCreateDTO>
             */
            $REmpleadoComplementarioCreateDTO = $this->createRelacion($postulanteDTO->complementarios ?? [], $empleadoCreateDTO->empleadoId, REmpleadoComplementarioCreateDTO::class);
            /**
             * @var array<REmpleadoExperienciaLaboralCreateDTO>
             */
            $REmpleadoExperienciaLaboralCreateDTO = $this->createRelacion($postulanteDTO->experiencia_laboral ?? [], $empleadoCreateDTO->empleadoId, REmpleadoExperienciaLaboralCreateDTO::class);
            /**
             * @var array<REmpleadoAcademiaCreateDTO>
             */
            $REmpleadoAcademiaCreateDTO = $this->createRelacion($postulanteDTO->academias ?? [], $empleadoCreateDTO->empleadoId, REmpleadoAcademiaCreateDTO::class);

            //Crea el empleado en la tabla de talento humano empleados 
            $this->_empleadoRepository->createEmpleado($empleadoCreateDTO->toArray());

            // Crea la replica de información de los datos del postulado en la tablas de Talento Humano 
            $this->_empleadoRepository->createEmpleadoAcademia($postulanteDTO->academias);
            $this->_empleadoRepository->createEmpleadoComplementarios($postulanteDTO->complementarios);
            $this->_empleadoRepository->createEmpleadoExperienciaLaboral($postulanteDTO->experiencia_laboral);
            $this->_empleadoRepository->createEmpleadoFamiliares($postulanteDTO->familiares);
            $this->_empleadoRepository->createEmpleadoPersonales($postulanteDTO->personales);

            // Crea las relaciones de la replicación de los postulados de en las tablas de talento humano
            $this->_empleadoRepository->createREmpleadoFamiliar($REmpleadoFamiliarCreateDTO);
            $this->_empleadoRepository->createREmpleadoPersonal($REmpleadoPersonalCreateDTO);
            $this->_empleadoRepository->createREmpleadoComplementario($REmpleadoComplementarioCreateDTO);
            $this->_empleadoRepository->createREmpleadoExperienciaLaboral($REmpleadoExperienciaLaboralCreateDTO);
            $this->_empleadoRepository->createREmpleadoAcademia($REmpleadoAcademiaCreateDTO);

        }

        $this->_repositoryPostulacion->statuChangePostulante($convocatoriaRelacionPostulanteId, $estado);

        $contactFormMail = new ContactFormMail($postulanteResponseDTO->nombreCompleto, $convocatoriaPostulanteRelacionDTO->estado);

        ProcesarCorreo::dispatch($postulanteResponseDTO->email, $contactFormMail);

        $mensajes = [
            "El postulante ha sido $estado con éxito.",
            "Se ha enviado un correo electrónico al usuario."
        ];

        return new ResponseDTO(
            $mensajes,
            $postulanteResponseDTO,
            Response::HTTP_OK
        );

    }

    public function getPostulantesByIdConvocatoria(string $idConvocatoria, $estadoPostulante = null)
    {


        // $page = Request::input('page', 1);
        $convocatoriasRelacionPostulante = $this->_repositoryPostulacion
            ->getPostulantesByIdConvocatoriaPaginate($idConvocatoria, $estadoPostulante);

        $convocatoriasRelacionPostulante->getCollection()->transform(function ($convocatoriaRelacionPostulante) {
            return new PostulanteConvocatoriaDTO($convocatoriaRelacionPostulante);
        });

        return new ResponseDTO('Datos traidos exitosamente', $convocatoriasRelacionPostulante);
    }


    public function getPostulanteByID($idPostulante)
    {

        $convocatoriasRelacionPostulante = $this->_repositoryPostulacion
            ->getPostulanteByID($idPostulante);

        $convocatoriasRelacionPostulante->transform(function ($postulante) {
            return new ResponsePostulanteConvocatoria($postulante);
        });

        return new ResponseDTO('Datos traidos exitosamente', $convocatoriasRelacionPostulante->first());
    }


    private function createRelacion(array $items, $empleadoId, $createDTOClass)
    {
        $result = [];
        foreach ($items as $item) {
            $dto = new $createDTOClass($empleadoId, $item['id']);
            $result[] = $dto->toArray();
        }
        return $result;
    }
}
