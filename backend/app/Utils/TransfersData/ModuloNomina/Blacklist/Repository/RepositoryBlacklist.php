<?php

namespace App\Utils\TransfersData\ModuloNomina\Blacklist\Repository;

use App\Models\NominaModels\Blacklist\NominaBlacklist;
use App\Utils\Repository\RepositoryDynamicsCrud;

class RepositoryBlacklist implements IRepositoryBlacklist
{
    public function userInBlacklistByIdentificacion(string $identificacion, $connection = null): bool
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        return NominaBlacklist::on($connection)->where('identificacion', $identificacion)->exists();
    }

    public function create(array $data, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        return NominaBlacklist::on($connection)->create($data);
    }

    public function update($id, array $data, $connection = null)
    {
        // return 
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        // Encuentra el registro por ID
        $registro = NominaBlacklist::on($connection)->find($id);

        // Verifica si el registro fue encontrado antes de intentar actualizarlo
        if ($registro) {
            return $registro->update($data);
        }

        // Retorna falso si el registro no fue encontrado
        return false;
    }

    public function findById($id, $connection = null)
    {
        // Utiliza una conexión predeterminada si no se proporciona una conexión específica
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        // Encuentra y retorna el registro por ID
        return NominaBlacklist::on($connection)->find($id);
    }


    public function isUserInBlacklistWithDifferentId($id, string $identificacion, $connection = null): bool
    {
        // Utiliza una conexión predeterminada si no se proporciona una conexión específica
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        // Verifica si existe un registro en la lista negra con la identificación dada y un ID diferente
        return NominaBlacklist::on($connection)
            ->where('identificacion', $identificacion)
            ->where('id', '<>', $id)
            ->exists();
    }

    public function delete($id, $connection = null)
    {
        // Utiliza una conexión predeterminada si no se proporciona una conexión específica
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        // Encuentra el registro por ID
        $registro = NominaBlacklist::on($connection)->find($id);

        // Verifica si el registro fue encontrado antes de intentar eliminarlo
        if ($registro) {
            return $registro->delete();
        }

        // Retorna falso si el registro no fue encontrado
        return false;
    }
}
