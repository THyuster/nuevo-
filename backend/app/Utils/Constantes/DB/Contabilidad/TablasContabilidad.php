<?php

namespace App\Utils\Constantes\DB\Contabilidad;

use App\Utils\Constantes\DB\Logistica\TablasLogistica;

class TablasContabilidad extends TablasLogistica
{
    private const TABLA_CLIENTES_CONTABILIDAD_TERCEROS = "contabilidad_terceros";
    private const TABLA_CLIENTES_CONTABILIDAD_BANCOS = "contabilidad_bancos";

    public static function getTablaClienteContabilidadTerceros()
    {
        return self::TABLA_CLIENTES_CONTABILIDAD_TERCEROS;
    }
    public static function getTablaClienteContabilidadBancos()
    {
        return self::TABLA_CLIENTES_CONTABILIDAD_BANCOS;
    }
}