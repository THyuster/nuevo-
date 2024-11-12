<?php

namespace App\Utils\UserRolesValidations;

class UserRoleValidation
{
    protected $_connection;

    public function __construct($connection = "app")
    {
        $this->_connection = $connection;
    }

    public function isRoleUser($roleId, $userId)
    {
        return \DB::connection($this->_connection)->table("roles_permiso_view")
            // ->where("role_id", $roleId)
            ->where("user_id", $userId)
            ->exists();
    }

    public function isPermiseRole($roleId, $userId, $permisoCrudId)
    {
        return \DB::connection($this->_connection)->table("roles_permiso_view")
            // ->where("role_id", $roleId)
            ->where("user_id", $userId)
            ->where("permisos_crud_id", $permisoCrudId)
            ->exists();
    }

}