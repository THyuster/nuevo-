<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Repository;

interface ISagrilaftEmpleadoRecursosRepository
{
    /**
     * Crea registros en la base de datos.
     *
     * @param array $datos Datos a insertar, donde cada elemento es un array asociativo
     *                     que representa un registro.
     * @param string|null $connection (opcional) Nombre de la conexión a la base de datos.
     *                                Si no se proporciona, se utiliza la conexión predeterminada.
     * @return bool Resultado de la operación de inserción (true si tiene éxito, false en caso contrario).
     * @throws \Exception Si ocurre un error durante la inserción de registros.
     */
    public function crearRegistros(array $datos, $connection = null);
}
