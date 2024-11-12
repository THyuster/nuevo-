<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories;

interface IRepositoryUrl
{
    /**
     * Crea una nueva instancia de SagrilaftUrl.
     *
     * @param array $datos Datos necesarios para crear la URL.
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @return \App\Data\Dtos\Sagrilaft\Validacion\Url\Response\SagrilaftUrl Instancia de SagrilaftUrl creada.
     * @throws \Exception Si ocurre un error al crear la URL.
     */
    public function create(array $datos, $connection = null);
    public function update($id, array $datos);
    /**
     * Obtiene una URL por su ID.
     *
     * Este método busca una instancia de SagrilaftUrls en la base de datos
     * utilizando el ID proporcionado y devuelve una nueva instancia de SagrilaftUrl.
     *
     * @param mixed $id ID de la URL a buscar.
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error al buscar la URL.
     * @return \App\Data\Dtos\Sagrilaft\Validacion\Url\Response\SagrilaftUrl Instancia de la URL solicitada.
     */
    public function getById($id, $connection = null);
    /**
     * Elimina un registro por su ID.
     *
     * @param mixed $id El ID del registro a eliminar.
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error durante la eliminación.
     * @return bool Retorna verdadero si la eliminación fue exitosa, falso en caso contrario.
     */
    public function deleteById($id, $connection = null);
    /**
     * Verifica si un registro existe en la base de datos a partir de su ID.
     *
     * Este método utiliza Eloquent para consultar la tabla de SagrilaftUrls y determinar
     * si hay un registro con el ID proporcionado. Si ocurre un error durante la
     * consulta, se lanzará una excepción con un mensaje descriptivo.
     *
     * @param int $id El ID del registro a verificar.
     * @param string|null $connection La conexión a la base de datos a utilizar.
     *                                Si no se proporciona, se utiliza la conexión por defecto.
     * 
     * @return bool Devuelve true si el registro existe, de lo contrario false.
     *
     * @throws \Exception Si ocurre un error durante la consulta.
     */
    public function existById($id, $connection = null);
}

