<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories;

interface IRepositoryUrlRelacion
{
    /**
     * Crea múltiples registros en la base de datos.
     *
     * Este método toma un array de datos, agrega las marcas de tiempo de creación
     * y actualización, y luego inserta los registros en la base de datos.
     *
     * @param array $datos Datos de los registros a crear.
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @return bool Devuelve true si la inserción fue exitosa, de lo contrario false.
     * @throws \Exception Si ocurre un error durante la inserción.
     */
    public function insertarRegistros(array $datos, $connection = null);
    /**
     * Elimina registros por el ID de URL.
     *
     * @param mixed $id El ID de URL cuyos registros se desean eliminar.
     * @param mixed|null $connection La conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error durante la eliminación.
     * @return int Retorna el número de registros eliminados.
     */
    public function eliminarRegistrosByUrlId($id, $connection = null);
}

