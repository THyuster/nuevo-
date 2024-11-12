<?php

namespace App\Utils\TransfersData\ModuloNomina\Postulaciones\Repository\Postulantes;

use App\Data\Dtos\Convocatorias\Postulantes\Responses\PostulanteResponseDTO;

interface IRepositoryPostulacion
{
    /**
     * Crea una nueva postulación en el sistema.
     *
     * Esta función recibe un array con los datos necesarios para crear una postulación
     * y realiza el proceso de creación. Opcionalmente, se puede proporcionar una conexión
     * a la base de datos específica para la operación. Retorna un valor booleano indicando
     * si la operación fue exitosa.
     *
     * @param array $postulacion Un array asociativo que contiene los datos de la postulación,
     *                           incluyendo todos los campos necesarios para completar la operación.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para la operación.
     *                          Si se omite, se utilizará la conexión predeterminada.
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $postulacion, $connection = null);
    /**
     * Verifica si un usuario está inscrito en una convocatoria específica.
     *
     * Esta función consulta si el usuario, identificado por su número de identificación,
     * ya está registrado en la convocatoria identificada por el ID proporcionado.
     * Opcionalmente, se puede especificar una conexión a la base de datos para la consulta.
     *
     * @param string $identificacion El número de identificación del usuario que se va a verificar.
     * @param string $nominaConvocatoriaId El identificador único de la convocatoria en la que se verifica la inscripción del usuario.
     * @param string|null $connection (Opcional) Una conexión a la base de datos para realizar la consulta. Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si el usuario está inscrito en la convocatoria, o `false` si no lo está o si ocurre un error durante la consulta.
     */
    public function userInConvocatoria(string $identificacion, string $nominaConvocatoriaId, $connection = null): bool;
    /**
     * Cierra una convocatoria específica.
     *
     * Esta función marca una convocatoria como cerrada utilizando el identificador proporcionado.
     * Opcionalmente, se puede especificar una conexión a la base de datos para realizar la operación.
     *
     * @param string $convocatoriaId El identificador único de la convocatoria que se desea cerrar.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la operación. 
     *                          Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si la convocatoria se cerró exitosamente, o `false` en caso contrario o si ocurre un error.
     */
    public function closedCall(string $convocatoriaId, $connection = null): bool;
    /**
     * Summary of createPostulacionFamiliares
     * @param array $datos
     * @param mixed $connection
     * @return bool
     */
    public function createPostulacionFamiliares(array $datos, $connection = null): bool;
    /**
     * Crea una nueva postulación para los familiares de un postulante.
     *
     * Este método procesa y guarda los datos proporcionados para crear una postulación
     * relacionada con los familiares del postulante. Opcionalmente, se puede especificar una
     * conexión a la base de datos para realizar la operación.
     *
     * @param array $datos Un array asociativo que contiene la información necesaria para la postulación
     *                     de los familiares, incluyendo todos los campos relevantes para completar
     *                     la operación.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la operación.
     *                          Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si la postulación se creó exitosamente, o `false` en caso contrario
     *              o si ocurre un error durante el proceso.
     */
    public function createPostulacionPersonales(array $datos, $connection = null): bool;
    /**
     * Crea una nueva postulación para postulantes complementarios.
     *
     * Este método procesa y guarda los datos proporcionados para crear una postulación
     * relacionada con los postulantes complementarios. Opcionalmente, se puede especificar
     * una conexión a la base de datos para realizar la operación.
     *
     * @param array $datos Un array asociativo que contiene la información necesaria para la
     *                     postulación de los postulantes complementarios, incluyendo todos los
     *                     campos relevantes para completar la operación.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la
     *                          operación. Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si la postulación se creó exitosamente, o `false` en caso
     *              contrario o si ocurre un error durante el proceso.
     */
    public function createPostulanteComplementarios(array $datos, $connection = null): bool;
    /**
     * Crea una nueva postulación para postulantes en el ámbito académico.
     *
     * Este método procesa y guarda los datos proporcionados para crear una postulación
     * relacionada con el ámbito académico del postulante. Opcionalmente, se puede especificar
     * una conexión a la base de datos para realizar la operación.
     *
     * @param array $datos Un array asociativo que contiene la información necesaria para la
     *                     postulación académica del postulante, incluyendo todos los campos
     *                     relevantes para completar la operación.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la
     *                          operación. Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si la postulación académica se creó exitosamente, o `false`
     *              en caso contrario o si ocurre un error durante el proceso.
     */
    public function createPostulanteAcademia(array $datos, $connection = null): bool;
    /**
     * Crea una nueva entrada de experiencia laboral para un postulante.
     *
     * Este método procesa y guarda los datos proporcionados para registrar una experiencia
     * laboral en el sistema para un postulante. Opcionalmente, se puede especificar una conexión
     * a la base de datos para realizar la operación.
     *
     * @param array $datos Un array asociativo que contiene la información necesaria para registrar
     *                     la experiencia laboral, incluyendo campos como el nombre de la empresa,
     *                     el cargo, la fecha de inicio y fin, entre otros.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la operación.
     *                          Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si la experiencia laboral se registró exitosamente, o `false`
     *              en caso contrario o si ocurre un error durante el proceso.
     */
    public function createExperienciaLaboral(array $datos, $connection = null): bool;
    /**
     * Crea una nueva postulación relacionada con el ámbito académico.
     *
     * Este método procesa y guarda los datos proporcionados para crear una postulación que
     * está asociada con el ámbito académico del postulante. Opcionalmente, se puede especificar
     * una conexión a la base de datos para realizar la operación.
     *
     * @param array $datos Un array asociativo que contiene la información necesaria para registrar
     *                     la postulación académica, incluyendo campos relevantes como el identificador
     *                     del postulante, el ID de la convocatoria académica, y detalles adicionales
     *                     específicos del contexto académico.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la operación.
     *                          Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si la postulación académica se creó exitosamente, o `false`
     *              en caso contrario o si ocurre un error durante el proceso.
     */
    public function createPostulacionRelacionAcademia(array $datos, $connection = null): bool;
    /**
     * Crea postulaciones relacionadas con postulantes complementarios.
     *
     * Este método procesa y guarda los datos proporcionados para registrar postulaciones
     * asociadas a postulantes complementarios. Opcionalmente, se puede especificar una conexión
     * a la base de datos para realizar la operación.
     *
     * @param array $datos Un array asociativo que contiene la información necesaria para crear
     *                     las postulaciones de los postulantes complementarios, incluyendo
     *                     campos relevantes como identificadores de los postulantes y detalles
     *                     específicos de cada postulación.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la operación.
     *                          Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si las postulaciones se crearon exitosamente, o `false`
     *              en caso contrario o si ocurre un error durante el proceso.
     */
    public function createPostulacionesRelacionComplementarios(array $datos, $connection = null): bool;
    /**
     * Crea una postulación para los familiares de un postulante.
     *
     * Este método procesa y guarda los datos proporcionados para registrar una postulación
     * relacionada con los familiares del postulante. Opcionalmente, se puede especificar una
     * conexión a la base de datos para realizar la operación.
     *
     * @param array $datos Un array asociativo que contiene la información necesaria para registrar
     *                     la postulación de los familiares, incluyendo campos como el identificador
     *                     del postulante, detalles de los familiares, y la información relevante
     *                     para completar la postulación.
     * @param mixed $connection (Opcional) Una conexión a la base de datos para realizar la operación.
     *                          Si se omite, se utilizará la conexión predeterminada.
     * @return bool Devuelve `true` si la postulación para los familiares se creó exitosamente, o
     *              `false` en caso contrario o si ocurre un error durante el proceso.
     */
    public function createPostulacionRelacionFamiliares(array $datos, $connection = null): bool;
    /**
     * Resumen de createPostulacionRelacionPersonales
     * @param array $datos Un arreglo que contiene los datos necesarios para crear una relación personal en la postulacion.
     * @param mixed $connection Una conexión a la base de datos. Si no se proporciona, se utilizará una conexión por defecto proporcionada por el método `findConectionDB` de `RepositoryDynamicsCrud`.
     * @return bool Devuelve verdadero si la operación se realiza con éxito, o falso en caso contrario.
     */
    public function createPostulacionRelacionPersonales(array $datos, $connection = null): bool;
    /**
     * Resumen de createPostulacionRelacionesExperienciaLaborales
     * @param array $datos Un arreglo que contiene los datos necesarios para crear las relaciones de experiencia laboral en la postulación.
     * @param mixed $connection Una conexión a la base de datos. Si no se proporciona, se utilizará una conexión por defecto proporcionada por el método `findConectionDB` de `RepositoryDynamicsCrud`.
     * @return bool Devuelve verdadero si la operación se realiza con éxito, o falso en caso contrario.
     */
    public function createPostulacionRelacionesExperienciaLaborales(array $datos, $connection = null): bool;

