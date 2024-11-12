<?php

namespace App\Utils\TransfersData\moduloContabilidad\Repositories\TiposIdentificaciones;
use App\Models\modulo_contabilidad\contabilidad_tipos_identificaciones as tipoIdentificacion;
use App\Utils\Repository\RepositoryDynamicsCrud;

class TipoIdentificacionRepository implements ITipoIdentificacionRepository
{

    public function tipoIdentificacionExistePorId($id, $connection = null)
    {
        // Determina si se debe usar una conexión específica o la predeterminada
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        // Realiza la consulta y retorna el resultado
        return tipoIdentificacion::on($connection)->where('id', $id)->exists();
    }
}
