<?php

namespace App\Utils\TransfersData\Erp\Roles\Interfaces;

interface InterfaceAsignacionRoles
{
    public function asignarRoleUsuario(array $asignacion);
    public function quitarAsignacion(int $id_asignacion);
    public function consultarPermiso(int $id_vista, int $user_id, int $permiso_id): bool;
    public function actualizarAsignacionRoleUsuario(int $id, array $asignacion);
    
}
