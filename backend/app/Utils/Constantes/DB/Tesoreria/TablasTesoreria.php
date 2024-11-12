<?php

namespace App\Utils\Constantes\DB\Tesoreria;



class TablasTesoreria
{
    private const TABLA_CLIENTES_TESORERIA_CONCEPTOS = "tesoreria_conceptos";
    private const TABLA_CLIENTES_TESORERIA_GRUPO_CONCEPTOS = "tesoreria_grupo_conceptos";



    public static function getTablaClienteTesoreriaConcepto()
    {
        return self::TABLA_CLIENTES_TESORERIA_CONCEPTOS;
    }
    public static function getTablaClienteTesoreriaGrupoConcepto()
    {
        return self::TABLA_CLIENTES_TESORERIA_GRUPO_CONCEPTOS;
    }
    
}