<?php

namespace App\Utils\TransfersData\ModuloNomina\Blacklist;

use App\Data\Dtos\Convocatorias\BlanckListDTOs\BlacklistRequestCreateDTO;
use Illuminate\Http\JsonResponse;

interface IServiceNominaBlacklist
{
    /**
     * Crea un nuevo registro en la lista negra.
     *
     * @param \App\Data\Dtos\Convocatorias\BlanckListDTOs\BlacklistRequestCreateDTO $blacklistRequestCreateDTO Los datos del nuevo registro.
     * @throws \Illuminate\Http\Exceptions\HttpResponseException Si ocurre un error durante la creación.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con el resultado de la operación.
     */

    public function create(BlacklistRequestCreateDTO $blacklistRequestCreateDTO);
    /**
     * Actualiza un registro en la lista negra.
     *
     * @param string $idBlacklist El ID del registro en la lista negra a actualizar.
     * @param \App\Data\Dtos\Convocatorias\BlanckListDTOs\BlacklistRequestCreateDTO $blacklistRequestUpdateDTO Los nuevos datos para el registro.
     * @throws \Illuminate\Http\Exceptions\HttpResponseException Si ocurre un error durante la actualización.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con el resultado de la operación.
     */
    public function update(string $idBlacklist, BlacklistRequestCreateDTO $blacklistRequestUpdateDTO);
    /**
     * Elimina un registro de la lista negra por su ID.
     *
     * @param string $idBlacklist El ID del registro en la lista negra a eliminar.
     * @throws \Illuminate\Http\Exceptions\HttpResponseException Si ocurre un error durante la eliminación.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con el resultado de la operación.
     */
    public function delete(string $idBlacklist): JsonResponse;
    /**
     * Obtiene datos de la tabla de la lista negra con soporte para server-side processing.
     *
     * @param mixed $request El objeto de solicitud que contiene los parámetros para la consulta.
     * @return \App\Data\Dtos\Datatable\DatatableResponseDTO La respuesta JSON con los datos de la tabla o un error.
     */
    public function get();

}
