<?php

namespace App\Utils\TransfersData\ModuloActivosFijos;
use App\Data\Dtos\ActivosFijos\GruposEquipos\Request\GrupoEquipoRequestCreateDTO;

interface IGruposEquiposServices
{
    /**
     * Crea un nuevo registro en la base de datos con los datos proporcionados.
     *
     * Este método verifica si ya existe un registro con el código proporcionado en el DTO. 
     * Si el código ya existe, lanza una excepción con un mensaje de conflicto y un código de estado HTTP 409 (Conflicto). 
     * Si el código no existe, crea un nuevo registro en la base de datos usando los datos del DTO. 
     * La creación se realiza mediante el método `create` del repositorio `_grupoEquipoRepository`.
     *
     * @param \App\Data\Dtos\ActivosFijos\GruposEquipos\Request\GrupoEquipoRequestCreateDTO $grupoEquipoRequestCreateDTO
     *        Un objeto DTO que contiene los datos para el nuevo registro. Debe ser una instancia de `GrupoEquipoRequestCreateDTO`.
     * 
     * @throws \Exception Lanza una excepción si el código proporcionado en el DTO ya existe en la base de datos. 
     *                     La excepción incluye un mensaje de conflicto y un código de estado HTTP 409 (Conflicto).
     * 
     * @return \Illuminate\Database\Eloquent\Model Devuelve el modelo `gruposEquipos` creado en la base de datos. 
     *         La instancia del modelo incluye los datos del nuevo registro.
     */
    public function create(GrupoEquipoRequestCreateDTO $grupoEquipoRequestCreateDTO);
    /**
     * Actualiza un registro existente en la base de datos con los datos proporcionados.
     *
     * Este método busca un registro en la base de datos usando el identificador proporcionado. Si el registro existe, 
     * se verifica la unicidad del código (ignorando el identificador actual para permitir actualizaciones del mismo código). 
     * Si el código ya existe, se lanza una excepción con un mensaje de conflicto y un código de estado HTTP 409 (Conflicto). 
     * Si todo está en orden, se actualiza el registro con los nuevos datos proporcionados en el DTO. 
     * La actualización se realiza mediante el método `update` del repositorio `_grupoEquipoRepository`.
     *
     * @param mixed $id El identificador del registro que se va a actualizar. 
     *                  Puede ser un valor de tipo entero o cadena, según el tipo de columna del identificador.
     * @param \App\Data\Dtos\ActivosFijos\GruposEquipos\Request\GrupoEquipoRequestCreateDTO $grupoEquipoRequestCreateDTO
     *        Un objeto DTO que contiene los nuevos datos para actualizar el registro. Debe ser una instancia de `GrupoEquipoRequestCreateDTO`.
     * 
     * @throws \Exception Lanza una excepción en los siguientes casos:
     *                     - Si el registro con el identificador proporcionado no se encuentra en la base de datos. 
     *                       La excepción incluye un mensaje de error y un código de estado HTTP 404 (No encontrado).
     *                     - Si el código proporcionado en el DTO ya existe para otro registro (ignorando el identificador actual). 
     *                       La excepción incluye un mensaje de conflicto y un código de estado HTTP 409 (Conflicto).
     * 
     * @return bool Devuelve verdadero si el registro se actualiza con éxito; 
     *              de lo contrario, devuelve falso. La actualización puede fallar si el registro no existe 
     *              o si hay un error durante el proceso de actualización.
     */
    public function update($id, GrupoEquipoRequestCreateDTO $grupoEquipoRequestCreateDTO);
    /**
     * Elimina un registro de la base de datos con el identificador especificado.
     *
     * Este método busca un registro en la base de datos usando el identificador proporcionado. Si el registro se encuentra, 
     * se procede a eliminarlo. Si no se encuentra el registro, se lanza una excepción con un mensaje de error y un código 
     * de estado HTTP 404 (No encontrado). La eliminación se realiza mediante el método `delete` del repositorio 
     * `_grupoEquipoRepository`.
     *
     * @param mixed $id El identificador del registro que se va a eliminar. 
     *                  Puede ser un valor de tipo entero o cadena, según el tipo de columna del identificador.
     * 
     * @throws \Exception Lanza una excepción si el registro con el identificador proporcionado no se encuentra en la base de datos.
     *                     La excepción incluye un mensaje de error y un código de estado HTTP 404.
     * 
     * @return bool Devuelve verdadero si el registro se eliminó con éxito; 
     *              de lo contrario, devuelve falso. La eliminación puede fallar si el registro no existe o si hay un error durante el proceso.
     */
    public function delete($id);
    /**
     * Obtiene los registros de la tabla 'gruposEquipos' que coinciden con el filtro proporcionado.
     *
     * Este método busca registros en la tabla 'gruposEquipos' usando un filtro que se aplica a varios campos. 
     * El filtro se utiliza para realizar una búsqueda en los campos especificados: "id", "descripcion" y "codigo".
     * La búsqueda se realiza mediante el método `findGrupoEquipoByLikeQuery` del repositorio `_grupoEquipoRepository`.
     *
     * @param mixed $filter El valor del filtro que se aplicará a la búsqueda. Este valor se usará para encontrar coincidencias en los campos 
     *                      especificados. Puede ser de cualquier tipo que sea compatible con el método de búsqueda del repositorio.
     * 
     * @return \Illuminate\Database\Eloquent\Collection Una colección de modelos 'gruposEquipos' que contiene los registros que coinciden 
     *         con el filtro aplicado. Si no hay coincidencias, se devuelve una colección vacía.
     */
    public function getGrupoEquiposFilter($filter);
    // public function ();
}
