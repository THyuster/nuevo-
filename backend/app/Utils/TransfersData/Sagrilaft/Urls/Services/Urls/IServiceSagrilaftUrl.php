<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Services\Urls;
use App\Data\Dtos\Response\ResponseDTO;
use App\Data\Dtos\Sagrilaft\Validacion\Url\Request\SagrilaftUrlRequestCreateDTO;

interface IServiceSagrilaftUrl
{
    /**
     * Crea una nueva URL y relaciona su tipo de validación.
     *
     * Este método verifica si el tipo de validación existe, crea la URL
     * y establece las relaciones correspondientes.
     *
     * @param SagrilaftUrlRequestCreateDTO $sagrilaftUrlRequestCreateDTO
     * @return \App\Data\Dtos\Response\ResponseDTO
     */
    public function create(SagrilaftUrlRequestCreateDTO $sagrilaftUrlRequestCreateDTO);
    /**
     * Obtiene los datos para la tabla de URLs.
     *
     * Este método construye una consulta para recuperar datos de SagrilaftUrls,
     * aplicando filtros, ordenamientos y paginación según la solicitud del cliente.
     *
     * @return \App\Data\Dtos\Datatable\DatatableResponseDTO DTO que contiene los datos de la tabla y la información de paginación.
     */
    public function getTable();
    /**
     * Elimina un registro por su ID.
     *
     * @param mixed $id El ID del registro a eliminar.
     * @return \App\Data\Dtos\Response\ResponseDTO Un objeto que contiene el mensaje y el estado de la operación.
     */
    public function delete($id): ResponseDTO;
}
