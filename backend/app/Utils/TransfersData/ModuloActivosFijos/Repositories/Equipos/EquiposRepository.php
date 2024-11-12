<?php

namespace App\Utils\TransfersData\ModuloActivosFijos\Repositories\Equipos;
use App\Models\modulo_activos_fijos\activos_fijos_equipos;
use App\Models\modulo_activos_fijos\activos_fijos_vista_erp;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Query\Builder;

class EquiposRepository implements IEquiposRepository
{
    public function create(array $datos, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return activos_fijos_equipos::on($connection)->create($datos);
    }

    public function existByCodigo(string $codigo, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();

        return activos_fijos_equipos::on($connection)
            ->where('codigo', $codigo)
            ->exists();
    }

    public function findById($id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return activos_fijos_equipos::on($connection)->find($id);
    }

    public function checkCodigoUniquenessIgnoringId(string $codigo, int $id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();

        return activos_fijos_equipos::on($connection)
            ->where('codigo', $codigo)
            ->where('id', '<>', $id)
            ->exists();
    }

    public function update(string $id, array $data, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();

        return activos_fijos_equipos::on($connection)
            ->find($id)
            ->update($data);
    }

    public function delete(string $id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return activos_fijos_equipos::on($connection)
            ->find($id)
            ->delete();
    }

    public function findEquiposFijosByLikeQuery(array $campos, $valor, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        $activosFijosEquipo = activos_fijos_equipos::on($connection);
        $activosFijosEquipo->where(function (Builder $q) use ($valor, $campos) {
            foreach ($campos as $column) {
                $q->orWhere($column, 'like', "%$valor%");
            }
        });
        return $activosFijosEquipo->get();
    }

    public function getQueryBuild($connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return activos_fijos_vista_erp::on($connection);
    }

}
