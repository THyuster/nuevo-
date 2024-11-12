<?php
namespace App\Utils\TransfersData\modulo_administradores\gestionRoles;

interface IGestionRoles
{
    public function crearRol($entidad_rol);
    public function actualizarRol($entidadRol, $id);
    public function activacionRol($id, $empresa);
    public function obtenerRol($empresa);
    public function eliminarRol($id, $empresa);
}