    /**
     * Resumen de createConvocatoriaRelacionPostulante
     * @param array $datos Un arreglo que contiene la información necesaria para crear una relación entre una convocatoria y un postulante.
     * @param mixed $connection Una conexión a la base de datos. Si no se proporciona, se utilizará una conexión por defecto proporcionada por el método `findConectionDB` de `RepositoryDynamicsCrud`.
     * @return bool Devuelve verdadero si la operación se realiza con éxito, o falso en caso contrario.
     */
    public function createConvocatoriaRelacionPostulante(array $datos, $connection = null): bool;

    /**
     * Resumen de statuChangePostulante
     * @param string $convocatoriaRelacionPostulanteId El identificador de la relación entre la convocatoria y el postulante cuyo estado se desea cambiar.
     * @param bool $estado El nuevo estado que se asignará a la relación (verdadero para activo, falso para inactivo).
     * @param mixed $connection Una conexión a la base de datos. Si no se proporciona, se utilizará una conexión por defecto proporcionada por el método `findConectionDB` de `RepositoryDynamicsCrud`.
     * @return bool Devuelve verdadero si el cambio de estado se realiza con éxito, o falso en caso contrario.
     */
    public function statuChangePostulante(string $convocatoriaRelacionPostulanteId, bool $estado, $connection = null): bool;

