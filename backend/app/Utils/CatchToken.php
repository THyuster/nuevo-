<?php

namespace App\Utils;

use App\Utils\Encryption\EncryptionFunction;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

// use Tymon\JWTAuth\Facades\JWTAuth;

class CatchToken
{

    public static function Claims()
    {

        try {
            $claims_token = JWTAuth::parseToken()->getPayload();
            $empresaId = $claims_token->get("id_empresa");

            if ($empresaId) {
                return EncryptionFunction::StaticDesencriptacion($empresaId);
            }

            return null;
            // if ($empresaId) {
            //     return EncryptionFunction::StaticDesencriptacion($empresaId);
            // }
            // throw new Exception("Empresa no seleccionada");
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        }

    }

}