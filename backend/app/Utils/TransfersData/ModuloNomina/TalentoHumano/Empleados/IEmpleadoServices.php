<?php

namespace App\Utils\TransfersData\ModuloNomina\TalentoHumano\Empleados;

interface IEmpleadoServices
{
    /**
     * Obtiene la paginación de empleados.
     *
     * @throws \InvalidArgumentException Si el valor de perPage no es válido.
     * @return \App\Data\Dtos\Response\ResponseDTO
     */
    public function getEmpleadosPagination();
}
