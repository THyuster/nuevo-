<?php

namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\RelacionUrlTipoValidacionRelacion;

interface ISagrilaftUrlTipoValidacionRelacionRepository
{
    /**
     * Crea una nueva relación de tipo de validación en la base de datos.
     *
     * Este método toma un array de datos y crea una nueva instancia de
     * SagrilaftUrlTipoValidacionRelacion.
     *
     * @param array $datos Datos necesarios para crear la relación de tipo de validación.
     * @param mixed|null $connection Conexión a la base de datos (opcional).
     * @throws \Exception Si ocurre un error al crear la relación de tipo de validación.
     * @return \Illuminate\Database\Eloquent\Model Instancia del modelo creado.
     */
    public function create(array $datos, $connection = null);
}