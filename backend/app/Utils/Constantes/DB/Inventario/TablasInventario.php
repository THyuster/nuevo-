<?php

namespace App\Utils\Constantes\DB\Inventario;

use App\Utils\Constantes\DB\ProduccionMinera\TablasProduccionMinera;

class TablasInventario extends TablasProduccionMinera
{
    private const TABLA_CLIENTES_BODEGA = "inventarios_bodegas";
    private const TABLA_CLIENTES_COLOR = "inventarios_color";
    private const TABLA_CLIENTES_INVENTARIO = "inventarios_departamento";
    private const TABLA_CLIENTES_LINEA = "inventarios_linea";
    private const TABLA_CLIENTES_MARCAS = "inventarios_marcas";
    private const TABLA_CLIENTES_UNIDADES = "inventarios_unidades";
    private const TABLA_CLIENTES_TIPOS_ARTICULOS = "inventarios_tipos_articulos";
    private const TABLA_CLIENTES_TIPOS_HOMOLOGACIONES = "mantenimiento_homologaciones";
    private const TABLA_CLIENTES_GRUPOS_ARTICULOS = "inventarios_grupo_articulos";
    private const TABLA_CLIENTES_GRUPOS_CONTABLES = "inventarios_grupos_contables";
    private const TABLA_CLIENTES_GRUPOS_TALLAS = "inventarios_talla";
    private const TABLA_ERP_INVENTARIO_CODIGO_BIEN_SERVICIO = "inventario_codigo_bien_servicio";
    private const TABLA_ERP_INVENTARIO_CODIGO_UNIDADES = "inventario_codigos_unidades";
    private const TABLA_CLIENTE_INVENTARIO_ARTICULOS = "inventarios_articulos2";

    public static function getTablaClienteInventarioDepartamento()
    {
        return self::TABLA_CLIENTES_INVENTARIO;
    }

    public static function getTablaClienteInventarioLinea()
    {
        return self::TABLA_CLIENTES_LINEA;
    }
    public static function getTablaClienteInventarioBodega()
    {
        return self::TABLA_CLIENTES_BODEGA;
    }
    public static function getTablaClienteInventarioMarcas()
    {
        return self::TABLA_CLIENTES_MARCAS;
    }
    public static function getTablaClienteInventarioColor()
    {
        return self::TABLA_CLIENTES_COLOR;
    }

    public static function getTablaClienteInventarioUnidades()
    {
        return self::TABLA_CLIENTES_UNIDADES;
    }
    public static function getTablaClienteInventarioTiposArticulos()
    {
        return self::TABLA_CLIENTES_TIPOS_ARTICULOS;
    }
    public static function getTablaClienteInventarioHomologaciones()
    {
        return self::TABLA_CLIENTES_TIPOS_HOMOLOGACIONES;
    }
    public static function getTablaClienteInventarioGrupoArticulos()
    {
        return self::TABLA_CLIENTES_GRUPOS_ARTICULOS;
    }
    public static function getTablaClienteInventarioGrupoContables()
    {
        return self::TABLA_CLIENTES_GRUPOS_CONTABLES;
    }
    public static function getTablaClienteInventarioTalla()
    {
        return self::TABLA_CLIENTES_GRUPOS_TALLAS;
    }
    public static function getTablaErpInventarioCodigoBienServicio()
    {
        return self::TABLA_ERP_INVENTARIO_CODIGO_BIEN_SERVICIO;
    }
    public static function getTablaErpInventarioCodigoUnidades()
    {
        return self::TABLA_ERP_INVENTARIO_CODIGO_UNIDADES;
    }
    public static function getTablaErpInventarioArticulos()
    {
        return self::TABLA_CLIENTE_INVENTARIO_ARTICULOS;
    }
}
