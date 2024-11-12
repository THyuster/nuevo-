<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Data\Dtos\Solicitudes\Request\RequestCreateSolicitudDTO;
use App\Data\Dtos\Solicitudes\Response\ResponseSolicitudDTO;
use App\Data\Dtos\Solicitudes\Response\ResponseSolicitudView;
use App\Data\Dtos\Solicitudes\Response\SolicitudDTO;
use App\Models\modulo_mantenimiento\mantenimiento_solicitudes_view;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloMantenimiento\CSolicitudes;
use App\Utils\Constantes\ModuloMantenimiento\Ordenes\COrdenes;
use App\Utils\CryptoFirmas\FirmasDigitalesImages;
use App\Utils\DBServerSide;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\FileManager;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloMantenimiento\Repositories\Solicitudes\ISolicitudRepository;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class ServicesSolicitudes implements IServicesSolicitudes
{

    private CSolicitudes $_cSolicitudes;
    private RepositoryDynamicsCrud $_repository;
    private FileManager $_fileManager;
    private $nombreTabla = "mantenimiento_solicitudes";
    private COrdenes $_COrdenes;
    protected ISolicitudRepository $solicitudRepository;

    public function __construct(
        COrdenes $cOrdenes,
        RepositoryDynamicsCrud $repositoryDynamicsCrud,
        CSolicitudes $cSolicitudes,
        FileManager $fileManager,
        ISolicitudRepository $iSolicitudRepository
    ) {
        $this->_repository = $repositoryDynamicsCrud;
        $this->_cSolicitudes = $cSolicitudes;
        $this->_fileManager = $fileManager;
        $this->_COrdenes = $cOrdenes;
        $this->solicitudRepository = $iSolicitudRepository;
    }

    public function getSolicitudesDatatable()
    {

        // Recupera el usuario autenticado.
        $user = Auth::user();
        $idUsuario = $user->id; // ID del usuario autenticado.

        // Establece una conexión con la base de datos.
        $connection = RepositoryDynamicsCrud::findConectionDB();
        $mantenimientoSolicitudView = new mantenimiento_solicitudes_view();
        $mantenimientoSolicitudViewQuery = mantenimiento_solicitudes_view::on($connection);

        // Captura la solicitud entrante.
        $request = Request::capture();
        $datatableDTO = new DatatableResponseDTO();

        // Obtiene los nombres de las columnas de la tabla de la vista.
        $columns = $mantenimientoSolicitudViewQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($mantenimientoSolicitudView->getTable());

        // Establece el número total de registros.
        $datatableDTO->recordsTotal = $mantenimientoSolicitudViewQuery->count();

        // Obtiene el parámetro draw de la solicitud.
        $datatableDTO->draw = intval($request->input('draw', 1));

        // Obtiene los parámetros de paginación y filtrado de la solicitud.
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        // Aplica el filtro de búsqueda a la consulta si se proporciona un término de búsqueda.
        if ($search) {
            $mantenimientoSolicitudViewQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        // Aplica filtros específicos de columna si se proporcionan.
        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);
        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $mantenimientoSolicitudViewQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        // Establece el número de registros filtrados.
        $datatableDTO->recordsFiltered = $mantenimientoSolicitudViewQuery->count();

        // Aplica el orden basado en los parámetros de ordenamiento.
        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $mantenimientoSolicitudViewQuery->orderBy($columnName, $direction);
                }
            }
        }

        // Añade un filtro específico del usuario.
        $mantenimientoSolicitudViewQuery->where('usuario_id', '=', $idUsuario);

        // Aplica los límites de paginación.
        if ($length != -1) {
            $mantenimientoSolicitudViewQuery->offset($start)->limit($length);
        }

        // Recupera los datos y los transforma para la respuesta de la DataTable.
        $datatableDTO->data = $mantenimientoSolicitudViewQuery->get()->transform(function ($solicitudView) {
            return new ResponseSolicitudView($solicitudView);
        })->toArray();

        return $datatableDTO;

    }

    public function crearSolicitud(RequestCreateSolicitudDTO $requestCreateSolicitudDTO)
    {
        $pathImagen = null;

        // Verifica si se han seleccionado tanto un equipo como un vehículo.
        if ($requestCreateSolicitudDTO->equipoId && $requestCreateSolicitudDTO->vehiculoId) {
            throw new Exception("Hay un equipo y vehiculo seleccionado: Solo puede seleccionar uno", Response::HTTP_CONFLICT);
        }

        // Verifica si no se ha seleccionado ni un equipo ni un vehículo.
        if (!$requestCreateSolicitudDTO->equipoId && !$requestCreateSolicitudDTO->vehiculoId) {
            throw new Exception("No se puede continuar si no existe un vehiculo o equipo en la solicitud", Response::HTTP_CONFLICT);
        }

        // Maneja la carga de una imagen si se proporciona.
        if ($requestCreateSolicitudDTO->rutaImagen) {
            try {
                // Intenta almacenar la imagen en la ubicación especificada.
                $pathImagen = $this->_fileManager->pushImag($requestCreateSolicitudDTO->rutaImagen, "perfiles_solicitudes", "");
                // Verifica si el almacenamiento de la imagen tuvo éxito.
                if ($pathImagen === "No se encontro imagen" || $pathImagen === "No es una imagen valida") {
                    throw new Exception($pathImagen, Response::HTTP_CONFLICT);
                }
            } catch (\Throwable $th) {
                throw new Exception("Imagen no fue almacenada error en la petición api", Response::HTTP_CONFLICT);
            }
        }
        
        // Asigna la ruta de la imagen al DTO de solicitud.
        $requestCreateSolicitudDTO->imagen = $pathImagen;

        // Crea una nueva solicitud en la base de datos utilizando el repositorio.
        $solicitud = $this->solicitudRepository->create($requestCreateSolicitudDTO->toArray());

        // Retorna el objeto de la solicitud creada.
        return $solicitud;
    }

    public function actualizarSolicitud(RequestCreateSolicitudDTO $requestCreateSolicitudDTO, $id)
    {

        if ($requestCreateSolicitudDTO->equipoId && $requestCreateSolicitudDTO->vehiculoId) {
            throw new Exception("Hay un equipo y vehiculo seleccionado: 
            Solo puede seleccionar uno", Response::HTTP_CONFLICT);
        }

        if (!$requestCreateSolicitudDTO->equipoId && !$requestCreateSolicitudDTO->vehiculoId) {
            throw new Exception("No se puede continuar si no existe un vehiculo o
             equipo en la solicitud", Response::HTTP_CONFLICT);
        }

        $solicitudDTO = new SolicitudDTO($this->solicitudRepository->getById($id));

        $imagenPath = $solicitudDTO->rutaImagen;

        if ($requestCreateSolicitudDTO->rutaImagen) {
            # code...
            if ($imagenPath) {
                $this->_fileManager->deleteImage($imagenPath);
            }

            $imagenPath = $this->_fileManager->pushImag($requestCreateSolicitudDTO->rutaImagen, 'perfiles_solicitudes', "");

            if ($imagenPath === "No se encontro imagen" || $imagenPath === "No es una imagen valida") {
                throw new Exception($imagenPath, Response::HTTP_CONFLICT);
            }

        }

        $requestCreateSolicitudDTO->imagen = $imagenPath;

        return $this->solicitudRepository->updateById($id, $requestCreateSolicitudDTO->toArray());

    }


    public function solicitudFirmar($id, Request $request)
    {
        $entidadSolicitud = $this->_repository->sqlFunction($this->_cSolicitudes->sqlSelectById($id));
        $firmarDigitales = new FirmasDigitalesImages();
        $user = Auth::user();
        $id_usuario = $user->id;

        if (empty($entidadSolicitud)) {
            throw new Exception("No se encontro encontrado la solicitud", Response::HTTP_NOT_FOUND);
        }

        $estadoSolicitud = $entidadSolicitud[0]->estado_id;

        if ($estadoSolicitud != 3) {
            throw new Exception("La solicitud aún no esta para firmar", Response::HTTP_CONFLICT);
        }

        $imagen = $request->ruta_imagen;

        $idFirma = $firmarDigitales->firmar($imagen, $id_usuario);
        $sql = "UPDATE mantenimiento_solicitudes SET id_signatures = '$idFirma', estado_id='4' WHERE id = '$id'";
        $this->_repository->sqlFunction($sql);

        return true;
    }

    public function eliminarSolicitud($id)
    {

        $solicitud = new SolicitudDTO($this->solicitudRepository->getById($id));

        if (!$solicitud) {
            # code...
            throw new Exception("No se encontro encontrado la solicitud", Response::HTTP_NOT_FOUND);
        }

        $ordenEntidad = $this->_repository->sqlFunction($this->_COrdenes->sqlGetBySolicitudId($solicitud->idSolicitud));

        if (!empty($ordenEntidad)) {
            throw new Exception("Hay una orden asignada a esta solicitud, no es posible eliminarla", 1);
        }

        if ($solicitud->rutaImagen) {
            $this->_fileManager->deleteImage($solicitud->rutaImagen);
        }

        if ($solicitud->estadoId && $solicitud->estadoId !== 1 && $solicitud->estadoId !== 4) {
            $estado = ($solicitud->estadoId == 2) ? "En proceso" : "Resuelta";
            throw new Exception("La solicitud está en estado:  $estado. Por lo que no es permitido eliminarla", Response::HTTP_CONFLICT);
        }

        return $this->solicitudRepository->deleteById($id);
    }


    public function getCamposSelectores()
    {
        $selectores = $this->_cSolicitudes->constanteSqlValidacionId();
        $arrayResultante = array();

        foreach ($selectores as $atributo => $valor) {
            $arrayResultante[$atributo] = $this->_repository->sqlFunction($this->_cSolicitudes->consultaSqlSelectores($valor));
        }

        return $arrayResultante;
    }

    public function getSolicitudById($id)
    {
        $solicitudDetails = $this->solicitudRepository->obtenerSolicitudConDetalles($id);

        if (!$solicitudDetails) {
            throw new Exception("No se encontro la solicitud", Response::HTTP_NOT_FOUND);
        }

        return response()->json(new ResponseSolicitudDTO($solicitudDetails));
    }

    public function getTerceros()
    {
        return $this->_repository->sqlFunction($this->_cSolicitudes->sqlTerceros());
    }

    public function actualizarEstadoSolicitud($id, $estado)
    {
        $solicitudDTO = new SolicitudDTO($this->solicitudRepository->getById($id));
        $solicitudDTO->estadoId = $estado;

        $attributes = [
            "estado_id" => $estado,
        ];

        $this->solicitudRepository->updateById($id, $attributes);

        return response()->json($solicitudDTO);
    }
}
