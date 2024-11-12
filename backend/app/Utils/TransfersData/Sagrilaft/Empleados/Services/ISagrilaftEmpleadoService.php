<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Services;
use App\Data\Dtos\Response\ResponseDTO;
use App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request\SagrilaftEmpleadoRelUrlCreateDTO;

interface ISagrilaftEmpleadoService
{
    /**
     * Crea una relación entre un empleado y una URL, incluyendo la gestión de recursos asociados.
     *
     * @param \App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request\SagrilaftEmpleadoRelUrlCreateDTO $sagrilaftEmpleadoRelUrlCreateDTO
     * @throws \Exception Si ocurre un error durante el proceso de creación.
     * @return \App\Data\Dtos\Response\ResponseDTO Retorna un objeto de respuesta con el resultado de la operación.
     */
    public function create(SagrilaftEmpleadoRelUrlCreateDTO $sagrilaftEmpleadoRelUrlCreateDTO): ResponseDTO;

}
