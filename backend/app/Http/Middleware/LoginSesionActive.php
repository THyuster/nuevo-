<?php

namespace App\Http\Middleware;

use App\Utils\ValidarLogin;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginSesionActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  ...$exceptMethods
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$exceptMethods)
    {
        // Obtener el token del header de autorización
        $token = $request->bearerToken();

        // Verificar si hay un usuario autenticado
        $user = auth()->user();

        // Obtener el nombre del método actual
        $currentMethod = $request->route()->getActionMethod();
        // return new JsonResponse([$exceptMethods], Response::HTTP_UNAUTHORIZED);

        // Verificar si el método actual está en la lista de excepciones
        if (in_array($currentMethod, $exceptMethods)) {
            return $next($request);
        }

        // Verificar el token y la validez de la sesión
        if ($token && $user && ValidarLogin::verificarToken($token, $user->id)) {
            return $next($request);
        }

        // Si no se cumple la validación, devolver una respuesta de no autorizado
        return new JsonResponse(["message" => "Unauthorized"], Response::HTTP_UNAUTHORIZED);
    }
}
