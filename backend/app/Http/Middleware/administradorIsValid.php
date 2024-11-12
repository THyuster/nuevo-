<?php

namespace App\Http\Middleware;

use App\Utils\AuthUser;
use App\Utils\MyFunctions;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class administradorIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = AuthUser::getUsuariosLogin();
        $resultado = MyFunctions::validar_administrador("admin");

        if ($usuario->getTipoAdministrador() == 2) {
            return $next($request);
        } else {
            return redirect("/");
        }
    }
}