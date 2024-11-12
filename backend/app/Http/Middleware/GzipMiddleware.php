<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GzipMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Verifica si el cliente acepta compresión
        if (strpos($request->header('Accept-Encoding'), 'gzip') !== false) {
            $response->headers->set('Content-Encoding', 'gzip');
            ob_start("ob_gzhandler");
            return $response;
        }

        return $response;
    }
}
