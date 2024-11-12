<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\TipoValidaciones;

interface ISagrilaftTipoValidacionRepository
{
    /**
     * Crea un nuevo tipo de validación en la base de datos.
     *
     * Este método toma un array de datos y crea una nueva instancia de
     * SagrilaftUrlTipoValidacion.
     *
     * @param array $datos Datos necesarios para crear el tipo de validación.
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error al crear el tipo de validación.
     * @return \Illuminate\Database\Eloquent\Model Instancia del modelo creado.
     */
    public function create(array $datos, $connection = null);

    /**
     * Verifica si un tipo de validación existe por su ID.
     *
     * Este método busca un tipo de validación en la base de datos utilizando su ID.
     *
     * @param mixed $id ID del tipo de validación a buscar.
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error al buscar el tipo de validación.
     * @return bool Verdadero si existe, falso en caso contrario.
     */
    public function existById($id, $connection = null);

    /**
     * Obtiene todos los tipos de validación.
     *
     * Este método recupera todas las instancias de SagrilaftUrlTipoValidacion
     * desde la base de datos.
     *
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error al buscar los tipos de validación.
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection Colección de tipos de validación.
     */
    public function getAll($connection = null);
}
