<?php

namespace App\Utils\TransfersData\Erp\Roles\Interfaces;

interface IRolesPermisos
{
    public function getServicesPermisosRoles(string $id): array;
    public function createServicesRoles(string $id, array $roles);

}
