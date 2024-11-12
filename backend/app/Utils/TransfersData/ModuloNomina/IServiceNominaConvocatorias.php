<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Data\Dtos\Convocatorias\ConvocatoriaBySolicitudEmpleoDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasCreacionRequestDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasCreateDTO;
use App\Data\Dtos\Convocatorias\ConvocatoriasUpdateDTO;
use App\Utils\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IServiceNominaConvocatorias
{
    /**
     * @param ConvocatoriasCreacionRequestDTO $convocatoriaCreateRequestDto
     * DTO de convocatorias para crear
     * @return JsonResponse
     */
    public function create(ConvocatoriasCreacionRequestDTO $convocatoriaCreateRequestDto): JsonResponse;
    /**
     * Metodo para actualizar una convocatoria
     * @param string $nominaConvocatoriaId
     * Id de la convocatoria
     * @param ConvocatoriasUpdateDTO $convocatoriasUpdateDTO
     * DTO para actualizar convocatoria
     * @return JsonResponse
     * Responde una JsonResponse
     */
    public function update(string $nominaConvocatoriaIdid, ConvocatoriasUpdateDTO $convocatoriasUpdateDTO): JsonResponse;
    /**
     * Elimina una convocatoria por su ID.
     *
     * Este método verifica si la convocatoria con el ID proporcionado existe antes
     * de intentar eliminarla. Si la convocatoria no se encuentra, devuelve un
     * mensaje de error con un código de estado HTTP 404. Si la eliminación es exitosa,
     * devuelve un mensaje de éxito con un código de estado HTTP 200. En caso de
     * que la eliminación falle o ocurra una excepción, se devuelve un mensaje de error
     * adecuado con un código de estado HTTP 500.
     *
     * @param string $nominaConvocatoriaId El ID de la convocatoria que se desea eliminar.
     * @return \App\Data\Dtos\Response\ResponseDTO Una instancia de ResponseDTO que contiene el mensaje de respuesta,
     *                      los datos (si los hay) y el código de estado HTTP correspondiente.
     * 
     * @throws \Throwable En caso de una excepción inesperada durante el proceso de eliminación.
     */
    public function delete(string $nominaConvocatoriaId);
    public function get();
    /**
     * Metodo para inactivar o activar convocatoria
     * @param string $nominaConvocatoriaId
     * Id de la convocotaria a actualizar
     * @return JsonResponse
     * Respondera un JsonResponse
     */
    public function active(string $nominaConvocatoriaId): JsonResponse;
    public function getNominaConvocatoriaId(string $id);
    public function getListConvocatoria(Request $request): JsonResponse;
    /**
     * @param ConvocatoriaBySolicitudEmpleoDTO $convocatoriaBySolicitudEmpleoDTO
     * DTO de datos para crear convocatoria por solicitud de empleo
     * @return JsonResponse
     */
    public function createConvoctariaBySolicitudEmpleo(ConvocatoriaBySolicitudEmpleoDTO $convocatoriaBySolicitudEmpleoDTO): JsonResponse;
    /**
     * @param string $solicitudEmpleoId
     * Id de la solicitud de empleo
     * @return JsonResponse
     */
    public function rejectConvocatoriaBySolicitud($solicitudEmpleoId): JsonResponse;

}