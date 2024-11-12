<?php

namespace App\Utils\TransfersData\ModuloActivosFijos\Repositories\GruposEquipos;
use App\Models\modulo_activos_fijos\activos_fijos_grupos_equipos as gruposEquipos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Database\Eloquent\Builder;

class GruposEquiposRepository implements IGruposEquiposRepository
{

    public function getGrupoEquipoByDescripcion(string $descripcion, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return gruposEquipos::on($connection)->where('descripcion', $descripcion)->first();
    }

    public function findById($id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return gruposEquipos::on($connection)->find($id);
    }
    public function verificarCodigoExistente($codigo, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return gruposEquipos::on($connection)->where('codigo', $codigo)->exists();
    }

    public function create(array $data)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return gruposEquipos::on($connection)->create($data);
    }

    public function checkCodigoUniquenessIgnoringId(string $codigo, int $id, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();

        return gruposEquipos::on($connection)
            ->where('codigo', $codigo)
            ->where('id', '<>', $id)
            ->exists();
    }

    public function update($id, array $data)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return gruposEquipos::on($connection)->find($id)->update($data);
    }

    public function delete($id)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return gruposEquipos::on($connection)->find($id)->delete();
    }

    public function findGrupoEquipoByLikeQuery(array $campos, $valor, $connection = null)
    {
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        $grupoEquipo = gruposEquipos::on($connection);
        $grupoEquipo->where(function (Builder $q) use ($valor, $campos) {
            foreach ($campos as $column) {
                $q->orWhere($column, 'like', "%$valor%");
            }
        });
        return $grupoEquipo->get();
    }

    public function fetchAllRecords($connection = null){
        $connection = $connection ?? RepositoryDynamicsCrud::findConectionDB();
        return gruposEquipos::on($connection)->get();
    }
}
