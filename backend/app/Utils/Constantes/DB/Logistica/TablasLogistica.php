<?php

namespace App\Utils\Constantes\DB\Logistica;

use App\Utils\Constantes\DB\ActivosFijosEquipos\TablasActivosFijosEquipos;

class TablasLogistica extends TablasActivosFijosEquipos
{

    private const TABLA_CLIENTES_LOGISTICA_VEHICULOS = "logistica_vehiculos";

    public static function getTablaClientelogisticaVehiculo()
    {
        return self::TABLA_CLIENTES_LOGISTICA_VEHICULOS;
    }
}
