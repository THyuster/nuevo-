<?php
namespace App\Utils\Constantes\ModuloConfiguracion;

class DisenoSubmenus
{
    public function getSqlViewBySubMenuses($id)
    {
        return "SELECT * FROM erp_sub_menuses WHERE menu_id = '$id' ORDER BY erp_sub_menuses.orden, erp_sub_menuses.descripcion " ;
    }

    public function getSqlSubmenu($id)
    {
        return "SELECT * FROM erp_sub_menuses WHERE id = '$id'";
    }


    public function getSqlViewsMenuses($id)
    {
        return "SELECT * FROM erp_menuses WHERE id = '$id'";
    }

    public function updateStatusSubmenuses($status, $id)
    {
        return "UPDATE erp_sub_menuses SET estado = $status WHERE id = $id";
    }

    public function insertCreateSubmenuses($id, $descripcion, $orden)
    {
        return "INSERT INTO `erp_sub_menuses` (`menu_id`, `descripcion`,`orden`, `estado`) 
        VALUES ('$id', '$descripcion','$orden', 1)";
    }

    public function menuSqlSubmenusesExistente($idMenu, $descripcion)
    {
        return "SELECT * FROM `erp_sub_menuses` WHERE 
      `menu_id` = '$idMenu' AND `descripcion` = '$descripcion'";
    }

    public function insertSubmenu($idMenu, $descripcion, $orden)
    {
        return "INSERT INTO `erp_sub_menuses` (`menu_id`, `descripcion`,`orden`,`estado`) 
        VALUES ('$idMenu', '$descripcion','$orden', 1)";
    }

    public function updateGetSqlDataBefore($idMenu, $id)
    {
        return "SELECT * FROM erp_sub_menuses WHERE menu_id ='$idMenu' and id = '$id'";
    }

    public function updateSqlSubmenuses($descripcion, $orden, $idMenu, $id, $descripcionPrevios, $ordenPrevios)
    {
        return "UPDATE erp_sub_menuses SET descripcion = '$descripcion', orden ='$orden' WHERE menu_id = '$idMenu'
      and id = '$id' and descripcion = '$descripcionPrevios' and orden = '$ordenPrevios'";
    }

    function deleteSqlSubmenuses($id)
    {
        return "DELETE FROM erp_sub_menuses WHERE `id` = '$id'";
    }

}