<?php
namespace App\Utils\Constantes\ModuloInventario;

final class ConstantesUnidades{
    protected $date;

    public function __construct() {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo)
    {
        return "SELECT * FROM `inventarios_unidades` WHERE codigo = '$codigo'";
    }
    public function sqlSelectAll(){
        return "SELECT id, codigo, descripcion FROM `inventarios_unidades`";
    }

    public function sqlSelectById($id){
        return "SELECT id, codigo, descripcion FROM `inventarios_unidades` WHERE id = '$id'";
    }
    public function sqlInsert($codigo, $descripcion){
        return "INSERT INTO `inventarios_unidades` 
        (`created_at`, `updated_at`,`codigo`, `descripcion`) 
        VALUES ('$this->date', '$this->date', '$codigo', '$descripcion')";
    }

    public function sqlUpdate($id,$codigo, $descripcion){
        return "UPDATE `inventarios_unidades` 
        SET `updated_at`='$this->date',`codigo`='$codigo', `descripcion`='$descripcion' WHERE `id` = '$id'";
    }
    
    public function sqlDelete($id){
        return "DELETE FROM `inventarios_unidades` WHERE `id` = '$id'";
    }

}