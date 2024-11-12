<?php

namespace App\Utils\TransfersData\ModuloActivosFijos\Repositories\GruposEquipos;

interface IGruposEquiposRepository
{
    /**
     * Obtiene un registro de la tabla activos_fijos_grupos_equipos basado en la descripción.
     *
     * Este método consulta la tabla `activos_fijos_grupos_equipos` para encontrar un registro
     * donde la columna `descripcion` coincida con la descripción proporcionada.
     *
     * @param string $descripcion La descripción que se busca en la columna `descripcion`.
     * @param mixed $connection Opcional. La conexión a la base de datos a utilizar. Si es null, se usa la conexión predeterminada.
     * @return \Illuminate\Database\Eloquent\Model|null El registro encontrado, o null si no se encuentra ningún registro.
     */
    public function getGrupoEquipoByDescripcion(string $descripcion, $connection = null);
    /**
     * Encuentra un registro en la tabla `gruposEquipos` por su ID.
     *
     * Este método busca un registro en la tabla `gruposEquipos` utilizando el ID proporcionado.
     * Si se proporciona una conexión a la base de datos, se utiliza esa conexión; de lo contrario,
     * se utiliza la conexión predeterminada que se obtiene mediante el método `findConectionDB` de 
     * `RepositoryDynamicsCrud`.
     *
     * @param mixed $id El ID del registro que se busca. Puede ser de cualquier tipo que sea compatible
     *                   con el tipo de clave primaria de la tabla.
     * @param mixed $connection Opcional. La conexión a la base de datos a utilizar. Si es null,
     *                          se usa la conexión predeterminada obtenida mediante `RepositoryDynamicsCrud::findConectionDB()`.
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     *         El registro encontrado, una colección de registros (si se usa un ID que podría coincidir con varios registros),
     *         o null si no se encuentra ningún registro.
     */
    public function findById($id, $connection = null);
    /**
     * Verifica si un registro con el 'codigo' especificado existe en la base de datos.
     *
     * Este método consulta la tabla 'gruposEquipos' para determinar si existe un registro con 
     * el 'codigo' dado. Si se proporciona una conexión de base de datos específica, utiliza 
     * esa conexión; de lo contrario, utiliza la conexión predeterminada obtenida 
     * mediante el método `findConectionDB` de la clase `RepositoryDynamicsCrud`.
     *
     * @param mixed $codigo El valor del 'codigo' para comprobar su existencia en la base de datos.
     *                      Puede ser de cualquier tipo que la columna 'codigo' en la base de datos pueda almacenar.
     * @param mixed $connection (opcional) La conexión de base de datos a utilizar para la consulta. 
     *                          Si no se proporciona, se utiliza la conexión predeterminada obtenida 
     *                          mediante `RepositoryDynamicsCrud::findConectionDB()`.
     *                          Este parámetro puede ser un nombre de conexión o una instancia de conexión.
     *                          Si es null, el método utilizará la conexión predeterminada.
     * 
     * @return bool Devuelve verdadero si existe un registro con el 'codigo' especificado en la base de datos; 
     *              de lo contrario, devuelve falso.
     */
    public function verificarCodigoExistente($codigo, $connection = null);
    /**
     * Crea un nuevo registro en la base de datos con los datos proporcionados.
     *
     * Este método utiliza el modelo 'gruposEquipos' para insertar un nuevo registro en la base de datos. 
     * Si no se proporciona una conexión de base de datos específica, se utiliza la conexión predeterminada 
     * obtenida mediante el método `findConectionDB` de la clase `RepositoryDynamicsCrud`.
     *
     * @param array $data Un array asociativo con los datos que se van a insertar en la base de datos. 
     *                    Las claves del array deben coincidir con los nombres de las columnas de la tabla.
     * 
     * @return \Illuminate\Database\Eloquent\Model El nuevo registro creado en la base de datos. 
     *         El método devuelve una instancia del modelo 'gruposEquipos' con los datos insertados.
     */
    public function create(array $data);
    /**
     * Verifica si existe un registro en la tabla `activos_fijos_grupos_equipos` con el código especificado
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
     * Actualiza un registro existente en la base de datos con los datos proporcionados.
     *
     * Este método busca un registro en la tabla 'gruposEquipos' usando el identificador proporcionado 
     * y actualiza los campos con los nuevos valores especificados en el array de datos. 
     * Si no se proporciona una conexión de base de datos específica, se utiliza la conexión predeterminada 
     * obtenida mediante el método `findConectionDB` de la clase `RepositoryDynamicsCrud`.
     *
     * @param mixed $id El identificador del registro que se va a actualizar. 
     *                  Puede ser un valor de tipo entero o cadena, según el tipo de columna del identificador.
     * @param array $data Un array asociativo con los datos que se van a actualizar en el registro.
     *                    Las claves del array deben coincidir con los nombres de las columnas de la tabla.
     * 
     * @return bool Devuelve verdadero si la actualización se realizó con éxito; 
     *              de lo contrario, devuelve falso. 
     *              En caso de error, puede devolver `false` o `0` dependiendo del comportamiento del método `update`.
     */
    public function update($id, array $data);
    /**
     * Elimina un registro de la base de datos con el identificador especificado.
     *
     * Este método busca un registro en la tabla 'gruposEquipos' utilizando el identificador proporcionado 
     * y elimina ese registro de la base de datos. Si no se proporciona una conexión de base de datos específica, 
     * se utiliza la conexión predeterminada obtenida mediante el método `findConectionDB` de la clase 
     * `RepositoryDynamicsCrud`.
     *
     * @param mixed $id El identificador del registro que se va a eliminar. 
     *                  Puede ser un valor de tipo entero o cadena, según el tipo de columna del identificador.
     * 
     * @return bool Devuelve verdadero si el registro se eliminó con éxito; 
     *              de lo contrario, devuelve falso. En caso de que el registro no se encuentre, 
     *              o haya algún problema durante la eliminación, también se devolverá `false`.
     */
    public function delete($id);
    /**
     * Obtiene una colección de registros de la tabla `activos_fijos_grupo_equipos` donde los valores de las columnas especificadas
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
     *         Retorna una colección de instancias del modelo `activos_fijos_grupo_equipos` que coinciden con la búsqueda.
     *         La colección puede estar vacía si no se encuentran registros que coincidan.
     *
     * @throws \Illuminate\Database\QueryException Si la consulta a la base de datos falla.
     */
    public function findGrupoEquipoByLikeQuery(array $campos, $valor, $connection = null);
    /**
     * Obtiene todos los registros de la tabla 'gruposEquipos'.
     *
     * Este método consulta la tabla 'gruposEquipos' en la base de datos y devuelve todos los registros 
     * existentes. Si no se proporciona una conexión de base de datos específica, se utiliza la conexión 
     * predeterminada obtenida mediante el método `findConectionDB` de la clase `RepositoryDynamicsCrud`.
     *
     * @param mixed $connection Opcional. El nombre de la conexión a la base de datos a utilizar.
     *                           Si no se proporciona, se recupera la conexión por defecto del método
     *                           `RepositoryDynamicsCrud::findConectionDB()`. Este parámetro puede ser
     *                           una cadena o null.
     * @return \Illuminate\Database\Eloquent\Collection Una colección de modelos 'gruposEquipos' que contiene todos los registros de la tabla. 
     *         Si la tabla está vacía, se devuelve una colección vacía.
     */
    public function fetchAllRecords($connection = null);
}
