<?php

namespace App\Utils\Constantes\DB\Configuracion;

use App\Utils\Constantes\DB\Inventario\TablasInventario;

class TablasConfiguracion extends TablasInventario
{
    private const TABLA_CLIENTE_LOG_IMPORTACIONES = "log_importaciones";
    private const TABLA_ERP_VARIABLES_GLOBALES = "configuracion_variables_globales";
    private const TABLA_CLIENTE_RESPUESTA_VARIABLES_GLOBALES = "respuesta_variables_glb";
    private const TABLA_ERP_MODULOS = "erp_modulos";
    private const TABLA_ERP_PERMISOS_MODULOS = "erp_permisos_modulos";
    private const TABLA_CONTABILIDAD_EMPRESAS = "contabilidad_empresas";

    private const TABLA_ASIGNACION_ROLES = "erp_roles_asignado_usuario";
    private const TABLA_ROL = "erp_roles";
    private const TABLA_ROL_PERMISOS = "roles_permiso";
    private const TABLA_CONEXION_DATABASE_EMPRESA = "conexiones_database_empresas";
    private const TABLA_CONTROL_MIGRACIONES = "control_migraciones";
    private const TABLA_ERP_MIGRACIONES = "erp_migraciones";

    public static function getTablaClienteLogImportaciones()
    {
        return self::TABLA_CLIENTE_LOG_IMPORTACIONES;
    }

    public static function getTablaErpVariablesGlobales()
    {
        return self::TABLA_ERP_VARIABLES_GLOBALES;
    }
    public static function getTablaErpModulo()
    {
        return self::TABLA_ERP_MODULOS;
    }
    public static function getTablaContabilidadEmpresas()
    {
        return self::TABLA_CONTABILIDAD_EMPRESAS;
    }

    public static function getTablaClienteRespuestaVariablesGlobales()
    {
        return self::TABLA_CLIENTE_RESPUESTA_VARIABLES_GLOBALES;
    }
    public static function getTablaErpRol()
    {
        return self::TABLA_ROL;
    }
    public static function getTablaErpAsignacionRoles()
    {
        return self::TABLA_ASIGNACION_ROLES;
    }
    public static function getTablaErpPermisosModulos()
    {
        return self::TABLA_ERP_PERMISOS_MODULOS;
    }
    public static function getTablaErpRolesPermisos()
    {
        return self::TABLA_ROL_PERMISOS;
    }
    public static function getTablaConexionEmpresa()
    {
        return self::TABLA_CONEXION_DATABASE_EMPRESA;
    }
    public static function getTablaControlMigraciones()
    {
        return self::TABLA_CONTROL_MIGRACIONES;
    }
    public static function getTablErpMigraciones()
    {
        return self::TABLA_ERP_MIGRACIONES;
    }
}
