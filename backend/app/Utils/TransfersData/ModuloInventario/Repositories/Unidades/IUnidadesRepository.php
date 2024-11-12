<?php

namespace App\Utils\TransfersData\ModuloInventario\Repositories\Unidades;

interface IUnidadesRepository
{
    /**
     * Verifica si un registro existe en la tabla `inventarios_unidades` por su ID.
     *
     * Este método determina si existe un registro con el ID especificado en la tabla `inventarios_unidades`.
     * Utiliza la conexión a la base de datos proporcionada si se especifica, o una conexión predeterminada
     * si no se proporciona ninguna.
     *
     * @param int $id El ID del registro que se desea verificar. Debe ser un entero que representa el ID
     *                en la base de datos.
     * @param mixed $connection (opcional) La conexión a la base de datos a utilizar. Puede ser una instancia
     *                          de conexión o `null`. Si es `null`, se usará la conexión predeterminada
     *                          proporcionada por `RepositoryDynamicsCrud::findConectionDB()`.
     * @return bool Devuelve `true` si el registro con el ID especificado existe en la tabla `inventarios_unidades`,
     *              `false` en caso contrario.
     */
    public function existById($id, $connection = null);
}
