<?php
namespace App\Utils\Constantes\ModuloActivosFijos;

final class ConstantesActivosFijosGruposEquipos
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo)
    {
        return "SELECT * FROM activos_fijos_grupos_equipos WHERE codigo = '$codigo'";
    }
    public function sqlSelectAll()
    {
        return "SELECT id, codigo, descripcion FROM activos_fijos_grupos_equipos";
    }

    public function sqlSelectById($id)
    {
        return "SELECT id, codigo, descripcion FROM activos_fijos_grupos_equipos WHERE id = '$id'";
    }
    public function sqlInsert($codigo, $descripcion)
    {
        return "INSERT INTO activos_fijos_grupos_equipos 
        (`created_at`, `updated_at`,`codigo`, `descripcion`) 
        VALUES ('$this->date', '$this->date', '$codigo', '$descripcion')";
    }

    public function sqlUpdate($id, $codigo, $descripcion)
    {
        return "UPDATE activos_fijos_grupos_equipos 
        SET `updated_at`='$this->date',`codigo`='$codigo', `descripcion`='$descripcion' WHERE `id` = '$id'";
    }

    public function sqlDelete($id)
    {
        return "DELETE FROM activos_fijos_grupos_equipos WHERE `id` = '$id'";
    }

}