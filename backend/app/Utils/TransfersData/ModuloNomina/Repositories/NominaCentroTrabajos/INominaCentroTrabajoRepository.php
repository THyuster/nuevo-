<?php

namespace App\Utils\TransfersData\ModuloNomina\Repositories\NominaCentroTrabajos;

interface INominaCentroTrabajoRepository
{
    /**
     * Verifica si un registro existe en la base de datos por su ID en la tabla `nomina_centros_trabajo`.
     *
     * Este método consulta la base de datos para determinar si existe un registro con el ID proporcionado
     * en la tabla `nomina_centros_trabajo`. Utiliza una conexión de base de datos específica si se proporciona,
     * o una conexión predeterminada si no se proporciona ninguna.
     *
     * @param int $id El ID del registro que se desea verificar. Debe ser un entero que representa el ID
     *                en la base de datos.
     * @param mixed $connection (opcional) La conexión a la base de datos a utilizar. Puede ser una instancia
     *                          de conexión o `null` para usar la conexión predeterminada proporcionada
     *                          por `RepositoryDynamicsCrud::findConectionDB()`.
     * @return bool Devuelve `true` si el registro con el ID especificado existe en la base de datos,
     *              `false` en caso contrario.
     */
    public function existById($id, $connection = null);
}
