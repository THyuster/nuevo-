<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Combustible\Repository;

interface ICombustibleRepository
{
    /**
     * Verifica si un registro existe en la base de datos por su ID.
     *
     * Este método verifica si un registro con el ID proporcionado existe en la base de datos
     * utilizando una conexión específica o la conexión predeterminada si no se proporciona ninguna.
     *
     * @param int $id El ID del registro a buscar. Debe ser un entero que represente el ID en la base de datos.
     * @param mixed $connection (opcional) La conexión a la base de datos a utilizar. Si no se proporciona,
     *                          se usará la conexión predeterminada proporcionada por 
     *                          `RepositoryDynamicsCrud::findConectionDB()`.
     * @return bool Devuelve `true` si el registro existe, `false` en caso contrario.
     */
    public function existById($id, $connection = null);

}
