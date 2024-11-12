<?php

namespace App\Utils\TransfersData\moduloContabilidad\Repositories\TiposIdentificaciones;

interface ITipoIdentificacionRepository
{
    /**
     * Verifica si el tipo identificación existe en la base de datos por su ID.
     *
     * Este método consulta la base de datos para determinar si existe un registro en la tabla `contabilidad_tipos_identificaciones` 
     * con el identificador proporcionado. Utiliza la conexión a la base de datos proporcionada o, si no se proporciona, 
     * utiliza una conexión predeterminada.
     *
     * @param mixed $id El identificador que se busca en la base de datos. Puede ser de cualquier tipo que sea
     *                  válido para la columna `id` en la tabla `contabilidad_tipos_identificaciones`.
     * @param mixed $connection (Opcional) La conexión a la base de datos que se debe usar para la consulta. Si no se proporciona,
     *                          se utilizará una conexión predeterminada obtenida a través de `RepositoryDynamicsCrud::findConectionDB()`.
     * 
     * @return bool Retorna `true` si se encuentra un registro con el identificador proporcionado; de lo contrario, retorna `false`.
     */
    public function tipoIdentificacionExistePorId($id, $connection = null);
}
