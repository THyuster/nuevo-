<?php
namespace App\Utils\Constantes\ModuloLogistica;

final class ConstantesLogisticaGruposVehiculos
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo)
    {
        return "SELECT * FROM logistica_grupos_vehiculos WHERE codigo = '$codigo'";
    }
    public function sqlSelectAll()
    {
        return "SELECT id, descripcion, codigo FROM logistica_grupos_vehiculos";
    }

    public function sqlSelectById($id)
    {
        return "SELECT id, codigo, descripcion FROM logistica_grupos_vehiculos WHERE id = '$id'";
    }
    public function sqlInsert($codigo, $descripcion)
    {
        return "INSERT INTO logistica_grupos_vehiculos 
        (`created_at`, `updated_at`,`codigo`, `descripcion`) 
        VALUES ('$this->date', '$this->date', '$codigo', '$descripcion')";
    }

    public function sqlUpdate($id, $codigo, $descripcion)
    {
        return "UPDATE logistica_grupos_vehiculos 
        SET `updated_at`='$this->date',`codigo`='$codigo', `descripcion`='$descripcion' WHERE `id` = '$id'";
    }

    public function sqlDelete($id)
    {
        return "DELETE FROM logistica_grupos_vehiculos WHERE `id` = '$id'";
    }



}