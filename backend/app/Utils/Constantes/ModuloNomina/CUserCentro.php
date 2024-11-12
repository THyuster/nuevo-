<?php

namespace App\Utils\Constantes\ModuloNomina;

class CUserCentro
{
    protected $date;

    function sqlFuncion($tabla): string
    {
        return "SELECT * FROM `$tabla`";
    }

    public function slqGetUserCentro()
    {

        return "
            SELECT users.id, users.name, ct.id userCentroId,nct.id idCentroTrabajo , nct.descripcion, ct.estado
            FROM nomina_user_centros ct 
            LEFT JOIN users on users.id = ct.user_id 
            LEFT JOIN nomina_centros_trabajos nct on nct.id = ct.centro_id;
        ";
    }
    public function sqlValidarUsuarioCentroTrabajo($id)
    {
        return "SELECT * FROM nomina_centros_trabajos WHERE id = $id";
    }
    public function sqlValidarUsuario($id)
    {
        return "SELECT * FROM nomina_user_centros WHERE id = $id";
    }
}
