<?php

namespace App\Utils\Constantes\DB\ActivosFijosEquipos;

use App\Utils\Constantes\DB\Configuracion\TablasConfiguracion;

class TablasActivosFijosEquipos extends TablasConfiguracion
{
    private const TABLA_CLIENTES_ACTIVOS_FIJOS_EQUIPOS = "activos_fijos_equipos";
    private const TABLA_CLIENTES_ACTIVOS_FIJOS_GRUPOS_EQUIPOS = "activos_fijos_grupos_equipos";

    public static function getTablaClienteActivoFijosEquipo()
    {
        return self::TABLA_CLIENTES_ACTIVOS_FIJOS_EQUIPOS;
    }
    public static function getTablaClienteActivoFijosGrupoEquipo()
    {
        return self::TABLA_CLIENTES_ACTIVOS_FIJOS_GRUPOS_EQUIPOS;
    }
}
