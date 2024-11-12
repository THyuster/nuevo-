<?php

namespace App\Utils\TransfersData\Sagrilaft\Empleados\Repository;
use App\Models\Sagrilaft\SagrilaftColores as Colores;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
class SagrilaftColores implements ISagrilaftColores
{
    public function create(array $datos, $connection = null)
    {
        try {
            $connection ??= RepositoryDynamicsCrud::findConectionDB();
            return Colores::on($connection)->create($datos);
        } catch (\Throwable $th) {
            throw new Exception("Error la registrar el color en la tabla sagrilaft colores {$th->getMessage()}", 500);
        }

    }

    public function getById($id, $connection = null)
    {
        try {
            $connection ??= RepositoryDynamicsCrud::findConectionDB();
            return Colores::on($connection)->find($id);
        } catch (\Throwable $th) {
            throw new Exception("Error la registrar el color en la tabla sagrilaft colores {$th->getMessage()}", 500);
        }
    }

    public function getAll($connection = null)
    {
        try {
            $connection ??= RepositoryDynamicsCrud::findConectionDB();
            return Colores::on($connection)->get();
        } catch (\Throwable $th) {
            throw new Exception("Error la registrar el color en la tabla sagrilaft colores {$th->getMessage()}", 500);
        }
    }

}