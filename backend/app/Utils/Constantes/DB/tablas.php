<?php

namespace App\Utils\Constantes\DB;

use App\Utils\Constantes\DB\Mantenimiento\TablasMantenimiento;

class tablas extends TablasMantenimiento
{
    private const DT_APP_ERP = "mla_erp_data";
    private const TABLA_APP_USER = "users";
    private const TABLA_APP_PRIORIDADES = "prioridades";
    private const TABLA_APP_ESTADOS = "estados";
    private const TABLA_APP_TIPOS_SOLICITUDES = "tipos_solicitud";

    private const TABLA_CLIENTES_ACTIVOS_FIJOS_EQUIPOS = "activos_fijos_equipos";
    private const TABLA_CLIENTES_LOGISTICA_VEHICULOS = "logistica_vehiculos";
    private const TABLA_CLIENTES_NOMINA_CENTROS_TRABAJOS = "nomina_centros_trabajos";

    private const TABLA_CLIENTES_LOGISTICA_COMBUSTIBLES = "logistica_combustibles";

    private const TABLA_APP_CONEXIONES_ODBC = "conexiones_odbc";


    public static function getTablaAppUser()
    {
        return self::TABLA_APP_USER;
    }

    public static function getTablaAppTiposSolicitudes()
    {
        return self::TABLA_APP_TIPOS_SOLICITUDES;
    }
    public static function getDatabaseAppErp()
    {
        return self::DT_APP_ERP;
    }

    public static function getTablaAppEstados()
    {
        return self::TABLA_APP_ESTADOS;
    }
    public static function getTablaAppPrioridades()
    {
        return self::TABLA_APP_PRIORIDADES;
    }

    public static function getTablaClienteActivosFijosEquipos()
    {
        return self::TABLA_CLIENTES_ACTIVOS_FIJOS_EQUIPOS;
    }

    public static function getTablaClienteLogisticaVehiculos()
    {
        return self::TABLA_CLIENTES_LOGISTICA_VEHICULOS;
    }

    public static function getTablaClienteNominaCentrosTrabajos()
    {
        return self::TABLA_CLIENTES_NOMINA_CENTROS_TRABAJOS;
    }



    public static function getTablaClienteLogisticaCombustibles()
    {
        return self::TABLA_CLIENTES_LOGISTICA_COMBUSTIBLES;
    }
    public static function getTablaAppConexionesOdbc()
    {
        return self::TABLA_APP_CONEXIONES_ODBC;
    }
}
