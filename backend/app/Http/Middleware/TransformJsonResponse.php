<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransformJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->headers->get('Content-Type') === 'application/json') {
            $data = json_decode($response->getContent(), true);

            // Verifica si hay una clave 'data' en la respuesta
            if (isset($data['data']) && is_array($data['data'])) {
                // Aplica la transformación a los datos
                $data['data'] = array_map(function ($item) {
                    if (isset($item['ruta_imagen'])) {
                        $item['ruta_imagen'] = url($item['ruta_imagen']);
                    }
                    return $item;
                }, $data['data']);
            } else {
                $data = array_map(function ($item) {
                    if (isset($item['ruta_imagen'])) {
                        $item['ruta_imagen'] = url($item['ruta_imagen']);
                    }
                    return $item;
                }, $data);
            }



            $response->setContent(json_encode($data));
        }

        return $response;
    }
}
