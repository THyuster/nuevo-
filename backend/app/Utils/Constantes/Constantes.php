<?php

namespace App\Utils\Constantes;

class Constantes
{

    //Constantes encriptación
    private const SECRET_KEY_ENCRYPT = "M1n4SL4Aur0rA**//";
    private const METHODENCRYPT = "aes-256-cbc";
    private const HASH = "sha512";
    private const SECRET_IV = "180503";
    //Constantes Base de datos
    const DB_TABLE_USER = "users";
    const DB_TABLE_ERP_GRUPO_EMPRESARIAL = "erp_grupo_empresarial";
    const DB_TABLE_ERP_RELACION_USER_CLIENTE = "erp_relacion_user_cliente";
    const DB_TABLE_ERP_RELACION_LICENCIAS = "erp_relacion_licencias";
    const DB_TABLE_ERP_RELACION_EMPRESAS = "erp_relacion_empresas";
    const DB_TABLE_CONTABILIDAD_EMPRESAS = "contabilidad_empresas";
    const DB_TABLE_ERP_LICENCIAMIENTOS = "erp_licenciamientos";
    const DB_TABLE_ERP_RELACION_USER_EMPRESAS = "erp_relacion_user_empresas";
    const DB_TABLE_CONTABILIDAD_TERCEROS = "contabilidad_terceros";

    public static function getHash()
    {
        return self::HASH;
    }

    public static function getSecretKeyEncrypt()
    {
        return self::SECRET_KEY_ENCRYPT;
    }

    public static function getSecretIV()
    {
        return self::SECRET_IV;
    }

    public static function getMethodEncrypt()
    {
        return self::METHODENCRYPT;
    }

}
