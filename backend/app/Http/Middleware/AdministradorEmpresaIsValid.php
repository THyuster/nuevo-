<?php

namespace App\Http\Middleware;

use App\Utils\AuthUser;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministradorEmpresaIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = AuthUser::getUsuariosLogin();

        if ($user->getTipoAdministrador() == 4) {
            return $next($request);
        }else{
            throw new Exception("No tiene permisos", 1);
        }

    }
}