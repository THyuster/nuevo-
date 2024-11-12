<?php
namespace App\Utils\Constantes\ModuloInventario;

final class ConstantesMarcas{
    protected $date;

    public function __construct() {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo)
    {
        return "SELECT * FROM inventarios_marcas WHERE codigo = '$codigo'";
    }
    public function sqlSelectAll(){
        return "SELECT id, codigo, descripcion FROM inventarios_marcas";
    }

    public function sqlSelectById($id){
        return "SELECT id, codigo, descripcion FROM inventarios_marcas WHERE id = '$id'";
    }
    public function sqlInsert($codigo, $descripcion){
        return "INSERT INTO inventarios_marcas 
        (`created_at`, `updated_at`,`codigo`, `descripcion`) 
        VALUES ('$this->date', '$this->date', '$codigo', '$descripcion')";
    }

    public function sqlUpdate($id,$codigo, $descripcion){
        return "UPDATE inventarios_marcas 
        SET `updated_at`='$this->date',`codigo`='$codigo', `descripcion`='$descripcion' WHERE `id` = '$id'";
    }
    
    public function sqlDelete($id){
        return "DELETE FROM inventarios_marcas WHERE `id` = '$id'";
    }

}