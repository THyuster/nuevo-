<?php

namespace App\Utils\Constantes\ModuloConfiguracion;

class DisenoVistas
{
    public function getSqlViewByViews($id)
    {
        return "SELECT * FROM erp_vistas WHERE submenu_id = '$id'";
    }

    public function getSqlViewsSubmenus($id)
    {
        return "SELECT * FROM erp_sub_menuses WHERE id = '$id'";
    }

    public function getSqlVistas($id){
        return "SELECT * FROM erp_vistas WHERE id = $id";
    }

    public function updateSqlVistasEstado($status,$id){
        return "UPDATE erp_vistas SET estado = $status WHERE id = $id";
    }

    public function insertSqlVista($idSubmenu,$descripcion,$ruta,$orden) {
        return "INSERT INTO erp_vistas (`submenu_id`, `descripcion`,`orden`, `ruta`,`estado`) 
        VALUES ('$idSubmenu', '$descripcion','$orden','$ruta', 1)";
    }

    public function getMenuExistente($idSubmenu,$descripcion,$ruta){
        return "SELECT * FROM erp_vistas WHERE  
        `submenu_id` = '$idSubmenu' AND `descripcion` = '$descripcion' AND ruta = '$ruta'";
    }

    public function getSqlBeforeData($idSubmenu,$id) {
        return "SELECT * FROM erp_vistas WHERE submenu_id ='$idSubmenu' and id = '$id'";
    }

    public function updateSqlVista($descripcion,$ruta,$orden,$idSubmenu,$id,$descripcionPrevios,$rutaPrevios,$ordenPrevios) {
        return "UPDATE erp_vistas 
        SET descripcion = '$descripcion', ruta = '$ruta', orden = '$orden' 
        WHERE submenu_id = '$idSubmenu' AND id = '$id' and descripcion = '$descripcionPrevios' AND ruta = '$rutaPrevios'
        AND orden = '$ordenPrevios'
        ";
    }

    function deleteSqlVista($id) {
        return "DELETE FROM erp_vistas WHERE `id` = '$id'";
    }
}
