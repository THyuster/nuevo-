<?php

namespace App\Utils\Connection;


class endpointsconnection
{
    private const POST_OBTENER_DATOS_API  = "/get/informacion";
    private const POST_EJECUTAR_ACCIONES_API  = "/execute/instruccion";
    
    public static function GET_POST_OBTENER_DATOS_API()
    {
        return self::buildApiUrl(self::POST_OBTENER_DATOS_API);
    }
    
    public static function GET_POST_EJECUTAR_ACCIONES_API()
    {
        return self::buildApiUrl(self::POST_EJECUTAR_ACCIONES_API);
    }
    
    private static function buildApiUrl($endpoint)
    {
        return env('API_ODBC_URL') . $endpoint;
    }
    
}
