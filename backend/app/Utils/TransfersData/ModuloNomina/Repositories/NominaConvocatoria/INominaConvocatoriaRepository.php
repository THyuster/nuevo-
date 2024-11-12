<?php

namespace App\Utils\TransfersData\ModuloNomina\Repositories\NominaConvocatoria;

interface INominaConvocatoriaRepository
{
    /**
     * Recupera todos los registros de ConvocatoriaView de la base de datos.
     *
     * Este método obtiene todos los registros del modelo ConvocatoriaView desde la conexión de base de datos especificada.
     * Si no se proporciona una conexión, se utiliza una conexión predeterminada obtenida de la clase RepositoryDynamicsCrud.
     *
     * @param mixed $conecction La conexión a la base de datos a utilizar. Si es null, se obtiene una conexión por defecto.
     * @return \App\Models\NominaModels\nomina_cargos[] Un array de objetos ConvocatoriaView.
     */
    public function all($conecction = null);
    /**
     * Elimina un registro por su ID del modelo NominaConvocatorias.
     *
     * Este método intenta encontrar y eliminar un registro de la base de datos
     * usando el ID proporcionado. Si no se especifica una conexión, se usa por defecto
     * la conexión devuelta por RepositoryDynamicsCrud::findConectionDB().
     *
     * @param mixed $id El ID del registro que se desea eliminar. Puede ser un entero o una cadena.
     * @param mixed $connection (opcional) La conexión a la base de datos que se utilizará. Si no se proporciona, se usa una conexión por defecto.
     * @return bool Devuelve verdadero si el registro fue eliminado con éxito, falso en caso contrario.
     */
    public function delete($id, $connection = null);
    /**
     * Verifica si existe un registro con el ID de convocatoria proporcionado.
     *
     * Este método verifica si existe un registro con el ID de convocatoria especificado
     * en el modelo NominaConvocatorias. Si no se especifica una conexión, se usa por defecto
     * la conexión devuelta por RepositoryDynamicsCrud::findConectionDB().
     *
     * @param mixed $idConvocatoria El ID de la convocatoria que se desea verificar. Puede ser un entero o una cadena.
     * @param mixed $connection (opcional) La conexión a la base de datos que se utilizará. Si no se proporciona, se usa una conexión por defecto.
     * @return bool Devuelve verdadero si existe un registro con el ID especificado, falso en caso contrario.
     */
    public function existByIdConvocatoria($idConvocatoria, $connection = null);
    /**
     * Verifica si hay una convocatoria aprobada asociada con un ID de solicitud de empleo.
     *
     * Este método consulta la base de datos para determinar si existe una convocatoria aprobada
     * que esté vinculada al ID de solicitud de empleo proporcionado. Si no se especifica una conexión,
     * se utiliza la conexión por defecto obtenida mediante `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param mixed $idSolicitudEmpleo El ID de la solicitud de empleo. Puede ser un entero o una cadena
     *                                  que identifica la solicitud de empleo en la base de datos.
     * @param mixed $connection (opcional) La conexión a la base de datos a utilizar. Si no se proporciona,
     *                          se usa una conexión por defecto obtenida mediante `RepositoryDynamicsCrud::findConectionDB()`.
     * @return bool Devuelve verdadero si existe una convocatoria aprobada para el ID de solicitud de empleo
     *              especificado, o falso en caso contrario.
     */
    public function convocatoriaAprobadaBySolicitudEmpleoId($idSolicitudEmpleo, $connection = null);

}
