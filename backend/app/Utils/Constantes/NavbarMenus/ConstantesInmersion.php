<?php
namespace App\Utils\Constantes\NavbarMenus;

class ConstantesInmersion
{
    public function RutaMenu($id)
    {
        return "SELECT erp_modulos.descripcion AS modulo_nombre, 
        erp_menuses.descripcion as menu_nombre
        FROM erp_modulos  , erp_menuses, erp_sub_menuses, erp_vistas 
        WHERE erp_menuses.modulo_id = erp_modulos.id 
        AND erp_modulos.id = '$id' limit 1 ";
    }

    public function RutaSubmenus($id)
    {
        return "SELECT erp_modulos.descripcion 
        AS modulo_nombre, erp_menuses.descripcion AS menu_nombre
        FROM erp_sub_menuses , erp_modulos , erp_menuses, erp_vistas 
        WHERE erp_menuses.modulo_id = erp_modulos.id AND erp_menuses.id = '$id' limit 1";
    }
    public function RutaVista($id)
    {
        return "SELECT erp_modulos.descripcion 
        AS modulo_nombre, erp_menuses.descripcion 
        AS menu_nombre, erp_sub_menuses.descripcion AS nombre_submenu 
        FROM erp_sub_menuses , erp_modulos , erp_menuses, erp_vistas 
        WHERE erp_sub_menuses.menu_id = erp_menuses.id 
        AND erp_menuses.modulo_id = erp_modulos.id AND erp_sub_menuses.id = '$id' limit 1;
        ";
    }
}