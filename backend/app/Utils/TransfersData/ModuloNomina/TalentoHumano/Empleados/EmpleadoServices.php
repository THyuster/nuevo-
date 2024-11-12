<?php

namespace App\Utils\TransfersData\ModuloNomina\TalentoHumano\Empleados;
use App\Custom\Http\Request;
use App\Data\Dtos\Response\ResponseDTO;
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Repository\IEmpleadosRepository;
use InvalidArgumentException;
use Response;

class EmpleadoServices implements IEmpleadoServices
{
    protected IEmpleadosRepository $empleadoRepository;

    public function __construct(IEmpleadosRepository $iEmpleadosRepository)
    {
        $this->empleadoRepository = $iEmpleadosRepository;
    }


    public function getEmpleadosPagination()
    {
        $request = Request::capture();

        // Captura la página y el número de elementos por página desde el request.
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        // Validación del parámetro perPage.
        if (!is_numeric($perPage) || $perPage < 1 || $perPage > 50) {
            throw new InvalidArgumentException('El valor de perPage debe ser un número entre 1 y 50.');
        }

        // Asegúrate de que perPage sea un entero.
        $perPage = (int) $perPage;

        // Obtiene los datos paginados desde el repositorio.
        $datos = $this->empleadoRepository->getAllEmpleadoPagination($perPage, $page);

        // Devuelve los datos en un DTO de respuesta.
        return new ResponseDTO('Datos Traidos Exitosamente', $datos);
    }
}
