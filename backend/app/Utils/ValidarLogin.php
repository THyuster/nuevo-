<?php
namespace App\Utils;

use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class ValidarLogin extends RepositoryDynamicsCrud
{
    public static function registrarSesion($id_user, $token)
    {
        DB::table("user_login")->insert([
            "user_id" => $id_user,
            "token" => $token,
            "conectado" => 1
        ]);
    }

    public static function verificarSesion($user_id)
    {
        $verificacion = DB::table("user_login")->select('conectado')->where('user_id', $user_id)->get();

        if (sizeof($verificacion) == 0) {
            return "NS";
        }

        return $verificacion[0]->conectado;
    }

    public static function verificarToken($token, $user_id)
    {
        // echo $user_id
        $token_usuario = DB::table("user_login")->select('token')->where('user_id', $user_id)->get();
        ValidarLogin::validarTiempoSesion($token);
        return $token == $token_usuario[0]->token;
    }

    public static function actualizarSesion($user_id, $token, $conectado)
    {
        $row = DB::table('user_login')->where('user_id', $user_id)->update(['token' => "$token", 'conectado' => "$conectado"]);
        return $row > 0;
    }

    public static function eliminarSesion($user_id)
    {
        $deleted = DB::table('user_login')->where('user_id', $user_id)->delete();
        return $deleted > 0;
    }

    private static function validarTiempoSesion($token)
    {
        try {

            $user = JWTAuth::toUser($token);
            $tokenExpiration = JWTAuth::getPayload($token)['exp'];

            $currentTimestamp = time();
            if ($tokenExpiration > $currentTimestamp) {

            } else {
                return new Response("Token Expirado", 401);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return new Response("Token Expirado", 401);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return new Response("Token no valido", 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return new Response("Error al verificar", 401);
        }

    }
}