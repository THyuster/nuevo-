<?php

namespace App\Http\Middleware;

use App\Utils\AuthUser;
use App\Utils\MyFunctions;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdministradorValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = AuthUser::getUsuariosLogin();
        $resultado = MyFunctions::validar_modulo("Super Admin");
      
        if (MyFunctions::validar_superadmin() && $usuario->getTipoAdministrador() == 2 && $resultado == "SI") {
            return $next($request);
        } else {
            return redirect("/");
        }

    }
}
