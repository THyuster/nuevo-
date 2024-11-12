<?php

namespace App\Utils\Constantes\ModulosSuAdmin;

use App\Utils\Constantes\Constantes;

class CSuAdmin
{
    private const DBTABLE_TIPO_ADMINISTRADOR = "tipo_administrador";
    private const DBTABLE_KEYS = "`key_su_administrador`";
    private const DBTABLE_USER = "users";

    protected string $DATE;

    public function __construct()
    {
        $this->DATE = date("Y-m-d H:i:s");
    }

    public function updateSuAdmin(int $id): string
    {
        return "UPDATE " . self::DBTABLE_USER . " 
                SET `updated_at` = '$this->DATE',  
                `tipo_administrador` = '2'
                WHERE `id` = '$id'";
    }

    public function updateTipoUser(int $id, int $tipo_administrador): string
    {
        return "UPDATE " . self::DBTABLE_USER . " 
                SET `updated_at` = '$this->DATE',  
                `tipo_administrador` = '$tipo_administrador'
                WHERE `id` = '$id'";
    }

    public function crearSuAdmin($name, $email, $password): string
    {
        return "INSERT INTO `users` (`name`,`email`,`password`,`created_at`, `updated_at`,`tipo_administrador`,`estado`)
        values ('$name','$email','$password','$this->DATE','$this->DATE','2','ACTIVO')";
    }

    public function getUserEmail($email): string
    {
        return "SELECT id FROM `users` WHERE`email` = '$email' ";
    }

    public function activarModuloSu($idUser): string
    {
        return "INSERT INTO `erp_permisos_modulos` 
        (`id`, `created_at`, `updated_at`, `user_id`, `modulo`, `estado`, `modulo_id`, `empresa_id`) 
        VALUES (NULL, '$this->DATE', '$this->DATE', '$idUser', 'Super Admin', 'ACTIVO', '101', NULL)";
    }

    public function eliminarUserSu($userId)
    {
        return "DELETE FROM `users` WHERE `id` = '$userId' AND `tipo_administrador` = '2'";
    }

    public function eliminarPermisos($userId)
    {
        return "DELETE FROM `erp_permisos_modulos` WHERE `user_id` = '$userId' AND modulo_id = '101'";
    }

    public function createClaves(int $userId): string
    {
        $key = password_hash(Constantes::getSecretKeyEncrypt(), PASSWORD_DEFAULT);

        return "INSERT INTO " . self::DBTABLE_KEYS . " (`id_super_admin`, `id_user`, `key_su_admin`) 
                VALUES (UUID(), $userId, '$key')";
    }

    public function setAdminEstado(int $estado, int $id): string
    {
        return "UPDATE " . self::DBTABLE_USER . " 
                SET `estado` = '$estado' 
                WHERE `id` = '$id'";
    }

    public function getRelationUserId(int $user_id)
    {
        return "SELECT * FROM " . self::DBTABLE_KEYS . "
        WHERE `id_user` = '$user_id'";
    }

    public function getUserId(int $user_id)
    {
        return "SELECT * FROM " . self::DBTABLE_USER . " WHERE `id` = '$user_id'";
    }

    public function getEstadoAdministrador(int $id)
    {
        return "SELECT * FROM " . self::DBTABLE_USER . "
        WHERE `id` = '$id' AND  `tipo_administrador` = '2' ";
    }

    public function eliminarKey(int $userId): string
    {
        return "DELETE FROM " . self::DBTABLE_KEYS . " 
                WHERE `id_user` = '$userId'";
    }

}