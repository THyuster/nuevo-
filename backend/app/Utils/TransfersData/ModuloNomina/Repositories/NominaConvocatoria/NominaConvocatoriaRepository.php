<?php

namespace App\Utils\TransfersData\ModuloNomina\Repositories\NominaConvocatoria;
use App\Models\NominaModels\Convocatorias\ConvocatoriaView;
use App\Models\NominaModels\nomina_cargos;
use App\Models\NominaModels\NominaConvocatorias;
use App\Utils\Repository\RepositoryDynamicsCrud;

class NominaConvocatoriaRepository implements INominaConvocatoriaRepository
{

    public function all($connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        return nomina_cargos::on($connection)->with(['convocatorias'])->get()->all();
    }
    public function delete($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        return NominaConvocatorias::on($connection)->find($id)->delete();
    }
    public function existByIdConvocatoria($idConvocatoria, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        return NominaConvocatorias::on($connection)
            ->where('nomina_convocatoria_id', $idConvocatoria)->exists();
    }
    
    public function convocatoriaAprobadaBySolicitudEmpleoId($idSolicitudEmpleo, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();
        return NominaConvocatorias::on($connection)
            ->where('nomina_solicitudes_empleo_id', $idSolicitudEmpleo)->where('activa', true)->exists();
    }
}
