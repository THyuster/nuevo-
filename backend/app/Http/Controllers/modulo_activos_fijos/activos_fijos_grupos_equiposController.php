<?php

namespace App\Http\Controllers\modulo_activos_fijos;

use App\Data\Dtos\ActivosFijos\GruposEquipos\Request\GrupoEquipoRequestCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivosFijos\GrupoEquipo\GrupoEquipoRequestCreate;
use App\Utils\TransfersData\ModuloActivosFijos\IGruposEquiposServices;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\GruposEquipos\IGruposEquiposRepository;
use Illuminate\Http\Request;

class activos_fijos_grupos_equiposController extends Controller
{
    protected IGruposEquiposServices $_grupoEquipoService;
    protected IGruposEquiposRepository $_grupoEquipoRepository;

    public function __construct(IGruposEquiposServices $iGruposEquiposServices, IGruposEquiposRepository $iGruposEquiposRepository)
    {
        $this->_grupoEquipoService = $iGruposEquiposServices;
        $this->_grupoEquipoRepository = $iGruposEquiposRepository;
    }
    /**
     * Crea un nuevo registro en la base de datos utilizando los datos del DTO proporcionado.
     *
     * Este método convierte los datos del objeto `GrupoEquipoRequestCreate` en un objeto DTO (`GrupoEquipoRequestCreateDTO`),
     * y luego llama al servicio correspondiente para crear el nuevo registro en la base de datos. 
     * Finalmente, devuelve una respuesta JSON que contiene el resultado de la operación de creación.
     *
     * @param GrupoEquipoRequestCreate $grupoEquipoRequestCreate
     *        Un objeto que contiene los datos necesarios para crear un nuevo registro. Debe ser una instancia de 
     *        `GrupoEquipoRequestCreate`.
     * 
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que incluye los datos del nuevo registro creado 
     *         o un mensaje de error en caso de que la operación falle. La respuesta tiene un formato adecuado para ser 
     *         procesado por el cliente, incluyendo el código de estado HTTP apropiado.
     */
    public function create(GrupoEquipoRequestCreate $grupoEquipoRequestCreate)
    {
        $grupoEquipoRequestDTO = new GrupoEquipoRequestCreateDTO($grupoEquipoRequestCreate->toArray());

        $response = $this->_grupoEquipoService->create($grupoEquipoRequestDTO);

        return response()->json($response);
    }
    /**
     * Obtiene todos los registros de 'gruposEquipos' y devuelve una respuesta JSON.
     *
     * Este método recupera todos los registros de la tabla 'gruposEquipos' utilizando el repositorio 
     * `_grupoEquipoRepository`. Luego, devuelve una respuesta JSON que incluye todos los registros 
     * obtenidos. Esta respuesta es adecuada para ser procesada por el cliente.
     *
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que contiene una colección de todos los registros 
     *         de 'gruposEquipos'. La respuesta está en un formato adecuado para que el cliente pueda procesarla, 
     *         incluyendo el código de estado HTTP 200 (Éxito).
     */
    public function show()
    {
        $gruposEquipos = $this->_grupoEquipoRepository->fetchAllRecords();

        return response()->json($gruposEquipos);
    }
    /**
     * Actualiza un registro existente con los datos proporcionados y devuelve una respuesta JSON.
     *
     * Este método convierte los datos del objeto `GrupoEquipoRequestCreate` en un DTO (`GrupoEquipoRequestCreateDTO`), 
     * y luego llama al servicio correspondiente para actualizar el registro en la base de datos usando el identificador proporcionado. 
     * Finalmente, devuelve una respuesta JSON que contiene el resultado de la operación de actualización.
     *
     * @param \App\Http\Requests\ActivosFijos\GrupoEquipo\GrupoEquipoRequestCreate $grupoEquipoRequestCreate
     *        Un objeto que contiene los datos necesarios para actualizar el registro. Debe ser una instancia de 
     *        `GrupoEquipoRequestCreate`.
     * @param mixed $id El identificador del registro que se va a actualizar. Puede ser de tipo entero o cadena, 
     *                   dependiendo del tipo de columna del identificador.
     * 
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que incluye los datos actualizados del registro, 
     *         o un mensaje de error en caso de que la operación falle. La respuesta está en un formato adecuado para ser 
     *         procesada por el cliente, incluyendo el código de estado HTTP apropiado.
     */
    public function update(GrupoEquipoRequestCreate $grupoEquipoRequestCreate, $id)
    {
        $grupoEquipoRequestDTO = new GrupoEquipoRequestCreateDTO($grupoEquipoRequestCreate->toArray());

        $response = $this->_grupoEquipoService->update($id, $grupoEquipoRequestDTO);

        return response()->json($response);
    }
    /**
     * Obtiene registros de 'gruposEquipos' filtrados basados en el parámetro de filtro del request y devuelve una respuesta JSON.
     *
     * Este método extrae el parámetro de filtro del objeto `Request`. Si no se proporciona ningún filtro, se devuelve una respuesta 
     * JSON vacía. Si se proporciona un filtro, se llama al servicio correspondiente para obtener los registros de 'gruposEquipos' 
     * que coinciden con el filtro aplicado. Finalmente, se devuelve una respuesta JSON que incluye los registros filtrados.
     *
     * @param \Illuminate\Http\Request $request El objeto request que contiene el parámetro de filtro para obtener los registros.
     * 
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que incluye los registros filtrados de 'gruposEquipos' 
     *         o una respuesta JSON vacía si no se proporciona ningún filtro. La respuesta está en un formato adecuado para 
     *         que el cliente pueda procesarla, incluyendo el código de estado HTTP apropiado.
     */
    public function getGrupoEquipoServerSide(Request $request)
    {
        $filter = $request->input('filter', null);

        if (!$filter) {
            return response()->json();
        }

        $response = $this->_grupoEquipoService->getGrupoEquiposFilter($filter);

        return response()->json($response);
    }
    /**
     * Elimina un registro específico de 'gruposEquipos' basado en el identificador proporcionado y devuelve una respuesta JSON.
     *
     * Este método llama al servicio correspondiente para eliminar el registro con el identificador proporcionado. 
     * Luego, devuelve una respuesta JSON que contiene el resultado de la operación de eliminación. La respuesta 
     * puede incluir un mensaje de éxito o un mensaje de error, dependiendo del resultado de la operación.
     *
     * @param mixed $id El identificador del registro que se va a eliminar. Puede ser de tipo entero o cadena, 
     *                   dependiendo del tipo de columna del identificador.
     * 
     * @return \Illuminate\Http\JsonResponse Devuelve una respuesta JSON que incluye el resultado de la operación de eliminación. 
     *         La respuesta está en un formato adecuado para el cliente, incluyendo el código de estado HTTP apropiado.
     */
    public function destroy($id)
    {
        $response = $this->_grupoEquipoService->delete($id);

        return response()->json($response);
    }
}
