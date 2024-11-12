<?php

namespace App\Utils\TransfersData\Erp\Roles\Services;

use App\Utils\TransfersData\Erp\Roles\Interfaces\InterfaceAsignacionRoles;

class ServicesAsignacionRoles implements InterfaceAsignacionRoles
{

    /**
     *
     * @param int $id
     * @param array $asignacion
     */
    public function actualizarAsignacionRoleUsuario(int $id, array $asignacion)
    {
    }

    /**
     *
     * @param array $asignacion
     */
    public function asignarRoleUsuario(array $asignacion)
    {
    }

    /**
     *
     * @param int $id_vista
     * @param int $user_id
     * @param int $permiso_id
     * @return bool
     */
    public function consultarPermiso(int $id_vista, int $user_id, int $permiso_id): bool
    {

        

        return true;
    }

    /**
     *
     * @param int $id_asignacion
     */
    public function quitarAsignacion(int $id_asignacion)
    {
    }
}
