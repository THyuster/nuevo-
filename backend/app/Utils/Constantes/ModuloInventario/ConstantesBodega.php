<?php
namespace App\Utils\Constantes\ModuloInventario;

final class ConstantesBodega {
    protected $date;

    public function __construct() {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo) {
        return "SELECT * FROM  inventarios_bodegas WHERE codigo = '$codigo'";
    }

    public function sqlSelectAll() {
        return "
        SELECT inventarios_bodegas.id idBodega, inventarios_bodegas.codigo codigo, inventarios_bodegas.descripcion ,
        contabilidad_sucursales.id sucursal_id,
        contabilidad_sucursales.descripcion sucursal_descripcion, inventarios_bodegas.estado estado FROM inventarios_bodegas JOIN contabilidad_sucursales on inventarios_bodegas.sucursal_id = contabilidad_sucursales.id WHERE contabilidad_sucursales.id = inventarios_bodegas.sucursal_id;
        ";
        //return "SELECT inventarios_bodegas.id, inventarios_bodegas.codigo, 
        //inventarios_bodegas.descripcion,contabilidad_sucursales.descripcion AS sucursal , inventarios_bodegas.estado, 
        //inventarios_bodegas.sucursal_id
        //FROM inventarios_bodegas, contabilidad_sucursales WHERE contabilidad_sucursales.id = inventarios_bodegas.sucursal_id;";
    }

    public function sqlSelectById($id) {
        return "SELECT codigo, descripcion, estado FROM  inventarios_bodegas WHERE id = '$id'";
    }
    public function sqlInsert($sucursal_id, $codigo, $descripcion) {
        // $time = date("Y-m-d H:i:s");
        return "INSERT INTO  inventarios_bodegas 
        (`created_at`, `updated_at`, `sucursal_id`, `codigo`, `descripcion`, `estado`) 
        VALUES ('$this->date', '$this->date',
         '$sucursal_id', '$codigo', '$descripcion', 1)";
    }

    public function sqlUpdate($id, $sucursal_id, $codigo, $descripcion) {
        return "UPDATE  inventarios_bodegas 
        SET `updated_at`='$this->date',`sucursal_id`='$sucursal_id'
        ,`codigo`='$codigo', `descripcion`='$descripcion' WHERE `id` = '$id'";
    }

    public function sqlUpdateEstado($id, $estado) {
        return "UPDATE  inventarios_bodegas 
        SET `updated_at`='$this->date',`estado`='$estado'
        WHERE `id` = '$id'";
    }

    public function sqlDelete($id) {
        return "DELETE FROM  inventarios_bodegas WHERE `id` = '$id'";
    }

    public function sqlSucursalesAll() {
        return "SELECT * FROM `contabilidad_sucursales`";
    }

    public function sqlSucursalesByid($id) {
        return "SELECT * FROM `contabilidad_sucursales` WHERE id ='$id'";
    }
}