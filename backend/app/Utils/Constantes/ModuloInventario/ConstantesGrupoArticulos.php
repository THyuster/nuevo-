<?php
namespace App\Utils\Constantes\ModuloInventario;

final class ConstantesGrupoArticulos{
    protected $date;
    public function __construct() {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo)
    {
        return "SELECT * FROM inventarios_grupo_articulos WHERE codigo = '$codigo'";
    }
    public function sqlSelectAll(){
        return "SELECT id, codigo, descripcion FROM inventarios_grupo_articulos";
    }

    public function sqlSelectById($id){
        return "SELECT codigo, descripcion FROM inventarios_grupo_articulos WHERE id = '$id'";
    }
    public function sqlInsert($codigo, $descripcion){
        return "INSERT INTO inventarios_grupo_articulos
        (`created_at`, `updated_at`,`codigo`, `descripcion`) 
        VALUES ('$this->date', '$this->date', '$codigo', '$descripcion')";
    }

    public function sqlUpdate($id,$codigo, $descripcion){
        return "UPDATE inventarios_grupo_articulos
        SET `updated_at`='$this->date',`codigo`='$codigo', `descripcion`='$descripcion' WHERE `id` = '$id'";
    }
    
    public function sqlDelete($id){
        return "DELETE FROM inventarios_grupo_articulos WHERE `id` = '$id'";
    }

}