    /**
     * Resumen de getConvocatoriaRelacionPostulanteById
     * @param string $convocatoriaRelacionPostulanteId El identificador de la relación entre la convocatoria y el postulante que se desea recuperar.
     * @param mixed $connection Una conexión a la base de datos. Si no se proporciona, se utilizará una conexión por defecto proporcionada por el método `findConectionDB` de `RepositoryDynamicsCrud`.
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null Devuelve el modelo de la relación entre convocatoria y postulante correspondiente al identificador proporcionado, o `null` si no se encuentra. Puede devolver una instancia de `Builder`, una colección de modelos, o el modelo específico.
     */
    public function getConvocatoriaRelacionPostulanteById(string $convocatoriaRelacionPostulanteId, $connection = null);
    /**
     * Recupera un registro de postulante por su ID.
     *
     * Este método obtiene un registro de postulante de la base de datos usando la conexión 
     * especificada. Si no se proporciona una conexión, se usa la conexión predeterminada 
     * obtenida del método `RepositoryDynamicsCrud::findConectionDB()`. Luego, envuelve el 
     * resultado en un objeto `PostulanteResponseDTO` y lo devuelve.
     *
     * @param string $postulanteId El identificador único del postulante a recuperar.
     * @param mixed $connection Opcional. La conexión a la base de datos a utilizar. Si no se proporciona, se usa la conexión predeterminada.
     * 
     * @return \App\Data\Dtos\Convocatorias\Postulantes\Responses\PostulanteResponseDTO Un Objeto de Transferencia de Datos (DTO) que contiene los datos del postulante.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra un postulante con el ID proporcionado.
     * @throws \Exception Si hay un problema con la conexión a la base de datos u otros errores imprevistos.
     */
    public function getPostulante(string $postulanteId, $connection = null): PostulanteResponseDTO;
    /**
     * Resumen de insertPostulanteInBlacklist
     * @param array $data Un arreglo que contiene los datos necesarios para insertar un postulante en la lista negra.
     * @param mixed $connection Una conexión a la base de datos. Si no se proporciona, se utilizará una conexión por defecto proporcionada por el método `findConectionDB` de `RepositoryDynamicsCrud`.
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model Devuelve el modelo de la lista negra creado con los datos proporcionados.
     */
    // public function insertPostulanteInBlacklist(array $data, $connection = null);
    /**
     * Obtiene los postulantes paginados por ID de convocatoria.
     *
     * @param string $idConvocatoria
     * @param bool $estadoPostulante estado de los postulantes a filtrar (Por defecto se buscan solo los que no han tenido una respuesta en su proceso)
     * @param int $perPage Número de elementos por página
     * @param mixed $connection
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPostulantesByIdConvocatoriaPaginate(string $idConvocatoria, $estadoPostulante = null, int $perPage = 15, $connection = null);
    /**
     * Resumen de getPostulanteByID
     * @param string $idPostulante El identificador del postulante que se desea recuperar.
     * @param mixed $connection Una conexión a la base de datos. Si no se proporciona, se utilizará una conexión por defecto proporcionada por el método `findConectionDB` de `RepositoryDynamicsCrud`.
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection Devuelve una colección de resultados que incluyen el postulante especificado y sus relaciones cargadas, como academia, experiencia laboral, familiares y personales.
     */
    public function getPostulanteByID(string $idPostulante, $connection = null);
}
