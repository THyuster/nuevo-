<?php
namespace App\Utils\Encryption;

use App\Utils\Constantes\Constantes;

class EncryptionFunction extends Constantes
{
    public function Encriptacion($string){
        $output = FALSE;
        $key = hash(Constantes::getHash(), Constantes::getSecretKeyEncrypt());
        $iv = substr(hash(Constantes::getHash(), Constantes::getSecretIV()), 0, 16);
        $output = openssl_encrypt($string, Constantes::getMethodEncrypt(), $key, OPENSSL_RAW_DATA, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public static function StaticEncriptacion($string){
        $output = FALSE;
        $key = hash(Constantes::getHash(), Constantes::getSecretKeyEncrypt());
        $iv = substr(hash(Constantes::getHash(), Constantes::getSecretIV()), 0, 16);
        $output = openssl_encrypt($string, Constantes::getMethodEncrypt(), $key, OPENSSL_RAW_DATA, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public function Desencriptacion($string)
    {
        $key = hash(Constantes::getHash(), Constantes::getSecretKeyEncrypt());
        $iv = substr(hash(Constantes::getHash(), Constantes::getSecretIV()), 0, 16);
        $output = openssl_decrypt(base64_decode($string), Constantes::getMethodEncrypt(), $key, OPENSSL_RAW_DATA, $iv);
        return $output;
    }
    public static function StaticDesencriptacion($string)
    {
        $key = hash(Constantes::getHash(), Constantes::getSecretKeyEncrypt());
        $iv = substr(hash(Constantes::getHash(), Constantes::getSecretIV()), 0, 16);
        $output = openssl_decrypt(base64_decode($string), Constantes::getMethodEncrypt(), $key, OPENSSL_RAW_DATA, $iv);
        return $output;
    }

}