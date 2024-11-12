<?php

namespace App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\Repository;

interface IMarcasRepository
{
    /**
     * Verifica si un registro con el ID proporcionado existe en la base de datos.
     *
     * Esta función comprueba la existencia de un registro en la tabla `logistica_marcas`
     * usando el ID proporcionado. Si se especifica una conexión de base de datos, se utiliza esa conexión;
     * de lo contrario, se usa la conexión predeterminada obtenida a través de `RepositoryDynamicsCrud::findConectionDB()`.
     *
     * @param mixed $id El ID del registro que se busca.
     * @param string|null $connection La conexión de base de datos a utilizar. Si es `null`, se usa la conexión predeterminada.
     * @return bool `true` si el registro existe, `false` en caso contrario.
     */
    public function existById($id, $connection = null);

}
