<?php

namespace App\Utils\TransfersData\ModuloNomina\Blacklist\Repository;

interface IRepositoryBlacklist
{
    /**
     * Verifica si un usuario está en la lista negra por su identificación.
     *
     * @param string $identificacion La identificación del usuario.
     * @param mixed $connection La conexión a la base de datos (opcional).
     * @return bool Retorna verdadero si el usuario está en la lista negra, de lo contrario falso.
     */
    public function userInBlacklistByIdentificacion(string $identificacion, $connection = null): bool;
    /**
     * Crea un nuevo registro en la tabla NominaBlacklist.
     *
     * @param array $data Datos para el nuevo registro.
     * @param mixed $connection Conexión a la base de datos (opcional).
     * @return \Illuminate\Database\Eloquent\Model El modelo del registro creado.
     */
    public function create(array $data, $connection = null);
    /**
     * Actualiza un registro existente en la tabla NominaBlacklist.
     *
     * @param mixed $id El ID del registro a actualizar.
     * @param array $data Datos a actualizar en el registro.
     * @param mixed $connection Conexión a la base de datos (opcional).
     * @return bool Retorna verdadero si la actualización fue exitosa, falso de lo contrario.
     */
    public function update($id, array $data, $connection = null);
    /**
     * Encuentra un registro por su ID en la tabla NominaBlacklist.
     *
     * @param mixed $id El ID del registro a encontrar.
     * @param mixed $connection Conexión a la base de datos (opcional).
     * @return \Illuminate\Database\Eloquent\Model|null El modelo del registro encontrado o null si no se encuentra.
     */
    public function findById($id, $connection = null);
    /**
     * Verifica si hay un registro en la lista negra con una identificación específica y un ID diferente al proporcionado.
     *
     * @param mixed $id El ID que debe ser excluido de la búsqueda.
     * @param string $identificacion La identificación a buscar en la lista negra.
     * @param mixed $connection Conexión a la base de datos (opcional).
     * @return bool Retorna verdadero si existe un registro que cumple con los criterios, de lo contrario falso.
     */
    public function isUserInBlacklistWithDifferentId($id, string $identificacion, $connection = null): bool;
    /**
     * Elimina un registro de la tabla NominaBlacklist por su ID.
     *
     * @param mixed $id El ID del registro a eliminar.
     * @param mixed $connection Conexión a la base de datos (opcional).
     * @return bool Retorna verdadero si el registro fue eliminado con éxito, falso si no se encontró el registro.
     */
    public function delete($id, $connection = null);

}
