<?php

namespace App\Utils\TransfersData\ModuloActivosFijos\Repositories\Equipos;

interface IEquiposRepository
{
    /**
     * Crea un nuevo registro en la tabla `activos_fijos_equipos` usando la conexión a la base de datos especificada.
     *
     * Este método utiliza el ORM Eloquent de Laravel para insertar un nuevo registro en la base de datos.
     * Si no se proporciona una conexión de base de datos específica, se usará una conexión por defecto
     * obtenida del método `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param array $datos Un array asociativo de atributos para el nuevo registro.
     *                     Las claves en este array deben coincidir con los nombres de las columnas
     *                     de la tabla `activos_fijos_equipos`.
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     *         Retorna una instancia del modelo `activos_fijos_equipos` recién creado. 
     *         El objeto retornado es una instancia de `\Illuminate\Database\Eloquent\Model` 
     *         y representa el nuevo registro creado en la base de datos.
     *
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se puede encontrar la clase del modelo.
     */
    public function create(array $datos, $connection = null);
    /**
     * Verifica si existe un registro en la tabla `activos_fijos_equipos` con el código especificado.
     *
     * Este método utiliza el ORM Eloquent de Laravel para comprobar la existencia de un registro en la base de datos
     * con el valor dado para la columna `codigo`. Si no se proporciona una conexión de base de datos específica, 
     * se usará una conexión por defecto obtenida del método `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param string $codigo El código que se busca en la columna `codigo` de la tabla `activos_fijos_equipos`.
     *                       Este debe ser una cadena de texto que representa el valor a verificar.
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     *
     * @return bool Este método no retorna un valor. Realiza una verificación de existencia en la base de datos.
     *
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se puede encontrar la clase del modelo.
     */
    public function existByCodigo(string $codigo, $connection = null);
    /**
     * Busca un registro en la tabla `activos_fijos_equipos` por su ID.
     *
     * Este método utiliza el ORM Eloquent de Laravel para encontrar un registro en la base de datos
     * con el ID especificado. Si no se proporciona una conexión de base de datos específica, 
     * se usará una conexión por defecto obtenida del método `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param mixed $id El identificador del registro que se busca. Puede ser un valor entero o cualquier
     *                   tipo que coincida con el tipo de ID de la tabla `activos_fijos_equipos`.
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     *         Retorna el modelo `activos_fijos_equipos` correspondiente al ID proporcionado. 
     *         El resultado puede ser una instancia del modelo `\Illuminate\Database\Eloquent\Model` si
     *         se encuentra el registro, o `null` si no se encuentra ningún registro con ese ID.
     *
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se puede encontrar la clase del modelo.
     */
    public function findById($id, $connection = null);
    /**
     * Verifica si existe un registro en la tabla `activos_fijos_equipos` con el código especificado
     * que sea diferente del ID proporcionado.
     *
     * Este método utiliza el ORM Eloquent de Laravel para comprobar la existencia de un registro en la base de datos
     * que tenga el valor dado para la columna `codigo` pero con un ID distinto al especificado. 
     * Si no se proporciona una conexión de base de datos específica, se usará una conexión por defecto obtenida 
     * del método `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param string $codigo El código que se busca en la columna `codigo` de la tabla `activos_fijos_equipos`.
     *                       Debe ser una cadena de texto que representa el valor a verificar.
     * @param int $id El identificador del registro que se debe excluir de la búsqueda. Debe ser un entero.
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     *
     * @return bool Retorna `true` si existe al menos un registro con el código especificado y un ID diferente al proporcionado,
     *              de lo contrario, retorna `false`.
     *
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se puede encontrar la clase del modelo.
     */
    public function checkCodigoUniquenessIgnoringId(string $codigo, int $id, $connection = null);
    /**
     * Actualiza un registro en la tabla `activos_fijos_equipos` con el ID especificado.
     *
     * Este método utiliza el ORM Eloquent de Laravel para actualizar un registro existente en la base de datos
     * con los datos proporcionados. Si no se proporciona una conexión de base de datos específica, 
     * se usará una conexión por defecto obtenida del método `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param string $id El identificador del registro que se debe actualizar. Debe ser una cadena que representa
     *                   el ID del registro en la tabla `activos_fijos_equipos`.
     * @param array $data Un array asociativo de atributos que se actualizarán en el registro. Las claves del array
     *                    deben coincidir con los nombres de las columnas de la tabla `activos_fijos_equipos`.
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     *
     * @return bool|int|mixed Retorna el número de registros afectados por la actualización (generalmente 1 si se
     *                        actualiza un solo registro). También puede retornar `false` si la actualización falla.
     *                        En el contexto de Eloquent, el valor retornado es el número de registros afectados.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra el modelo con el ID proporcionado.
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     */
    public function update(string $id, array $data, $connection = null);
    /**
     * Elimina un registro de la tabla `activos_fijos_equipos` con el ID especificado.
     *
     * Este método utiliza el ORM Eloquent de Laravel para eliminar un registro existente en la base de datos
     * que corresponde al ID proporcionado. Si no se proporciona una conexión de base de datos específica, 
     * se usará una conexión por defecto obtenida del método `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param string $id El identificador del registro que se debe eliminar. Debe ser una cadena que representa
     *                   el ID del registro en la tabla `activos_fijos_equipos`.
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     *
     * @return bool|mixed|null Retorna `true` si el registro fue eliminado exitosamente. 
     *                         Puede retornar `false` si la eliminación falla. En algunos casos, el valor
     *                         retornado puede ser `null`, dependiendo del comportamiento de la base de datos
     *                         y la implementación específica de Eloquent.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra el modelo con el ID proporcionado.
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     */
    public function delete(string $id, $connection = null);
    /**
     * Obtiene una colección de registros de la tabla `activos_fijos_equipos` donde los valores de las columnas especificadas
     * coinciden parcialmente con el valor dado.
     *
     * Este método utiliza el ORM Eloquent de Laravel para buscar registros en la base de datos que contengan el valor dado
     * en alguna de las columnas especificadas. Si no se proporciona una conexión de base de datos específica, se usará
     * una conexión por defecto obtenida del método `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param array $campos Un array de nombres de columnas en las cuales se debe realizar la búsqueda. 
     *                      Cada nombre de columna debe coincidir con una columna en la tabla `activos_fijos_equipos`.
     * @param mixed $valor El valor a buscar en las columnas especificadas. Este valor se buscará usando una coincidencia parcial (like).
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     *         Retorna una colección de instancias del modelo `activos_fijos_equipos` que coinciden con la búsqueda.
     *         La colección puede estar vacía si no se encuentran registros que coincidan.
     *
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     */
    public function findEquiposFijosByLikeQuery(array $campos, $valor, $connection = null);
    /**
     * Obtiene una instancia del constructor de consultas para la tabla `activos_fijos_equipos`.
     *
     * Este método devuelve una instancia de `Illuminate\Database\Eloquent\Builder` para la tabla
     * `activos_fijos_equipos`, permitiendo la construcción de consultas Eloquent. Si se proporciona
     * una conexión a la base de datos, se utiliza esa conexión; de lo contrario, se usa la conexión
     * predeterminada que se obtiene mediante el método `findConectionDB` de `RepositoryDynamicsCrud`.
     *
     * @param mixed $connection Opcional. La conexión a la base de datos a utilizar. Si es null,
     *                          se usa la conexión predeterminada obtenida mediante `RepositoryDynamicsCrud::findConectionDB()`.
     * @return \Illuminate\Database\Eloquent\Builder Una instancia del constructor de consultas para la tabla `activos_fijos_equipos`.
     */
    public function getQueryBuild($connection = null);
}
