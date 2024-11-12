<?php

namespace App\Utils\CryptoFirmas;

use App\Utils\Constantes\Constantes;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;

class FirmasDigitalesImages extends RepositoryDynamicsCrud
{
    private $iv = '1671229130189417';

    public function firmar($firma, $idUser)
    {
        $idUnique = uuid_create();
        $encryptionKey = Constantes::getSecretKeyEncrypt();
        $cipher_algo = Constantes::getMethodEncrypt();
        // $iv = Constantes::getSecretIV();
        $pngData = $firma;
        $encryptedPngData = openssl_encrypt($pngData, $cipher_algo, $encryptionKey, 0, $this->iv);
        $sql = "INSERT INTO signatures(`encrypted_signature`,`user_id`,`id_signatures`) values ('$encryptedPngData','$idUser','$idUnique')";
        $this->sqlFunction($sql);
        return $idUnique;
    }

    public function getFirma($id)
    {

        $encryptionKey = Constantes::getSecretKeyEncrypt();
        $cipher_algo = Constantes::getMethodEncrypt();
        // $iv = Constantes::getSecretIV();
        $sql = "SELECT encrypted_signature FROM signatures WHERE id = '$id'";
        $encryptedPngData = $this->sqlFunction($sql);

        if (empty($encryptedPngData)) {
            throw new Exception("No existe la firma", 1);
        } else {
            $encryptedPngData = $encryptedPngData[0]->firma;
        }

        $decryptedPngData = openssl_decrypt($encryptedPngData, $cipher_algo, $encryptionKey, 0, $this->iv);
        return file_put_contents('decrypted_signature.png', $decryptedPngData);
    }
}
