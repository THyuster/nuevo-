<?php

namespace App\Utils\TransfersData\ModuloSuperAdmin;
use App\Data\Models\UsuarioModel;

interface ISuAdminService
{
    public function crearAdmin(UsuarioModel $SuperAdmin);
    // public function actualizarSuAdmin(int $id,UsuarioModel $SuperAdmin);
    // public function cambiarEstadoSuAdmin(int $id);
    public function eliminarSuAdmin($id);
    // public function getSuAdmin();
}